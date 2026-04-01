<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php include('includes/dashboardheader.php'); ?>

<?php
$user_id = $_SESSION['user_id'];

// Fetch application progress counts
$sql = "SELECT 
            SUM(CASE WHEN full_name IS NOT NULL THEN 1 ELSE 0 END) AS step1_completed,
            SUM(CASE WHEN institution IS NOT NULL THEN 1 ELSE 0 END) AS step2_completed,
            SUM(CASE WHEN choice1 IS NOT NULL THEN 1 ELSE 0 END) AS step3_completed,
            SUM(CASE WHEN certificates_uploaded = 1 THEN 1 ELSE 0 END) AS step4_completed
        FROM applications
        WHERE user_id = '$user_id'";

$result = mysqli_query($conn, $sql);
$progress = mysqli_fetch_assoc($result);

// Calculate stats
$steps_completed = 0;
for ($i = 1; $i <= 4; $i++) {
    $steps_completed += (int)$progress["step{$i}_completed"];
}
$steps_pending = 4 - $steps_completed;
?>

<!-- Hero Section -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, #002147, #004080);">
    <div class="container text-center">
        <h1 class="fw-bold mb-2">Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?></h1>
        <p class="lead mb-0">Manage your application, track progress, and upload documents easily.</p>
    </div>
</section>

<!-- Dashboard Cards -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">

            <!-- Start / Continue Application -->
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-journal-plus display-3 text-warning mb-3"></i>
                        <h5 class="card-title">Start / Continue Application</h5>
                        <p class="card-text">Fill out your application or continue from where you left off.</p>
                        <a href="apply/step1_personal.php" class="btn btn-warning fw-bold text-white">Go</a>
                    </div>
                </div>
            </div>

            <!-- Application Status -->
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-clock-history display-3 text-primary mb-3"></i>
                        <h5 class="card-title">Application Status</h5>
                        <p class="card-text">Track the status of your submitted application.</p>
                        <a href="application_status.php" class="btn btn-primary fw-bold text-white">Go</a>
                    </div>
                </div>
            </div>

            <!-- Uploaded Documents -->
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-file-earmark-text display-3 text-success mb-3"></i>
                        <h5 class="card-title">Uploaded Documents</h5>
                        <p class="card-text">View or upload certificates and other required documents.</p>
                        <a href="uploaded_documents.php" class="btn btn-success fw-bold text-white">Go</a>
                    </div>
                </div>
            </div>

            <!-- Profile Settings -->
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-person-circle display-3 text-warning mb-3"></i>
                        <h5 class="card-title">Profile Settings</h5>
                        <p class="card-text">Update your personal info and change your password securely.</p>
                        <a href="profile.php" class="btn btn-warning fw-bold text-white">Go</a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Quick Stats -->
        <div class="row mt-5 g-4">

            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Steps Completed</h5>
                        <p class="display-4 text-success"><?php echo $steps_completed; ?> / 4</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Pending Steps</h5>
                        <p class="display-4 text-warning"><?php echo $steps_pending; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Documents Uploaded</h5>
                        <p class="display-4 text-primary"><?php echo $progress['step4_completed'] ? 'Yes' : 'No'; ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include('includes/dashboardfooter.php'); ?>
