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

// Function to convert fraction string to float with validation
function fractionToFloat($fraction) {
    if ($fraction === null || $fraction === '') {
        return 0;
    }
    if (strpos($fraction, '/') !== false) {
        $parts = explode('/', $fraction);
        if (count($parts) === 2 && $parts[1] != 0) {
            return floatval($parts[0]) / floatval($parts[1]);
        }
        return 0;
    }
    return floatval($fraction);
}

// Check if we're editing an existing expert
$edit_mode = false;
$expert_id = null;
$expert_data = null;
$criteria = [];

if (isset($_GET['id'])) {
    $edit_mode = true;
    $expert_id = $_GET['id'];
    
    // Fetch expert data
    $sql = "SELECT * FROM experts WHERE id = $expert_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $expert_data = $result->fetch_assoc();
        $criteria = json_decode($expert_data['criteria_weights'], true);
    } else {
        header("Location: ahp.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate all required fields are present
    $required_fields = [
        'name', 'harga_vs_tahun', 'harga_vs_mesin', 'harga_vs_fisik', 
        'harga_vs_dokumen', 'tahun_vs_mesin', 'tahun_vs_fisik', 
        'tahun_vs_dokumen', 'mesin_vs_fisik', 'mesin_vs_dokumen', 
        'fisik_vs_dokumen'
    ];
    
    $missing_fields = [];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || $_POST[$field] === '') {
            $missing_fields[] = $field;
        }
    }
    
    if (!empty($missing_fields)) {
        die("Error: Required fields are missing: " . implode(', ', $missing_fields));
    }

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

    // Convert all values to float for matrix calculation with validation
    $harga_vs_tahun = fractionToFloat($_POST['harga_vs_tahun']);
    $harga_vs_mesin = fractionToFloat($_POST['harga_vs_mesin']);
    $harga_vs_fisik = fractionToFloat($_POST['harga_vs_fisik']);
    $harga_vs_dokumen = fractionToFloat($_POST['harga_vs_dokumen']);
    $tahun_vs_mesin = fractionToFloat($_POST['tahun_vs_mesin']);
    $tahun_vs_fisik = fractionToFloat($_POST['tahun_vs_fisik']);
    $tahun_vs_dokumen = fractionToFloat($_POST['tahun_vs_dokumen']);
    $mesin_vs_fisik = fractionToFloat($_POST['mesin_vs_fisik']);
    $mesin_vs_dokumen = fractionToFloat($_POST['mesin_vs_dokumen']);
    $fisik_vs_dokumen = fractionToFloat($_POST['fisik_vs_dokumen']);

    // Validate no zero values that would cause division by zero
    if ($harga_vs_tahun == 0 || $harga_vs_mesin == 0 || $harga_vs_fisik == 0 || $harga_vs_dokumen == 0 ||
        $tahun_vs_mesin == 0 || $tahun_vs_fisik == 0 || $tahun_vs_dokumen == 0 ||
        $mesin_vs_fisik == 0 || $mesin_vs_dokumen == 0 || $fisik_vs_dokumen == 0) {
        die("Error: Comparison values cannot be zero");
    }

    // Matriks perbandingan berpasangan (using float values)
    $matrix = [
        [1, $harga_vs_tahun, $harga_vs_mesin, $harga_vs_fisik, $harga_vs_dokumen],
        [1/$harga_vs_tahun, 1, $tahun_vs_mesin, $tahun_vs_fisik, $tahun_vs_dokumen],
        [1/$harga_vs_mesin, 1/$tahun_vs_mesin, 1, $mesin_vs_fisik, $mesin_vs_dokumen],
        [1/$harga_vs_fisik, 1/$tahun_vs_fisik, 1/$mesin_vs_fisik, 1, $fisik_vs_dokumen],
        [1/$harga_vs_dokumen, 1/$tahun_vs_dokumen, 1/$mesin_vs_dokumen, 1/$fisik_vs_dokumen, 1]
    ];

    $matrix_json = json_encode($matrix);
    $criteria_json = json_encode($criteria);

    if ($edit_mode && isset($_POST['id'])) {
        // Update existing expert
        $expert_id = $_POST['id'];
        $sql = "UPDATE experts SET name=?, criteria_weights=?, matrix=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $criteria_json, $matrix_json, $expert_id);
    } else {
        // Insert new expert
        $sql = "INSERT INTO experts (name, criteria_weights, matrix) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $criteria_json, $matrix_json);
    }

    // Execute the query and check for success
    if ($stmt->execute()) {
        header("Location: ahp.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $edit_mode ? 'Edit' : 'Tambah'; ?> Ahli</title>
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
            justify-content: space-between;
            align-items: center;
        }
        .navbar-nav {
            display: flex;
            align-items: center;
            padding: 60px 20px;
            margin-left: auto;
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
            margin-left: 20px;
        }
        .navbar-toggler {
            padding: 10px;
        }
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
            max-width: 900px;
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
            flex: 0 0 25%;
            max-width: 25%;
        }
        .form-horizontal .form-group > div {
            flex: 0 0 75%;
            max-width: 75%;
        }
        .radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 15px;
        }
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
        .radio-group label {
            display: inline-block;
            margin-right: 10px;
        }
        .radio-group input[type="radio"] {
            margin-right: 5px;
        }
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

<div class="form-container">
    <h2><?php echo $edit_mode ? 'Edit' : 'Tambah'; ?> Ahli</h2>

    <form method="post" action="" class="form-horizontal">
        <?php if ($edit_mode): ?>
            <input type="hidden" name="id" value="<?php echo $expert_id; ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nama Ahli:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" 
                       value="<?php echo $edit_mode ? htmlspecialchars($expert_data['name']) : ''; ?>" required>
            </div>
        </div>

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
            
            // Nilai-nilai radio button
            $values = [
                '9' => '9',
                '7' => '7',
                '5' => '5',
                '3' => '3',
                '1' => '1',
                '1/3' => '1/3',
                '1/5' => '1/5',
                '1/7' => '1/7',
                '1/9' => '1/9'
            ];
            
            foreach ($values as $value => $label) {
                $checked = '';
                if ($edit_mode && isset($criteria[$key]) && $criteria[$key] == $value) {
                    $checked = 'checked';
                }
                echo "<label><input type='radio' name='$key' value='$value' $checked > $label</label>";
            }
            
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        ?>

        <div class="form-group submit-group">
            <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-primary"><?php echo $edit_mode ? 'Update' : 'Tambah'; ?></button>
            </div>
        </div>
    </form>
    <a href="ahp.php" class="btn btn-default">Kembali ke Dashboard</a>
</div>
</body>
</html>