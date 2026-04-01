
<?php include('includes/dashboardheader.php'); ?>
<?php

$user_id = $_SESSION['user_id'];

// Fetch existing application if exists
$app_sql = "SELECT * FROM applications WHERE user_id=$user_id LIMIT 1";
$app_res = mysqli_query($conn, $app_sql);
$application = mysqli_fetch_assoc($app_res);
?>



<!-- Hero Section -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, #002147, #004080);">
    <div class="container text-center">
        <h1 class="fw-bold mb-2">Step 1: Personal Information</h1>
        <p class="lead mb-0">Fill in your personal details to start your application.</p>
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
                        <form method="post" action="../../actions/step1_personal.php">

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="full_name" class="form-control" 
                                    value="<?php echo htmlspecialchars($application['full_name'] ?? $_SESSION['full_name']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control" 
                                    value="<?php echo $application['dob'] ?? ''; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?php if(($application['gender'] ?? '') === 'Male') echo 'selected'; ?>>Male</option>
                                    <option value="Female" <?php if(($application['gender'] ?? '') === 'Female') echo 'selected'; ?>>Female</option>
                                    <option value="Other" <?php if(($application['gender'] ?? '') === 'Other') echo 'selected'; ?>>Other</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" 
                                    value="<?php echo htmlspecialchars($application['phone'] ?? ''); ?>" placeholder="+211 XXX XXX XXX" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="3" required><?php echo htmlspecialchars($application['address'] ?? ''); ?></textarea>
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
