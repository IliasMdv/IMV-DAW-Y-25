<?php
$pageTitle = 'Mensajes — Admin';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requiereAdmin();
$pdo = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marcar_leido'])) {
    $stmt = $pdo->prepare('UPDATE contactos SET leido = 1 WHERE id_contacto = ?');
    $stmt->execute([(int)$_POST['id_contacto']]);
    header('Location: contactos.php');
    exit;
}

$contactos = $pdo->query('SELECT * FROM contactos ORDER BY fecha DESC')->fetchAll();
include __DIR__ . '/layout.php';
?>
<div class="admin-page-header">
    <h1>Mensajes de contacto</h1>
    <p><?= count(array_filter($contactos, fn($c) => !$c['leido'])) ?> sin leer</p>
</div>
<div class="admin-block">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr>
                <th>Nombre</th><th>Email</th><th>Teléfono</th><th>Mensaje</th><th>Fecha</th><th>Estado</th><th></th>
            </tr></thead>
            <tbody>
            <?php foreach ($contactos as $c): ?>
            <tr class="<?= !$c['leido'] ? 'admin-row-new' : '' ?>">
                <td><?= htmlspecialchars($c['nombre']) ?></td>
                <td><a href="mailto:<?= htmlspecialchars($c['email']) ?>" class="admin-link"><?= htmlspecialchars($c['email']) ?></a></td>
                <td><?= htmlspecialchars($c['telefono'] ?? '—') ?></td>
                <td class="admin-td-msg"><?= htmlspecialchars(mb_substr($c['mensaje'], 0, 80)) ?>…</td>
                <td><?= date('d M Y H:i', strtotime($c['fecha'])) ?></td>
                <td><span class="perfil-badge <?= $c['leido'] ? 'perfil-badge--confirmada' : 'perfil-badge--pendiente' ?>"><?= $c['leido'] ? 'Leído' : 'Nuevo' ?></span></td>
                <td>
                    <?php if (!$c['leido']): ?>
                    <form method="POST">
                        <input type="hidden" name="id_contacto" value="<?= $c['id_contacto'] ?>">
                        <button type="submit" name="marcar_leido" class="admin-btn-sm admin-btn-success">Marcar leído</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include __DIR__ . '/layout_end.php'; ?>