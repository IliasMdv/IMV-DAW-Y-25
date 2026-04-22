<?php
$currentPage = '';
$pageTitle   = 'Mi Perfil';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requiereLogin();

$pdo = getDB();
$id  = $_SESSION['user_id'];

// Datos del usuario
$stmt = $pdo->prepare('SELECT * FROM usuarios WHERE id_usuario = ?');
$stmt->execute([$id]);
$usuario = $stmt->fetch();

// Reservas activas
$stmt = $pdo->prepare('
    SELECT r.*, i.nombre AS instalacion, i.tipo
    FROM reservas r
    JOIN instalaciones i ON r.id_instalacion = i.id_instalacion
    WHERE r.id_usuario = ? AND r.estado != "cancelada" AND r.fecha >= CURDATE()
    ORDER BY r.fecha ASC, r.hora_inicio ASC
');
$stmt->execute([$id]);
$reservas_activas = $stmt->fetchAll();

// Historial de reservas
$stmt = $pdo->prepare('
    SELECT r.*, i.nombre AS instalacion, i.tipo
    FROM reservas r
    JOIN instalaciones i ON r.id_instalacion = i.id_instalacion
    WHERE r.id_usuario = ? AND (r.estado = "cancelada" OR r.fecha < CURDATE())
    ORDER BY r.fecha DESC
    LIMIT 10
');
$stmt->execute([$id]);
$historial = $stmt->fetchAll();

// Eventos inscritos
$stmt = $pdo->prepare('
    SELECT e.*, ie.fecha AS fecha_inscripcion
    FROM inscripciones_eventos ie
    JOIN eventos e ON ie.id_evento = e.id_evento
    WHERE ie.id_usuario = ?
    ORDER BY e.fecha ASC
');
$stmt->execute([$id]);
$eventos_inscritos = $stmt->fetchAll();

// Cancelar reserva
$msg = ''; $msg_tipo = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancelar_reserva'])) {
    $id_reserva = (int)$_POST['id_reserva'];
    $stmt = $pdo->prepare('UPDATE reservas SET estado = "cancelada" WHERE id_reserva = ? AND id_usuario = ?');
    $stmt->execute([$id_reserva, $id]);
    $msg = 'Reserva cancelada correctamente.';
    $msg_tipo = 'ok';
    header('Location: perfil.php?msg=cancelada');
    exit;
}

include __DIR__ . '/../includes/header.php';
?>

<div class="perfil-page">
    <div class="rv-bg"></div>

    <div class="perfil-inner">

        <!-- ── SIDEBAR ── -->
        <aside class="perfil-sidebar reveal">
            <div class="perfil-avatar">
                <div class="perfil-avatar-img">
                    <?= strtoupper(substr($usuario['nombre'], 0, 1)) ?>
                </div>
                <h2><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']) ?></h2>
                <span class="perfil-rol"><?= ucfirst($usuario['rol']) ?></span>
                <p><?= htmlspecialchars($usuario['email']) ?></p>
                <?php if ($usuario['telefono']): ?>
                <p><?= htmlspecialchars($usuario['telefono']) ?></p>
                <?php endif; ?>
            </div>

            <div class="perfil-sidebar-info">
                <div class="perfil-stat">
                    <span><?= count($reservas_activas) ?></span>
                    <p>Reservas activas</p>
                </div>
                <div class="perfil-stat">
                    <span><?= count($eventos_inscritos) ?></span>
                    <p>Eventos inscritos</p>
                </div>
            </div>

            <div class="perfil-sidebar-actions">
                <?php if (esAdmin()): ?>
                <a href="../admin/index.php" class="perfil-btn-admin">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    Panel Admin
                </a>
                <?php endif; ?>
                <a href="..\includes\logout.php" class="perfil-btn-logout">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                    </svg>
                    Cerrar sesión
                </a>
            </div>
        </aside>

        <!-- ── CONTENIDO ── -->
        <div class="perfil-content">

            <?php if (isset($_GET['msg'])): ?>
            <div class="ev-msg ev-msg--ok" style="margin-bottom:24px">
                Reserva cancelada correctamente.
            </div>
            <?php endif; ?>

            <!-- Reservas activas -->
            <div class="perfil-block reveal reveal-delay-1">
                <h3 class="perfil-block-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    Reservas activas
                </h3>

                <?php if (empty($reservas_activas)): ?>
                <p class="perfil-empty">No tienes reservas próximas. <a href="reservas.php">Reservar ahora →</a></p>
                <?php else: ?>
                <div class="perfil-table-wrap">
                    <table class="perfil-table">
                        <thead>
                            <tr>
                                <th>Instalación</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($reservas_activas as $r): ?>
                            <tr>
                                <td><?= htmlspecialchars($r['instalacion']) ?></td>
                                <td><?= date('d M Y', strtotime($r['fecha'])) ?></td>
                                <td><?= substr($r['hora_inicio'],0,5) ?> – <?= substr($r['hora_fin'],0,5) ?></td>
                                <td><span class="perfil-badge perfil-badge--<?= $r['estado'] ?>"><?= ucfirst($r['estado']) ?></span></td>
                                <td>
                                    <form method="POST" onsubmit="return confirm('¿Cancelar esta reserva?')">
                                        <input type="hidden" name="id_reserva" value="<?= $r['id_reserva'] ?>">
                                        <button type="submit" name="cancelar_reserva" class="perfil-btn-cancel">Cancelar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>

            <!-- Eventos inscritos -->
            <div class="perfil-block reveal reveal-delay-2">
                <h3 class="perfil-block-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    Eventos inscritos
                </h3>

                <?php if (empty($eventos_inscritos)): ?>
                <p class="perfil-empty">No estás inscrito en ningún evento. <a href="eventos.php">Ver eventos →</a></p>
                <?php else: ?>
                <div class="perfil-eventos-grid">
                    <?php foreach ($eventos_inscritos as $e): ?>
                    <div class="perfil-evento-card">
                        <span class="perfil-evento-fecha"><?= date('d M Y', strtotime($e['fecha'])) ?></span>
                        <h4><?= htmlspecialchars($e['titulo']) ?></h4>
                        <?php if ($e['ubicacion']): ?>
                        <p><?= htmlspecialchars($e['ubicacion']) ?></p>
                        <?php endif; ?>
                        <span class="perfil-badge perfil-badge--<?= $e['estado'] ?>"><?= ucfirst($e['estado']) ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Historial -->
            <div class="perfil-block reveal reveal-delay-3">
                <h3 class="perfil-block-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                    </svg>
                    Historial de reservas
                </h3>

                <?php if (empty($historial)): ?>
                <p class="perfil-empty">No hay reservas en el historial.</p>
                <?php else: ?>
                <div class="perfil-table-wrap">
                    <table class="perfil-table perfil-table--muted">
                        <thead>
                            <tr>
                                <th>Instalación</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estado</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($historial as $r): ?>
                            <tr>
                                <td><?= htmlspecialchars($r['instalacion']) ?></td>
                                <td><?= date('d M Y', strtotime($r['fecha'])) ?></td>
                                <td><?= substr($r['hora_inicio'],0,5) ?> – <?= substr($r['hora_fin'],0,5) ?></td>
                                <td><span class="perfil-badge perfil-badge--<?= $r['estado'] ?>"><?= ucfirst($r['estado']) ?></span></td>
                                <td><?= $r['precio_total'] ? number_format($r['precio_total'],2) . ' €' : '—' ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<script>
document.querySelectorAll('.reveal').forEach(function(el) { el.classList.add('visible'); });
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>