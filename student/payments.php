<?php 
include('includes/dashboardheader.php');

$student_id = $_SESSION['user_id'];

// Fetch student's payments via allocations
$paymentsResult = mysqli_query($conn, "
    SELECT 
        p.*,
        r.room_number,
        b.bed_number
    FROM payments p
    LEFT JOIN allocations a ON p.allocation_id = a.id
    LEFT JOIN rooms r ON a.room_id = r.id
    LEFT JOIN beds b ON a.bed_id = b.id
    WHERE a.student_id = '$student_id'
    ORDER BY p.payment_date DESC
");

// Calculate totals
$totalPaidResult = mysqli_query($conn, "
    SELECT SUM(p.amount) AS total_paid
    FROM payments p
    LEFT JOIN allocations a ON p.allocation_id = a.id
    WHERE a.student_id = '$student_id' AND p.status='paid'
");

$totalPaid = mysqli_fetch_assoc($totalPaidResult)['total_paid'] ?? 0;
?>

<div class="container-fluid py-4">

    <div class="text-center mb-4">
        <h1 class="fw-bold">My Payments</h1>
        <p class="text-muted">View your hostel payment history</p>
    </div>

    <!-- Summary Card -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Total Paid</h5>
                    <h2 class="fw-bold text-success">$<?= number_format($totalPaid, 2); ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Room</th>
                    <th>Bed</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($paymentsResult) > 0): ?>
                    <?php $i = 1; ?>
                    <?php while($pay = mysqli_fetch_assoc($paymentsResult)): ?>
                        <tr>
                            <td><?= $i++; ?></td>

                            <td><?= htmlspecialchars($pay['room_number'] ?? '-'); ?></td>

                            <td><?= htmlspecialchars($pay['bed_number'] ?? '-'); ?></td>

                            <td>
                                <strong>$<?= number_format($pay['amount'], 2); ?></strong>
                            </td>

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
                        <td colspan="6" class="text-muted">No payments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include('includes/dashboardfooter.php'); ?>