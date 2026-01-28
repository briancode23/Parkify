<?php
class AreaParkir
{
    private $conn;
    private $table = "tb_area_parkir";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        return $this->conn
            ->query("SELECT * FROM {$this->table}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambahTerisi($id_area)
    {
        $sql = "UPDATE {$this->table} SET terisi = terisi + 1 WHERE id_area = ? AND terisi < kapasitas";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id_area]);
    }

    public function kurangTerisi($id_area)
    {
        $sql = "UPDATE {$this->table} SET terisi = terisi - 1 WHERE id_area = ? AND terisi > 0";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id_area]);
    }

    public function tersedia($id_area)
    {
        $sql = "SELECT kapasitas, terisi FROM tb_area_parkir WHERE id_area = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id_area]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data && $data['terisi'] < $data['kapasitas'];
    }
}