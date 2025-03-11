<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $identitas = $_POST['identitas'];
    $gender = $_POST['gender'];
    $car = $_POST['car'];
    $durasi = $_POST['durasi'] ?? 1;
    $harga = $_POST['harga'];
    $supir = isset($_POST['supir']);
    
    // Hitung total bayar
    $hargaTotal = $harga * $durasi;
    $diskon = ($durasi >= 3) ? 0.1 * $hargaTotal : 0;
    $biaya_supir = $supir ? (80000 * $durasi) : 0;
    $totalBayar = ($hargaTotal - $diskon) + $biaya_supir;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-success text-white text-center"><h5>Detail Pemesanan</h5></div>
            <div class="card-body">
                <p><strong>Nama Pemesan:</strong> <?= $nama ?></p>
                <p><strong>Nomor Identitas:</strong> <?= $identitas ?></p>
                <p><strong>Jenis Kelamin:</strong> <?= $gender ?></p>
                <p><strong>Tipe Mobil:</strong> <?= $car ?></p>
                <p><strong>Durasi nyewa:</strong> <?= $durasi ?> Hari</p>
                <p><strong>Discount:</strong> <?= ($durasi >= 3) ? '10%' : '0%' ?></p>
                <p><strong>Total Bayar:</strong> Rp <?= number_format($totalBayar, 0, ',', '.') ?></p>

                <a href="index.php" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
