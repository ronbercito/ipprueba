<?php
declare(strict_types=1);
require '/home/xui/ipzstream/auth.php';
require '/home/xui/ipzstream/layout.php';

$user = ipz_require_admin();
$pdo = ipz_pdo();
$q = trim((string)($_GET['q'] ?? ''));
$sql = 'SELECT id, stream_display_name, stream_source, type, category_id, enabled FROM streams';
$params = [];
if ($q !== '') {
    $sql .= ' WHERE stream_display_name LIKE ?';
    $params[] = '%' . $q . '%';
}
$sql .= ' ORDER BY id DESC LIMIT 250';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$streams = $stmt->fetchAll();

ipz_header($user, 'Streams', 'streams');
?>
<h1 class="page-title">Streams</h1>
<div class="page-sub">Gestión de streams registrados</div>
<div class="panel">
<div class="toolbar"><form method="get"><input name="q" value="<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>" placeholder="Buscar stream..."></form><a class="btn" href="#">+ Añadir stream</a></div>
<div class="table-wrap"><table class="data-table"><thead><tr><th>ID</th><th>Nombre</th><th>Tipo</th><th>Categoría</th><th>Estado</th></tr></thead><tbody>
<?php if (!$streams): ?><tr><td colspan="5" class="empty">No hay streams registrados.</td></tr>
<?php else: foreach ($streams as $stream): ?><tr>
<td><?= (int)$stream['id'] ?></td>
<td><?= htmlspecialchars((string)$stream['stream_display_name'], ENT_QUOTES, 'UTF-8') ?></td>
<td><?= htmlspecialchars((string)$stream['type'], ENT_QUOTES, 'UTF-8') ?></td>
<td><?= htmlspecialchars((string)$stream['category_id'], ENT_QUOTES, 'UTF-8') ?></td>
<td><?= (int)$stream['enabled'] === 1 ? 'Activo' : 'Inactivo' ?></td>
</tr><?php endforeach; endif; ?>
</tbody></table></div></div>
<?php ipz_footer(); ?>
