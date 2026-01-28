<?php
require_once __DIR__ . '/../helpers/auth.php';

require_once __DIR__ . '/../helpers/auth_helper.php';
isLogin();

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Transaksi.php';
require_once __DIR__ . '/../models/AreaParkir.php';
require_once __DIR__ . '/../models/Tarif.php';

$db = (new Database())->connect();
$transaksi = new Transaksi($db);
$area = new AreaParkir($db);
$tarif = new Tarif($db);

if (isset($_POST['parkir_masuk'])) {
    if (empty($_POST['id_kendaraan']) || empty($_POST['id_area'])) {
        die("Data tidak lengkap");
    }

    if ($transaksi->sudahMasuk($_POST['id_kendaraan'])) {
        die("Kendaraan masih parkir");
    }

    if (!$area->tersedia($_POST['id_area'])) {
        die("Area parkir penuh");
    }

    try {
        $db->beginTransaction();

        $tarifData = $tarif->getByJenis($_POST['jenis_kendaraan']);

        $transaksi->masuk([
            'id_kendaraan' => $_POST['id_kendaraan'],
            'id_tarif' => $tarifData['id_tarif'],
            'id_user' => $_SESSION['id_user'],
            'id_area' => $_POST['id_area']
        ]);

        $area->tambahTerisi($_POST['id_area']);

        $db->commit();
        header("Location: ../views/parkir/masuk.php?id=success=1");

    } catch (Exception $e) {
        $db->rollBack();
        die("Gagal parkir masuk");
    }

    $tarifData = $tarif->getByJenis($_POST['jenis_kendaraan']);

    $transaksi->masuk([
        'id_kendaraan' => $_POST['id_kendaraan'],
        'id_parkir' => $tarifData['id_tarif'],
        'id_user' => $_SESSION['id_user'],
        'id_area' => $_POST['id_area']
    ]);

    $area->tambahTerisi($_POST['id_kendaraan']);
    header("Location: ../views/parkir/masuk.php?success=1");
}

if (isset($_POST['parkir_keluar'])) {

    $data = $transaksi->getAktif($_POST['id_kendaraan']);

    if (!$data) {
        die("Data parkir tidak ditemukan!");
    }

    try {
        $db->beginTransaction();

        $masuk = strtotime($data['waktu_masuk']);
        $keluar = time();
        $durasi = max(1, ceil(($keluar - $masuk) / 3600));
        $total = $durasi * $data['tarif_per_jam'];

        $transaksi->keluar($data['id_parkir'], $durasi, $total);
        $area = $durasi * $data['tarif_per_jam'];

        $db->commit();
        header("Location: ../views/parkir/keluar.php?total=$total");

    } catch (Exception $e) {
        $db->rollBack();
        die("Gagal parkir keluar!");
    }

    $data = $transaksi->getAktif($_POST['id_kendaraan']);

    $masuk = strtotime($data['waktu_masuk']);
    $keluar = time();
    $durasi = ceil(($keluar - $masuk) / 3600);
    $total = $durasi * $data['tarif_per_jam'];

    $transaksi->keluar($data['id_parkir'], $durasi, $total);
    $area->kurangTerisi($data['id_area']);

    header("Location: ../views/parkir/keluar.php?total=$total");
}
?>