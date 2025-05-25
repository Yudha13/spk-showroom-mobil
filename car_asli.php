<?php 
session_start(); // Mulai sesi untuk mengakses informasi pengguna

// Koneksi ke database 
$conn = mysqli_connect("localhost", "root", "", "car_showroom");
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

// Ambil detail mobil dari database
$query = "SELECT * FROM Cars WHERE car_id = $car_id";
$result = mysqli_query($conn, $query);

// Periksa apakah query berhasil dan mobil ada
// Ambil detail mobil dari database, termasuk semua kolom yang dibutuhkan
// Query to get car details along with the showroom's phone number and other details
$query = "
    SELECT Cars.*, Showrooms.name AS showroom_name, Showrooms.contact AS showroom_phone, Showrooms.location AS showroom_location
    FROM Cars
    JOIN Showrooms ON Cars.showroom_id = Showrooms.showroom_id
    WHERE Cars.car_id = $car_id
";


$result = mysqli_query($conn, $query);

// Check if the query was successful and the car exists
if ($car = mysqli_fetch_assoc($result)) {
    $car_name = $car['name'];
    $car_price = $car['price'];
    $car_license_plate = $car['license_plate'];
    $car_physical_condition = $car['physical_condition'];
    $car_engine_condition = $car['engine_condition'];
    $car_year = $car['year'];
    $car_ahp_value = $car['ahp_value'];
    $car_image = $car['image'];
    $image_path = 'upload/' . $car_image;
    $car_description = $car['description'];
    $showroom_name = $car['showroom_name'];
    $showroom_contact = $car['showroom_phone'];
    $showroom_location = $car['showroom_location'];
    // Phone number from the Showrooms table
}
 else {
    echo "Mobil tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo $car_name; ?> Detail</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div class="header">
    <div class="wrap">
        <div class="header-bot">
            <div class="logo">
                <a href="index.html"><img src="images/logo.png" alt="Logo" style="width:450px; height: 160px;"></a>
            </div>
            <div class="cart">
                <div class="menu-main">
                    <?php
                    if (isset($_SESSION['s_name'])) {
                        echo '<ul class="dc_css3_menu">';
                        echo '<li class="active"><a href="indexlogin.php">Beranda</a></li>';
                        echo '<li><a href="services.php">Merek</a></li>';
                        echo '<li><a href="booking.php">Pesan</a></li>';
                        echo '<li><a href="orders.php">Pesanan</a></li>';
                        echo '<li><a href="logout.php">Keluar</a></li>';
                        echo '</ul>';
                    } else {
                        echo '<ul class="dc_css3_menu">';
                        echo '<li class="active"><a href="index.php">Beranda</a></li>';
                        echo '<li><a href="about.html">Tentang</a></li>';
                        echo '<li><a href="login.php">Masuk</a></li>';
                        echo '</ul>';
                    }
                    ?>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<div class="header-bottom">
    <div class="wrap">
        <div class="single">
            <div class="box_wrapper">
                <h1><?php echo $showroom_name; ?></h1> <!-- Nama showroom ditampilkan di sini -->
            </div>
            <div class="single-top">
                <div class="lsidebar span_1_of_s" style="float:left; width:40%;">
                <img src="<?php echo $image_path; ?>" alt="<?php echo $car_name; ?>" style="width: 100%; height: auto;">
                </div>

                <div class="car_profile span_2_of_3" style="float:right; width:55%;">
                    <table class="table table-bordered table-responsive table-striped table-hover table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center">Fitur</th>
                                <th class="text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr>
                                <td>Nama</td>
                                <td><?php echo $car_name; ?></td>
                            </tr>
                            <tr>
                                <td>Harga</td>
                                <td>Rp.<?php echo $car_price; ?></td>
                            </tr>
                            <tr>
                                <td>No. Polisi</td>
                                <td><?php echo $car_license_plate; ?></td>
                            </tr><tr>
                                <td>Kondisi Fisik</td>
                                <td><?php echo $car_physical_condition; ?></td>
                            </tr><tr>
                                <td>Kondisi Mesin</td>
                                <td><?php echo $car_engine_condition; ?></td>
                            </tr><tr>
                                <td>Tahun Keluaran</td>
                                <td><?php echo $car_year; ?></td>
                            </tr><tr>
                                <td>No. HP</td>
                                <td><?php echo $showroom_contact; ?></td>
                            </tr><tr>
                                <td>Alamat</td>
                                <td><?php echo $showroom_location; ?></td>
                            </tr>
                            <!-- Tambahkan detail mobil lainnya secara dinamis dari database di sini -->
                        </tbody>
                    </table>
                </div>

                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<!-- Deskripsi mobil di bagian bawah -->
<div class="footer" style="position: fixed; bottom: 0; width: 100%; background-color: #333; color: white; padding: 10px;">
    <div class="wrap">
        <div class="car-description">
            <h3>Deskripsi <?php echo $car_name; ?></h3>
            <p><?php echo $car_description; ?></p>
        </div>
    </div>
</div>

</body>
</html>

<?php 
// Tutup koneksi 
mysqli_close($conn); 
?>
