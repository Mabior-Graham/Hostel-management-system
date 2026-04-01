<?php
session_start();
include('../config/db.php'); // correct path to your db.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get inputs
    $room_id = intval($_POST['room_id']);
    $bed_number = trim(mysqli_real_escape_string($conn, $_POST['bed_number']));
    $status = trim(mysqli_real_escape_string($conn, $_POST['status']));
    $notes = trim(mysqli_real_escape_string($conn, $_POST['notes']));

    // Validate required fields
    if (empty($room_id) || empty($bed_number) || empty($status)) {
        $_SESSION['error'] = "Please fill in all required fields.";
        header("Location: ../admin/beds.php?room_id=$room_id");
        exit;
    }

    // Check if bed number already exists in this room
    $check = mysqli_query($conn, "SELECT * FROM beds WHERE room_id='$room_id' AND bed_number='$bed_number'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['error'] = "Bed number '$bed_number' already exists in this room.";
        header("Location: ../admin/beds.php?room_id=$room_id");
        exit;
    }

    // Insert bed
    $stmt = mysqli_prepare($conn, "INSERT INTO beds (room_id, bed_number, status, notes) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isss", $room_id, $bed_number, $status, $notes);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Bed '$bed_number' added successfully!";
    } else {
        $_SESSION['error'] = "Failed to add bed. Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    header("Location: ../admin/beds.php?room_id=$room_id");
    exit;

} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: ../admin/rooms.php");
    exit;
}
