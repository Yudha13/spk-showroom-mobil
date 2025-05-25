<?php 
session_start(); // Start the session to access user role

// Database connection
$conn = mysqli_connect("localhost","spkq4689","BT37Su3mVcBX61","spkq4689_car_showroom");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get search query and filter values
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$min_price = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 999999;

// SQL query to fetch filtered cars
$query = "SELECT * FROM Cars WHERE name LIKE '%$search%' AND price BETWEEN $min_price AND $max_price ORDER BY ahp_value DESC";


$result = mysqli_query($conn, $query);

// Check if query returns any results
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

?>

<!DOCTYPE HTML>
<html>
<head>
<title>Search Cars</title>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<!-- Navigation Bar -->
<div class="header">    
    <div class="wrap"> 
        <div class="header-bot">
            <div class="logo">
                <!-- <a href="index.html"><img src="images/2.jpg" alt="" style ="width:450px; height: 160px;"></a> -->
            </div>
         
            <div class="cart">
                <div class="menu-main">
                    <ul class="dc_css3_menu">
                        <li class="active"><a href="index.php">Home</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="services.php">Home</a></li>
                        <li><a href="login.php">Login</a></li>
                    </ul>
                    <div class="clear"></div>
                </div>  
            </div>  
            <div class="clear"></div> 
        </div>
    </div>    
</div>

<!-- Search Form -->
<form action="cars.php" method="GET">
    <input type="text" name="search" placeholder="Nama Mobil" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <input type="number" name="min_price" placeholder="Harga Minimal" value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>">
    <input type="number" name="max_price" placeholder="Harga Maksimal" value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>">
    <button type="submit">Search</button>
</form>

<!-- Display Cars -->
<div class="section group">
<?php
// Display the cars dynamically
while ($row = mysqli_fetch_assoc($result)) {
    // Check if image is missing, use default image if necessary
    $image = !empty($row['image']) ? "images/{$row['image']}" : "images/default_car.jpg";

    echo "
    <div class='col_1_of_4 span_1_of_4'>
        <img src='$image' alt='Image not available' style='width: 375px; height: 210px;'/>
        <div class='grid_desc'>
            <p class='title'>{$row['name']}</p>
            <p>Price: {$row['price']}</p>
            <p>AHP Value: {$row['ahp_value']}</p>
        </div>
        <div class='Details'>
            <a href='car.php?id={$row['car_id']}' class='button'>View Car Details</a>
        </div>";

    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        echo "<a href='edit_car.php?id={$row['car_id']}' class='edit-button'>Edit</a>";
    }

    echo "</div>";
}

?>
</div>

</body>
</html>

<?php
// Close the connection
mysqli_close($conn);
?>
