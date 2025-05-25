<?php 
session_start(); // Mulai sesi untuk mengakses informasi pengguna

$is_admin = isset($_SESSION['s_role']) && $_SESSION['s_role'] == 'admin';

// Koneksi ke database 
$conn = mysqli_connect("localhost","spkq4689","BT37Su3mVcBX61","spkq4689_car_showroom");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
// Ambil ID mobil dari URL
$car_id = isset($_GET['id']) ? intval($_GET['id']) : null;

// Periksa apakah ID mobil valid
if (!$car_id) {
    echo "Tidak ada mobil yang dipilih.";
    exit;
}

if ($is_admin) {
    // Logika khusus untuk admin
    $c_id = isset($_SESSION['c_id']) ? $_SESSION['c_id'] : null;

    // Cek apakah c_id ada
    if ($c_id) {
        // Query untuk mendapatkan showroom_id berdasarkan c_id dari tabel customer
        $showroom_query = "SELECT showroom_id FROM customer WHERE c_id = $c_id";
        $showroom_result = mysqli_query($conn, $showroom_query);

        // Cek apakah query berhasil dan ambil hasilnya
        if ($showroom_result && mysqli_num_rows($showroom_result) > 0) {
            $showroom = mysqli_fetch_assoc($showroom_result);
            $showroom_id = $showroom['showroom_id'];
        } else {
            echo "Tidak ada showroom yang ditugaskan untuk admin ini.";
            exit;
        }
    } else {
        echo "Session admin tidak memiliki c_id.";
        exit;
    }
}

$query = "SELECT * FROM Cars WHERE car_id = $car_id";
$result = mysqli_query($conn, $query);

// Ambil detail mobil dari database
$query = "
    SELECT Cars.*, Showrooms.name AS showroom_name, Showrooms.contact AS showroom_phone, Showrooms.location AS showroom_location
    FROM Cars
    JOIN Showrooms ON Cars.showroom_id = Showrooms.showroom_id
    WHERE Cars.car_id = $car_id
";
$result = mysqli_query($conn, $query);

// Periksa apakah query berhasil dan mobil ada
if ($car = mysqli_fetch_assoc($result)) {
    $car_name = $car['name'];
    $car_price = $car['price_asli'];
    $car_license_plate = $car['license_plate'];
    $car_physical_condition = $car['physical_condition'];
    $car_engine_condition = $car['engine_condition'];
    $car_year = $car['year_asli'];
    $car_ahp_value = $car['ahp_value'];
    $car_image = $car['image']; // Gambar yang disimpan dalam kolom 'image'
    $car_images = json_decode($car_image, true); // Decode JSON untuk mendapatkan array gambar
    $image_path = 'upload/'; // Path untuk gambar
    $showroom_name = $car['showroom_name'];
    $showroom_contact = $car['showroom_phone'];
    $showroom_id = $car['showroom_id'];
    $showroom_location = $car['showroom_location'];
} else {
    echo "Mobil tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE HTML>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $car_name; ?> Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #a50000; /* Warna latar belakang navbar */
            border: none;
            border-radius: 0;
            margin-bottom: 0;
            padding: 0;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            padding: 60px 20px;
        }

        .nav-item {
            position: relative; /* Untuk memastikan hover berlaku pada seluruh item */
        }

        .nav-link {
            display: flex;
            align-items: center; /* Teks di tengah vertikal */
            justify-content: center;
            padding: 0 20px; /* Berikan jarak horizontal */
            height: 100%; /* Tinggi penuh dari navbar */
            color: #fff !important; /* Warna teks tetap putih */
            text-decoration: none; /* Hilangkan garis bawah */
            transition: background-color 0.3s ease; /* Efek transisi saat hover */
        }

        .nav-link:hover {
            background-color: #800000; /* Warna hover mencakup seluruh area */
            color: #fff; /* Pastikan teks tetap terlihat */
        }

        .navbar-brand img {
            height: 70px; /* Tinggi logo */
        }

        .navbar-toggler {
            padding: 10px;
        }
        .table {
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .table th {
            background-color: #a50000;
            color: #fff;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .box_wrapper h1 {
            color: #a50000;
            font-weight: 700;
        }
        .carousel-inner img {
    height: 350px;
    width: 100%;
    object-fit: contain; /* Pastikan gambar tidak terpotong */
    border-radius: 5px;
    background-color: #f8f9fa; /* Tambahkan latar belakang jika gambar tidak penuh */
}
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="admin/admin.php">
        <img src="images/logoreal.png" alt="Logo" height="40">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <?php if ($is_admin): ?>
                <li class="nav-item"><a class="nav-link" href="http://localhost/showroom_mobil/showroom.php">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="admin/adminaddcar.php">Tambah Data Mobil</a></li>
                <li class="nav-item"><a class="nav-link" href="showroom.php">Kembali</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="about.html">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Kembali</a></li>
            <?php endif; ?>

        </ul>
    </div>
</nav>

<!-- Content -->
<div class="container">
    <div class="box_wrapper text-center mb-4">
        <h1><?php echo $showroom_name; ?></h1>
        <p class="text-muted"><?php echo $showroom_location; ?> | Kontak: <?php echo $showroom_contact; ?></p>
    </div>

    <div class="row">
        <!-- Carousel -->
        <div class="col-md-6">
            <div id="carCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($car_images as $index => $image): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <img src="<?php echo $image_path . $image; ?>" class="d-block w-100" alt="<?php echo $car_name; ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                <a class="carousel-control-prev" href="#carCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </a>
                <a class="carousel-control-next" href="#carCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        <!-- Table Details -->
        <div class="col-md-6">
            <table class="table table-hover table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Fitur</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td><?php echo $car_name; ?></td>
                    </tr>
                    <tr>
                        <td>Harga</td>
                        <td>Rp. <?php echo number_format($car_price, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td>No. Polisi</td>
                        <td><?php echo $car_license_plate; ?></td>
                    </tr>
                    <tr>
                        <td>Kondisi Fisik</td>
                        <td>
                            <?php
                            $physical_conditions = [
                                9 => 'Tanpa cacat, seperti baru',
                                7 => 'Sedikit goresan',
                                5 => 'Beberapa penyok dan goresan',
                                3 => 'Banyak penyok dan goresan',
                                1 => 'Rusak parah'
                            ];
                            echo $physical_conditions[$car_physical_condition] ?? 'Tidak diketahui';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Kondisi Mesin</td>
                        <td>
                            <?php
                            $engine_conditions = [
                                9 => 'Sangat baik (servis rutin, tanpa masalah)',
                                7 => 'Baik (beberapa perbaikan kecil)',
                                5 => 'Cukup (membutuhkan perawatan rutin)',
                                3 => 'Buruk (membutuhkan perbaikan besar)',
                                1 => 'Sangat buruk (mesin rusak)'
                            ];
                            echo $engine_conditions[$car_engine_condition] ?? 'Tidak diketahui';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tahun Keluaran</td>
                        <td><?php echo $car_year; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>


<?php 
// Tutup koneksi 
mysqli_close($conn); 
?>
