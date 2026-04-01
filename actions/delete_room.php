<?php
session_start();
require_once('../config/db.php');

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Access denied.";
    header("Location: ../login.php");
    exit;
}

// Check if room ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid room ID.";
    header("Location: ../admin/rooms.php");
    exit;
}

$roomId = intval($_GET['id']);

// Fetch room data
$roomResult = mysqli_query($conn, "SELECT * FROM rooms WHERE id = $roomId");
if (mysqli_num_rows($roomResult) === 0) {
    $_SESSION['error'] = "Room not found.";
    header("Location: ../admin/rooms.php");
    exit;
}

$room = mysqli_fetch_assoc($roomResult);

// Delete room image if exists
$uploadDir = '../uploads/';
if (!empty($room['image']) && file_exists($uploadDir . $room['image'])) {
    unlink($uploadDir . $room['image']);
}

// Delete room record
$deleteQuery = "DELETE FROM rooms WHERE id = $roomId";

if (mysqli_query($conn, $deleteQuery)) {
    $_SESSION['success'] = "Room deleted successfully!";
} else {
    $_SESSION['error'] = "Database error: " . mysqli_error($conn);
}

header("Location: ../admin/rooms.php");
exit;
