<?php
session_start();
include('../config/db.php'); // Make sure $conn is available

// Restrict access to receptionist
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'receptionist') {
    $_SESSION['error'] = "Access denied.";
    header("Location: ../login.php");
    exit;
}

// Check if booking ID is provided
if (isset($_GET['id'])) {
    $booking_id = intval($_GET['id']);

    // Fetch booking
    $bookingRes = mysqli_query($conn, "SELECT * FROM bookings WHERE id = $booking_id AND status = 'checked_in'");
    if (mysqli_num_rows($bookingRes) === 0) {
        $_SESSION['error'] = "Booking not found or guest is not currently checked in.";
        header("Location: ../receptionist/checkin_checkout.php");
        exit;
    }

    $booking = mysqli_fetch_assoc($bookingRes);
    $room_id = $booking['room_id'];

    // Update booking status to checked_out
    $updateBooking = mysqli_query($conn, "UPDATE bookings SET status = 'checked_out', updated_at = NOW() WHERE id = $booking_id");
    if ($updateBooking) {
        // Update room status to available
        mysqli_query($conn, "UPDATE rooms SET status = 'available' WHERE id = $room_id");

        $_SESSION['success'] = "Guest checked out successfully.";
    } else {
        $_SESSION['error'] = "Failed to check out guest: " . mysqli_error($conn);
    }

    header("Location: ../receptionist/checkin_checkout.php");
    exit;

} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../receptionist/checkin_checkout.php");
    exit;
}
