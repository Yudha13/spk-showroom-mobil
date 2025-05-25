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

// Ambil data matriks dari database
$sql = "SELECT id, name, matrix FROM experts";
$result = $conn->query($sql);

$matrices = [];
$experts = [];
$expert_ids = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $expert_ids[] = $row['id'];
        $experts[] = $row['name'];
        
        // Decode JSON dan validasi
        $matrix = json_decode($row['matrix'], true);
        
        // Validasi matriks
        if (!is_array($matrix) || json_last_error() !== JSON_ERROR_NONE) {
            die("Error: Format matriks tidak valid untuk ahli " . $row['name']);
        }
        
        // Konversi semua nilai ke float dan validasi
        $valid_matrix = [];
        foreach ($matrix as $row_matrix) {
            $valid_row = [];
            foreach ($row_matrix as $value) {
                // Pastikan nilai numerik
                if (!is_numeric($value)) {
                    die("Error: Nilai matriks harus numerik untuk ahli " . $row['name']);
                }
                $valid_row[] = (float)$value;
            }
            $valid_matrix[] = $valid_row;
        }
        
        $matrices[] = $valid_matrix;
    }
} else {
    echo "Tidak ada data matriks yang ditemukan.";
}

// MENGHITUNG MATRIKS GABUNGAN
function calculateArithmeticMean($matrices) {
    if (empty($matrices)) {
        die("Error: Tidak ada matriks yang tersedia untuk dihitung");
    }

    $num_criteria = count($matrices[0]); // Ambil jumlah kriteria dari matriks pertama
    $sum_matrix = array_fill(0, $num_criteria, array_fill(0, $num_criteria, 0));
    $n = count($matrices);
    
    foreach ($matrices as $matrix) {
        // Validasi konsistensi ukuran matriks
        if (count($matrix) !== $num_criteria) {
            die("Error: Ukuran matriks tidak konsisten");
        }
        
        for ($i = 0; $i < $num_criteria; $i++) {
            if (count($matrix[$i]) !== $num_criteria) {
                die("Error: Ukuran matriks tidak konsisten");
            }
            
            for ($j = 0; $j < $num_criteria; $j++) {
                if (!is_numeric($matrix[$i][$j])) {
                    die("Error: Nilai matriks harus numerik pada baris $i, kolom $j");
                }
                $sum_matrix[$i][$j] += (float)$matrix[$i][$j];
            }
        }
    }
    
    $combined_matrix = array_fill(0, $num_criteria, array_fill(0, $num_criteria, 0));
    for ($i = 0; $i < $num_criteria; $i++) {
        for ($j = 0; $j < $num_criteria; $j++) {
            $combined_matrix[$i][$j] = $sum_matrix[$i][$j] / $n;
        }
    }
    
    return $combined_matrix;
}
// Hitung matriks gabungan dengan arithmetic mean
$combined_matrix = calculateArithmeticMean($matrices);

// Normalisasi matriks gabungan
$num_criteria = count($combined_matrix); // Ambil jumlah kriteria dari matriks gabungan
$sums = array_fill(0, $num_criteria, 0);

// Hitung jumlah per kolom
for ($j = 0; $j < $num_criteria; $j++) {
    for ($i = 0; $i < $num_criteria; $i++) {
        if (!is_numeric($combined_matrix[$i][$j])) {
            die("Error: Elemen matriks bukan numerik pada baris $i, kolom $j");
        }
        $sums[$j] += (float)$combined_matrix[$i][$j];
    }
}

// Buat matriks normalisasi
$normalized_matrix = array_fill(0, $num_criteria, array_fill(0, $num_criteria, 0));
for ($i = 0; $i < $num_criteria; $i++) {
    for ($j = 0; $j < $num_criteria; $j++) {
        if ($sums[$j] != 0) {  // Hindari pembagian dengan nol
            $normalized_matrix[$i][$j] = $combined_matrix[$i][$j] / $sums[$j];
        } else {
            die("Error: Pembagian dengan nol pada kolom $j");
        }
    }
}

// Hitung eigen vector (bobot kriteria)
$weights = array_fill(0, $num_criteria, 0);
for ($i = 0; $i < $num_criteria; $i++) {
    for ($j = 0; $j < $num_criteria; $j++) {
        $weights[$i] += $normalized_matrix[$i][$j];
    }
    $weights[$i] /= $num_criteria;
}

// Hitung λ_max
$lambda_max = 0;
for ($i = 0; $i < $num_criteria; $i++) {
    $sum = 0;
    for ($j = 0; $j < $num_criteria; $j++) {
        $sum += $combined_matrix[$i][$j] * $weights[$j];
    }
    $lambda_max += $sum / $weights[$i];
}
$lambda_max /= $num_criteria;

// Hitung Consistency Index (CI)
$ci = ($lambda_max - $num_criteria) / ($num_criteria - 1);

// Hitung Consistency Ratio (CR)
$ri_values = [0, 0, 0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49];
$ri = $ri_values[$num_criteria];
$cr = $ci / $ri;

// Simpan hasil bobot kriteria ke tabel criteria_weights
$weights_json = json_encode(array_combine(["Harga", "Tahun Keluaran", "Kondisi Mesin", "Kondisi Fisik", "Kelengkapan Dokumen"], $weights));
$sql = "INSERT INTO criteria_weights (weights) VALUES ('$weights_json')";
if ($conn->query($sql) === TRUE) {
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Car</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
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
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            padding: 60px 20px;
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
        }

        .navbar-toggler {
            padding: 10px;
        }
        
        /* Table Styles */
        .table-container {
            width: 90%;
            margin: 20px auto;
            overflow-x: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .table {
            width: 100%;
            margin: 20px 0;
            font-family: Arial, sans-serif;
            font-size: 14px;
            border-collapse: collapse;
            text-align: center;
            table-layout: fixed;
        }

        .table th,
        .table td {
            padding: 12px 8px;
            border: 1px solid #ddd;
            word-wrap: break-word;
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
            
        }

        .table th {
            background-color:rgb(0, 153, 115);
            color: white;
            font-weight: bold;
        }

        /* Column Widths */
        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 20%;
        }

        .table th:nth-child(2),
        .table td:nth-child(2),
        .table th:nth-child(3),
        .table td:nth-child(3),
        .table th:nth-child(4),
        .table td:nth-child(4),
        .table th:nth-child(5),
        .table td:nth-child(5),
        .table th:nth-child(6),
        .table td:nth-child(6) {
            width: 16%;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 20px;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-edit {
            background-color:rgb(0, 153, 115);
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-edit:hover {
            background-color:rgb(0, 153, 115);
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        /* Headings */
        h2, h3 {
            text-align: center;
            margin: 20px 0;
            color: #3a7669;
        }
        .ahli-heading {
    text-align: left;
    margin-left: 5%;
}


        /* Consistency Ratio */
        .consistency-ratio {
            text-align: center;
            margin: 20px auto;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 5px;
            width: 50%;
            font-weight: bold;
            color: #3a7669;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 30px 0;
            background-color: #a50000;
            color: white;
            margin-top: 50px;
            font-family: Arial, sans-serif;
            width: 100%;
        }

        .footer p {
            margin: 0;
            font-size: 16px;
            letter-spacing: 0.5px;
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

<div class="main-content">
    <h2>Perbandingan Berpasangan AHP</h2>

    <?php
    $criteria_names = ["Harga", "Tahun Keluaran", "Kondisi Mesin", "Kondisi Fisik", "Kelengkapan Dokumen"];
    
foreach ($experts as $index => $name) {
    $matrix = $matrices[$index];
    $expert_id = $expert_ids[$index]; // Ambil id yang sesuai
    
    echo "<h3 class='ahli-heading'>Ahli: $name</h3>";
    echo "<div class='action-buttons'>";
echo "<a href='./edit_expert.php?id=$expert_id' class='btn-edit'>Edit</a>"; // Gunakan expert_id
    echo "<a href='delete_expert.php?id=$expert_id' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this expert?\");'>Delete</a>";
    echo "</div>";
        
        echo "<div class='table-container'>";
        echo "<table class='table table-bordered table-striped table-hover'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Kriteria</th>";
        foreach ($criteria_names as $criteria_name) {
            echo "<th>$criteria_name</th>";
        }
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        for ($i = 0; $i < count($matrix); $i++) {
            echo "<tr>";
            echo "<td>" . $criteria_names[$i] . "</td>";
            for ($j = 0; $j < count($matrix[$i]); $j++) {
                echo "<td>" . $matrix[$i][$j] . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }

    // Tampilkan matriks gabungan
    echo "<h3>Matriks Gabungan</h3>";
    echo "<div class='table-container'>";
    echo "<table class='table table-bordered table-striped table-hover'>";
    echo "<thead>";
    echo "<tr><th>Kriteria</th>";
    foreach ($criteria_names as $criteria_name) {
        echo "<th>$criteria_name</th>";
    }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    for ($i = 0; $i < count($combined_matrix); $i++) {
        echo "<tr>";
        echo "<td>" . $criteria_names[$i] . "</td>";
        for ($j = 0; $j < count($combined_matrix[$i]); $j++) {
            echo "<td>" . number_format($combined_matrix[$i][$j], 3) . "</td>";
        }
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    // Tampilkan matriks normalisasi
    echo "<h3>Matriks Normalisasi</h3>";
    echo "<div class='table-container'>";
    echo "<table class='table table-bordered table-striped table-hover'>";
    echo "<thead>";
    echo "<tr><th>Kriteria</th>";
    foreach ($criteria_names as $criteria_name) {
        echo "<th>$criteria_name</th>";
    }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    for ($i = 0; $i < count($normalized_matrix); $i++) {
        echo "<tr>";
        echo "<td>" . $criteria_names[$i] . "</td>";
        for ($j = 0; $j < count($normalized_matrix[$i]); $j++) {
            echo "<td>" . number_format($normalized_matrix[$i][$j], 4) . "</td>";
        }
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    
    // Tampilkan bobot kriteria
    echo "<h3>Bobot Kriteria</h3>";
    echo "<div class='table-container'>";
    echo "<table class='table table-bordered table-striped table-hover'>";
    echo "<thead>";
    echo "<tr><th>Kriteria</th><th>Bobot</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($weights as $i => $weight) {
        echo "<tr>";
        echo "<td>" . $criteria_names[$i] . "</td>";
        echo "<td>" . number_format($weight, 4) . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    // Tampilkan nilai CR
    echo "<div class='consistency-ratio'>";
    echo "<h3>Nilai Consistency Ratio (CR)</h3>";
    echo "<p>CR: " . number_format($cr, 4) . "</p>";
    if ($cr < 0.1) {
        echo "<p>Konsistensi baik (CR < 0.1)</p>";
    } else {
        echo "<p>Konsistensi tidak baik (CR ≥ 0.1)</p>";
    }
    echo "</div>";

    $conn->close();
    ?>
</div>

<div class="footer">
    <p>&copy; 2025 SPK SHOWROOM MOBIL</p>
</div>
</body>
</html>