<?php
session_start();
require_once('../config/db.php');

// Only admin can add services
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Unauthorized access!";
    header("Location: ../login.php");
    exit;
}

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
    $price = mysqli_real_escape_string($conn, trim($_POST['price']));

    // Validation
    if (empty($name) || !is_numeric($price)) {
        $_SESSION['error'] = "Please provide valid service name and price.";
        header("Location: ../admin/services.php");
        exit;
    }

    // Insert into database
    $query = "INSERT INTO services (name, description, price) VALUES ('$name', '$description', '$price')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Service added successfully!";
    } else {
        $_SESSION['error'] = "Failed to add service: " . mysqli_error($conn);
    }

    header("Location: ../admin/services.php");
    exit;
}

// Redirect if accessed directly
header("Location: ../admin/services.php");
exit;
