<?php 
include('includes/dashboardheader.php');

$student_id = $_SESSION['user_id'];

// Fetch student's complaints
$complaintsResult = mysqli_query($conn, "
    SELECT * FROM complaints 
    WHERE student_id = '$student_id'
    ORDER BY created_at DESC
");
?>

<div class="container-fluid py-4">

    <div class="text-center mb-4">
        <h1 class="fw-bold">My Complaints</h1>
        <p class="text-muted">Submit and track your hostel issues</p>
    </div>

    <!-- Add Complaint Button -->
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-info fw-bold" data-bs-toggle="modal" data-bs-target="#addComplaintModal">
            <i class="bi bi-plus-circle"></i> New Complaint
        </button>
    </div>

    <!-- Alerts -->
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Complaints Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($complaintsResult) > 0): ?>
                    <?php $i = 1; ?>
                    <?php while($comp = mysqli_fetch_assoc($complaintsResult)): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($comp['title']); ?></td>
                            <td><?= htmlspecialchars($comp['description']); ?></td>
                            <td>
                                <span class="badge bg-<?= 
                                    $comp['status'] === 'resolved' ? 'success' : 
                                    ($comp['status'] === 'in_progress' ? 'info' : 'warning'); ?>">
                                    <?= htmlspecialchars($comp['status']); ?>
                                </span>
                            </td>
                            <td><?= date('d M Y', strtotime($comp['created_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-muted">No complaints yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Add Complaint Modal -->
<div class="modal fade" id="addComplaintModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="../actions/add_complaint.php" class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Submit Complaint</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Water issue" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Describe your issue..." required></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-info fw-bold">Submit</button>
            </div>

        </form>
    </div>
</div>

<?php include('includes/dashboardfooter.php'); ?>