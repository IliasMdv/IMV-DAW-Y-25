<?php
$pageTitle = 'Eventos — Admin';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requiereAdmin();
$pdo = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_estado'])) {
    $stmt = $pdo->prepare('UPDATE eventos SET estado = ? WHERE id_evento = ?');
    $stmt->execute([$_POST['estado'], (int)$_POST['id_evento']]);
    header('Location: eventos.php');
    exit;
}

$eventos = $pdo->query('
    SELECT e.*, COUNT(ie.id_inscripcion) AS inscritos
    FROM eventos e
    LEFT JOIN inscripciones_eventos ie ON e.id_evento = ie.id_evento
    GROUP BY e.id_evento
    ORDER BY e.fecha DESC
')->fetchAll();

include __DIR__ . '/layout.php';
?>
<div class="admin-page-header">
    <h1>Eventos</h1>
    <p><?= count($eventos) ?> eventos en total</p>
</div>
<div class="admin-block">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr>
                <th>Título</th><th>Fecha</th><th>Ubicación</th><th>Aforo</th><th>Inscritos</th><th>Estado</th><th>Acciones</th>
            </tr></thead>
            <tbody>
            <?php foreach ($eventos as $e): ?>
            <tr>
                <td><?= htmlspecialchars($e['titulo']) ?></td>
                <td><?= date('d M Y', strtotime($e['fecha'])) ?> <?= $e['hora'] ? substr($e['hora'],0,5).'h' : '' ?></td>
                <td><?= htmlspecialchars($e['ubicacion'] ?? '—') ?></td>
                <td><?= $e['aforo_max'] ?? '∞' ?></td>
                <td><?= $e['inscritos'] ?></td>
                <td><span class="perfil-badge perfil-badge--<?= $e['estado'] === 'activo' ? 'confirmada' : 'cancelada' ?>"><?= ucfirst($e['estado']) ?></span></td>
                <td>
                    <form method="POST" style="display:inline">
                        <input type="hidden" name="id_evento" value="<?= $e['id_evento'] ?>">
                        <select name="estado" onchange="this.form.submit()" class="admin-select">
                            <?php foreach (['activo','cancelado','completo'] as $s): ?>
                            <option value="<?= $s ?>" <?= $e['estado'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
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