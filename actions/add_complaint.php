<?php
session_start();
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../student/complaints.php");
    exit;
}

$student_id = $_SESSION['user_id'];
$title = trim($_POST['title']);
$description = trim($_POST['description']);

if (empty($title) || empty($description)) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: ../student/complaints.php");
    exit;
}

// Insert complaint
$stmt = mysqli_prepare($conn, "
    INSERT INTO complaints (student_id, title, description, status, created_at)
    VALUES (?, ?, ?, 'pending', NOW())
");

mysqli_stmt_bind_param($stmt, "iss", $student_id, $title, $description);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['success'] = "Complaint submitted successfully.";
} else {
    $_SESSION['error'] = "Failed to submit complaint.";
}

header("Location: ../student/complaints.php");
exit;
?>