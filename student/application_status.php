<?php
 include('includes/dashboardheader.php'); 
$user_id = $_SESSION['user_id'];

// Fetch student's application
$sql = "SELECT * FROM applications WHERE user_id=$user_id LIMIT 1";
$result = mysqli_query($conn, $sql);
$application = mysqli_fetch_assoc($result);

if (!$application) {
    $_SESSION['error'] = 'You have not started an application yet.';
    header('Location: step1_personal.php');
    exit;
}

// Decode certificates JSON
$certificates = [];
if (!empty($application['certificates'])) {
    $certificates = json_decode($application['certificates'], true);
}

?>



<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold">My Application Status</h1>
            <p class="lead">Track your submitted application and uploaded certificates.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">

                <!-- Application Details -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">

                        <h5 class="mb-3 fw-bold">Application Information</h5>
                        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($application['full_name']); ?></p>
                        <p><strong>Date of Birth:</strong> <?php echo $application['dob']; ?></p>
                        <p><strong>Gender:</strong> <?php echo htmlspecialchars($application['gender']); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($application['phone']); ?></p>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($application['address']); ?></p>

                        <h5 class="mt-4 mb-3 fw-bold">Academic Background</h5>
                        <p><strong>Qualification:</strong> <?php echo htmlspecialchars($application['qualification']); ?></p>
                        <p><strong>Institution:</strong> <?php echo htmlspecialchars($application['institution']); ?></p>
                        <p><strong>Completion Year:</strong> <?php echo htmlspecialchars($application['completion_year']); ?></p>
                        <p><strong>Grades:</strong> <?php echo htmlspecialchars($application['grades']); ?></p>

                        <h5 class="mt-4 mb-3 fw-bold">Program Choices</h5>
                        <ol>
                            <li><?php echo htmlspecialchars($application['choice1']); ?></li>
                            <li><?php echo htmlspecialchars($application['choice2']); ?></li>
                            <li><?php echo htmlspecialchars($application['choice3']); ?></li>
                            <li><?php echo htmlspecialchars($application['choice4']); ?></li>
                            <li><?php echo htmlspecialchars($application['choice5']); ?></li>
                        </ol>

                        <h5 class="mt-4 mb-3 fw-bold">Uploaded Certificates</h5>
                        <?php if (!empty($certificates)): ?>
                            <ul>
                                <?php foreach ($certificates as $file): ?>
                                    <li>
                                        <a href="<?php echo '../../' . $file; ?>" target="_blank">
                                            <?php echo basename($file); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>No certificates uploaded yet.</p>
                        <?php endif; ?>

                        <h5 class="mt-4 mb-3 fw-bold">Application Status</h5>
                        <p>
                            <span class="badge 
                                <?php 
                                    switch($application['status']){
                                        case 'Pending': echo 'bg-warning text-dark'; break;
                                        case 'Submitted': echo 'bg-primary'; break;
                                        case 'Reviewed': echo 'bg-info text-dark'; break;
                                        case 'Accepted': echo 'bg-success'; break;
                                        case 'Rejected': echo 'bg-danger'; break;
                                        default: echo 'bg-secondary'; 
                                    }
                                ?>">
                                <?php echo $application['status']; ?>
                            </span>
                        </p>

                    </div>
                </div>

                <div class="text-center">
                    <a href="../dashboard.php" class="btn btn-primary">Back to Dashboard</a>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include('includes/dashboardfooter.php'); ?>
