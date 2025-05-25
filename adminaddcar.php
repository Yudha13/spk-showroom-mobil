<?php
session_start();

$conn = mysqli_connect("localhost","spkq4689","BT37Su3mVcBX61","spkq4689_car_showroom");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk mengkonversi harga ke skala
function convert_price_to_scale($price) {
    if ($price <= 50000000) return 9;
    elseif ($price <= 100000000) return 7;
    elseif ($price <= 150000000) return 5;
    elseif ($price <= 200000000) return 3;
    else return 1;
}

// Fungsi untuk mengkonversi dokumen ke skala
function convert_document_to_scale($documents) {
    $complete_docs = ['STNK', 'BPKB', 'Faktur', 'Kuitansi', 'Surat Pelepasan Hak', 'KTP', 'Asuransi'];
    $missing_docs = array_diff($complete_docs, $documents);

    if (empty($missing_docs)) return 9;
    elseif (count($missing_docs) == 1 && !in_array('Asuransi', $missing_docs)) return 8;
    elseif (count($missing_docs) == 1) return 7;
    elseif (count($missing_docs) == 2) return 5;
    elseif (count($missing_docs) > 2) return 3;
    else return 1;
}

// Fungsi untuk menghitung skor AHP
function calculate_score($car_data, $weights) {
    $score = 0;
    $score += $car_data['price'] * $weights['Harga'];
    $score += $car_data['year'] * $weights['Tahun Keluaran'];
    $score += $car_data['physical_condition'] * $weights['Kondisi Fisik'];
    $score += $car_data['engine_condition'] * $weights['Kondisi Mesin'];
    $score += $car_data['document'] * $weights['Kelengkapan Dokumen'];
    return $score;
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    // Ambil data dari form
    $name = $_POST['name'];
    $license_plate = $_POST['license_plate'];
    $price = convert_price_to_scale($_POST['price']);
    $year = $_POST['year'];
    $physical_condition = $_POST['physical_condition'];
    $engine_condition = $_POST['engine_condition'];
    $documents = isset($_POST['documents']) ? $_POST['documents'] : [];
    $document = convert_document_to_scale($documents);
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $photo = $_POST['photo'];
    $admin_id = $_POST['admin_id'];

    // Ambil bobot kriteria dari database
    $sql = "SELECT weights FROM criteria_weights ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $weights = json_decode($row['weights'], true);
    
        // Buat array data mobil
        $car_data = [
            'price' => $price,
            'year' => $year,
            'physical_condition' => $physical_condition,
            'engine_condition' => $engine_condition,
            'document' => $document
        ];
    
        // Hitung skor AHP
        $score = calculate_score($car_data, $weights);
    
        // Simpan data mobil ke dalam tabel cars
        $sql = "INSERT INTO cars (name, license_plate, price, year, physical_condition, engine_condition, document, phone, address, photo, admin_id, score) 
                VALUES ('$name', '$license_plate', '$price', '$year', '$physical_condition', '$engine_condition', '$document', '$phone', '$address', '$photo', '$admin_id', '$score')";
    
        if ($conn->query($sql) === TRUE) {
            echo "Mobil berhasil ditambahkan dengan skor AHP: " . $score;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Gagal mendapatkan bobot kriteria dari database.";
    }
}

$conn->close();
?>


<!-- Form HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mobil</title>
    <!--<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
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
    </style>
</head>
<body>
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
          <li class="nav-item active"><a class="nav-link" href="http://localhost/showroom_mobil/showroom.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="admin/adminaddcar.php">Tambah Mobil</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Keluar</a></li>
        <?php else: ?>
          <li class="nav-item active"><a class="nav-link" href="index.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="about.html">Tentang</a></li>
        <?php endif; ?>
        </ul>
      </div>
    </nav>

    <div class="container">
        <h2 class="mt-5">Tambah Mobil</h2>
        <form method="post" action="" class="mt-4">
            <div class="form-group">
                <label>Nama Mobil:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nomor Polisi:</label>
                <input type="text" name="license_plate" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Dokumen:</label><br>
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="documents[]" value="STNK" class="form-check-input">
                    <label class="form-check-label">STNK</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="documents[]" value="BPKB" class="form-check-input">
                    <label class="form-check-label">BPKB</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="documents[]" value="Faktur" class="form-check-input">
                    <label class="form-check-label">Faktur</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="documents[]" value="Kuitansi" class="form-check-input">
                    <label class="form-check-label">Kuitansi</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="documents[]" value="Surat Pelepasan Hak" class="form-check-input">
                    <label class="form-check-label">Surat Pelepasan Hak</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="documents[]" value="KTP" class="form-check-input">
                    <label class="form-check-label">KTP</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="documents[]" value="Asuransi" class="form-check-input">
                    <label class="form-check-label">Asuransi</label>
                </div>
            </div>
            <div class="form-group">
                <label>Kondisi Fisik:</label>
                <select name="physical_condition" class="form-control" required>
                    <option value="9">Tanpa cacat, seperti baru</option>
                    <option value="7">Sedikit goresan</option>
                    <option value="5">Beberapa penyok dan goresan</option>
                    <option value="3">Banyak penyok dan goresan</option>
                    <option value="1">Rusak parah</option>
                </select>
            </div>
            <div class="form-group">
                <label>Kondisi Mesin:</label>
                <select name="engine_condition" class="form-control" required>
                    <option value="9">Sangat baik (servis rutin, tanpa masalah)</option>
                    <option value="7">Baik (beberapa perbaikan kecil)</option>
                    <option value="5">Cukup (membutuhkan perawatan rutin)</option>
                    <option value="3">Buruk (membutuhkan perbaikan besar)</option>
                    <option value="1">Sangat buruk (mesin rusak)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tahun Keluaran:</label>
                <select name="year" class="form-control" required>
                    <option value="9">1 tahun atau kurang</option>
                    <option value="7">2-3 tahun</option>
                    <option value="5">4-5 tahun</option>
                    <option value="3">6-7 tahun</option>
                    <option value="1">8 tahun atau lebih</option>
                </select>
            </div>
            <div class="form-group">
                <label>Harga:</label>
                <input type="number" name="price" class="form-control" required>
            </div>
            <!--<div class="form-group">
                <label>Telepon:</label>
                <input type="text" name="phone" class="form-control" required>
            </div>-->
            <div class="form-group">
                <label>Alamat:</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label>Foto (URL):</label>
                <input type="text" name="photo" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
        <a href="admin.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
    </div>
</body>
</html>
