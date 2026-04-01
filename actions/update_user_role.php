<?php
session_start();
require_once('../config/db.php');

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Access denied.";
    header("Location: ../login.php");
    exit;
}

// Validate input
if (!isset($_POST['user_id'], $_POST['role'])) {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../admin/roles.php");
    exit;
}

$userId = (int) $_POST['user_id'];
$newRole = $_POST['role'];

// Allowed roles
$allowedRoles = ['admin', 'receptionist', 'guest'];
if (!in_array($newRole, $allowedRoles)) {
    $_SESSION['error'] = "Invalid role selected.";
    header("Location: ../admin/roles.php");
    exit;
}

// Prevent admin from changing their own role
if ($userId === (int) $_SESSION['user_id']) {
    $_SESSION['error'] = "You cannot change your own role.";
    header("Location: ../admin/roles.php");
    exit;
}

// Check if user exists
$userCheck = mysqli_query($conn, "SELECT id FROM users WHERE id = $userId");
if (mysqli_num_rows($userCheck) === 0) {
    $_SESSION['error'] = "User not found.";
    header("Location: ../admin/roles.php");
    exit;
}

// Update role
$updateQuery = "UPDATE users SET role = '$newRole' WHERE id = $userId";

if (mysqli_query($conn, $updateQuery)) {
    $_SESSION['success'] = "User role updated successfully.";
} else {
    $_SESSION['error'] = "Database error: " . mysqli_error($conn);
}

header("Location: ../admin/roles.php");
exit;
