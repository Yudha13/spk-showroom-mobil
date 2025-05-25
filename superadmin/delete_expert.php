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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare a delete statement
    $delete_sql = "DELETE FROM experts WHERE id = $id"; // Assuming you have an `id` field in your experts table
    
    // Execute the delete query
    if ($conn->query($delete_sql) === TRUE) {
        header("Location: ahp.php"); // Redirect to your AHP page after deletion
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No expert found.";
}

$conn->close(); // Close the database connection
?>
