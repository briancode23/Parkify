<?php
require_once __DIR__ . '/../../config/Database.php';
$db = (new Database())->connect();

$where = "WHERE t.status='keluar'";
$params = [];

/* Filter tanggal */
if (!empty($_GET['from']) && !empty($_GET['to'])) {
    $where .= " AND DATE(t.waktu_keluar) BETWEEN ? AND ?";
    $params[] = $_GET['from'];
    $params[] = $_GET['to'];
}

/* Filter jenis kendaraan */
if (!empty($_GET['jenis'])) {
    $where .= " AND k.jenis_kendaraan = ?";
    $params[] = $_GET['jenis'];
}

/* Filter petugas */
if (!empty($_GET['petugas'])) {
    $where .= " AND t.id_user = ?";
    $params[] = $_GET['petugas'];
}

$sql = "
    SELECT 
        t.*, 
        k.plat_nomor,
        k.jenis_kendaraan,
        u.nama_lengkap AS petugas
    FROM tb_transaksi t
    JOIN tb_kendaraan k ON t.id_kendaraan = k.id_kendaraan
    JOIN tb_user u ON t.id_user = u.id_user
    $where
    ORDER BY t.waktu_keluar DESC
";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<form method="GET">
    <label>Dari Tanggal</label><br>
    <input type="date" name="from" value="<?= $_GET['from'] ?? '' ?>"><br><br>

    <label>Sampai Tanggal</label><br>
    <input type="date" name="to" value="<?= $_GET['to'] ?? '' ?>"><br><br>

    <label>Jenis Kendaraan</label><br>
    <select name="jenis">
        <option value="">-- Semua --</option>
        <option value="motor" <?= ($_GET['jenis'] ?? '')=='motor'?'selected':'' ?>>Motor</option>
        <option value="mobil" <?= ($_GET['jenis'] ?? '')=='mobil'?'selected':'' ?>>Mobil</option>
        <option value="lainnya" <?= ($_GET['jenis'] ?? '')=='lainnya'?'selected':'' ?>>Lainnya</option>
    </select><br><br>

    <label>Petugas</label><br>
    <select name="petugas">
        <option value="">-- Semua --</option>
        <?php
        $users = $db->query("
            SELECT id_user, nama_lengkap 
            FROM tb_user 
            WHERE role='petugas'
        ")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $u):
        ?>
            <option value="<?= $u['id_user'] ?>"
                <?= ($_GET['petugas'] ?? '')==$u['id_user']?'selected':'' ?>>
                <?= $u['nama_lengkap'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Filter</button>
    <a href="/parkify/public/laporan">Reset</a>
</form>

<hr>



<h2>Laporan Parkir</h2>

<table border="1" cellpadding="6">
<tr>
    <th>Plat</th>
    <th>Jenis</th>
    <th>Petugas</th>
    <th>Masuk</th>
    <th>Keluar</th>
    <th>Durasi</th>
    <th>Total</th>
</tr>

<?php if (!$data): ?>
<tr>
    <td colspan="7" align="center">Tidak ada data</td>
</tr>
<?php endif; ?>

<?php foreach ($data as $d): ?>
<tr>
    <td><?= htmlspecialchars($d['plat_nomor']) ?></td>
    <td><?= ucfirst($d['jenis_kendaraan']) ?></td>
    <td><?= htmlspecialchars($d['petugas']) ?></td>
    <td><?= $d['waktu_masuk'] ?></td>
    <td><?= $d['waktu_keluar'] ?></td>
    <td><?= $d['durasi_jam'] ?> jam</td>
    <td>Rp <?= number_format($d['biaya_total']) ?></td>
</tr>
<?php endforeach; ?>
</table>

<?php
$total = array_sum(array_column($data, 'biaya_total'));
?>
<h3>Total Pendapatan: Rp <?= number_format($total) ?></h3>

