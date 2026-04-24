<?php
$currentPage = 'reservas';
$pageTitle = 'Reservas';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

// ── FUNCIONES ────────────────────────────────

function isDisponibleInstalacion(int $id_instalacion, string $fecha, string $hora_inicio, string $hora_fin): bool
{
    $pdo = getDB();
    $stmt = $pdo->prepare('
        SELECT COUNT(*) FROM reservas
        WHERE id_instalacion = ? AND fecha = ? AND estado != "cancelada"
        AND hora_inicio < ? AND hora_fin > ?
    ');
    $stmt->execute([$id_instalacion, $fecha, $hora_fin, $hora_inicio]);
    return (int) $stmt->fetchColumn() === 0;
}

function getUnidadesFutbolOcupadas(string $fecha, string $hora_inicio, string $hora_fin): array
{
    $pdo = getDB();
    $stmt = $pdo->prepare('
        SELECT COUNT(*) FROM reservas r
        JOIN instalaciones i ON r.id_instalacion = i.id_instalacion
        WHERE i.tipo = "futbol" AND i.aforo = 14
        AND r.fecha = ? AND r.estado != "cancelada"
        AND r.hora_inicio < ? AND r.hora_fin > ?
    ');
    $stmt->execute([$fecha, $hora_fin, $hora_inicio]);
    $f7 = (int) $stmt->fetchColumn();

    $stmt = $pdo->prepare('
        SELECT COUNT(*) FROM reservas r
        JOIN instalaciones i ON r.id_instalacion = i.id_instalacion
        WHERE i.tipo = "futbol" AND i.aforo = 10
        AND r.fecha = ? AND r.estado != "cancelada"
        AND r.hora_inicio < ? AND r.hora_fin > ?
    ');
    $stmt->execute([$fecha, $hora_fin, $hora_inicio]);
    $f5 = (int) $stmt->fetchColumn();

    return [
        'f7' => $f7,
        'f5' => $f5,
        'unidades_usadas' => ($f7 * 3) + $f5,
        'unidades_libres' => 6 - (($f7 * 3) + $f5),
    ];
}

function getAllFranjas(string $tipo, string $subtipo, string $fecha): array
{
    $pdo = getDB();
    $duracion = 60;
    $inicio = strtotime("08:00");
    $fin = strtotime("22:00");
    $franjas = [];

    for ($t = $inicio; $t < $fin; $t += 30 * 60) {
        $hi = date('H:i:s', $t);
        $hf = date('H:i:s', $t + $duracion * 60);
        if (strtotime($hf) > $fin)
            break;

        $disponible = false;

        if ($tipo === 'futbol') {
            $unidades = ($subtipo === 'f7') ? 3 : 1;
            $ocup = getUnidadesFutbolOcupadas($fecha, $hi, $hf);
            $disponible = $ocup['unidades_libres'] >= $unidades;

            if ($disponible && $subtipo === 'f7') {
                $stmt = $pdo->prepare('
                    SELECT COUNT(*) FROM reservas r
                    JOIN instalaciones i ON r.id_instalacion = i.id_instalacion
                    WHERE i.tipo = "futbol" AND i.aforo = 14
                    AND r.fecha = ? AND r.hora_inicio = ? AND r.estado != "cancelada"
                ');
                $stmt->execute([$fecha, $hi]);
                if ((int) $stmt->fetchColumn() > 0)
                    $disponible = false;
            }
        } else {
            $stmt = $pdo->prepare('
                SELECT id_instalacion FROM instalaciones
                WHERE tipo = ? AND estado = "disponible"
                AND id_instalacion NOT IN (
                    SELECT id_instalacion FROM reservas
                    WHERE fecha = ? AND estado != "cancelada"
                    AND hora_inicio < ? AND hora_fin > ?
                )
                LIMIT 1
            ');
            $stmt->execute([$tipo, $fecha, $hf, $hi]);
            $disponible = (bool) $stmt->fetchColumn();
        }

        $franjas[] = [
            'hora' => date('H:i', $t),
            'disponible' => $disponible,
        ];
    }

    return $franjas;
}

// ── AJAX — debe ir ANTES del header ──────────
if (isset($_GET['ajax_franjas'])) {
    header('Content-Type: application/json');
    $tipo = $_GET['tipo'] ?? '';
    $subtipo = $_GET['subtipo'] ?? '';
    $fecha = $_GET['fecha'] ?? '';
    if (empty($tipo) || empty($fecha)) {
        echo json_encode([]);
        exit;
    }
    if ($tipo === 'futbol' && empty($subtipo)) {
        echo json_encode([]);
        exit;
    }
    echo json_encode(getAllFranjas($tipo, $subtipo, $fecha));
    exit;
}

// ── HACER RESERVA ─────────────────────────────
$msg = '';
$msg_tipo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hacer_reserva'])) {
    requiereLogin();
    $tipo = $_POST['tipo'] ?? '';
    $subtipo = $_POST['subtipo'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $hora_inicio = $_POST['hora_inicio'] ?? '';
    $id_usuario = $_SESSION['user_id'];

    if (empty($tipo) || empty($fecha) || empty($hora_inicio)) {
        $msg = 'Por favor completa todos los campos.';
        $msg_tipo = 'error';
    } else {
        $pdo = getDB();
        $duracion = 60;
        $hi_db = $hora_inicio . ':00';
        $hf_db = date('H:i:s', strtotime($hora_inicio) + $duracion * 60);

        if ($tipo === 'futbol') {
            $aforo = ($subtipo === 'f7') ? 14 : 10;
            $stmt = $pdo->prepare('
                SELECT id_instalacion FROM instalaciones
                WHERE tipo = "futbol" AND aforo = ? AND estado = "disponible"
                AND id_instalacion NOT IN (
                    SELECT id_instalacion FROM reservas
                    WHERE fecha = ? AND estado != "cancelada"
                    AND hora_inicio < ? AND hora_fin > ?
                ) LIMIT 1
            ');
            $stmt->execute([$aforo, $fecha, $hf_db, $hi_db]);
        } else {
            $stmt = $pdo->prepare('
                SELECT id_instalacion FROM instalaciones
                WHERE tipo = ? AND estado = "disponible"
                AND id_instalacion NOT IN (
                    SELECT id_instalacion FROM reservas
                    WHERE fecha = ? AND estado != "cancelada"
                    AND hora_inicio < ? AND hora_fin > ?
                ) LIMIT 1
            ');
            $stmt->execute([$tipo, $fecha, $hf_db, $hi_db]);
        }

        $id_inst = $stmt->fetchColumn();

        if (!$id_inst) {
            $msg = 'No hay instalaciones disponibles en ese horario.';
            $msg_tipo = 'error';
        } else {
            $stmt2 = $pdo->prepare('SELECT precio_hora FROM instalaciones WHERE id_instalacion = ?');
            $stmt2->execute([$id_inst]);
            $precio_total = (float) $stmt2->fetchColumn() * ($duracion / 60);

            $stmt3 = $pdo->prepare('
                INSERT INTO reservas (id_usuario, id_instalacion, fecha, hora_inicio, hora_fin, precio_total, estado)
                VALUES (?, ?, ?, ?, ?, ?, "confirmada")
            ');
            $stmt3->execute([$id_usuario, $id_inst, $fecha, $hi_db, $hf_db, $precio_total]);
            $msg = '¡Reserva confirmada! Puedes verla en tu perfil.';
            $msg_tipo = 'ok';
        }
    }
}

// ── Header DESPUÉS de todo lo anterior ───────
include __DIR__ . '/../includes/header.php';
?>

<div class="rv-page">
    <div class="rv-bg"></div>

    <div class="rv-hero-content">
        <p class="rv-hero-sub">Centro Deportivo</p>
        <h1 class="rv-hero-title">Reserva tu pista</h1>
        <p class="rv-hero-desc">Elige tu instalación y reserva en segundos.</p>
    </div>

    <?php if ($msg): ?>
        <div class="ev-msg ev-msg--<?= $msg_tipo ?>" style="max-width:900px;width:100%;position:relative;z-index:1">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <div class="rv-grid">

        <div class="rv-card reveal reveal-delay-1">
            <div class="rv-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M8 12h8M12 8v8" />
                </svg>
            </div>
            <h3>Pádel</h3>
            <p>4 pistas cubiertas disponibles. Partidas individuales o en pareja.</p>
            <ul class="rv-card-info">
                <li><span>Duración</span> 60 min</li>
                <li><span>Precio</span> 10 €/hora</li>
                <li><span>Pistas</span> 4 disponibles</li>
            </ul>
            <?php if (estaLogueado()): ?>
                <button class="rv-btn" onclick="abrirModal('padel')">Reservar</button>
            <?php else: ?>
                <button class="rv-btn" onclick="showLoginModal()">Reservar</button>
            <?php endif; ?>
        </div>

        <div class="rv-card reveal reveal-delay-2">
            <div class="rv-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M5 7c2 2 2 6 0 8M19 7c-2 2-2 6 0 8" />
                </svg>
            </div>
            <h3>Tenis</h3>
            <p>3 pistas de superficie rápida. Ideales para todos los niveles.</p>
            <ul class="rv-card-info">
                <li><span>Duración</span> 60 min</li>
                <li><span>Precio</span> 12 €/hora</li>
                <li><span>Pistas</span> 3 disponibles</li>
            </ul>
            <?php if (estaLogueado()): ?>
                <button class="rv-btn" onclick="abrirModal('tenis')">Reservar</button>
            <?php else: ?>
                <button class="rv-btn" onclick="showLoginModal()">Reservar</button>
            <?php endif; ?>
        </div>

        <div class="rv-card reveal reveal-delay-3">
            <div class="rv-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10" />
                    <path
                        d="M12 2a10 10 0 00-6.88 17.26M12 2a10 10 0 016.88 17.26M5 19.26A10 10 0 0112 22a10 10 0 007-2.74" />
                    <polygon points="12,7 14.5,11 12,13 9.5,11" />
                </svg>
            </div>
            <h3>Fútbol</h3>
            <p>6 pistas de césped artificial. Elige entre Fútbol 7 o Fútbol 5.</p>
            <ul class="rv-card-info">
                <li><span>Duración</span> 60 min</li>
                <li><span>Fútbol 7</span> 56 €</li>
                <li><span>Fútbol 5</span> 40 €</li>
            </ul>
            <?php if (estaLogueado()): ?>
                <button class="rv-btn" onclick="abrirModal('futbol')">Reservar</button>
            <?php else: ?>
                <button class="rv-btn" onclick="showLoginModal()">Reservar</button>
            <?php endif; ?>
        </div>

        <div class="rv-card reveal reveal-delay-1">
            <div class="rv-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M2 12c2-2 4-2 6 0s4 2 6 0 4-2 6 0" />
                    <path d="M2 17c2-2 4-2 6 0s4 2 6 0 4-2 6 0" />
                    <path d="M8 7a2 2 0 100-4 2 2 0 000 4zM8 7v5" />
                </svg>
            </div>
            <h3>Piscina</h3>
            <p>Carril de nado libre. Reserva tu franja horaria con antelación.</p>
            <ul class="rv-card-info">
                <li><span>Duración</span> 60 min</li>
                <li><span>Precio</span> 8 €/hora</li>
                <li><span>Carriles</span> Disponibles</li>
            </ul>
            <?php if (estaLogueado()): ?>
                <button class="rv-btn" onclick="abrirModal('piscina')">Reservar</button>
            <?php else: ?>
                <button class="rv-btn" onclick="showLoginModal()">Reservar</button>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- MODAL LOGIN -->
<div class="rv-modal-backdrop" id="rv-modal-backdrop"></div>
<div class="rv-modal" id="rv-modal">
    <div class="rv-modal-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
        </svg>
    </div>
    <h3>Necesitas una cuenta</h3>
    <p>Para realizar una reserva debes estar registrado en Club Montepalma. Es rápido y gratuito.</p>
    <div class="rv-modal-btns">
        <a href="register.php" class="rv-modal-register">Registrarse</a>
        <a href="login.php" class="rv-modal-login">Iniciar Sesión</a>
    </div>
    <button class="rv-modal-close" id="rv-modal-close">Ahora no</button>
</div>

<?php if (estaLogueado()): ?>
    <!-- MODAL RESERVA -->
    <div class="rv-modal-backdrop" id="res-backdrop"></div>
    <div class="rv-modal" id="res-modal">

        <h3 id="res-titulo">Reservar</h3>
        <p id="res-desc"></p>

        <form method="POST" id="res-form" onsubmit="return validarReserva()">
            <input type="hidden" name="hacer_reserva" value="1">
            <input type="hidden" name="tipo" id="res-tipo">
            <input type="hidden" name="subtipo" id="res-subtipo">
            <input type="hidden" name="hora_inicio" id="res-hora-val">
            <input type="hidden" name="fecha" id="res-fecha-val">

            <!-- Selector fútbol -->
            <div id="res-futbol-tipo" style="display:none">
                <p class="res-label">Modalidad</p>
                <div class="res-subtipo-wrap">
                    <label class="res-subtipo-btn">
                        <input type="radio" name="_sub" value="f7" onchange="selSubtipo('f7')">
                        <span>Fútbol 7<br><small>56 €</small></span>
                    </label>
                    <label class="res-subtipo-btn">
                        <input type="radio" name="_sub" value="f5" onchange="selSubtipo('f5')">
                        <span>Fútbol 5<br><small>40 €</small></span>
                    </label>
                </div>
            </div>

            <!-- Fecha -->
            <div style="margin-bottom:16px">
                <p class="res-label">Fecha</p>
                <input type="date" id="res-fecha-inp" min="<?= date('Y-m-d') ?>"
                    max="<?= date('Y-m-d', strtotime('+30 days')) ?>" onchange="cargarFranjas()"
                    style="width:100%;padding:10px 12px;border:1px solid rgba(45,74,107,.2);border-radius:8px;font-family:'Montserrat',sans-serif;font-size:.82rem;color:#1a2635;background:#f4f4f4;outline:none">
            </div>

            <!-- Grid de franjas -->
            <div id="res-franjas-wrap" style="display:none">
                <p class="res-label">Selecciona una franja</p>
                <div class="res-legend">
                    <span class="res-legend-dot res-legend-ok"></span> Disponible
                    <span class="res-legend-dot res-legend-no" style="margin-left:12px"></span> Ocupada
                </div>
                <div class="res-grid" id="res-grid"></div>
            </div>

            <div id="res-cargando" style="display:none;font-size:.78rem;color:#999;padding:12px 0">Cargando horarios...
            </div>
            <div id="res-sin-franjas" style="display:none;font-size:.78rem;color:#c74a4a;padding:8px 0">No hay franjas
                disponibles para este día.</div>

            <!-- Confirmación -->
            <div id="res-seleccionada" style="display:none;margin-bottom:12px">
                <p class="res-label">Franja seleccionada</p>
                <div class="res-seleccionada-texto" id="res-sel-txt"></div>
            </div>

            <button type="submit" class="rv-btn" id="res-submit" style="width:100%;padding:13px;margin-top:4px" disabled>
                Confirmar reserva
            </button>
        </form>

        <button class="rv-modal-close" onclick="cerrarResModal()" style="margin-top:12px">Cancelar</button>
    </div>
<?php endif; ?>

<style>
    /* ── Modal reserva ── */
    #res-modal {
        max-width: 520px;
        text-align: left;
    }

    #res-modal h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.6rem;
        font-weight: 400;
        color: #1a2635;
        margin-bottom: 6px;
    }

    #res-modal>p {
        font-size: .78rem;
        color: #888;
        margin-bottom: 20px;
    }

    .res-label {
        font-size: .68rem;
        letter-spacing: .15em;
        text-transform: uppercase;
        color: #666;
        margin-bottom: 8px;
        font-weight: 600;
    }

    /* Subtipo fútbol */
    .res-subtipo-wrap {
        display: flex;
        gap: 10px;
        margin-bottom: 16px;
    }

    .res-subtipo-btn {
        flex: 1;
        cursor: pointer;
    }

    .res-subtipo-btn input {
        display: none;
    }

    .res-subtipo-btn span {
        display: block;
        text-align: center;
        padding: 12px 8px;
        border: 1px solid rgba(45, 74, 107, .2);
        border-radius: 8px;
        font-size: .78rem;
        color: #555;
        transition: all .2s;
    }

    .res-subtipo-btn small {
        font-size: .7rem;
        color: #888;
    }

    .res-subtipo-btn input:checked+span {
        border-color: var(--accent);
        background: rgba(74, 156, 199, .08);
        color: var(--dark);
    }

    /* Legend */
    .res-legend {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: .72rem;
        color: #888;
        margin-bottom: 10px;
    }

    .res-legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 3px;
        display: inline-block;
    }

    .res-legend-ok {
        background: rgba(74, 199, 120, .3);
        border: 1px solid #4ac778;
    }

    .res-legend-no {
        background: rgba(199, 74, 74, .15);
        border: 1px solid #c74a4a;
    }

    /* Grid de franjas */
    .res-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
        max-height: 260px;
        overflow-y: auto;
        padding-right: 4px;
        margin-bottom: 16px;
    }

    .res-franja {
        padding: 9px 10px;
        border-radius: 6px;
        font-size: .76rem;
        font-family: 'Montserrat', sans-serif;
        text-align: center;
        cursor: pointer;
        border: 1px solid;
        transition: all .15s;
        user-select: none;
    }

    .res-franja.disponible {
        background: rgba(74, 199, 120, .12);
        border-color: rgba(74, 199, 120, .4);
        color: #2a7a45;
    }

    .res-franja.disponible:hover {
        background: rgba(74, 199, 120, .25);
        border-color: #4ac778;
    }

    .res-franja.disponible.selected {
        background: #4ac778;
        border-color: #4ac778;
        color: #fff;
        font-weight: 600;
    }

    .res-franja.ocupada {
        background: rgba(199, 74, 74, .08);
        border-color: rgba(199, 74, 74, .25);
        color: #b04040;
        cursor: not-allowed;
        opacity: .7;
    }

    /* Seleccionada */
    .res-seleccionada-texto {
        background: rgba(74, 199, 120, .12);
        border: 1px solid rgba(74, 199, 120, .4);
        border-radius: 8px;
        padding: 10px 14px;
        font-size: .82rem;
        color: #2a7a45;
        font-weight: 500;
    }
</style>

<script>
    document.querySelectorAll('.reveal').forEach(function (el) { el.classList.add('visible'); });

    // ── Modal login ──
    var backdrop = document.getElementById('rv-modal-backdrop');
    var modal = document.getElementById('rv-modal');
    var btnClose = document.getElementById('rv-modal-close');

    function showLoginModal() {
        modal.classList.add('active'); backdrop.classList.add('active');
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                modal.classList.add('visible'); backdrop.classList.add('visible');
            });
        });
        document.body.style.overflow = 'hidden';
    }
    function closeLoginModal() {
        modal.classList.remove('visible'); backdrop.classList.remove('visible');
        document.body.style.overflow = '';
        setTimeout(function () { modal.classList.remove('active'); backdrop.classList.remove('active'); }, 350);
    }
    if (btnClose) btnClose.addEventListener('click', closeLoginModal);
    if (backdrop) backdrop.addEventListener('click', function (e) { if (e.target === backdrop) closeLoginModal(); });

    <?php if (estaLogueado()): ?>
        var resBackdrop = document.getElementById('res-backdrop');
        var resModal = document.getElementById('res-modal');
        var tipoActual = '';
        var horaSeleccionada = '';

        var titulos = { padel: 'Reservar — Pádel', tenis: 'Reservar — Tenis', futbol: 'Reservar — Fútbol', piscina: 'Reservar — Piscina' };
        var descs = { padel: '60 min · 10 €/hora · 4 pistas', tenis: '60 min · 12 €/hora · 3 pistas', futbol: '60 min · elige modalidad', piscina: '60 min · 8 €/hora' };

        function abrirModal(tipo) {
            tipoActual = tipo;
            horaSeleccionada = '';
            document.getElementById('res-tipo').value = tipo;
            document.getElementById('res-subtipo').value = '';
            document.getElementById('res-titulo').textContent = titulos[tipo];
            document.getElementById('res-desc').textContent = descs[tipo];
            document.getElementById('res-futbol-tipo').style.display = tipo === 'futbol' ? 'block' : 'none';
            document.getElementById('res-fecha-inp').value = '';
            document.getElementById('res-fecha-val').value = '';
            document.getElementById('res-hora-val').value = '';
            document.getElementById('res-franjas-wrap').style.display = 'none';
            document.getElementById('res-sin-franjas').style.display = 'none';
            document.getElementById('res-seleccionada').style.display = 'none';
            document.getElementById('res-submit').disabled = true;
            document.getElementById('res-grid').innerHTML = '';

            // Reset subtipo radio
            document.querySelectorAll('input[name="_sub"]').forEach(function (r) { r.checked = false; });

            resModal.classList.add('active'); resBackdrop.classList.add('active');
            requestAnimationFrame(function () {
                requestAnimationFrame(function () {
                    resModal.classList.add('visible'); resBackdrop.classList.add('visible');
                });
            });
            document.body.style.overflow = 'hidden';
        }

        function cerrarResModal() {
            resModal.classList.remove('visible'); resBackdrop.classList.remove('visible');
            document.body.style.overflow = '';
            setTimeout(function () { resModal.classList.remove('active'); resBackdrop.classList.remove('active'); }, 350);
        }

        resBackdrop.addEventListener('click', cerrarResModal);

        function selSubtipo(st) {
            document.getElementById('res-subtipo').value = st;
            cargarFranjas();
        }

        function cargarFranjas() {
            var fecha = document.getElementById('res-fecha-inp').value;
            var tipo = tipoActual;
            var subtipo = document.getElementById('res-subtipo').value;

            if (!fecha) return;
            if (tipo === 'futbol' && !subtipo) return;

            document.getElementById('res-fecha-val').value = fecha;
            horaSeleccionada = '';
            document.getElementById('res-hora-val').value = '';
            document.getElementById('res-submit').disabled = true;
            document.getElementById('res-seleccionada').style.display = 'none';
            document.getElementById('res-franjas-wrap').style.display = 'none';
            document.getElementById('res-sin-franjas').style.display = 'none';
            document.getElementById('res-cargando').style.display = 'block';
            document.getElementById('res-grid').innerHTML = '';

            fetch('?ajax_franjas=1&tipo=' + tipo + '&subtipo=' + subtipo + '&fecha=' + fecha)
                .then(function (r) { return r.json(); })
                .then(function (franjas) {
                    document.getElementById('res-cargando').style.display = 'none';

                    if (!franjas.length) {
                        document.getElementById('res-sin-franjas').style.display = 'block';
                        return;
                    }

                    var grid = document.getElementById('res-grid');
                    grid.innerHTML = '';

                    // Separar en punto (:00) y media (:30) — columna izquierda y derecha
                    // El grid es 2 columnas, ponemos las :00 primero y :30 después de cada par
                    // Hacemos pares por hora
                    var horas = {};
                    franjas.forEach(function (f) {
                        var partes = f.hora.split(':');
                        var h = partes[0];
                        var m = partes[1];
                        if (!horas[h]) horas[h] = {};
                        horas[h][m] = f;
                    });

                    // Construir grid: por cada hora, celda :00 izquierda, celda :30 derecha
                    var hKeys = Object.keys(horas).sort();
                    hKeys.forEach(function (h) {
                        ['00', '30'].forEach(function (m) {
                            var key = h + ':' + m;
                            var f = horas[h] && horas[h][m];

                            if (!f) {
                                // celda vacía para mantener alineación
                                var empty = document.createElement('div');
                                empty.style.visibility = 'hidden';
                                empty.className = 'res-franja';
                                grid.appendChild(empty);
                                return;
                            }

                            var div = document.createElement('div');
                            div.className = 'res-franja ' + (f.disponible ? 'disponible' : 'ocupada');

                            // Calcular hora fin
                            var minTot = parseInt(h) * 60 + parseInt(m) + 60;
                            var hfStr = String(Math.floor(minTot / 60)).padStart(2, '0') + ':' + String(minTot % 60).padStart(2, '0');
                            div.textContent = f.hora + ' – ' + hfStr;

                            if (f.disponible) {
                                div.addEventListener('click', function () {
                                    document.querySelectorAll('.res-franja.disponible').forEach(function (el) { el.classList.remove('selected'); });
                                    div.classList.add('selected');
                                    horaSeleccionada = f.hora;
                                    document.getElementById('res-hora-val').value = f.hora;
                                    document.getElementById('res-submit').disabled = false;
                                    document.getElementById('res-seleccionada').style.display = 'block';
                                    document.getElementById('res-sel-txt').textContent = f.hora + ' – ' + hfStr + ' · ' + new Date(fecha + 'T00:00:00').toLocaleDateString('es-ES', { weekday: 'long', day: 'numeric', month: 'long' });
                                });
                            }

                            grid.appendChild(div);
                        });
                    });

                    document.getElementById('res-franjas-wrap').style.display = 'block';
                })
                .catch(function () { document.getElementById('res-cargando').style.display = 'none'; });
        }

        function validarReserva() {
            if (!horaSeleccionada) { alert('Por favor selecciona una franja horaria.'); return false; }
            return true;
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { closeLoginModal(); cerrarResModal(); }
        });
    <?php endif; ?>
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>