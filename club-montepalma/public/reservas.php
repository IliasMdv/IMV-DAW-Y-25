<?php
$currentPage = 'reservas';
$pageTitle = 'Reservas';
include __DIR__ . '/../includes/header.php';
?>

<div class="rv-page">

    <div class="rv-bg"></div>

    <div class="rv-hero-content">
        <p class="rv-hero-sub">Centro Deportivo</p>
        <h1 class="rv-hero-title">Reserva tu pista</h1>
        <p class="rv-hero-desc">Elige tu instalación y reserva en segundos.</p>
    </div>

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
                <li><span>Duración</span> 90 min</li>
                <li><span>Precio</span> Consultar</li>
                <li><span>Pistas</span> 4 disponibles</li>
            </ul>
            <button class="rv-btn" onclick="showLoginModal()">Reservar</button>
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
                <li><span>Precio</span> Consultar</li>
                <li><span>Pistas</span> 3 disponibles</li>
            </ul>
            <button class="rv-btn" onclick="showLoginModal()">Reservar</button>
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
            <p>6 pistas de césped artificial. Para equipos y partidos organizados.</p>
            <ul class="rv-card-info">
                <li><span>Duración</span> 60 min</li>
                <li><span>Precio</span> Consultar</li>
                <li><span>Pistas</span> 6 de césped</li>
            </ul>
            <button class="rv-btn" onclick="showLoginModal()">Reservar</button>
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
                <li><span>Precio</span> Consultar</li>
                <li><span>Carriles</span> Disponibles</li>
            </ul>
            <button class="rv-btn" onclick="showLoginModal()">Reservar</button>
        </div>

        <div class="rv-card reveal reveal-delay-2">
            <div class="rv-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M6 4v16M18 4v16M2 8h4M18 8h4M2 16h4M18 16h4" />
                </svg>
            </div>
            <h3>Fitness</h3>
            <p>Sala de musculación y cardio. Acceso libre en horario de apertura.</p>
            <ul class="rv-card-info">
                <li><span>Duración</span> Libre</li>
                <li><span>Precio</span> Incluido</li>
                <li><span>Acceso</span> Con membresía</li>
            </ul>
            <button class="rv-btn" onclick="showLoginModal()">Reservar</button>
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

<script>
    document.querySelectorAll('.reveal').forEach(function (el) {
        el.classList.add('visible');
    });

    // Modal reservas
    var backdrop = document.getElementById('rv-modal-backdrop');
    var modal = document.getElementById('rv-modal');
    var btnClose = document.getElementById('rv-modal-close');

    function showLoginModal() {
        modal.classList.add('active');
        backdrop.classList.add('active');
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                modal.classList.add('visible');
                backdrop.classList.add('visible');
            });
        });
        document.body.style.overflow = 'hidden';
    }

    function closeLoginModal() {
        modal.classList.remove('visible');
        backdrop.classList.remove('visible');
        document.body.style.overflow = '';
        setTimeout(function () {
            modal.classList.remove('active');
            backdrop.classList.remove('active');
        }, 350);
    }

    btnClose.addEventListener('click', closeLoginModal);
    backdrop.addEventListener('click', closeLoginModal);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeLoginModal();
    });

    document.querySelectorAll('.reveal').forEach(function (el) {
        el.classList.add('visible');
    });
</script>

<?php
// ============================================
// Club Montepalma — Funciones de Reservas
// ============================================
require_once __DIR__ . '/../includes/db.php';

// ── OBTENER INSTALACIONES ─────────────────────
function getInstalaciones(string $tipo = ''): array
{
    $pdo = getDB();

    if ($tipo) {
        $stmt = $pdo->prepare('SELECT * FROM instalaciones WHERE tipo = ? AND estado = "disponible" ORDER BY nombre');
        $stmt->execute([$tipo]);
    } else {
        $stmt = $pdo->query('SELECT * FROM instalaciones WHERE estado = "disponible" ORDER BY tipo, nombre');
    }

    return $stmt->fetchAll();
}

// ── COMPROBAR DISPONIBILIDAD ──────────────────
function isDisponible(int $id_instalacion, string $fecha, string $hora_inicio, string $hora_fin): bool
{
    $pdo = getDB();

    $stmt = $pdo->prepare('
        SELECT COUNT(*) FROM reservas
        WHERE id_instalacion = ?
          AND fecha = ?
          AND estado != "cancelada"
          AND hora_inicio < ?
          AND hora_fin > ?
    ');
    $stmt->execute([$id_instalacion, $fecha, $hora_fin, $hora_inicio]);

    return (int) $stmt->fetchColumn() === 0;
}

// ── CREAR RESERVA ─────────────────────────────
function crearReserva(int $id_usuario, int $id_instalacion, string $fecha, string $hora_inicio, string $hora_fin, string $notas = ''): array
{
    $pdo = getDB();

    if (!isDisponible($id_instalacion, $fecha, $hora_inicio, $hora_fin)) {
        return ['ok' => false, 'msg' => 'Esta instalación ya está reservada en ese horario.'];
    }

    // Calcular precio
    $stmt = $pdo->prepare('SELECT precio_hora FROM instalaciones WHERE id_instalacion = ?');
    $stmt->execute([$id_instalacion]);
    $instalacion = $stmt->fetch();

    $horas = (strtotime($hora_fin) - strtotime($hora_inicio)) / 3600;
    $precio_total = $instalacion['precio_hora'] * $horas;

    $stmt = $pdo->prepare('
        INSERT INTO reservas (id_usuario, id_instalacion, fecha, hora_inicio, hora_fin, precio_total, notas)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ');
    $stmt->execute([$id_usuario, $id_instalacion, $fecha, $hora_inicio, $hora_fin, $precio_total, $notas]);

    return ['ok' => true, 'id' => $pdo->lastInsertId(), 'precio' => $precio_total];
}

// ── RESERVAS DE UN USUARIO ────────────────────
function getReservasUsuario(int $id_usuario): array
{
    $pdo = getDB();

    $stmt = $pdo->prepare('
        SELECT r.*, i.nombre AS instalacion, i.tipo
        FROM reservas r
        JOIN instalaciones i ON r.id_instalacion = i.id_instalacion
        WHERE r.id_usuario = ?
        ORDER BY r.fecha DESC, r.hora_inicio DESC
    ');
    $stmt->execute([$id_usuario]);

    return $stmt->fetchAll();
}

// ── CANCELAR RESERVA ──────────────────────────
function cancelarReserva(int $id_reserva, int $id_usuario): array
{
    $pdo = getDB();

    // Verificar que la reserva pertenece al usuario
    $stmt = $pdo->prepare('SELECT * FROM reservas WHERE id_reserva = ? AND id_usuario = ?');
    $stmt->execute([$id_reserva, $id_usuario]);
    $reserva = $stmt->fetch();

    if (!$reserva) {
        return ['ok' => false, 'msg' => 'Reserva no encontrada.'];
    }

    if ($reserva['estado'] === 'cancelada') {
        return ['ok' => false, 'msg' => 'La reserva ya estaba cancelada.'];
    }

    $stmt = $pdo->prepare('UPDATE reservas SET estado = "cancelada" WHERE id_reserva = ?');
    $stmt->execute([$id_reserva]);

    return ['ok' => true];
}



include __DIR__ . '/../includes/footer.php'; ?>