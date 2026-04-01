<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
require_once('../config/db.php');

// Allow only admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid room type selected.";
    header("Location: ../admin/room_types.php");
    exit;
}

$roomTypeId = (int) $_GET['id'];

// Optional: check if room type is in use
$checkStmt = $conn->prepare(
    "SELECT COUNT(*) FROM rooms WHERE room_type_id = ?"
);
$checkStmt->bind_param("i", $roomTypeId);
$checkStmt->execute();
$checkStmt->bind_result($count);
$checkStmt->fetch();
$checkStmt->close();

if ($count > 0) {
    $_SESSION['error'] = "Cannot delete room type. It is assigned to existing rooms.";
    header("Location: ../admin/room_types.php");
    exit;
}

// Delete room type
$stmt = $conn->prepare(
    "DELETE FROM room_types WHERE id = ?"
);
$stmt->bind_param("i", $roomTypeId);

if ($stmt->execute()) {
    $_SESSION['success'] = "Room type deleted successfully.";
} else {
    $_SESSION['error'] = "Failed to delete room type.";
}

$stmt->close();
header("Location: ../admin/room_types.php");
exit;
