<?php
$servername = "localhost";
$username = "root";     // Default XAMPP username
$password = "";         // Default XAMPP password is blank
$dbname = "rps_game";   // The name of the database
// Create the connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    
}

// Note: We don't put an "echo" here so it stays quiet 
// until we actually need it in the game.
?>