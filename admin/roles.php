<?php
include('includes/dashboardheader.php');

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Access denied.";
    header("Location: ../login.php");
    exit;
}

// Fetch all users
$result = mysqli_query($conn, "SELECT id, full_name, email, role, created_at FROM users ORDER BY created_at DESC");
?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Roles Management</h3>
        <span class="text-muted">Assign system roles to users</span>
    </div>

    <!-- Alerts -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Users Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php $i = 1; while ($user = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= htmlspecialchars($user['full_name']); ?></td>
                                    <td><?= htmlspecialchars($user['email']); ?></td>
                                    <td class="text-capitalize">
                                        <span class="badge bg-secondary">
                                            <?= $user['role']; ?>
                                        </span>
                                    </td>
                                    <td><?= date('d M Y', strtotime($user['created_at'])); ?></td>
                                    <td>
                                        <form method="post" action="../actions/update_user_role.php" class="d-flex gap-2">
                                            <input type="hidden" name="user_id" value="<?= $user['id']; ?>">

                                            <select name="role" class="form-select form-select-sm" required>
                                                <option value="guest" <?= $user['role']=='guest'?'selected':''; ?>>Guest</option>
                                                <option value="receptionist" <?= $user['role']=='receptionist'?'selected':''; ?>>Receptionist</option>
                                                <option value="admin" <?= $user['role']=='admin'?'selected':''; ?>>Admin</option>
                                            </select>

                                            <button class="btn btn-sm btn-primary">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include('includes/dashboardfooter.php'); ?>
