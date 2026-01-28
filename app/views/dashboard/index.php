<?php
require_once __DIR__ . '/../../config/Database.php';
$db = (new Database())->connect();

$aktif = $db->query(
    "SELECT COUNT(*) FROM tb_transaksi WHERE status='masuk'"
)->fetchColumn();

$totalHariIni = $db->query(
    "SELECT SUM(biaya_total) FROM tb_transaksi
     WHERE status='keluar' AND DATE(waktu_keluar)=CURDATE()"
)->fetchColumn();
?>

<h2>Dashboard Parkify</h2>

<p>👤 User: <?= $_SESSION['nama'] ?> (<?= $_SESSION['role'] ?>)</p>

<ul>
    <li>🚗 Kendaraan parkir aktif: <?= $aktif ?></li>
    <li>💰 Pendapatan hari ini: Rp <?= number_format($totalHariIni ?? 0) ?></li>
</ul>

<hr>

<a href="/parkify/app/views/parkir/masuk.php">Parkir Masuk</a> |
<a href="/parkify/app/views/parkir/keluar.php">Parkir Keluar</a> |
<a href="/parkify/app/views/laporan/index.php">Laporan</a> |
<a href="/parkify/app/controllers/AuthController.php?logout=1">Logout</a>
