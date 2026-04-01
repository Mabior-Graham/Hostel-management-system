<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
include('../config/db.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $student_id = $_POST['student_id'] ?? null;
    $room_id    = $_POST['room_id'] ?? null;
    $bed_id     = $_POST['bed_id'] ?? null;
    $start_date = $_POST['start_date'] ?? null;
    $end_date   = $_POST['end_date'] ?? null;

    // Basic validation
    if (!$student_id || !$room_id || !$bed_id || !$start_date) {
        $_SESSION['error'] = "Please fill all required fields.";
        header("Location: ../admin/allocations.php");
        exit;
    }

    // Check if student is already allocated
    $checkStudent = mysqli_query($conn, "SELECT * FROM allocations WHERE student_id = '$student_id'");
    if (mysqli_num_rows($checkStudent) > 0) {
        $_SESSION['error'] = "This student is already allocated to a room.";
        header("Location: ../admin/allocations.php");
        exit;
    }

    // Check if bed is already occupied
    $checkBed = mysqli_query($conn, "SELECT * FROM allocations WHERE bed_id = '$bed_id'");
    if (mysqli_num_rows($checkBed) > 0) {
        $_SESSION['error'] = "This bed is already occupied.";
        header("Location: ../admin/allocations.php");
        exit;
    }

    // Insert allocation
    $stmt = mysqli_prepare($conn, "INSERT INTO allocations (student_id, room_id, bed_id, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iiiss", $student_id, $room_id, $bed_id, $start_date, $end_date);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Student allocated successfully.";
    } else {
        $_SESSION['error'] = "Failed to allocate student. Please try again.";
    }

    mysqli_stmt_close($stmt);
    header("Location: ../admin/allocations.php");
    exit;
} else {
    header("Location: ../admin/allocations.php");
    exit;
}
