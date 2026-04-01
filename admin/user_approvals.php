<?php

include('includes/dashboardheader.php');

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Access denied.";
    header("Location: ../login.php");
    exit;
}

// Fetch pending users
$sql = "SELECT id, full_name, email, role, created_at 
        FROM users 
        WHERE account_status = 'Pending'
        ORDER BY created_at ASC";
$result = mysqli_query($conn, $sql);

// Collect modals separately
$modals = [];
?>

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">User Approvals</h1>
        <p class="text-muted">Approve or reject newly registered users.</p>
    </div>

    <!-- Feedback messages -->
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <!-- Pending Users Table -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registered On</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php $i=1; while($user = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= htmlspecialchars($user['full_name']); ?></td>
                                <td><?= htmlspecialchars($user['email']); ?></td>
                                <td><?= htmlspecialchars($user['role']); ?></td>
                                <td><?= date('d M Y', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- Approve button triggers modal -->
                                        <button type="button" class="btn btn-sm btn-success" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#approveModal<?= $user['id']; ?>">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>

                                        <!-- Reject button -->
                                        <a href="../actions/reject_user.php?id=<?= $user['id']; ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Reject this user?');">
                                           <i class="bi bi-x-circle"></i> Reject
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <?php 
                            // Store modal HTML for later
                            $modals[] = '
                            <div class="modal fade" id="approveModal'.$user['id'].'" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form method="POST" action="../actions/approve_user.php" class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Approve User: '.htmlspecialchars($user['full_name']).'</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="user_id" value="'.$user['id'].'">
                                            <div class="mb-3">
                                                <label class="form-label">Select Role</label>
                                                <select name="role" class="form-select" required>
                                                    <option value="" disabled selected>-- Choose Role --</option>
                                                    <option value="league_manager">League Manager</option>
                                                    <option value="team_manager">Team Manager</option>
                                                    <option value="referee">Referee</option>
                                                    <option value="admin">Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Approve</button>
                                        </div>
                                    </form>
                                </div>
                            </div>';
                            ?>

                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No pending users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php
// Render all modals after the table (keeps HTML clean)
foreach ($modals as $modal) {
    echo $modal;
}
?>

<?php include('includes/dashboardfooter.php'); ?>
