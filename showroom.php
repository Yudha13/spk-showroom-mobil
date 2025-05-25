<?php
session_start(); // Mulai session untuk mengakses peran pengguna

// Pastikan session berisi data yang benar
$is_admin = isset($_SESSION['s_role']) && $_SESSION['s_role'] == 'admin';

// Koneksi ke database
$conn = mysqli_connect("localhost","spkq4689","BT37Su3mVcBX61","spkq4689_car_showroom");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
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
} else {
    // Ambil ID showroom dari URL
$showroom_id = isset($_GET['id']) ? intval($_GET['id']) : null;

// Periksa apakah ID showroom valid
if (!$showroom_id) {
    echo "Tidak ada mobil yang dipilih.";
    exit;
}
}
// Ambil data mobil dari showroom
$car_query = "SELECT * FROM Cars WHERE showroom_id = $showroom_id";
$car_result = mysqli_query($conn, $car_query);

// Debugging: Menampilkan jumlah mobil yang ditemukan
//echo "Jumlah mobil yang ditemukan: " . mysqli_num_rows($car_result) . "<br>";

// Ambil informasi showroom
$showroom_query = "SELECT * FROM Showrooms WHERE showroom_id = $showroom_id";
$showroom_result = mysqli_query($conn, $showroom_query);

// Cek apakah showroom ada
if ($showroom = mysqli_fetch_assoc($showroom_result)) {
    $showroom_name = $showroom['name'];
    $showroom_description = $showroom['description'];
    $showroom_contact = $showroom['contact'];
    $showroom_location = $showroom['location'];
} else {
    echo "Showroom tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $showroom['name'] ?? 'Showroom'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            margin: 0;
            font-family: Arial, sans-serif;
        }
      /* Navbar */
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
        .main-content {
            padding: 20px;
        }
        .car-card {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 25px; /* Sedikit perbesar jarak antar kartu */
        padding: 20px; /* Tambahkan padding untuk membuat kartu lebih besar */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transform: scale(1.05); /* Sedikit perbesar tampilan kartu */
        transition: transform 0.2s ease-in-out; /* Tambahkan animasi saat hover */
    }

    .car-card img {
        width: 100%;
        height: 230px; /* Sedikit perbesar tinggi gambar */
        object-fit: cover;
    }
        .car-details {
            text-align: center;
            margin-top: 10px;
        }
        .footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 15px 0;
            position: relative;
        }
    </style>
</head>
<body>
</nav>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
      <a class="navbar-brand" href="#">
        <img src="images/logoreal.png" alt="Showroom Mobil" />
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
        <?php if ($is_admin): ?>
          <li class="nav-item active"><a class="nav-link" href="showroom.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="admin/adminaddcar.php">Tambah Mobil</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Keluar</a></li>
        <?php else: ?>
          <li class="nav-item active"><a class="nav-link" href="index.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="about.html">Tentang</a></li>
        <?php endif; ?>
        </ul>
      </div>
    </nav>

<div class="main-content">
    <div class="container">
        <h1 class="text-center"><?php echo $showroom['name']; ?></h1>
        <p class="text-center"><?php echo $showroom['description']; ?></p>
        <div class="row">
                <?php 
                $counter = 0;
                while ($car = mysqli_fetch_assoc($car_result)): ?>
                    <div class="col-md-3"> <!-- Ubah col-md-4 menjadi col-md-3 -->
                        <div class="car-card">
                            <img src="upload/<?php echo json_decode($car['image'])[0]; ?>" alt="<?php echo $car['name']; ?>">
                            <div class="car-details">
                                <h4><?php echo $car['name']; ?></h4>
                                <p>Harga: Rp. <?php echo number_format($car['price_asli'], 0, ',', '.'); ?></p>
                                <p>Tahun: <?php echo $car['year_asli']; ?></p>
                                <a href="car.php?id=<?php echo $car['car_id']; ?>" class="btn btn-danger">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                    $counter++;
                    if ($counter % 4 == 0) echo '</div><div class="row">'; // Ubah angka 3 menjadi 4
                endwhile; 
                ?>
            </div>
    </div>
</div>

<div class="footer">
    <p>&copy; 2024 Car Showroom. All Rights Reserved.</p>
</div>

</body>
</html>

<?php
// Tutup koneksi
mysqli_close($conn);
?>
