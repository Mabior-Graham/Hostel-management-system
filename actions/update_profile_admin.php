<?php
session_start();
require_once('../config/db.php'); // database connection

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Access denied.';
    header('Location: ../login.php');
    exit;
}

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/profile.php');
    exit;
}

// Collect & sanitize inputs
$user_id  = $_SESSION['user_id'];
$name     = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? ''); // optional

// Basic validation
if ($name === '' || $email === '') {
    $_SESSION['error'] = 'Full Name and Email are required.';
    header('Location: ../admin/profile.php');
    exit;
}

// Escape inputs to prevent SQL injection
$name_safe  = mysqli_real_escape_string($conn, $name);
$email_safe = mysqli_real_escape_string($conn, $email);

// Check if email is already used by another user
$check_sql = "SELECT id FROM users WHERE email='$email_safe' AND id != $user_id";
$check_res = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_res) > 0) {
    $_SESSION['error'] = 'This email is already in use by another account.';
    header('Location: ../admin/profile.php');
    exit;
}

// Build update query
if ($password !== '') {
    // Hash password using md5 (student project; for real apps use password_hash)
    $hashed_password = md5($password);
    $update_sql = "
        UPDATE users
        SET full_name='$name_safe',
            email='$email_safe',
            password='$hashed_password'
        WHERE id=$user_id
    ";
} else {
    $update_sql = "
        UPDATE users
        SET full_name='$name_safe',
            email='$email_safe'
        WHERE id=$user_id
    ";
}

// Execute update
if (mysqli_query($conn, $update_sql)) {
    $_SESSION['success'] = 'Profile updated successfully.';
} else {
    $_SESSION['error'] = 'Failed to update profile: ' . mysqli_error($conn);
}

// Redirect back to profile page
header('Location: ../admin/profile.php');
exit;
