<?php
class Database
{
    private $host = "localhost";
    private $db = "parkify";
    private $user = "root";
    private $pass = "";
    private $charset = "utf8";

    public function connect()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Koneksi database gagal: " . $e->getMessage());
        }
    }
}
?>