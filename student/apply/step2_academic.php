<?php include('includes/dashboardheader.php'); ?>
<?php

$user_id = $_SESSION['user_id'];

// Fetch existing application
$app_sql = "SELECT * FROM applications WHERE user_id=$user_id LIMIT 1";
$app_res = mysqli_query($conn, $app_sql);
$application = mysqli_fetch_assoc($app_res);

// Redirect back if Step 1 is not completed
if (!$application) {
    $_SESSION['error'] = 'Please complete Step 1: Personal Information first.';
    header('Location: step1_personal.php');
    exit;
}
?>



<!-- Hero Section -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, #002147, #004080);">
    <div class="container text-center">
        <h1 class="fw-bold mb-2">Step 2: Academic Background</h1>
        <p class="lead mb-0">Provide your previous academic qualifications and grades.</p>
    </div>
</section>

<!-- Form Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8 col-lg-6">

                <!-- Messages -->
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form method="post" action="../../actions/step2_academic.php">

                            <div class="mb-3">
                                <label class="form-label">Highest Qualification</label>
                                <input type="text" name="qualification" class="form-control" 
                                    value="<?php echo htmlspecialchars($application['qualification'] ?? ''); ?>" placeholder="e.g. High School Diploma" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Institution Name</label>
                                <input type="text" name="institution" class="form-control" 
                                    value="<?php echo htmlspecialchars($application['institution'] ?? ''); ?>" placeholder="e.g. Juba Secondary School" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Year of Completion</label>
                                <input type="number" name="completion_year" class="form-control" 
                                    value="<?php echo htmlspecialchars($application['completion_year'] ?? ''); ?>" placeholder="e.g. 2024" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Grades / GPA</label>
                                <input type="text" name="grades" class="form-control" 
                                    value="<?php echo htmlspecialchars($application['grades'] ?? ''); ?>" placeholder="e.g. 4.0 or A+" required>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-warning fw-bold text-white">Save & Continue</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include('includes/dashboardfooter.php'); ?>
