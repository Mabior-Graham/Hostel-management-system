<?php
session_start();
require_once('../config/db.php');


// Admin check
if (!isset($_SESSION['librarian_id'])) {
    $_SESSION['error'] = 'Access denied.';
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = intval($_POST['request_id'] ?? 0);
    $due_date   = $_POST['due_date'] ?? '';
}

if ($request_id <= 0 || !$due_date) {
        $_SESSION['error'] = 'Invalid request or due date.';
        header('Location: ../admin/borrowrequests.php');
        exit;
    }
$request_id = intval($_POST['request_id'] ?? 0);
$due_date   = $_POST['due_date'] ?? '';


if ($request_id <= 0) {
    $_SESSION['error'] = 'Invalid request.';
    header('Location: ../librarian/borrowrequests.php');
    exit;
}

/* Fetch borrow request */
$requestSql = "
    SELECT br.book_id, br.status, b.quantity
    FROM borrow_requests br
    JOIN books b ON br.book_id = b.id
    WHERE br.id = $request_id
";
$requestRes = mysqli_query($conn, $requestSql);

if (mysqli_num_rows($requestRes) === 0) {
    $_SESSION['error'] = 'Borrow request not found.';
    header('Location: ../librarian/borrowrequests.php');
    exit;
}

$request = mysqli_fetch_assoc($requestRes);

// Must be pending
if ($request['status'] !== 'pending') {
    $_SESSION['error'] = 'Request already processed.';
    header('Location: ../admin/borrowrequests.php');
    exit;
}

// Check availability
if ($request['quantity'] <= 0) {
    $_SESSION['error'] = 'Book is no longer available.';
    header('Location: ../librarian/borrowrequests.php');
    exit;
}

/* Reduce book quantity */
$updateBook = "
    UPDATE books 
    SET quantity = quantity - 1 
    WHERE id = {$request['book_id']}
";

if (!mysqli_query($conn, $updateBook)) {
    $_SESSION['error'] = 'Failed to update book quantity.';
    header('Location: ../librarian/borrowrequests.php');
    exit;
}

/* Approve request */
 // Approve request with due date
    $approveSql = "
        UPDATE borrow_requests
        SET status = 'approved', approve_date = NOW(), due_date = '$due_date'
        WHERE id = $request_id
    ";

if (mysqli_query($conn, $approveSql)) {
    $_SESSION['success'] = 'Borrow request approved.';
} else {
    $_SESSION['error'] = 'Failed to approve request.';
}

header('Location: ../librarian/borrowrequests.php');
exit;
