<?php
session_start();

// Establish connection to the database
$servername = "localhost";  // Database server (localhost for local dev)
$username = "spkq4689";         // Your MySQL username (default is 'root' for XAMPP)
$password = "BT37Su3mVcBX61";             // Your MySQL password (leave blank for XAMPP default)
$dbname = "spkq4689_car_showroom";    // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $criteria = [
        'harga_vs_tahun' => $_POST['harga_vs_tahun'],
        'harga_vs_mesin' => $_POST['harga_vs_mesin'],
        'harga_vs_fisik' => $_POST['harga_vs_fisik'],
        'harga_vs_dokumen' => $_POST['harga_vs_dokumen'],
        'tahun_vs_mesin' => $_POST['tahun_vs_mesin'],
        'tahun_vs_fisik' => $_POST['tahun_vs_fisik'],
        'tahun_vs_dokumen' => $_POST['tahun_vs_dokumen'],
        'mesin_vs_fisik' => $_POST['mesin_vs_fisik'],
        'mesin_vs_dokumen' => $_POST['mesin_vs_dokumen'],
        'fisik_vs_dokumen' => $_POST['fisik_vs_dokumen']
    ];

    // Matriks perbandingan berpasangan
    $matrix = [
        [1, 1/$_POST['harga_vs_tahun'], 1/$_POST['harga_vs_mesin'], 1/$_POST['harga_vs_fisik'], 1/$_POST['harga_vs_dokumen']],
        [$_POST['harga_vs_tahun'], 1, 1/$_POST['tahun_vs_mesin'], 1/$_POST['tahun_vs_fisik'], 1/$_POST['tahun_vs_dokumen']],
        [$_POST['harga_vs_mesin'], $_POST['tahun_vs_mesin'], 1, 1/$_POST['mesin_vs_fisik'], 1/$_POST['mesin_vs_dokumen']],
        [$_POST['harga_vs_fisik'], $_POST['tahun_vs_fisik'], $_POST['mesin_vs_fisik'], 1, 1/$_POST['fisik_vs_dokumen']],
        [$_POST['harga_vs_dokumen'], $_POST['tahun_vs_dokumen'], $_POST['mesin_vs_dokumen'], $_POST['fisik_vs_dokumen'], 1]
    ];

    $matrix_json = json_encode($matrix);

    // Prepare SQL to insert data
    $sql = "INSERT INTO experts (name, criteria_weights, matrix) VALUES ('$name', '".json_encode($criteria)."', '$matrix_json')";

    // Execute the query and check for success
    if ($conn->query($sql) === TRUE) {
        header("Location: ahp.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Car</title>
    <!--<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar {
    background-color: #a50000;
    border: none;
    border-radius: 0;
    margin-bottom: 0;
    padding: 0;
    display: flex;
    justify-content: space-between; /* Ini akan memisahkan logo dan menu */
    align-items: center;
}

.navbar-nav {
    display: flex;
    align-items: center;
    padding: 60px 20px;
    margin-left: auto; /* Ini akan mendorong menu ke kanan */
}

.nav-item {
    position: relative;
}

.nav-link {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 20px;
    height: 100%;
    color: #fff !important;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.nav-link:hover {
    background-color: #800000;
    color: #fff;
}

.navbar-brand img {
    height: 70px;
    margin-left: 20px; /* Memberikan jarak dari kiri */
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
        /* General Form Styles */
       /* Ganti bagian form styles dengan ini */
.form-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
}

form {
    background-color: #f5f5f5;
    padding: 30px;
    border-radius: 10px;
    width: 80%;
    max-width: 900px; /* Lebar maksimum form */
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    margin: 20px auto;
}

h2 {
    text-align: center;
    color: #3a7669;
    font-weight: bold;
    margin-bottom: 30px;
}

.form-horizontal .form-group {
    margin-bottom: 20px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
}

.form-horizontal .form-group label {
    color: #3a7669;
    font-weight: bold;
    flex: 0 0 25%; /* Lebar label 25% */
    max-width: 25%;
}

.form-horizontal .form-group > div {
    flex: 0 0 75%; /* Lebar input 75% */
    max-width: 75%;
}

.radio-group {
    display: flex;
    flex-wrap: wrap;
    gap: 10px 15px;
}

/* Tombol submit */
.form-group.submit-group {
    justify-content: center;
    margin-top: 30px;
}

.btn-primary {
    background-color: #3a7669;
    border-color: #3a7669;
    padding: 10px 30px;
    font-size: 16px;
}

.btn-primary:hover {
    background-color: #2f5c50;
    border-color: #2f5c50;
}

.btn-default {
    display: block;
    margin: 20px auto;
    text-align: center;
    max-width: 200px;
}

        .btn-default:hover {
            background-color: #bbb;
        }

        /* Radio Buttons */
        .radio-group label {
            display: inline-block;
            margin-right: 10px;
        }

        .radio-group input[type="radio"] {
            margin-right: 5px;
        }

        /* Section Titles */
        h3 {
            text-align: left;
            color: #3a7669;
            margin-bottom: 20px;
            font-weight: bold;
        }


    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">
        <img src="images/logoreal.png" alt="Showroom Mobil">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active"><a class="nav-link" href="ahp.php">Beranda</a></li>
            <li class="nav-item"><a class="nav-link" href="add_expert.php">Tambah Ahli</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Keluar</a></li>
        </ul>
    </div>
</nav>
    <!--<div class="header">
        <div class="wrap">
            <div class="header-bot">
                <div class="logo">
                    <img src="images/logoreal.png" alt="Logo" style="width:450px; height: 160px;">
                </div>
                <div class="cart">
                    <div class="menu-main">
                        <ul class="dc_css3_menu">
                            <li class="active"><a href="index.php">Home</a></li>
                            <li><a href="add_expert.php">Tambah Ahli</a></li>
                            <li><a href="ahp.php">Lihat Perhitungan AHP</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    <div class="clear"></div>
                    </div>	
                </div>
                <div class="clear"></div> 
            </div>
        </div>
    </div>-->
    <div class="form-container">
    <h2>Tambah Ahli</h2>


    <form method="post" action="" class="form-horizontal">

        <?php
        $questions = [
            'harga_vs_tahun' => 'Harga vs. Tahun Keluaran',
            'harga_vs_mesin' => 'Harga vs. Kondisi Mesin',
            'harga_vs_fisik' => 'Harga vs. Kondisi Fisik',
            'harga_vs_dokumen' => 'Harga vs. Kelengkapan Dokumen',
            'tahun_vs_mesin' => 'Tahun Keluaran vs. Kondisi Mesin',
            'tahun_vs_fisik' => 'Tahun Keluaran vs. Kondisi Fisik',
            'tahun_vs_dokumen' => 'Tahun Keluaran vs. Kelengkapan Dokumen',
            'mesin_vs_fisik' => 'Kondisi Mesin vs. Kondisi Fisik',
            'mesin_vs_dokumen' => 'Kondisi Mesin vs. Kelengkapan Dokumen',
            'fisik_vs_dokumen' => 'Kondisi Fisik vs. Kelengkapan Dokumen'
        ];

        foreach ($questions as $key => $question) {
            echo "<div class='form-group'>";
            echo "<label for='$key' class='col-sm-2 control-label'>$question:</label>";
            echo "<div class='col-sm-10'>";
            echo "<div class='radio-group'>";
            for ($i = 9; $i >= 1; $i -= 2) { // only odd numbers
                echo "<label><input type='radio' name='$key' value='$i' required> $i</label>";
            }
            $fractions = ['1/3' => '1/3', '1/5' => '1/5', '1/7' => '1/7', '1/9' => '1/9']; // only fractions with odd denominators
            foreach ($fractions as $value => $label) {
                echo "<label><input type='radio' name='$key' value='$value' required> $label</label>";
            }
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        ?>

<div class="form-group submit-group">
    <div class="col-sm-12 text-center">
        <button type="submit" class="btn btn-primary">Tambah</button>
    </div>
</div>
    </form>
    <a href="index.php" class="btn btn-default">Kembali ke Dashboard</a>
</div>
</body>

</html>
