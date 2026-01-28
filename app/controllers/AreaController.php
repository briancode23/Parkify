<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/auth_helper.php';

isLogin();
userRole(['admin']);

$db = (new Database())->connect();

if (isset($_POST['tambah'])) {
    $sql = "INSERT INTO tb_area_parkir (nama_area, kapasitas, terisi) VALUES (?, ?, 0)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        $_POST['nama_area'],
        $_POST['kapasitas']
    ]);
    header("Location: ../views/area/index.php");
}