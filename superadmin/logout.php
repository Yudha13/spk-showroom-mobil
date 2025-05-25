<?php
session_start();

// Logout logic here...

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: http://spkshowroom.my.id/login.php");
exit;
?>