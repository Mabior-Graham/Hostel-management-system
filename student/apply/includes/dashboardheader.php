
<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'You must log in first.';
    header('Location: ../../login.php');
    exit;
}


require_once('../../config/db.php'); // MySQLi connection ($conn)
include('../../includes/header2.php');
?>

<div class="container-fluid">
    <div class="row">

     <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse vh-100"
     style="background: linear-gradient(180deg, #002147, #004080);">
    <div class="position-sticky pt-4">

        <!-- User Info -->
        <div class="text-center mb-4">
            <img src="../../assets/images/user-avatar.png" alt="User Avatar" class="rounded-circle mb-2" width="80">
            <h6 class="text-white fw-bold mb-0"><?php echo htmlspecialchars($_SESSION['full_name']); ?></h6>
            <small class="text-light">Applicant</small>
        </div>

        <!-- Menu -->
        <ul class="nav flex-column">

            <!-- Dashboard -->
            <li class="nav-item mb-2">
                <a class="nav-link d-flex align-items-center rounded px-3 py-2 text-white"
                   href="../dashboard.php"
                   style="transition: 0.3s;"
                   onmouseover="this.style.backgroundColor='#FFC107'; this.style.color='#002147';"
                   onmouseout="this.style.backgroundColor=''; this.style.color='white';">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <!-- Start/Continue Application -->
            <li class="nav-item mb-2">
                <a class="nav-link d-flex align-items-center rounded px-3 py-2 text-white"
                   href="apply/step1_personal.php"
                   style="transition: 0.3s;"
                   onmouseover="this.style.backgroundColor='#FFC107'; this.style.color='#002147';"
                   onmouseout="this.style.backgroundColor=''; this.style.color='white';">
                    <i class="bi bi-journal-plus me-2"></i> Start / Continue Application
                </a>
            </li>

            <!-- Application Status -->
            <li class="nav-item mb-2">
                <a class="nav-link d-flex align-items-center rounded px-3 py-2 text-white"
                   href="../application_status.php"
                   style="transition: 0.3s;"
                   onmouseover="this.style.backgroundColor='#FFC107'; this.style.color='#002147';"
                   onmouseout="this.style.backgroundColor=''; this.style.color='white';">
                    <i class="bi bi-clock-history me-2"></i> Application Status
                </a>
            </li>

            <!-- Uploaded Documents -->
            <li class="nav-item mb-2">
                <a class="nav-link d-flex align-items-center rounded px-3 py-2 text-white"
                   href="../uploaded_documents.php"
                   style="transition: 0.3s;"
                   onmouseover="this.style.backgroundColor='#FFC107'; this.style.color='#002147';"
                   onmouseout="this.style.backgroundColor=''; this.style.color='white';">
                    <i class="bi bi-file-earmark-text me-2"></i> Uploaded Documents
                </a>
            </li>

            <!-- Profile -->
            <li class="nav-item mb-2">
                <a class="nav-link d-flex align-items-center rounded px-3 py-2 text-white"
                   href="../profile.php"
                   style="transition: 0.3s;"
                   onmouseover="this.style.backgroundColor='#FFC107'; this.style.color='#002147';"
                   onmouseout="this.style.backgroundColor=''; this.style.color='white';">
                    <i class="bi bi-person-circle me-2"></i> Profile
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item mt-4">
                <a class="nav-link d-flex align-items-center rounded px-3 py-2 text-white"
                   href="../../actions/logout.php"
                   style="transition: 0.3s;"
                   onmouseover="this.style.backgroundColor='#FFC107'; this.style.color='#002147';"
                   onmouseout="this.style.backgroundColor=''; this.style.color='white';">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>

        </ul>
    </div>
</nav>




        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
          