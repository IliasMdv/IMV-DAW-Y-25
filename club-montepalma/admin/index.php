<?php
$pageTitle = 'Panel Admin';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requiereAdmin();

$pdo = getDB();

// Estadísticas
$stats = [];
$stats['usuarios']  = $pdo->query('SELECT COUNT(*) FROM usuarios WHERE activo = 1')->fetchColumn();
$stats['reservas']  = $pdo->query('SELECT COUNT(*) FROM reservas WHERE estado = "confirmada"')->fetchColumn();
$stats['ingresos']  = $pdo->query('SELECT COALESCE(SUM(precio_total),0) FROM reservas WHERE estado = "confirmada"')->fetchColumn();
$stats['eventos']   = $pdo->query('SELECT COUNT(*) FROM eventos WHERE estado = "activo"')->fetchColumn();
$stats['mensajes']  = $pdo->query('SELECT COUNT(*) FROM contactos WHERE leido = 0')->fetchColumn();
$stats['socios']    = $pdo->query('SELECT COUNT(*) FROM socios WHERE estado = "activo"')->fetchColumn();

// Últimas reservas
$ultimas_reservas = $pdo->query('
    SELECT r.*, u.nombre, u.apellidos, i.nombre AS instalacion
    FROM reservas r
    JOIN usuarios u ON r.id_usuario = u.id_usuario
    JOIN instalaciones i ON r.id_instalacion = i.id_instalacion
    ORDER BY r.fecha_creacion DESC LIMIT 5
')->fetchAll();

// Últimos mensajes
$ultimos_mensajes = $pdo->query('
    SELECT * FROM contactos ORDER BY fecha DESC LIMIT 5
')->fetchAll();

include __DIR__ . '/../admin/layout.php';
?>

<!-- Dashboard -->
<div class="admin-page-header">
    <h1>Dashboard</h1>
    <p>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?>. Aquí tienes un resumen del club.</p>
</div>

<!-- Stats -->
<div class="admin-stats">
    <div class="admin-stat-card">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
        </svg>
        <div>
            <span><?= number_format($stats['usuarios']) ?></span>
            <p>Usuarios activos</p>
        </div>
    </div>
    <div class="admin-stat-card">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
        </svg>
        <div>
            <span><?= number_format($stats['reservas']) ?></span>
            <p>Reservas confirmadas</p>
        </div>
    </div>
    <div class="admin-stat-card">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
        </svg>
        <div>
            <span><?= number_format($stats['ingresos'], 2) ?> €</span>
            <p>Ingresos totales</p>
        </div>
    </div>
    <div class="admin-stat-card">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
        <div>
            <span><?= number_format($stats['socios']) ?></span>
            <p>Socios activos</p>
        </div>
    </div>
    <div class="admin-stat-card">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
            <polyline points="22,6 12,13 2,6"/>
        </svg>
        <div>
            <span><?= number_format($stats['mensajes']) ?></span>
            <p>Mensajes sin leer</p>
        </div>
    </div>
    <div class="admin-stat-card">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
        </svg>
        <div>
            <span><?= number_format($stats['eventos']) ?></span>
            <p>Eventos activos</p>
        </div>
    </div>
</div>

<!-- Últimas reservas -->
<div class="admin-block">
    <div class="admin-block-header">
        <h2>Últimas reservas</h2>
        <a href="reservas.php" class="admin-link">Ver todas →</a>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr>
                <th>Usuario</th><th>Instalación</th><th>Fecha</th><th>Hora</th><th>Estado</th>
            </tr></thead>
            <tbody>
            <?php foreach ($ultimas_reservas as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['nombre'] . ' ' . $r['apellidos']) ?></td>
                <td><?= htmlspecialchars($r['instalacion']) ?></td>
                <td><?= date('d M Y', strtotime($r['fecha'])) ?></td>
                <td><?= substr($r['hora_inicio'],0,5) ?> – <?= substr($r['hora_fin'],0,5) ?></td>
                <td><span class="perfil-badge perfil-badge--<?= $r['estado'] ?>"><?= ucfirst($r['estado']) ?></span></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Últimos mensajes -->
<div class="admin-block">
    <div class="admin-block-header">
        <h2>Últimos mensajes</h2>
        <a href="contactos.php" class="admin-link">Ver todos →</a>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr>
                <th>Nombre</th><th>Email</th><th>Mensaje</th><th>Fecha</th><th>Estado</th>
            </tr></thead>
            <tbody>
            <?php foreach ($ultimos_mensajes as $m): ?>
            <tr>
                <td><?= htmlspecialchars($m['nombre']) ?></td>
                <td><?= htmlspecialchars($m['email']) ?></td>
                <td><?= htmlspecialchars(mb_substr($m['mensaje'], 0, 60)) ?>…</td>
                <td><?= date('d M Y', strtotime($m['fecha'])) ?></td>
                <td><span class="perfil-badge <?= $m['leido'] ? 'perfil-badge--confirmada' : 'perfil-badge--pendiente' ?>"><?= $m['leido'] ? 'Leído' : 'Nuevo' ?></span></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/layout_end.php'; ?>