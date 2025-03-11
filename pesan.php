<?php
$id = $_GET['id'] ?? 0;
$rentals = [
    ["Fortuner", 1000000],
    ["Creta", 900000],
    ["CRV", 700000]
];

$pilih_mobil = $_POST['car'] ?? $rentals[$id][0];
$pilih_harga = array_column($rentals, 1, 0)[$pilih_mobil];
$supir = isset($_POST['supir']);
$durasi = $_POST['durasi'] ?? '';
$total_bayar = 0;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (!is_numeric($durasi)) {
        $errors[] = "Durasi harus berupa angka";
    }
    if (!preg_match('/^\d{16}$/', $_POST['identitas'] ?? '')) {
        $errors[] = "Nomor Identitas harus 16 digit angka.";
    }

    if (empty($errors)) {
        $biaya_supir = $supir ? 100000 * $durasi : 0;
        $total_harga_mobil = $pilih_harga * $durasi;
        $discount = ($durasi >= 3) ? 0.1 * $total_harga_mobil : 0;
        $total_bayar = ($total_harga_mobil - $discount) + $biaya_supir;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white text-center"><h5>Form Pemesanan</h5></div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error) echo "<li>$error</li>"; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form method="POST">
                    <input type="text" class="form-control mb-3" name="nama" placeholder="Nama Pemesan" value="<?= $_POST['nama'] ?? '' ?>" required>
                    
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label><br>
                        <input class="form-check-input" type="radio" name="gender" value="Laki-laki" <?= (isset($_POST['gender']) && $_POST['gender'] === 'Laki-laki') ? 'checked' : '' ?>> Laki-laki
                        <input class="form-check-input ms-3" type="radio" name="gender" value="Perempuan" <?= (isset($_POST['gender']) && $_POST['gender'] === 'Perempuan') ? 'checked' : '' ?>> Perempuan
                    </div>

                    <input type="text" class="form-control mb-3" name="identitas" placeholder="Nomor Identitas" value="<?= $_POST['identitas'] ?? '' ?>" required>
                    
                    <select class="form-select mb-3" name="car" onchange="this.form.submit()">
                        <?php foreach ($rentals as $car){ ?>
                            <option value="<?= $car[0] ?>" <?= ($car[0] === $pilih_mobil) ? 'selected' : '' ?>>
                                <?= $car[0] ?>
                            </option>
                        <?php } ?>
                    </select>

                    <input type="text" class="form-control mb-3" name="harga" value="<?= $pilih_harga ?>" readonly>

                    <input type="date" class="form-control mb-3" name="tanggal" placeholder="dd/mm/yyyy" value="<?= $_POST['tanggal'] ?? '' ?>" required>
                    
                    <input type="number" class="form-control mb-3" name="durasi" placeholder="Durasi Menginap" value="<?= $durasi ?>" required>

                    <div class="mb-3">
                        <input class="form-check-input" type="checkbox" name="supir" <?= $supir ? 'checked' : '' ?>> Termasuk Supir
                    </div>

                    <input type="text" class="form-control mb-3" id="total" value="<?= $total_bayar ? number_format($total_bayar, 0, ',', '.') : '' ?>" placeholder="Total Bayar" readonly>

                    <button type="submit" class="btn btn-primary">Hitung Total</button>
                    <button type="submit" formaction="hasil.php" class="btn btn-primary">Simpan</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
