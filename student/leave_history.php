<?php
session_start();
include('includes/dashboardheader.php'); 
require_once('../config/db.php'); // database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Access denied.";
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch leave requests for this user
$sql = "SELECT * FROM leave_requests WHERE user_id='$user_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold">My Leave History</h1>
            <p class="lead">View all your leave requests and their current status.</p>
        </div>

        <!-- Display Session Messages -->
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php 
                echo $_SESSION['success']; 
                unset($_SESSION['success']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Leave Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Applied On</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $count = 1;
                                while($row = mysqli_fetch_assoc($result)): 
                                ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo htmlspecialchars($row['leave_type']); ?></td>
                                        <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                                        <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                                        <td><?php echo htmlspecialchars($row['reason']); ?></td>
                                        <td>
                                            <?php 
                                            $status = $row['status'];
                                            $class = 'secondary';
                                            if($status == 'Pending') $class = 'warning';
                                            elseif($status == 'Approved') $class = 'success';
                                            elseif($status == 'Rejected') $class = 'danger';
                                            ?>
                                            <span class="badge bg-<?php echo $class; ?>"><?php echo $status; ?></span>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center">You have not applied for any leave yet.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>

<?php include('includes/dashboardfooter.php'); ?>
