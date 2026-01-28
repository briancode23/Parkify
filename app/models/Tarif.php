<?php
class Tarif
{
    private $conn;
    private $table = "tb_tarif";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getByJenis($jenis)
    {
        $sql = "SELECT * FROM {$this->table} WHERE jenis_kendaraan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$jenis]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>