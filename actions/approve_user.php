<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
require_once('../config/db.php');

// Ensure admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Unauthorized access.";
    header("Location: ../login.php");
    exit;
}

// Ensure POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: ../admin/user_approvals.php");
    exit;
}

// Get POST data
$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
$role = isset($_POST['role']) ? trim($_POST['role']) : '';

// Validate input
$valid_roles = ['admin', 'league_manager', 'team_manager', 'referee'];
if ($user_id <= 0 || !in_array($role, $valid_roles)) {
    $_SESSION['error'] = "Invalid input.";
    header("Location: ../admin/user_approvals.php");
    exit;
}

// Check if user exists and is pending
$stmt = $conn->prepare("SELECT account_status FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($status);
$stmt->fetch();
$stmt->close();

if (!$status) {
    $_SESSION['error'] = "User not found.";
    header("Location: ../admin/user_approvals.php");
    exit;
} elseif ($status !== 'pending') {
    $_SESSION['error'] = "User is not pending approval.";
    header("Location: ../admin/user_approvals.php");
    exit;
}

// Update user status and role
$update_stmt = $conn->prepare("UPDATE users SET account_status='active', role=? WHERE id=?");
$update_stmt->bind_param("si", $role, $user_id);

if ($update_stmt->execute()) {
    $_SESSION['success'] = "User approved successfully as '$role'.";
} else {
    $_SESSION['error'] = "Failed to approve user.";
}

$update_stmt->close();

// Redirect back
header("Location: ../admin/user_approvals.php");
exit;
