<h2>Parkir Masuk</h2>
<form action="../../controllers/ParkirController.php" method="POST">
    <input type="hidden" name="id_kendaraan" value="1">

    <select name="jenis_kendaraan">
        <option value="motor">Motor</option>
        <option value="mobil">Mobil</option>
    </select>

    <select name="id_area">
        <option value="1">Area A</option>
        <option value="2">Area B</option>
    </select>

    <button type="submit" name="parkir_masuk">Parkir Masuk</button>
</form>