<?php 
include('includes/dashboardheader.php');

// Fetch complaints with student info
$complaintsResult = mysqli_query($conn, "
    SELECT 
        c.id,
        u.full_name,
        c.title,
        c.description,
        c.status,
        c.created_at
    FROM complaints c
    LEFT JOIN users u ON c.student_id = u.id
    ORDER BY c.created_at DESC
");
?>

<div class="container-fluid py-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Complaints Management</h1>
        <p class="text-muted">Manage and resolve student complaints</p>
    </div>

    <!-- Alerts -->
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <!-- Complaints Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($complaintsResult) > 0): ?>
                    <?php $i = 1; ?>
                    <?php while($comp = mysqli_fetch_assoc($complaintsResult)): ?>
                        <tr>
                            <td class="text-center"><?= $i++; ?></td>

                            <td><?= htmlspecialchars($comp['full_name'] ?? 'N/A'); ?></td>

                            <td><?= htmlspecialchars($comp['title']); ?></td>

                            <td><?= htmlspecialchars($comp['description']); ?></td>

                            <td class="text-center">
                                <span class="badge bg-<?= 
                                    $comp['status'] === 'resolved' ? 'success' : 
                                    ($comp['status'] === 'pending' ? 'warning' : 'secondary'); ?>">
                                    <?= htmlspecialchars($comp['status']); ?>
                                </span>
                            </td>

                            <td class="text-center">
                                <?= date('d M Y', strtotime($comp['created_at'])); ?>
                            </td>

                            <td class="text-center">
                                <!-- Update Status Form -->
                                <form method="post" action="../actions/update_complaint.php" class="d-flex gap-2 justify-content-center">
                                    <input type="hidden" name="complaint_id" value="<?= $comp['id']; ?>">

                                    <select name="status" class="form-select form-select-sm">
                                        <option value="pending" <?= $comp['status']=='pending'?'selected':''; ?>>Pending</option>
                                        <option value="in_progress" <?= $comp['status']=='in_progress'?'selected':''; ?>>In Progress</option>
                                        <option value="resolved" <?= $comp['status']=='resolved'?'selected':''; ?>>Resolved</option>
                                    </select>

                                    <button type="submit" class="btn btn-sm btn-info">
                                        Update
                                    </button>
                                </form>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">No complaints found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('includes/dashboardfooter.php'); ?>