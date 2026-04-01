<?php 
session_start();
include('includes/dashboardheader.php'); 
?>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold">Apply for Leave</h1>
            <p class="lead">Submit your leave request and track its approval status.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- Display Success/Error Messages -->
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

                <!-- Leave Form -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="../actions/applyleave.php" method="POST">
                  
                            <!-- Leave Type -->
                            <div class="mb-3">
                                <label for="leave_type" class="form-label">Leave Type</label>
                                <select class="form-select" id="leave_type" name="leave_type" required>
                                    <option value="" selected disabled>Select leave type</option>
                                    <option value="Annual">Annual Leave</option>
                                    <option value="Sick">Sick Leave</option>
                                    <option value="Maternity">Maternity Leave</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <!-- Start Date -->
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>

                            <!-- End Date -->
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>

                            <!-- Reason -->
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason for Leave</label>
                                <textarea class="form-control" id="reason" name="reason" rows="4" placeholder="Provide a reason for your leave" required></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Submit Leave Request</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<?php include('includes/dashboardfooter.php'); ?>
