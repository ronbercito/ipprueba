<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name('IPZSTREAMSESSID');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function ipz_pdo(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = require '/home/xui/ipzstream/bootstrap.php';
    }
    return $pdo;
}

function ipz_user(): ?array {
    if (empty($_SESSION['user_id'])) return null;
    $stmt = ipz_pdo()->prepare(
        'SELECT u.id,u.username,u.member_group_id,u.status,g.group_name,g.is_admin
         FROM users u
         LEFT JOIN users_groups g ON g.group_id=u.member_group_id
         WHERE u.id=? AND u.status=1 LIMIT 1'
    );
    $stmt->execute([(int)$_SESSION['user_id']]);
    $user = $stmt->fetch();
    return $user ?: null;
}

function ipz_require_admin(): array {
    $user = ipz_user();
    if (!$user || (int)$user['is_admin'] !== 1) {
        $_SESSION = [];
        header('Location: /ipz/login.php');
        exit;
    }
    return $user;
}

function ipz_csrf(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}

function ipz_check_csrf(string $token): bool {
    return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}
