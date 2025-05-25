<?php
session_start();

// Koneksi ke database
$servername = "localhost";
$username = "pkq4689"; // Ganti sesuai dengan pengaturan Anda
$password = "BT37Su3mVcBX61";
$dbname = "spkq4689_car_showroom"); // Ganti dengan nama database Anda

// Buat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID mobil dari URL
if (isset($_GET['id'])) {
    $car_id = $_GET['id'];

    // Ambil data mobil berdasarkan ID
    $sql = "SELECT * FROM Cars WHERE car_id = $car_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Ambil data mobil
        $car = $result->fetch_assoc();
    } else {
        echo "Mobil tidak ditemukan.";
        exit;
    }
} else {
    echo "ID mobil tidak ditemukan.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mobil</title>
</head>
<body>
    <h2>Edit Mobil: <?php echo $car['name']; ?></h2>

    <!-- Form untuk mengedit data mobil -->
    <form method="post" action="updatecar.php">
        <input type="hidden" name="car_id" value="<?php echo $car['car_id']; ?>">

        <div>
            <label>Nama Mobil:</label>
            <input type="text" name="name" value="<?php echo $car['name']; ?>" required>
        </div>
        <div>
            <label>Nomor Polisi:</label>
            <input type="text" name="license_plate" value="<?php echo $car['license_plate']; ?>" required>
        </div>
        <div>
            <button type="submit">Update Mobil</button>
        </div>
    </form>
</body>
</html>
