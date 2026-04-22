<?php
$currentPage = 'events';
$pageTitle = 'Eventos';
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/header.php';

function getEventos(bool $soloActivos = true): array
{
    $pdo = getDB();
    $stmt = $pdo->query("SELECT * FROM eventos ORDER BY fecha ASC");
    return $stmt->fetchAll();
}

function estaInscrito(int $id_evento, int $id_usuario): bool
{
    $pdo = getDB();
    $stmt = $pdo->prepare('SELECT 1 FROM inscripciones_eventos WHERE id_evento = ? AND id_usuario = ?');
    $stmt->execute([$id_evento, $id_usuario]);
    return (bool) $stmt->fetch();
}

function inscribirseEvento(int $id_evento, int $id_usuario): array
{
    $pdo = getDB();
    $stmt = $pdo->prepare('SELECT id_inscripcion FROM inscripciones_eventos WHERE id_evento = ? AND id_usuario = ?');
    $stmt->execute([$id_evento, $id_usuario]);
    if ($stmt->fetch()) {
        return ['ok' => false, 'msg' => 'Ya estás inscrito en este evento.'];
    }
    $stmt = $pdo->prepare('INSERT INTO inscripciones_eventos (id_evento, id_usuario) VALUES (?, ?)');
    $stmt->execute([$id_evento, $id_usuario]);
    return ['ok' => true];
}

function cancelarInscripcionEvento(int $id_evento, int $id_usuario): array
{
    $pdo = getDB();
    $stmt = $pdo->prepare('DELETE FROM inscripciones_eventos WHERE id_evento = ? AND id_usuario = ?');
    $stmt->execute([$id_evento, $id_usuario]);
    return ['ok' => true];
}

$eventos = getEventos(true);

// Manejar inscripción via POST
$msg = '';
$msg_tipo = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscribirse'])) {
    if (!estaLogueado()) {
        $msg = 'Debes iniciar sesión para inscribirte.';
        $msg_tipo = 'error';
    } else {
        $resultado = inscribirseEvento((int) $_POST['id_evento'], $_SESSION['user_id']);
        $msg = $resultado['msg'] ?? 'Inscripción realizada con éxito.';
        $msg_tipo = $resultado['ok'] ? 'ok' : 'error';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancelar'])) {
    if (!estaLogueado()) {
        $msg = 'Debes iniciar sesión.';
        $msg_tipo = 'error';
    } else {
        cancelarInscripcionEvento((int) $_POST['id_evento'], $_SESSION['user_id']);
        $msg = 'Inscripción cancelada.';
        $msg_tipo = 'ok';
    }
}
?>

<div class="ev-page">
    <div class="rv-bg"></div>

    <!-- HERO -->
    <div class="rv-hero-content">
        <p class="rv-hero-sub">Centro Deportivo</p>
        <h1 class="rv-hero-title">Eventos</h1>
        <p class="rv-hero-desc">Torneos, clases y actividades para todos los socios.</p>
    </div>

    <!-- MENSAJE -->
    <?php if ($msg): ?>
        <div class="ev-msg ev-msg--<?= $msg_tipo ?>">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <!-- LISTA DE EVENTOS -->
    <div class="ev-list">
        <?php if (empty($eventos)): ?>
            <div class="ev-empty">No hay eventos próximos disponibles.</div>
        <?php else: ?>
            <?php foreach ($eventos as $i => $ev):
                // Contar inscritos
                $pdo = getDB();
                $stmt = $pdo->prepare('SELECT COUNT(*) FROM inscripciones_eventos WHERE id_evento = ?');
                $stmt->execute([$ev['id_evento']]);
                $inscritos = (int) $stmt->fetchColumn();
                $plazas_libres = $ev['aforo_max'] ? $ev['aforo_max'] - $inscritos : null;
                $completo = $plazas_libres !== null && $plazas_libres <= 0;
                $delay = ($i % 4) + 1;
                ?>
                <div class="ev-item reveal reveal-delay-<?= $delay ?>">

                    <!-- Imagen o placeholder -->
                    <div class="ev-item-img">
                        <?php if ($ev['imagen']): ?>
                            <img src="/club-montepalma/public/assets/images/eventos/<?= htmlspecialchars($ev['imagen']) ?>"
                                alt="<?= htmlspecialchars($ev['titulo']) ?>">
                        <?php else: ?>
                            <div class="ev-item-img-placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <path d="M16 2v4M8 2v4M3 10h18" />
                                </svg>
                            </div>
                        <?php endif; ?>
                        <div class="ev-item-tipo"><?= ucfirst($ev['estado']) ?></div>
                    </div>

                    <!-- Contenido -->
                    <div class="ev-item-body">
                        <div class="ev-item-meta">
                            <span class="ev-meta-fecha">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <path d="M16 2v4M8 2v4M3 10h18" />
                                </svg>
                                <?= date('d M Y', strtotime($ev['fecha'])) ?>
                            </span>
                            <?php if ($ev['hora']): ?>
                                <span class="ev-meta-hora">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <circle cx="12" cy="12" r="10" />
                                        <path d="M12 6v6l4 2" />
                                    </svg>
                                    <?= substr($ev['hora'], 0, 5) ?>h
                                </span>
                            <?php endif; ?>
                            <?php if ($ev['ubicacion']): ?>
                                <span class="ev-meta-ubicacion">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1118 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    <?= htmlspecialchars($ev['ubicacion']) ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <h2 class="ev-item-titulo"><?= htmlspecialchars($ev['titulo']) ?></h2>
                        <p class="ev-item-desc"><?= htmlspecialchars($ev['descripcion'] ?? '') ?></p>

                        <div class="ev-item-footer">
                            <?php if ($plazas_libres !== null): ?>
                                <div
                                    class="ev-plazas <?= $completo ? 'ev-plazas--agotado' : ($plazas_libres <= 5 ? 'ev-plazas--pocas' : '') ?>">
                                    <?php if ($completo): ?>
                                        Sin plazas disponibles
                                    <?php elseif ($plazas_libres <= 5): ?>
                                        ¡Solo quedan <?= $plazas_libres ?> plazas!
                                    <?php else: ?>
                                        <?= $plazas_libres ?> plazas disponibles
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php
                            $inscrito = estaLogueado() ? estaInscrito($ev['id_evento'], $_SESSION['user_id']) : false;
                            ?>

                            <?php if (!$completo): ?>

                                <?php if ($inscrito): ?>
                                    <!-- BOTÓN CANCELAR -->
                                    <form method="POST" class="ev-form-inscripcion">
                                        <input type="hidden" name="id_evento" value="<?= $ev['id_evento'] ?>">
                                        <button type="submit" name="cancelar" class="ev-btn-inscripcion ev-btn-cancelar">
                                            Cancelar inscripción
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <!-- BOTÓN INSCRIBIR -->
                                    <form method="POST" class="ev-form-inscripcion">
                                        <input type="hidden" name="id_evento" value="<?= $ev['id_evento'] ?>">
                                        <button type="submit" name="inscribirse" class="ev-btn-inscripcion">
                                            Inscribirse
                                        </button>
                                    </form>
                                <?php endif; ?>

                            <?php else: ?>
                                <button class="ev-btn-inscripcion ev-btn-inscripcion--disabled" disabled>Completo</button>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>



<script>
    document.querySelectorAll('.reveal').forEach(function (el) {
        el.classList.add('visible');
    });

</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>