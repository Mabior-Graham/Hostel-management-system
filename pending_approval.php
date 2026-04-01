<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
require_once('config/db.php');
include('includes/header.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login first.";
    header("Location: login.php");
    exit;
}

// Fetch current user's status
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT full_name, account_status, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "User not found.";
    header("Location: login.php");
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();
?>

<!-- Pending Approval Section -->
<section class="py-5 text-center" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('assets/images/pending.jpg') center/cover no-repeat; min-height: 70vh;">
    <div class="container text-white d-flex flex-column justify-content-center align-items-center h-100">
        <h1 class="display-4 fw-bold mb-3">Hello, <?= htmlspecialchars($user['full_name']); ?>!</h1>
        <p class="lead mb-4">
            Your account is currently <strong><?= htmlspecialchars($user['account_status']); ?></strong>.
        </p>
        <p class="mb-2">Please wait for the admin to review your registration.</p>
        <p>If you have any questions, contact us at <a href="mailto:support@flms.com" class="text-white text-decoration-underline">support@flms.com</a>.</p>
        <a href="actions/logout.php" class="btn btn-light btn-lg mt-3">Logout</a>
    </div>
</section>

<?php include('includes/footer.php'); ?>
