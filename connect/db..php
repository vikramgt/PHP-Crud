<?php
// Database configuration
$host = 'localhost';
$dbname = 'demo';
$username = 'root';
$password = '';

// Establish a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
