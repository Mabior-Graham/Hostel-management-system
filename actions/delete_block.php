<?php
session_start();
include('../config/db.php'); // Correct path to your DB connection

// Check if 'id' is provided and is a number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $block_id = (int) $_GET['id'];

    // Delete the block
    $query = "DELETE FROM blocks WHERE id = $block_id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Hostel block deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting block: " . mysqli_error($conn);
    }

} else {
    $_SESSION['error'] = "Invalid block ID.";
}

// Redirect back to blocks page
header("Location: ../admin/blocks.php");
exit;
