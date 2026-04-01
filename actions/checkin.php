<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
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
    $bookingRes = mysqli_query($conn, "SELECT * FROM bookings WHERE id = $booking_id AND status = 'booked'");
    if (mysqli_num_rows($bookingRes) === 0) {
        $_SESSION['error'] = "Booking not found or already checked in.";
        header("Location: ../receptionist/checkin_checkout.php");
        exit;
    }

    $booking = mysqli_fetch_assoc($bookingRes);
    $room_id = $booking['room_id'];

    // Update booking status to checked_in
    $updateBooking = mysqli_query($conn, "UPDATE bookings SET status = 'checked_in', updated_at = NOW() WHERE id = $booking_id");
    if ($updateBooking) {
        // Update room status to booked (for consistency)
        mysqli_query($conn, "UPDATE rooms SET status = 'booked' WHERE id = $room_id");

        $_SESSION['success'] = "Guest checked in successfully.";
    } else {
        $_SESSION['error'] = "Failed to check in guest: " . mysqli_error($conn);
    }

    header("Location: ../receptionist/checkin_checkout.php");
    exit;

} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../receptionist/checkin_checkout.php");
    exit;
}
