<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start the session to access user roles

// Database connection
$conn = mysqli_connect("localhost", "root", "", "car_showroom");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize search variables
$search = isset($_POST['search']) ? mysqli_real_escape_string($conn, $_POST['search']) : '';
$min_price = isset($_POST['min_price']) && $_POST['min_price'] !== '' ? (float)$_POST['min_price'] : null; // Allow null for min price
$max_price = isset($_POST['max_price']) && $_POST['max_price'] !== '' ? (float)$_POST['max_price'] : null; // Allow null for max price

// Prepare the SQL statement to retrieve cars with optional search
$query = "SELECT Cars.*, Showrooms.name AS showroom_name, Showrooms.contact AS showroom_contact 
          FROM Cars 
          JOIN Showrooms ON Cars.showroom_id = Showrooms.showroom_id 
          WHERE 1=1"; // Start with a true condition

// Append search conditions based on input
if ($search !== '') {
    $query .= " AND Cars.name LIKE '%$search%'";
}
if ($min_price !== null) {
    $query .= " AND Cars.price >= $min_price";
}
if ($max_price !== null) {
    $query .= " AND Cars.price <= $max_price";
}

// Maintain your ordering
$query .= " ORDER BY Cars.ahp_value DESC"; 

// Execute the query
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Available Cars</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<!-- Navigation -->
<div class="header">    
    <div class="wrap"> 
        <div class="header-bot">
            <div class="logo">
                <!-- <a href="index.html"><img src="images/2.jpg" alt="" style="width:450px; height:160px;"></a> -->
            </div>
            <div class="cart">
                <div class="menu-main">
                    <ul class="dc_css3_menu">
                        <li class="active"><a href="index.php">Home</a></li>
                        <li><a href="about.html">About</a></li>
                    </ul>
                    <div class="clear"></div>
                </div>  
            </div>  
            <div class="clear"></div> 
        </div>
    </div>    
</div>

<!-- Search Form -->
<div class="search-container">
    <form method="POST" action="">
        <input type="text" name="search" placeholder="Search for a car..." value="<?php echo htmlspecialchars($search); ?>">
        <input type="number" name="min_price" placeholder="Min Price" value="<?php echo isset($_POST['min_price']) ? htmlspecialchars($_POST['min_price']) : ''; ?>">
        <input type="number" name="max_price" placeholder="Max Price" value="<?php echo isset($_POST['max_price']) ? htmlspecialchars($_POST['max_price']) : ''; ?>">
        <button type="submit">Search</button>
    </form>
</div>

<!-- Car Display -->
<div class="section group">
<?php
// Display cars dynamically
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Determine car image or default image if not available
        $image = !empty($row['image']) ? "images/{$row['image']}" : "images/default_car.jpg";

        echo "
        <div class='col_1_of_4 span_1_of_4'>
            <img src='$image' alt='Gambar tidak tersedia' style='width: 375px; height: 210px;'/>
            <div class='grid_desc'>
                <p class='title'>" . htmlspecialchars($row['name']) . "</p>
                <p>Price: " . htmlspecialchars($row['price']) . "</p>
                <p>Showroom: " . htmlspecialchars($row['showroom_name']) . "</p>
                <p>Kontak: " . htmlspecialchars($row['showroom_contact']) . "</p>            
            </div>
            <div class='Details'>
                <a href='car.php?id=" . htmlspecialchars($row['car_id']) . "' class='button'>Lihat Detail Mobil</a>
            </div>";

        // Display edit button only if user is admin
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
            echo "<a href='edit_car.php?id=" . htmlspecialchars($row['car_id']) . "' class='edit-button'>Edit</a>";
        }

        echo "</div>";
    }
} else {
    echo "<p>Tidak ada mobil yang ditemukan.</p>";
}
?>
</div>

</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>
