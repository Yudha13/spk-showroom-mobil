<?php
session_start();
if (!isset($_SESSION['s_role']) || $_SESSION['s_role'] != 'superadmin') {
    header("Location: showroom_mobil/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Car</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
                            <li class="active"><a href="admin.php">Home</a></li>
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
    </div>
    <h1>Superadmin Dashboard</h1>
    <a href="add_expert.php">Tambah Ahli</a> | <a href="ahp.php">Lihat Perhitungan AHP</a> | <a href="../logout.php">Logout</a>
    <!-- Konten lain untuk superadmin -->
</body>
</html>
