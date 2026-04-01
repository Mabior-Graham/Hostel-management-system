<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
include('../config/db.php'); // Your database connection file

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect and sanitize input
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
    $floor_count = (int) $_POST['floor_count'];

    // Validate input
    if (empty($name)) {
        $_SESSION['error'] = "Block name is required.";
        header("Location: ../admin/blocks.php");
        exit;
    }

    if ($floor_count < 1) {
        $_SESSION['error'] = "Number of floors must be at least 1.";
        header("Location: ../admin/blocks.php");
        exit;
    }

    // Insert into database
    $query = "INSERT INTO blocks (name, description, floor_count) VALUES ('$name', '$description', $floor_count)";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Hostel block '$name' added successfully.";
    } else {
        $_SESSION['error'] = "Error adding block: " . mysqli_error($conn);
    }

    // Redirect back to blocks page
    header("Location: ../admin/blocks.php");
    exit;
} else {
    // Invalid access
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../admin/blocks.php");
    exit;
}
