<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();

// Redirect if not logged in as admin
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'You must log in as an admin to access this page.';
    header('Location: ../login.php');
    exit;
}



require_once('../config/db.php'); // MySQLi connection ($conn)
include('../includes/header1.php');
?>

<div class="container-fluid my-5">
    <div class="row">

 <!-- Hostel Admin Sidebar -->
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar vh-100"
     style="background: linear-gradient(180deg, #0f2027, #203a43, #2c5364);">
    
    <div class="position-sticky pt-4">

        <!-- Admin Info -->
        <div class="text-center mb-4">
            <img src="../assets/images/user-avatar.png"
                 alt="Admin Avatar"
                 class="rounded-circle mb-2 border border-light"
                 width="80">

            <h6 class="text-white fw-bold mb-0">
                <?php echo htmlspecialchars($_SESSION['full_name']); ?>
            </h6>
            <small class="text-light">Hostel Administrator</small>
        </div>

        <!-- Menu -->
        <ul class="nav flex-column px-2">

            <!-- Dashboard -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="dashboard.php">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Dashboard
                </a>
            </li>

            <!-- Hostel Blocks / Buildings -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="blocks.php">
                    <i class="bi bi-building me-2"></i>
                    Hostel Blocks
                </a>
            </li>

             <!-- Hostel Blocks / Buildings -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="room_types.php">
                    <i class="bi bi-building me-2"></i>
                    Room Type
                </a>
            </li>

            <!-- Rooms -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="rooms.php">
                    <i class="bi bi-door-open-fill me-2"></i>
                    Manage Rooms
                </a>
            </li>

            <!-- Bed Spaces -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="beds.php">
                    <i class="bi bi-grid-3x3-gap-fill me-2"></i>
                    Bed Spaces
                </a>
            </li>

            <!-- Students -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="students.php">
                    <i class="bi bi-people-fill me-2"></i>
                    Students
                </a>
            </li>

            <!-- Allocations -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="allocations.php">
                    <i class="bi bi-person-check-fill me-2"></i>
                    Room Allocation
                </a>
            </li>

            <!-- Payments -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="payments.php">
                    <i class="bi bi-cash-coin me-2"></i>
                    Hostel Payments
                </a>
            </li>

            <!-- Complaints / Maintenance -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="complaints.php">
                    <i class="bi bi-tools me-2"></i>
                    Complaints & Repairs
                </a>
            </li>

            <!-- Reports -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="reports.php">
                    <i class="bi bi-bar-chart-line-fill me-2"></i>
                    Reports
                </a>
            </li>

            <!-- Profile -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="profile.php">
                    <i class="bi bi-gear-fill me-2"></i>
                    Profile
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item mt-4">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="../actions/logout.php">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Logout
                </a>
            </li>

        </ul>
    </div>
</nav>




        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
          