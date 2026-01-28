<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../helpers/session.php';

$db = (new Database())->connect();

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM tb_user WHERE username = ? AND status_aktif = 1";
    $stmt = $db->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        session_regenerate_id(true);
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nama'] = $user['nama_lengkap'];

        header("Location: /parkify/public/");
        exit;
    }

    header("Location: /parkify/public/?page=login&error=login");
}

if (!empty($_POST['remember'])) {
    $token = bin2hex(random_bytes(32));

    $stmt = $db->prepare(
        "UPDATE tb_user SET remember_token=? WHERE id_user=?"
    );
    $stmt->execute([$token, $user['id_user']]);

    setcookie(
        'remember_token',
        $token,
        time() + (86400 * 30),
        '/',
        '',
        false,
        true
    );
}
