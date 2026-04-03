<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'You must log in first.';
    header('Location: ../login.php');
    exit;
}


require_once('../config/db.php'); // MySQLi connection ($conn)
include('../includes/header1.php');
?>

<div class="container-fluid pt-5">
    <div class="row">

    <!-- Student Sidebar -->
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar vh-100"
     style="background: linear-gradient(180deg, #0f2027, #203a43, #2c5364);">
    
    <div class="position-sticky pt-4">

        <!-- Student Info -->
        <div class="text-center mb-4">
            <img src="../assets/images/user-avatar.png"
                 alt="Student Avatar"
                 class="rounded-circle mb-2 border border-light"
                 width="80">

            <h6 class="text-white fw-bold mb-0">
                <?php echo htmlspecialchars($_SESSION['full_name']); ?>
            </h6>
            <small class="text-light">Student</small>
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

            <!-- My Room -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="my_room.php">
                    <i class="bi bi-door-open-fill me-2"></i>
                    My Room
                </a>
            </li>

            <!-- Payments -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="payments.php">
                    <i class="bi bi-cash-coin me-2"></i>
                    My Payments
                </a>
            </li>

            <!-- Complaints -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="complaints.php">
                    <i class="bi bi-tools me-2"></i>
                    Complaints
                </a>
            </li>

            <!-- Profile -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center rounded px-3 py-2"
                   href="profile.php">
                    <i class="bi bi-person-circle me-2"></i>
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
          