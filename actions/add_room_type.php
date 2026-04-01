<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
include('../config/db.php'); // correct path to your db.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $price = trim(mysqli_real_escape_string($conn, $_POST['price']));

    // Basic validation
    if (empty($name) || empty($price) || !is_numeric($price)) {
        $_SESSION['error'] = "Please provide a valid room type name and price.";
        header("Location: ../admin/room_types.php");
        exit;
    }

    // Check for duplicate room type
    $check = mysqli_query($conn, "SELECT * FROM room_types WHERE name='$name'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['error'] = "Room type '$name' already exists.";
        header("Location: ../admin/room_types.php");
        exit;
    }

    // Insert into database
    $insert = mysqli_query($conn, "INSERT INTO room_types (name, price) VALUES ('$name', '$price')");

    if ($insert) {
        $_SESSION['success'] = "Room type '$name' added successfully!";
    } else {
        $_SESSION['error'] = "Failed to add room type. Error: " . mysqli_error($conn);
    }

    header("Location: ../admin/room_types.php");
    exit;
} else {
    // Invalid request
    $_SESSION['error'] = "Invalid request method.";
    header("Location: ../admin/room_types.php");
    exit;
}
