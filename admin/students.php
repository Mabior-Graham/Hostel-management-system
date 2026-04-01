<?php
include('includes/dashboardheader.php');
include('../config/db.php');

// Fetch all students with their allocation info
$query = "
    SELECT u.id AS user_id, u.full_name, u.email, 
           a.id AS allocation_id, a.allocation_date, a.end_date, a.status AS allocation_status,
           r.room_number, b.bed_number
    FROM users u
    LEFT JOIN allocations a ON u.id = a.student_id AND a.status='active'
    LEFT JOIN beds b ON a.bed_id = b.id
    LEFT JOIN rooms r ON b.room_id = r.id
    WHERE u.role='student'
    ORDER BY u.full_name
";

$result = mysqli_query($conn, $query);
?>

<div class="container-fluid py-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold mb-2">Students & Allocations</h1>
        <p class="text-muted">List of all students and their bed allocations</p>
    </div>

    <!-- Alert Messages -->
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Students Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Room</th>
                    <th>Bed</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Allocation Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php $i = 1; while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($row['full_name'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($row['email'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($row['room_number'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($row['bed_number'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($row['allocation_date'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($row['end_date'] ?? 'N/A'); ?></td>
                            <td class="<?= ($row['allocation_status'] === 'active') ? 'text-success' : 'text-muted'; ?>">
                                <?= htmlspecialchars($row['allocation_status'] ?? 'Not Allocated'); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">No students found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('includes/dashboardfooter.php'); ?>
