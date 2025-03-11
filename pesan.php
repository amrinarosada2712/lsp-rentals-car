<?php
    // Mengambil nilai 'id' dari URL, jika tidak ada, default ke 0
    $id = $_GET['id'] ?? 0;

    // Daftar mobil beserta harga sewanya per hari (dalam Rupiah)
    $rentals = [
        ["Fortuner", 1000000], 
        ["Creta", 900000], 
        ["CRV", 700000]
    ];

    // Menentukan mobil yang dipilih berdasarkan input form atau default dari daftar berdasarkan ID
    $pilih_mobil = $_POST['car'] ?? $rentals[$id][0];

    // Mendapatkan harga mobil yang dipilih menggunakan array_column untuk memetakan nama ke harga
    $pilih_harga = array_column($rentals, 1, 0)[$pilih_mobil];

    // Mengecek apakah opsi supir dipilih oleh pengguna
    $supir = isset($_POST['supir']);

    // Mengambil durasi sewa dari input pengguna, default kosong jika tidak ada
    $durasi = $_POST['durasi'] ?? '';

    // Inisialisasi total pembayaran
    $total_bayar = 0;

    // Array untuk menyimpan pesan error validasi
    $errors = [];

    // Mengecek apakah form telah dikirim (dengan metode POST)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validasi: Durasi harus angka dan lebih dari 0
        if (!is_numeric($durasi) || $durasi <= 0) {
            $errors[] = "Durasi harus berupa angka dan lebih dari 0.";
        }
        
        // Validasi: Nomor identitas harus 16 digit angka
        if (!preg_match('/^\d{16}$/', $_POST['identitas'] ?? '')) {
            $errors[] = "Nomor Identitas harus 16 digit angka.";
        }

        // Jika tidak ada error validasi, hitung total pembayaran
        if (empty($errors)) {
            // Menghitung biaya sewa mobil total berdasarkan durasi
            $total_harga_mobil = $pilih_harga * $durasi;

            // Memberikan diskon 10% jika durasi sewa 3 hari atau lebih
            $diskon = ($durasi >= 3) ? 0.1 * $total_harga_mobil : 0;

            // Menghitung biaya tambahan untuk supir jika dipilih (Rp 100.000 per hari)
            $biaya_supir = $supir ? 100000 * $durasi : 0;

            // Menghitung total pembayaran setelah dikurangi diskon dan ditambah biaya supir
            $total_bayar = $total_harga_mobil - $diskon + $biaya_supir;
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
            <div class="card-header bg-primary text-white text-center">
                <h5>Form Pemesanan</h5>
            </div>
            <div class="card-body">
                <!-- Menampilkan error jika ada -->
                <?php if ($errors) : ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Form Pemesanan -->
                <form method="POST">
                    <!-- Input Nama Pemesan -->
                    <input type="text" class="form-control mb-3" name="nama" placeholder="Nama Pemesan" value="<?= $_POST['nama'] ?? '' ?>" required>
                    
                    <!-- Input Jenis Kelamin -->
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label><br>
                        <input class="form-check-input" type="radio" name="gender" value="Laki-laki" <?= ($_POST['gender'] ?? '') === 'Laki-laki' ? 'checked' : '' ?>> Laki-laki
                        <input class="form-check-input ms-3" type="radio" name="gender" value="Perempuan" <?= ($_POST['gender'] ?? '') === 'Perempuan' ? 'checked' : '' ?>> Perempuan
                    </div>
                    
                    <!-- Input Nomor Identitas -->
                    <input type="text" class="form-control mb-3" name="identitas" placeholder="Nomor Identitas (16 digit)" value="<?= $_POST['identitas'] ?? '' ?>" required>
                    
                    <!-- Dropdown Pilihan Mobil -->
                    <select class="form-select mb-3" name="car" onchange="this.form.submit()">
                        <?php foreach ($rentals as $car) : ?>
                            <option value="<?= $car[0] ?>" <?= ($car[0] === $pilih_mobil) ? 'selected' : '' ?>>
                                <?= $car[0] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                   
                    <!-- Input Harga Mobil (Readonly) -->
                    <input type="text" class="form-control mb-3" name="harga" value="<?= number_format($pilih_harga, 0, ',', '.') ?>" readonly>
                    
                    <!-- Input Tanggal Sewa -->
                    <input type="date" class="form-control mb-3" name="tanggal" value="<?= $_POST['tanggal'] ?? '' ?>" required>
                    
                    <!-- Input Durasi Sewa -->
                    <input type="number" class="form-control mb-3" name="durasi" placeholder="Durasi Sewa (hari)" value="<?= $durasi ?>" required>
                    
                    <!-- Checkbox untuk memilih Supir -->
                    <div class="mb-3">
                        <input class="form-check-input" type="checkbox" name="supir" <?= $supir ? 'checked' : '' ?>> Termasuk Supir (Rp 100.000/hari)
                    </div>

                    <!-- Menampilkan Total Bayar -->
                    <input type="text" class="form-control mb-3" id="total" value="<?= $total_bayar ? number_format($total_bayar, 0, ',', '.') : '' ?>" placeholder="Total Bayar" readonly>
                    
                    <!-- Tombol untuk menghitung total -->
                    <button type="submit" class="btn btn-primary">Hitung Total</button>

                    <!-- Tombol Simpan (akan mengarahkan ke hasil.php) -->
                    <button type="submit" formaction="hasil.php" class="btn btn-primary">Simpan</button>
                    
                    <!-- Tombol Reset -->
                    <button type="reset" class="btn btn-danger">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
