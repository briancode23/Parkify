<?php
require_once __DIR__ . '/../helpers/session.php';

/* Hapus semua session */
$_SESSION = [];
session_unset();
session_destroy();

/* Hapus cookie session */
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

/* Hapus remember me */
setcookie('remember_token', '', time() - 3600, '/');

header("Location: /parkify/public/?page=login");
exit;
