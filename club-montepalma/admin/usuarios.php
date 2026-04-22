<?php
$pageTitle = 'Usuarios — Admin';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requiereAdmin();
$pdo = getDB();

// Acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['toggle_activo'])) {
        $stmt = $pdo->prepare('UPDATE usuarios SET activo = NOT activo WHERE id_usuario = ?');
        $stmt->execute([(int)$_POST['id_usuario']]);
    }
    if (isset($_POST['cambiar_rol'])) {
        $stmt = $pdo->prepare('UPDATE usuarios SET rol = ? WHERE id_usuario = ?');
        $stmt->execute([$_POST['rol'], (int)$_POST['id_usuario']]);
    }
    header('Location: usuarios.php');
    exit;
}

$usuarios = $pdo->query('SELECT * FROM usuarios ORDER BY fecha_registro DESC')->fetchAll();
include __DIR__ . '/layout.php';
?>
<div class="admin-page-header">
    <h1>Usuarios</h1>
    <p><?= count($usuarios) ?> usuarios registrados</p>
</div>
<div class="admin-block">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr>
                <th>Nombre</th><th>Email</th><th>Teléfono</th><th>Rol</th><th>Registro</th><th>Estado</th><th>Acciones</th>
            </tr></thead>
            <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr class="<?= !$u['activo'] ? 'admin-row-inactive' : '' ?>">
                <td><?= htmlspecialchars($u['nombre'] . ' ' . $u['apellidos']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= htmlspecialchars($u['telefono'] ?? '—') ?></td>
                <td>
                    <form method="POST" style="display:inline">
                        <input type="hidden" name="id_usuario" value="<?= $u['id_usuario'] ?>">
                        <select name="rol" onchange="this.form.submit()" class="admin-select">
                            <?php foreach (['cliente','empleado','admin'] as $rol): ?>
                            <option value="<?= $rol ?>" <?= $u['rol'] === $rol ? 'selected' : '' ?>><?= ucfirst($rol) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" name="cambiar_rol" style="display:none"></button>
                    </form>
                </td>
                <td><?= date('d M Y', strtotime($u['fecha_registro'])) ?></td>
                <td><span class="perfil-badge <?= $u['activo'] ? 'perfil-badge--confirmada' : 'perfil-badge--cancelada' ?>"><?= $u['activo'] ? 'Activo' : 'Inactivo' ?></span></td>
                <td>
                    <form method="POST" style="display:inline">
                        <input type="hidden" name="id_usuario" value="<?= $u['id_usuario'] ?>">
                        <button type="submit" name="toggle_activo" class="admin-btn-sm <?= $u['activo'] ? 'admin-btn-danger' : 'admin-btn-success' ?>">
                            <?= $u['activo'] ? 'Desactivar' : 'Activar' ?>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include __DIR__ . '/layout_end.php'; ?>