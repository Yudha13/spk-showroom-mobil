<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start the session to access user roles

// Database connection
$conn = mysqli_connect("localhost","spkq4689","BT37Su3mVcBX61","spkq4689_car_showroom");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize search variables
$search = isset($_POST['search']) ? mysqli_real_escape_string($conn, $_POST['search']) : '';
$min_price = isset($_POST['min_price']) && $_POST['min_price'] !== '' 
    ? (float)str_replace('.', '', $_POST['min_price']) 
    : null;
$max_price = isset($_POST['max_price']) && $_POST['max_price'] !== '' 
    ? (float)str_replace('.', '', $_POST['max_price']) 
    : null;


// Prepare the SQL statement
$query = "SELECT Cars.*, Showrooms.name AS showroom_name, Showrooms.contact AS showroom_contact 
          FROM Cars 
          JOIN Showrooms ON Cars.showroom_id = Showrooms.showroom_id 
          WHERE 1=1";

if ($search !== '') {
    $query .= " AND Cars.name LIKE '%$search%'";
}
if ($min_price !== null && $min_price > 0) {
    $query .= " AND Cars.price_asli >= " . (float)$min_price;
}
if ($max_price !== null && $max_price > 0) {
    $query .= " AND Cars.price_asli <= " . (float)$max_price;
}


$query .= " ORDER BY Cars.ahp_value DESC";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Available Cars</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
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
        .search-container {
            margin: 20px auto;
            max-width: 900px;
        }
        .search-container input, .search-container button {
            margin-right: 10px;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .card-img-top {
            width: 100%; /* Mengatur lebar gambar mengikuti lebar kartu */
            height: 180px; /* Tinggi tetap */
            object-fit: cover; /* Menjaga proporsi gambar tanpa terdistorsi */
            border-radius: 5px; /* (Opsional) Membuat sudut gambar melengkung */
        }

    </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">
        <img src="images/logoreal.png" alt="Showroom Mobil">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active"><a class="nav-link" href="index.php">Beranda</a></li>
            <li class="nav-item"><a class="nav-link" href="about.html">Tentang</a></li>
        </ul>
    </div>
</nav>

<!-- Search Form -->
<div class="search-container text-center">
    <form method="POST" action="">
        <input type="text" name="search" placeholder="Cari Nama Mobil..." class="form-control d-inline-block" style="width: 200px;" value="<?php echo htmlspecialchars($search); ?>">
        <input type="text" id="minPrice" name="min_price" placeholder="Harga Minimal" class="form-control d-inline-block" style="width: 150px;" value="<?php echo $min_price !== null ? htmlspecialchars(number_format($min_price, 0, ',', '.')) : ''; ?>">
        <input type="text" id="maxPrice" name="max_price" placeholder="Harga Maksimal" class="form-control d-inline-block" style="width: 150px;" value="<?php echo $max_price !== null ? htmlspecialchars(number_format($max_price, 0, ',', '.')) : '';  ?>">
        <button type="submit" class="btn btn-danger">Cari</button>
    </form>
</div>

<!-- Main Content -->
<div class="container-fluid">
    <div class="row">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $image_json = $row['image'];
                $image_path = 'images/default.jpg'; // Default image

                if (!empty($image_json)) {
                    $images = json_decode($image_json, true);
                    if (is_array($images) && !empty($images)) {
                        $first_image = $images[0];
                        $image_path = 'upload/' . $first_image;
                    }
                }

                echo "
                <div class='col-lg-3 col-md-4 col-sm-6'>
                    <div class='card'>
                        <img class='card-img-top' src='$image_path' alt='Car Image'>
                        <div class='card-body'>
                            <h5 class='card-title'>" . htmlspecialchars($row['name']) . "</h5>
                            <p>Harga: Rp. " . number_format($row['price_asli'], 0, ',', '.') . "</p>
                            <p>Showroom: " . htmlspecialchars($row['showroom_name']) . "</p>
                            <p>Kontak: " . htmlspecialchars($row['showroom_contact']) . "</p>
                            <a href='car.php?id=" . htmlspecialchars($row['car_id']) . "' class='btn btn-danger btn-block'>Lihat Detail</a>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "<p class='text-center'>Tidak ada mobil yang ditemukan.</p>";
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function formatRupiah(input) {
    let value = input.value.replace(/[^0-9]/g, ''); // Hanya angka
    let formatted = new Intl.NumberFormat('id-ID').format(value);
    input.value = formatted;
}

document.getElementById('minPrice').addEventListener('input', function () {
    formatRupiah(this);
});

document.getElementById('maxPrice').addEventListener('input', function () {
    formatRupiah(this);
});

</script>

</body>
</html>

