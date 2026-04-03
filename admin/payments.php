<?php 
include('includes/dashboardheader.php');

// Fetch payments with student + room info
$paymentsResult = mysqli_query($conn, "
    SELECT 
        p.id,
        u.full_name,
        r.room_number,
        b.bed_number,
        p.amount,
        p.payment_date,
        p.status
    FROM payments p
    LEFT JOIN allocations a ON p.allocation_id = a.id
    LEFT JOIN users u ON a.student_id = u.id
    LEFT JOIN rooms r ON a.room_id = r.id
    LEFT JOIN beds b ON a.bed_id = b.id
    ORDER BY p.payment_date DESC
");

// Fetch allocations for dropdown
$allocationsResult = mysqli_query($conn, "
    SELECT 
        a.id,
        u.full_name,
        r.room_number,
        b.bed_number
    FROM allocations a
    JOIN users u ON a.student_id = u.id
    JOIN rooms r ON a.room_id = r.id
    JOIN beds b ON a.bed_id = b.id
    WHERE a.status = 'active'
    ORDER BY u.full_name
");
?>

<div class="container-fluid py-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Payments Management</h1>
        <p class="text-muted">Track hostel payments and student billing</p>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
            <i class="bi bi-plus-circle"></i> Add Payment
        </button>
    </div>

    <!-- Alerts -->
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <!-- Payments Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Room</th>
                    <th>Bed</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($paymentsResult) > 0): ?>
                    <?php $i=1; ?>
                    <?php while($pay = mysqli_fetch_assoc($paymentsResult)): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($pay['full_name'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($pay['room_number'] ?? '-'); ?></td>
                            <td><?= htmlspecialchars($pay['bed_number'] ?? '-'); ?></td>
                            <td><strong>$<?= htmlspecialchars($pay['amount']); ?></strong></td>
                            <td><?= htmlspecialchars($pay['payment_date']); ?></td>
                            <td>
                                <span class="badge bg-<?= $pay['status'] === 'paid' ? 'success' : 'warning'; ?>">
                                    <?= htmlspecialchars($pay['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-muted">No payments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Payment Modal -->
<div class="modal fade" id="addPaymentModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="../actions/add_payment.php" class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title">Add Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Student Allocation</label>
                    <select name="allocation_id" class="form-select" required>
                        <option value="">-- Select Allocation --</option>
                        <?php while($alloc = mysqli_fetch_assoc($allocationsResult)): ?>
                            <option value="<?= $alloc['id']; ?>">
                                <?= htmlspecialchars($alloc['full_name'].' - Room '.$alloc['room_number'].' Bed '.$alloc['bed_number']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input type="number" name="amount" class="form-control" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Payment Date</label>
                    <input type="date" name="payment_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="paid">Paid</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success fw-bold">Save Payment</button>
            </div>

        </form>
    </div>
</div>

<?php include('includes/dashboardfooter.php'); ?>