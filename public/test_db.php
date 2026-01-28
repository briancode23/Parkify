<?php
require_once __DIR__ . '/../app/config/Database.php';

$db = (new Database())->connect();
echo "KONEKSI DATABASE BERHASIL";
