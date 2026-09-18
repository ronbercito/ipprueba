<?php
declare(strict_types=1);
require '/home/xui/ipzstream/auth.php';
require '/home/xui/ipzstream/layout.php';

$user = ipz_require_admin();
$pdo = ipz_pdo();
$stats = [
    'streams' => (int)$pdo->query('SELECT COUNT(*) FROM streams')->fetchColumn(),
    'lines' => (int)$pdo->query('SELECT COUNT(*) FROM `lines`')->fetchColumn(),
    'users' => (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn(),
    'servers' => (int)$pdo->query('SELECT COUNT(*) FROM servers WHERE enabled=1')->fetchColumn(),
];

ipz_header($user, 'Dashboard', 'dashboard');
?>
<h1 class="page-title">Dashboard</h1>
<div class="page-sub">Panel de administración IPZStream</div>
<div class="cards">
<?php foreach ([['streams','Streams'],['lines','Clientes'],['users','Usuarios'],['servers','Servidores']] as [$key,$label]): ?>
<div class="card"><div class="card-value"><?= $stats[$key] ?></div><div class="card-label"><?= $label ?></div></div>
<?php endforeach; ?>
</div>
<div class="panel">Base de datos: <span class="ok">Conectada</span><br><br>Sesión administrativa: <span class="ok">Activa</span></div>
<?php ipz_footer(); ?>
