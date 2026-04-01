<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
require_once('../config/db.php'); // mysqli connection, e.g., $conn

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../register.php');
    exit;
}

// Collect & trim inputs
$full_name = trim($_POST['full_name'] ?? '');
$email     = trim($_POST['email'] ?? '');
$password  = $_POST['password'] ?? '';
$confirm   = $_POST['confirm_password'] ?? '';

// Basic validation
if ($full_name === '' || $email === '' || $password === '' || $confirm === '') {
    $_SESSION['error'] = 'All fields are required.';
    header('Location: ../register.php');
    exit;
}

// Email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Invalid email address.';
    header('Location: ../register.php');
    exit;
}

// Password match
if ($password !== $confirm) {
    $_SESSION['error'] = 'Passwords do not match.';
    header('Location: ../register.php');
    exit;
}

// Check duplicate email using prepared statement
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['error'] = 'Email already registered.';
    $stmt->close();
    header('Location: ../register.php');
    exit;
}
$stmt->close();

// Hash password securely
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user using prepared statement
$stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $full_name, $email, $hashedPassword);

if ($stmt->execute()) {
    $_SESSION['success'] = 'Registration successful. You can now log in.';
    $stmt->close();
    header('Location: ../login.php');
    exit;
} else {
    $_SESSION['error'] = 'Registration failed. Try again.';
    $stmt->close();
    header('Location: ../register.php');
    exit;
}
?>
