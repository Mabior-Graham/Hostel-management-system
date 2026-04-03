<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
include('../config/db.php');

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../admin/payments.php");
    exit;
}

// Get and sanitize inputs
$allocation_id = intval($_POST['allocation_id'] ?? 0);
$amount = floatval($_POST['amount'] ?? 0);
$payment_date = $_POST['payment_date'] ?? '';
$status = $_POST['status'] ?? 'paid';

// Basic validation
if ($allocation_id <= 0 || $amount <= 0 || empty($payment_date)) {
    $_SESSION['error'] = "Please fill all required fields correctly.";
    header("Location: ../admin/payments.php");
    exit;
}

// Validate status
$allowed_status = ['paid', 'pending'];
if (!in_array($status, $allowed_status)) {
    $status = 'paid';
}

// Check if allocation exists
$check = mysqli_prepare($conn, "SELECT id FROM allocations WHERE id = ?");
mysqli_stmt_bind_param($check, "i", $allocation_id);
mysqli_stmt_execute($check);
$result = mysqli_stmt_get_result($check);

if (mysqli_num_rows($result) === 0) {
    $_SESSION['error'] = "Invalid allocation selected.";
    header("Location: ../admin/payments.php");
    exit;
}

// Insert payment
$stmt = mysqli_prepare($conn, "
    INSERT INTO payments (allocation_id, amount, payment_date, status, created_at, updated_at)
    VALUES (?, ?, ?, ?, NOW(), NOW())
");

mysqli_stmt_bind_param($stmt, "idss", $allocation_id, $amount, $payment_date, $status);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['success'] = "Payment recorded successfully.";
} else {
    $_SESSION['error'] = "Failed to record payment. Try again.";
}

// Redirect back
header("Location: ../admin/payments.php");
exit;
?>