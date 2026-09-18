<?php
declare(strict_types=1);

function ipz_header(array $user, string $title, string $active = 'dashboard'): void {
    $items = [
        'dashboard' => ['Dashboard', '/ipz/dashboard.php'],
        'streams' => ['Streams', '/ipz/streams.php'],
        'clients' => ['Clientes', '#'],
        'bouquets' => ['Bouquets', '#'],
        'epg' => ['EPG', '#'],
        'servers' => ['Servidores', '#'],
        'settings' => ['Configuración', '#'],
    ];
    ?><!doctype html>
<html lang="es"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?> - IPZStream</title>
<link rel="stylesheet" href="/ipz/assets/ipz.css">
</head><body>
<header class="topbar"><a class="brand" href="/ipz/dashboard.php">IPZ<span>Stream</span></a>
<div class="account"><?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?><a href="/ipz/logout.php">Cerrar sesión</a></div></header>
<div class="app"><aside class="sidebar"><nav>
<?php foreach ($items as $key => [$label,$url]): ?>
<a class="<?= $active === $key ? 'active' : '' ?>" href="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></a>
<?php endforeach; ?>
</nav></aside><main class="content">
<?php
}

function ipz_footer(): void {
    ?></main></div></body></html><?php
}
