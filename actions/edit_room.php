<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
require_once('../config/db.php');

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Access denied.";
    header("Location: ../login.php");
    exit;
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../admin/rooms.php");
    exit;
}

$roomId = intval($_POST['id']);
$room_number = mysqli_real_escape_string($conn, $_POST['room_number']);
$room_type_id = intval($_POST['room_type_id']);
$floor = intval($_POST['floor']);
$status = $_POST['status'];
$notes = mysqli_real_escape_string($conn, $_POST['notes']);

// Fetch current room data
$roomResult = mysqli_query($conn, "SELECT * FROM rooms WHERE id = $roomId");
if (mysqli_num_rows($roomResult) === 0) {
    $_SESSION['error'] = "Room not found.";
    header("Location: ../admin/rooms.php");
    exit;
}

$room = mysqli_fetch_assoc($roomResult);

// Handle image upload
$imageName = $room['image']; // default to existing image

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/';
    
    // Make sure folder exists and writable
    if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
        $_SESSION['error'] = "Upload folder is not writable!";
        header("Location: ../admin/edit_room.php?id=$roomId");
        exit;
    }

    $tmpName = $_FILES['image']['tmp_name'];
    $originalName = basename($_FILES['image']['name']);
    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','webp','gif'];

    if (!in_array(strtolower($ext), $allowed)) {
        $_SESSION['error'] = "Invalid image format. Allowed: jpg, jpeg, png, webp, gif.";
        header("Location: ../admin/edit_room.php?id=$roomId");
        exit;
    }

    // Create unique file name
    $newFileName = uniqid('room_', true) . '.' . $ext;
    $destination = $uploadDir . $newFileName;

    if (!move_uploaded_file($tmpName, $destination)) {
        $_SESSION['error'] = "Failed to upload image.";
        header("Location: ../admin/edit_room.php?id=$roomId");
        exit;
    }

    // Delete old image if exists
    if (!empty($room['image']) && file_exists($uploadDir . $room['image'])) {
        unlink($uploadDir . $room['image']);
    }

    $imageName = $newFileName;
}

// Update the room in DB
$updateQuery = "
    UPDATE rooms SET
        room_number = '$room_number',
        room_type_id = $room_type_id,
        floor = $floor,
        status = '$status',
        notes = '$notes',
        image = '$imageName',
        updated_at = NOW()
    WHERE id = $roomId
";

if (mysqli_query($conn, $updateQuery)) {
    $_SESSION['success'] = "Room updated successfully!";
} else {
    $_SESSION['error'] = "Database error: " . mysqli_error($conn);
}

header("Location: ../admin/rooms.php");
exit;
