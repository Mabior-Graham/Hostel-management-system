<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php include('includes/dashboardheader.php'); 
$user_id = $_SESSION['user_id'];

// Fetch existing application
$app_sql = "SELECT * FROM applications WHERE user_id=$user_id LIMIT 1";
$app_res = mysqli_query($conn, $app_sql);
$application = mysqli_fetch_assoc($app_res);

// Redirect back if Step 2 is not completed
if (!$application || empty($application['qualification'])) {
    $_SESSION['error'] = 'Please complete Step 2: Academic Background first.';
    header('Location: step2_academic.php');
    exit;
}

// Fetch available programs (optional: from programs table)
$programs = [];
$result = mysqli_query($conn, "SELECT program_name FROM programs ORDER BY program_name ASC");
while($row = mysqli_fetch_assoc($result)) {
    $programs[] = $row['program_name'];
}
?>


<!-- Hero Section -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, #002147, #004080);">
    <div class="container text-center">
        <h1 class="fw-bold mb-2">Step 3: Program Choices</h1>
        <p class="lead mb-0">Select up to 5 programs in order of preference.</p>
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
                        <form method="post" action="../../actions/step3_choices.php">

                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <div class="mb-3">
                                    <label class="form-label">Choice <?php echo $i; ?></label>
                                    <select name="choice<?php echo $i; ?>" class="form-select" required>
                                        <option value="">-- Select Program --</option>
                                        <?php foreach($programs as $program): ?>
                                            <option value="<?php echo htmlspecialchars($program); ?>"
                                                <?php if(($application["choice$i"] ?? '') === $program) echo 'selected'; ?>>
                                                <?php echo htmlspecialchars($program); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endfor; ?>

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
