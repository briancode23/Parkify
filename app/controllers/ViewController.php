<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/auth_helper.php'

cekLogin();
cekRole(['admin','owner']);

$db = (new Database())->connect();
$data = $db->query(
    "SELECT l.*, u.nama_lengkap 
     FROM tb_log_aktivitas l
     JOIN tb_user u ON l.id_user = u.id_user
     ORDER BY waktu_aktivitas DESC"
)->fetchAll(PDO::FETCH_ASSOC);
    