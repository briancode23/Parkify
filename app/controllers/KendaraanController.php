<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../helpers/auth.php';

require_once __DIR__ . '/../helpers/auth_helper.php';

isLogin();

$db = (new Database())->connect();

if (isset($_POST['tambah'])) {
    $sql = "INSERT INTO tb_kendaraan (plat_nomor, jenis_kendaraan, warna, pemilik, id_user) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        $_POST['plat'],
        $_POST['jenis'],
        $_POST['warna'],
        $_POST['pemilik'],
        $_SESSION['id_user']
    ]);
    header("Location: ../views/kendaraan/index.php");
}

if (isset($_GET['hapus'])) {
    $stmt = $db->prepare("DELETE FROM tb_kendaraan WHERE id_kendaraan = ?");
    $stmt->execute([$_GET['hapus']]);
    header("Location: ../views/kendaraan/index.php");
}