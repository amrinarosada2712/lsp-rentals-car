<?php
$rentals = [
    ["Fortuner", 1000000, "fortuner.jpg"],
    ["Creta", 900000, "creta.jpg"],
    ["CRV", 700000, "crv.jpg"]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotel Kami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card {
            text-align: center;
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .carousel-item img {
            height: 450px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Rental Kami</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#produk">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang Kami</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Banner Kamar (Carousel) -->
    <div id="bannerKamar" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php foreach ($rentals as $rental => $car) { ?>
                <button type="button" data-bs-target="#bannerKamar" data-bs-slide-to="<?= $rental ?>" class="<?= $rental === 0 ? 'active' : '' ?>" aria-label="Slide <?= $rental + 1 ?>"></button>
            <?php } ?>
        </div>
        <div class="carousel-inner">
            <?php foreach ($rentals as $rental => $car) { ?>
                <div class="carousel-item <?= $rental === 0 ? 'active' : '' ?>">
                    <img src="img/<?= $car[2] ?>" class="d-block w-100" alt="<?= $car[0] ?>">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                        <h3><?= $car[0] ?></h3>
                        <p>Harga mulai dari Rp <?= number_format($car[1], 0, ',', '.') ?> per malam.</p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerKamar" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerKamar" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>



    <div class="container mt-5">
        <section id="produk">
            <h2 class="text-center">Jenis Kamar</h2>
            <div class="row">
                <?php foreach ($rentals as $rental => $car) { ?>
                <div class="col-md-4">
                    <div class="product-card">
                        <img src="img/<?= $car[2] ?>" alt="<?= $car[0] ?>">
                        <h5 class="mt-2"><?= $car[0] ?></h5>
                        <h5 class="mt-2">Rp <?= number_format($car[1], 0, ',', '.') ?></h5>
                        <a href="pesan.php?id=<?= $rental ?>" class="btn btn-primary mt-2">Pesan</a>                    </div>
                </div>
                <?php } ?>
            </div>
        </section>
    </div>

    <div class="container mt-5">
        <section id="tentang">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h2 class="card-title">Tentang Kami</h2>
                    <p class="card-text">Selamat datang di <strong>Rental Kami</strong>, penyedia layanan rental terpercaya yang siap memenuhi kebutuhan transportasi Anda.</p>
                    <p class="card-text">Kami berlokasi di <strong>Jalan Flamboyan III</strong>, dengan berbagai pilihan kendaraan yang nyaman, terawat, dan siap digunakan untuk perjalanan bisnis, wisata, atau keperluan pribadi.</p>
                    <p class="card-text">Kami selalu mengutamakan kepuasan pelanggan dengan menyediakan layanan profesional, harga kompetitif, serta kemudahan dalam proses penyewaan.</p>
                    <hr>
                    <h5>Hubungi Kami</h5>
                    <p><strong>📍 Alamat:</strong>Jalan Flamboyan III</p>
                    <p><strong>📞 Telepon:</strong> <a href="tel:[+62895383875089]">+62895383875089</a></p>
                    <p><strong>📧 Email:</strong> <a href="mailto:[rentalkami@gmail.com]">rentalkami@gmail.com</a></p>
                </div>
            </div>
        </section>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 Rental.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
