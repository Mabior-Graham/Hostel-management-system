<?php include('includes/dashboardheader.php'); 
$user_id = $_SESSION['user_id'];

// Fetch existing application
$app_sql = "SELECT * FROM applications WHERE user_id=$user_id LIMIT 1";
$app_res = mysqli_query($conn, $app_sql);
$application = mysqli_fetch_assoc($app_res);

// Redirect back if Step 3 is not completed
if (!$application || empty($application['choice1'])) {
    $_SESSION['error'] = 'Please complete Step 3: Program Choices first.';
    header('Location: step3_choices.php');
    exit;
}
?>


<section class="py-5 text-white" style="background: linear-gradient(135deg, #002147, #004080);">
    <div class="container text-center">
        <h1 class="fw-bold mb-2">Step 4: Upload Certificates</h1>
        <p class="lead mb-0">Upload your certificates (PDF or images). You can upload multiple files.</p>
    </div>
</section>

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
                        <form method="post" action="../../actions/step4_certificates.php" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label class="form-label">Upload Certificates</label>
                                <input type="file" name="certificates[]" class="form-control" multiple required>
                                <small class="text-muted">Allowed formats: PDF, JPG, PNG. Max size per file: 2MB.</small>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-warning fw-bold text-white">Submit Application</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include('includes/dashboardfooter.php'); ?>
