<?php
session_start();

if(isset($_POST["login"])){

    if(!empty($_POST['useremail']) && !empty($_POST['pass'])) {

        $useremail = $_POST['useremail'];
        $pass = $_POST['pass'];
        $db = mysqli_connect("localhost","spkq4689","BT37Su3mVcBX61","spkq4689_car_showroom");

        // Fetch user information including c_id from the database
        $query = mysqli_query($db, "SELECT * FROM customer WHERE email = '".$useremail."' AND pass = '".$pass."'");

        $numrows = mysqli_num_rows($query);

        if($numrows != 0) {
            while($row = mysqli_fetch_assoc($query)) {
                $dbuseremail = $row['email'];
                $dbpass = $row['pass'];
                $dbusername = $row['name'];
                $dbrole = $row['role']; // Add this line to retrieve the user's role
                $dbc_id = $row['c_id'];  // Retrieve the c_id of the customer (admin or user)
            }

            if($useremail == $dbuseremail && $pass == $dbpass) {
                // Store the necessary session data
                $_SESSION['s_name'] = $dbusername;
                $_SESSION['s_role'] = $dbrole;  // Store the user's role
                $_SESSION['c_id'] = $dbc_id;    // Store the c_id for later use

                /* Redirect based on role */
                if ($_SESSION['s_role'] == 'superadmin') {
                    header("Location: superadmin/ahp.php");
                    exit();
                } elseif ($_SESSION['s_role'] == 'admin') {
                    header("Location: showroom.php");
                    exit();
                } else {
                    header("Location: indexlogin.php");
                    exit();
                }
            }
        } else {
            $message = "Invalid credentials!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

    } else {
        echo "All fields are required!";
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Car Showroom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
        .login-container {
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .footer {
            background-color: #333;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: auto;
        }
        .footer p, .footer span {
            color: white;
        }
        .full-height {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
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

<!-- Form Login -->
<div class="full-height">
    <div class="login-container">
        <h2 class="text-center">Silahkan Masuk</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="useremail">Username</label>
                <input type="text" class="form-control" id="useremail" name="useremail" placeholder="Masukkan Username Anda" required>
            </div>
            <div class="form-group">
                <label for="pass">Password</label>
                <input type="password" class="form-control" id="pass" name="pass" placeholder="Masukkan Password Anda" required>
            </div>
            <button type="submit" class="btn btn-danger btn-block" name="login">Masuk</button>
        </form>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>&copy; 2024 Car Showroom. All Rights Reserved.</p>
    <p>Contact Us: 082239012645 | mrizkyirvanto@gmail.com</p>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>





    	
    	
            