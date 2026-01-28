<?php
class Transaksi
{
    private $conn;
    private $table = "tb_transaksi";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function masuk($data)
    {
        $sql = "INSERT INTO {$this->table} (id_kendaraan, waktu_masuk, id_tarif, status, id_user, id_area) VALUES (?, NOW(), ?, 'masuk', ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['id_kendaraan'],
            $data['id_tarif'],
            $data['id_user'],
            $data['id_area']
        ]);
    }

    public function getAktif($id_kendaraan)
    {
        $sql = "SELECT t.*, tf.tarif_per_jam FROM {$this->table} t JOIN tb_tarif tf ON t.id_tarif = tf.id_tarif WHERE t.id_kendaraan = ? AND t.status = 'masuk'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id_kendaraan]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function keluar($id_parkir, $durasi, $total)
    {
        $sql = "UPDATE {$this->table} SET waktu_keluar = NOW(),
        durasi_jam = ?,
        biaya_total = ?,
        status = 'keluar'
        WHERE id_parkir = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$durasi, $total, $id_parkir]);
    }

    public function sudahMasuk($id_kendaraan)
    {
        $sql = "SELECT COUNT(*) FROM tb_transaksi WHERE id_kendaraan = ? AND status = 'masuk'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id_kendaraan]);
        return $stmt->fetchColumn() > 0;
    }
}
?>