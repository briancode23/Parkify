<h2>Parkir Keluar</h2>

<form method="POST" action="/parkify/app/controllers/ParkirController.php">
    <input type="number" name="id_kendaraan" placeholder="ID Kendaraan" required>
    <button type="submit" name="parkir_keluar">Proses Keluar</button>
</form>

<?php if (isset($_GET['total'])): ?>
    <h3>Total Bayar: Rp <?= number_format($_GET['total']) ?></h3>
<?php endif; ?>
