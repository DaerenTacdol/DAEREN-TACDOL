<?php
$host = 'localhost';
$dbname = 'employeer';
$username = 'root';
$password = '';

// Create a new MySQLi instance
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to UTF-8 (optional, but recommended)
$conn->set_charset("utf8");
?>