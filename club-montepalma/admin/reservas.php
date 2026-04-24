<?php
$pageTitle = 'Reservas — Admin';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requiereAdmin();
$pdo = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_estado'])) {
    $stmt = $pdo->prepare('UPDATE reservas SET estado = ? WHERE id_reserva = ?');
    $stmt->execute([$_POST['estado'], (int)$_POST['id_reserva']]);
    header('Location: reservas.php');
    exit;
}

$reservas = $pdo->query('
    SELECT r.*, u.nombre, u.apellidos, i.nombre AS instalacion
    FROM reservas r
    JOIN usuarios u ON r.id_usuario = u.id_usuario
    JOIN instalaciones i ON r.id_instalacion = i.id_instalacion
    ORDER BY r.fecha DESC, r.hora_inicio DESC
')->fetchAll();

include __DIR__ . '/layout.php';
?>
<div class="admin-page-header">
    <h1>Reservas</h1>
    <p><?= count($reservas) ?> reservas en total</p>
</div>
<div class="admin-block">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr>
                <th>Usuario</th><th>Instalación</th><th>Fecha</th><th>Hora</th><th>Precio</th><th>Estado</th><th>Acciones</th>
            </tr></thead>
            <tbody>
            <?php foreach ($reservas as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['nombre'] . ' ' . $r['apellidos']) ?></td>
                <td><?= htmlspecialchars($r['instalacion']) ?></td>
                <td><?= date('d M Y', strtotime($r['fecha'])) ?></td>
                <td><?= substr($r['hora_inicio'],0,5) ?> – <?= substr($r['hora_fin'],0,5) ?></td>
                <td><?= $r['precio_total'] ? number_format($r['precio_total'],2) . ' €' : '—' ?></td>
                <td><span class="perfil-badge perfil-badge--<?= $r['estado'] ?>"><?= ucfirst($r['estado']) ?></span></td>
                <td>
                    <form method="POST" style="display:inline">
                        <input type="hidden" name="id_reserva" value="<?= $r['id_reserva'] ?>">
                        <select name="estado" onchange="this.form.submit()" class="admin-select">
                            <?php foreach (['pendiente','confirmada','cancelada'] as $e): ?>
                            <option value="<?= $e ?>" <?= $r['estado'] === $e ? 'selected' : '' ?>><?= ucfirst($e) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" name="cambiar_estado" style="display:none"></button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include __DIR__ . '/layout_end.php'; ?>