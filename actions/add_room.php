<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
include('../config/db.php'); // correct path to db.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form inputs and sanitize
    $room_number   = trim(mysqli_real_escape_string($conn, $_POST['room_number']));
    $room_type_id  = intval($_POST['room_type_id']);
    $floor         = intval($_POST['floor']);
    $bed_capacity  = intval($_POST['bed_capacity']);
    $status        = trim(mysqli_real_escape_string($conn, $_POST['status']));
    $notes         = trim(mysqli_real_escape_string($conn, $_POST['notes']));

    // Basic validation
    if (empty($room_number) || empty($room_type_id) || empty($status) || $bed_capacity < 1) {
        $_SESSION['error'] = "Please fill in all required fields and provide a valid bed capacity.";
        header("Location: ../admin/rooms.php");
        exit;
    }

    // Check for duplicate room number
    $check = mysqli_query($conn, "SELECT * FROM rooms WHERE room_number='$room_number'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['error'] = "Room number '$room_number' already exists.";
        header("Location: ../admin/rooms.php");
        exit;
    }

    // Insert room into database
    $stmt = mysqli_prepare($conn, "INSERT INTO rooms (room_number, room_type_id, floor, status, notes, bed_capacity) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "siissi", $room_number, $room_type_id, $floor, $status, $notes, $bed_capacity);

    if (mysqli_stmt_execute($stmt)) {
        $room_id = mysqli_insert_id($conn);

        // Auto-create beds based on bed_capacity
        for ($i = 1; $i <= $bed_capacity; $i++) {
            mysqli_query($conn, "INSERT INTO beds (room_id, bed_number) VALUES ('$room_id', '$i')");
        }

        $_SESSION['success'] = "Room '$room_number' added successfully with $bed_capacity bed(s)!";
    } else {
        $_SESSION['error'] = "Failed to add room. Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    header("Location: ../admin/rooms.php");
    exit;

} else {
    // Invalid request
    $_SESSION['error'] = "Invalid request method.";
    header("Location: ../admin/rooms.php");
    exit;
}
