<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/auth_helper.php';

isLogin();
userRole('admin');

$db = (new Database())->connect();

if (isset($_POST['tambah'])) {
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO tb_user (nama_lengkap, username, password, role, status_aktif) VALUES (?, ?, ?, ?, 1)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        $_POST['nama'],
        $_POST['username'],
        $hash,
        $_POST['role']
    ]);

    header("Location: ../views/user/index.php");
}

if (isset($_GET['hapus'])) {
    $stmt = $db->prepare("DELETE FROM tb_user WHERE id_user = ?");
    $stmt->execute([$_GET['hapus']]);
    header("Location: ../views/user/index.php");
}