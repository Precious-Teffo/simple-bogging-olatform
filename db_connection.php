<?php
// Define database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myblogs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();
?>