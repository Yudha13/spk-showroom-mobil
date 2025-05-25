<?php
session_start(); // Mulai session untuk mengakses peran pengguna

// Pastikan session berisi data yang benar
$is_admin = isset($_SESSION['s_role']) && $_SESSION['s_role'] == 'admin';

// Koneksi ke database
$conn = mysqli_connect("localhost","spkq4689","BT37Su3mVcBX61","spkq4689_car_showroom");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Logika untuk admin
if ($is_admin) {
    $c_id = isset($_SESSION['c_id']) ? (int)$_SESSION['c_id'] : null;

    if (!$c_id) {
        echo "❌ Session admin tidak memiliki c_id.";
        exit;
    }

    // Ambil showroom_id berdasarkan c_id
    $showroom_query = "SELECT showroom_id FROM customer WHERE c_id = $c_id";
    $showroom_result = mysqli_query($conn, $showroom_query);

    if (!$showroom_result) {
        echo "❌ Query gagal: " . mysqli_error($conn);
        exit;
    }

    if (mysqli_num_rows($showroom_result) === 0) {
        echo "❌ Tidak ada showroom yang ditugaskan untuk admin ini.";
        exit;
    }

    $showroom_data = mysqli_fetch_assoc($showroom_result);
    $showroom_id = (int) $showroom_data['showroom_id'];

    // Cek apakah showroom_id valid
    if (!$showroom_id) {
        echo "❌ Admin ini tidak memiliki showroom_id yang valid.";
        exit;
    }
}




// Fungsi konversi
function konversi_harga_ke_skala($harga_asli) {
    if ($harga_asli <= 50000000) return 9;
    elseif ($harga_asli <= 100000000) return 7;
    elseif ($harga_asli <= 150000000) return 5;
    elseif ($harga_asli <= 200000000) return 3;
    else return 1;
}

function konversi_tahun($tahun_asli) {
    $currentYear = date('Y');
    $selisih = $currentYear - $tahun_asli;

    if ($selisih <= 1) {
        return 9;
    } elseif ($selisih <= 3) {
        return 7;
    } elseif ($selisih <= 5) {
        return 5;
    } elseif ($selisih <= 7) {
        return 3;
    } else {
        return 1;
    }
}


function konversi_dokumen_ke_skala($dokumen) {
    $dokumen_lengkap = ['STNK', 'BPKB', 'Faktur', 'Kuitansi', 'Surat Pelepasan Hak', 'KTP', 'Asuransi'];
    $dokumen_tidak_lengkap = array_diff($dokumen_lengkap, $dokumen);

    $jumlah_tidak_lengkap = count($dokumen_tidak_lengkap);
    if ($jumlah_tidak_lengkap === 0) {
        return 9;
    } elseif ($jumlah_tidak_lengkap === 1) {
        return (!in_array('Asuransi', $dokumen_tidak_lengkap)) ? 8 : 7;
    } elseif ($jumlah_tidak_lengkap === 2) {
        return 5;
    } else {
        return 3;
    }
}


function hitung_skor($data_mobil, $bobot) {
    return $data_mobil['harga'] * $bobot['Harga'] +
           $data_mobil['tahun'] * $bobot['Tahun Keluaran'] +
           $data_mobil['kondisi_fisik'] * $bobot['Kondisi Fisik'] +
           $data_mobil['kondisi_mesin'] * $bobot['Kondisi Mesin'] +
           $data_mobil['dokumen'] * $bobot['Kelengkapan Dokumen'];
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
    $nama = $_POST['name'];
    $nomor_polisi = $_POST['license_plate'];
    $harga_asli = $_POST['price_asli'];
    $harga = konversi_harga_ke_skala($harga_asli);
    $tahun_asli = $_POST['year_asli'];
    $tahun = konversi_tahun($tahun_asli);
    $kondisi_fisik = $_POST['physical_condition'];
    $kondisi_mesin = $_POST['engine_condition'];
    $dokumen = isset($_POST['documents']) ? $_POST['documents'] : [];
    $dokumen_skala = konversi_dokumen_ke_skala($dokumen);
    $showroom_id = $showroom['showroom_id']; // Ambil nilai showroom_id dari hasil query

    $foto = []; // Array untuk menyimpan nama file yang berhasil diupload

// Proses upload gambar
if (isset($_FILES['images']) && count($_FILES['images']['name']) > 0) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/showroom_mobil/upload/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $max_file_size = 10 * 1024 * 1024; // Batas ukuran file: 10 MB

    for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
        $file_name = time() . "_" . basename($_FILES['images']['name'][$i]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi ekstensi file dan ukuran
        if (in_array($imageFileType, $allowed_extensions)) {
            if ($_FILES['images']['size'][$i] <= $max_file_size) {
                if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $target_file)) {
                    $foto[] = $file_name; // Simpan nama file
                } else {
                    echo "Error saat mengupload file: " . $_FILES['images']['name'][$i];
                }
            } else {
                echo "File " . $_FILES['images']['name'][$i] . " terlalu besar. Maksimal 10 MB.";
            }
        } else {
            echo "File " . $_FILES['images']['name'][$i] . " memiliki format tidak valid.";
        }
    }
}

    $foto_json = json_encode($foto); // Simpan nama file dalam format JSON

    $sql = "SELECT weights FROM criteria_weights ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $bobot = json_decode($row['weights'], true);

        $data_mobil = [
            'harga' => $harga,
            'tahun' => $tahun,
            'kondisi_fisik' => $kondisi_fisik,
            'kondisi_mesin' => $kondisi_mesin,
            'dokumen' => $dokumen_skala,
        ];
        $skor = hitung_skor($data_mobil, $bobot);

        $stmt = $conn->prepare("INSERT INTO cars (name, license_plate, price_asli, price, year, year_asli, physical_condition, engine_condition, document, image, showroom_id, ahp_value) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiiiiisis", $nama, $nomor_polisi, $harga_asli, $harga, $tahun, $tahun_asli, $kondisi_fisik, $kondisi_mesin, $dokumen_skala, $foto_json, $showroom_id, $skor);

        if ($stmt->execute()) {
            echo "Mobil berhasil ditambahkan dengan skor AHP: " . $skor;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Gagal mendapatkan bobot kriteria dari database.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mobil</title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
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
        .container {
            margin-top: 30px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-primary {
            width: 100%;
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
          <li class="nav-item active"><a class="nav-link" href="http://spkshowroom.my.id/showroom.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="admin/adminaddcar.php">Tambah Mobil</a></li>
          <li class="nav-item"><a class="nav-link" href="adminlogout.php">Keluar</a></li>
        <?php else: ?>
          <li class="nav-item active"><a class="nav-link" href="index.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="about.html">Tentang</a></li>
        <?php endif; ?>
        </ul>
      </div>
    </nav>

    <!-- Form Container -->
    <div class="container">
        <h2>Tambah Mobil</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <!-- Form content tetap sama -->
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
                <?php
                $documents = ['STNK', 'BPKB', 'Faktur', 'Kuitansi', 'Surat Pelepasan Hak', 'KTP', 'Asuransi'];
                foreach ($documents as $doc) {
                    echo "<div class='form-check form-check-inline'>
                            <input type='checkbox' name='documents[]' value='$doc' class='form-check-input'>
                            <label class='form-check-label'>$doc</label>
                          </div>";
                }
                ?>
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
                <label>Harga:</label>
                <input type="number" name="price_asli" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tahun Keluaran:</label>
                <input type="number" name="year_asli" class="form-control" required>
            </div>
            <!--<div class="form-group">
                <label>Telepon:</label>
                <input type="text" name="phone" class="form-control" required>
            </div>-->
            <div class="form-group">
                <label>Pilih Gambar:</label>
                <input type="file" name="images[]" class="form-control" multiple required>
            </div>
            <button type="submit" name="tambah" class="btn btn-danger btn-block">Tambah</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>



