<?php

include('includes/dashboardheader.php'); 

$user_id = $_SESSION['user_id'];

// Fetch student's application
$sql = "SELECT certificates FROM applications WHERE user_id=$user_id LIMIT 1";
$result = mysqli_query($conn, $sql);
$application = mysqli_fetch_assoc($result);

$certificates = [];
if ($application && !empty($application['certificates'])) {
    $certificates = json_decode($application['certificates'], true);
}

?>


<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold">My Uploaded Documents</h1>
            <p class="lead">View or download your submitted certificates and supporting documents.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">

                <?php if (empty($certificates)): ?>
                    <div class="alert alert-warning text-center">
                        You have not uploaded any documents yet.
                    </div>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($certificates as $file): ?>
                            <a href="<?php echo '../' . $file; ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <?php echo basename($file); ?>
                                <span class="badge bg-primary rounded-pill">Download</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="text-center mt-4">
                    <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include('includes/dashboardfooter.php'); ?>
