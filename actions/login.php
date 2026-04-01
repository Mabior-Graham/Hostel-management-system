<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
require_once('../config/db.php'); // MySQLi connection ($conn)

// Ensure form submitted via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

// Collect and trim inputs
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Basic validation
if ($email === '' || $password === '') {
    $_SESSION['error'] = 'Both email and password are required.';
    header('Location: ../login.php');
    exit;
}

// Fetch user using prepared statement
$stmt = $conn->prepare("SELECT id, full_name, email, password, role FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = 'Invalid email or password.';
    $stmt->close();
    header('Location: ../login.php');
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();

// Verify password
if (!password_verify($password, $user['password'])) {
    $_SESSION['error'] = 'Invalid email or password.';
    header('Location: ../login.php');
    exit;
}

// Set session variables
$_SESSION['user_id']   = $user['id'];
$_SESSION['full_name'] = $user['full_name'];
$_SESSION['role']      = $user['role'];

    // Redirect based on role
    switch ($user['role']) {

        case 'admin':
            header('Location: ../admin/dashboard.php');
            break;

        case 'student':
            header('Location: ../student/dashboard.php');
            break;

        default:
            header('Location: ../pending_approval.php');
            break;
    }


exit;
?>
