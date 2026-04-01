<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
require_once('../config/db.php');


// Redirect if not logged in as admin
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'You must log in as an admin to access this page.';
    header('Location: ../login.php');
    exit;
}

// Get user ID
$user_id = intval($_GET['id'] ?? 0);

if ($user_id <= 0) {
    $_SESSION['error'] = 'Invalid user.';
    header('Location: ../admin/manage_users.php');
    exit;
}



// Deactivate user
$sql = "
    UPDATE users 
    SET account_status = 'pending' 
    WHERE id = $user_id
";

if (mysqli_query($conn, $sql)) {
    $_SESSION['success'] = 'User account deactivated successfully.';
} else {
    $_SESSION['error'] = 'Failed to deactivate user.';
}

header('Location: ../admin/manage_users.php');
exit;
