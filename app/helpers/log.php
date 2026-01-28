function logAktivitas($db, $id_user, $aksi) {
    $sql = "INSERT INTO tb_log_aktivitas (id_user, aktivitas, waktu_aktivitas)
            VALUES (?, ?, NOW())";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id_user, $aksi]);
}
