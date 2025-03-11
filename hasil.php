<?php
// Periksa apakah form telah dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $nama = htmlspecialchars($_POST['nama'] ?? 'Tidak diisi');
    $identitas = htmlspecialchars($_POST['identitas'] ?? 'Tidak diisi');
    $gender = htmlspecialchars($_POST['gender'] ?? 'Tidak diisi');
    $car = htmlspecialchars($_POST['car'] ?? 'Tidak diisi');
    $durasi = $_POST['durasi'] ?? 1;
    $harga = str_replace('.', '', $_POST['harga'] ?? 0); // Menghapus format angka sebelum dikalkulasi
    $supir = isset($_POST['supir']);

    // Konversi nilai durasi dan harga ke tipe numerik untuk perhitungan
    $durasi = (int) $durasi;
    $harga = (int) $harga;
    
    // Menghitung total harga sewa mobil
    $total_harga_mobil = $harga * $durasi;

    // Menghitung diskon jika durasi >= 3 hari (diskon 10%)
    $diskon = ($durasi >= 3) ? 0.1 * $total_harga_mobil : 0;

    // Menghitung biaya supir jika dipilih (Rp 100.000 per hari)
    $biaya_supir = $supir ? (100000 * $durasi) : 0;

    // Total pembayaran akhir setelah diskon dan biaya supir
    $totalBayar = ($total_harga_mobil - $diskon) + $biaya_supir;
} else {
    // Jika halaman diakses langsung tanpa form, redirect ke halaman utama
    header("Location: index.php");
    exit();
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
            <div class="card-header bg-success text-white text-center">
                <h5>Detail Pemesanan</h5>
            </div>
            <div class="card-body">
                <p><strong>Nama Pemesan:</strong> <?= $nama ?></p>
                <p><strong>Nomor Identitas:</strong> <?= $identitas ?></p>
                <p><strong>Jenis Kelamin:</strong> <?= $gender ?></p>
                <p><strong>Mobil yang Dipilih:</strong> <?= $car ?></p>
                <p><strong>Supir:</strong> <?= $supir ? 'Ya' : 'Tidak' ?></p>
                <p><strong>Durasi Sewa:</strong> <?= $durasi ?> Hari</p>
                <p><strong>Diskon:</strong> <?= ($diskon > 0) ? '10%' : '0%' ?></p>
                <p><strong>Total Bayar:</strong> Rp <?= number_format($totalBayar, 0, ',', '.') ?></p>

                <a href="index.php" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>