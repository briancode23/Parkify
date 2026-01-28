<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/auth_helper.php';

isLogin();
userRole(['admin']);

$db = (new Database())->connect();

if (isset($_POST['simpan'])) {
    $sql = "INSERT INTO tb_tarif (jenis_kendaraan, tarif_per_jam) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        $_POST['jenis'],
        $_POST['tarif']
    ]);

    header("Location: ../views/tarif/index.php");
}