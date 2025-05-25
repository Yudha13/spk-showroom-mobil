<?php
$servername = "localhost";
$username = "spkq4689";
$password = "BT37Su3mVcBX61";
$dbname = "spkq4689_car_showroom";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
