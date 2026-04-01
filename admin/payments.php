<?php
include('includes/dashboardheader.php');

// Fetch all payments with student, room, bed info
$paymentsResult = mysqli_query($conn, "
    SELECT p.*, s.full_name, r.room_number, b.bed_number
    FROM payments p
    LEFT JOIN students s ON p.student_id = s.id
    LEFT JOIN rooms r ON p.room_id = r.id
    LEFT JOIN beds b ON p.bed_id = b.id
    ORDER BY p.payment_date DESC
");

// Fetch students, rooms, beds for the modal
$studentsResult = mysqli_query($conn, "SELECT id, full_name FROM students ORDER BY full_name");
$roomsResult = mysqli_query($conn, "SELECT id, room_number FROM rooms ORDER BY room_number");
$bedsResult = mysqli_query($conn, "SELECT id, bed_number, room_id FROM beds ORDER BY room_id, bed_number");
?>

<div class="container-fluid py-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold mb-2">Payments Management</h1>
        <p class="text-muted">Track student payments for hostel rooms and beds</p>
    </div>

    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-info fw-bold" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
            <i class="bi bi-plus-circle me-1"></i> Record Payment
        </button>
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

    <!-- Payments Table -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Room</th>
                    <th>Bed</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($paymentsResult) > 0): ?>
                    <?php $i = 1; ?>
                    <?php while($payment = mysqli_fetch_assoc($paymentsResult)): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($payment['full_name']); ?></td>
                            <td><?= htmlspecialchars($payment['room_number']); ?></td>
                            <td><?= htmlspecialchars($payment['bed_number']); ?></td>
                            <td>$<?= number_format($payment['amount'], 2); ?></td>
                            <td><?= htmlspecialchars($payment['payment_date']); ?></td>
                            <td>
                                <span class="badge <?= $payment['status'] === 'paid' ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                    <?= ucfirst($payment['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="edit_payment.php?id=<?= $payment['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="../actions/delete_payment.php?id=<?= $payment['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this payment?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-muted">No payments found.</td>
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
                <h5 class="modal-title">Record Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Student</label>
                    <select name="student_id" class="form-select" required>
                        <option value="">-- Select Student --</option>
                        <?php while($student = mysqli_fetch_assoc($studentsResult)): ?>
                            <option value="<?= $student['id']; ?>"><?= htmlspecialchars($student['full_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Room</label>
                    <select name="room_id" class="form-select">
                        <option value="">-- Select Room (optional) --</option>
                        <?php while($room = mysqli_fetch_assoc($roomsResult)): ?>
                            <option value="<?= $room['id']; ?>"><?= htmlspecialchars($room['room_number']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bed</label>
                    <select name="bed_id" class="form-select">
                        <option value="">-- Select Bed (optional) --</option>
                        <?php 
                        mysqli_data_seek($bedsResult, 0);
                        while($bed = mysqli_fetch_assoc($bedsResult)): ?>
                            <option value="<?= $bed['id']; ?>">
                                <?= htmlspecialchars('Room '.$bed['room_id'].' - Bed '.$bed['bed_number']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input type="number" step="0.01" name="amount" class="form-control" placeholder="100.00" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Payment Date</label>
                    <input type="date" name="payment_date" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="paid" selected>Paid</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-info fw-bold">Save Payment</button>
            </div>
        </form>
    </div>
</div>

<?php include('includes/dashboardfooter.php'); ?>
