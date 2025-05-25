<?php
session_start();

// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti sesuai dengan pengaturan Anda
$password = "";
$dbname = "car_showroom"; // Ganti dengan nama database Anda

// Buat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk mengkonversi harga ke skala
function konversi_harga_ke_skala($harga) {
    if ($harga <= 50000000) return 9;
    elseif ($harga <= 100000000) return 7;
    elseif ($harga <= 150000000) return 5;
    elseif ($harga <= 200000000) return 3;
    else return 1;
}

// Fungsi untuk mengkonversi dokumen ke skala
function konversi_dokumen_ke_skala($dokumen) {
    $dokumen_lengkap = ['STNK', 'BPKB', 'Faktur', 'Kuitansi', 'Surat Pelepasan Hak', 'KTP', 'Asuransi'];
    $dokumen_tidak_lengkap = array_diff($dokumen_lengkap, $dokumen);

    if (empty($dokumen_tidak_lengkap)) return 9;
    elseif (count($dokumen_tidak_lengkap) == 1 && !in_array('Asuransi', $dokumen_tidak_lengkap)) return 8;
    elseif (count($dokumen_tidak_lengkap) == 1) return 7;
    elseif (count($dokumen_tidak_lengkap) == 2) return 5;
    elseif (count($dokumen_tidak_lengkap) > 2) return 3;
    else return 1;
}

// Fungsi untuk menghitung skor AHP
function hitung_skor($data_mobil, $bobot) {
    $skor = 0;
    $skor += $data_mobil['harga'] * $bobot['Harga'];
    $skor += $data_mobil['tahun'] * $bobot['Tahun Keluaran'];
    $skor += $data_mobil['kondisi_fisik'] * $bobot['Kondisi Fisik'];
    $skor += $data_mobil['kondisi_mesin'] * $bobot['Kondisi Mesin'];
    $skor += $data_mobil['dokumen'] * $bobot['Kelengkapan Dokumen'];
    return $skor;
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
    // Ambil data dari form
    $nama = $_POST['name'];
    $nomor_polisi = $_POST['license_plate'];
    $harga = konversi_harga_ke_skala($_POST['price']);
    $tahun = $_POST['year'];
    $kondisi_fisik = $_POST['physical_condition'];
    $kondisi_mesin = $_POST['engine_condition'];
    $dokumen = isset($_POST['documents']) ? $_POST['documents'] : [];
    $dokumen_skala = konversi_dokumen_ke_skala($dokumen);
    $telepon = $_POST['phone'];
    $alamat = $_POST['address'];
    $showroom_id = $_POST['showroom_id'];
    
    // Menangani upload gambar
    $foto = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Direktori tempat gambar akan disimpan
        // $target_dir = "upload/"; // Tentukan folder untuk menyimpan gambar
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/showroom_mobil/upload/"; // Path absolut menuju folder upload
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif']; // Ekstensi gambar yang diperbolehkan

        // Cek ekstensi file
        if (in_array($imageFileType, $allowed_extensions)) {
            // Cek ukuran file, misalnya batas 5MB
            if ($_FILES['image']['size'] <= 5000000) {
                // Pastikan file berhasil dipindahkan
                // if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                //     $foto = $target_file; // Simpan path gambar
                // } else {
                //     echo "Gagal mengupload file gambar.";
                // }
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    echo "File gambar berhasil diupload.";
                    $foto = "" . basename($_FILES["image"]["name"]);
                } else {
                    echo "Gagal mengupload file gambar. Pastikan folder upload memiliki izin tulis.";
                }
            }
        }
    }

    // Ambil bobot kriteria dari database
    $sql = "SELECT weights FROM criteria_weights ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $bobot = json_decode($row['weights'], true);
    
        // Buat array data mobil
        $data_mobil = [
            'harga' => $harga,
            'tahun' => $tahun,
            'kondisi_fisik' => $kondisi_fisik,
            'kondisi_mesin' => $kondisi_mesin,
            'dokumen' => $dokumen_skala
        ];
    
        // Hitung skor AHP
        $skor = hitung_skor($data_mobil, $bobot);
    
        // Simpan data mobil ke dalam tabel cars
        $sql = "INSERT INTO cars (name, license_plate, price, year, physical_condition, engine_condition, document, phone, address, image, showroom_id, ahp_value) 
                VALUES ('$nama', '$nomor_polisi', '$harga', '$tahun', '$kondisi_fisik', '$kondisi_mesin', '$dokumen_skala', '$telepon', '$alamat', '$foto', '$showroom_id', '$skor')";
    
        if ($conn->query($sql) === TRUE) {
            echo "Mobil berhasil ditambahkan dengan skor AHP: " . $skor;
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mobil</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
                        <ul class="dc_css3_menu">
                            <li class="active"><a href="admin.php">Beranda</a></li>
                            <li><a href="http://localhost/showroom_mobil/showroom.php">Daftar Mobil</a></li>
                            <li><a href="adminaddcar.php">Tambah Mobil</a></li>
                            <li><a href="http://localhost/showroom_mobil/logout.php">Keluar</a></li> 
                        </ul>
                    <div class="clear"></div>
                    </div>    
                </div>
                <div class="clear"></div> 
            </div>
        </div>
    </div>

    <div class="container">
        <h2 class="mt-5">Tambah Mobil</h2>
        <form method="post" action="" enctype="multipart/form-data" class="mt-4">
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
            <div class="form-group">
                <label>Telepon:</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Alamat:</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>
        <div class="form-group">
            <label>Foto:</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="form-group">
                <label>Showroom:</label>
                <select name="showroom_id" class="form-control">
                    <!-- Showroom options -->
                    <option value="1">Showroom 1</option>
                    <option value="2">Showroom 2</option>
                    <!-- Add more showroom options here -->
                </select>
        </div>
            <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
            <button onclick="window.location.href='admin.php';" name="kembali" class="btn btn-primary">Kembali ke Dashboard</button>
        </form>
    </div>
</body>
</html>
