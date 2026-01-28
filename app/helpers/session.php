<?php
/*ini_set('session.save_path', sys_get_temp_dir());
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => false, // true jika HTTPS
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

if (!isset($_SESSION['id_user']) && isset($_COOKIE['remember_token'])) {
    require_once __DIR__ . '/../config/Database.php';
    $db = (new Database())->connect();

    $stmt = $db->prepare(
        "SELECT * FROM tb_user WHERE remember_token=? AND status_aktif=1"
    );
    $stmt->execute([$_COOKIE['remember_token']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['role']    = $user['role'];
        $_SESSION['nama']    = $user['nama_lengkap'];
    }
}

if (!isset($_SESSION['fingerprint'])) {
    $_SESSION['fingerprint'] = md5($_SERVER['HTTP_USER_AGENT']);
}

if ($_SESSION['fingerprint'] !== md5($_SERVER['HTTP_USER_AGENT'])) {
    session_destroy();
    header("Location: /parkify/public/login.php");
    exit;
}*/
session_start();
