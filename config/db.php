<?php
// Database configuration
$host     = "localhost";      // usually localhost
$user     = "root";           // your DB username
$password = "";               // your DB password
$dbname   = "hostelms";     // your DB name

// Create connection
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: set charset
mysqli_set_charset($conn, "utf8");
