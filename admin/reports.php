<?php 
include('includes/dashboardheader.php');

// =====================
// SUMMARY DATA
// =====================

// Total income
$totalIncomeResult = mysqli_query($conn, "
    SELECT SUM(amount) AS total_income 
    FROM payments 
    WHERE status = 'paid'
");
$totalIncome = mysqli_fetch_assoc($totalIncomeResult)['total_income'] ?? 0;

// Monthly income
$monthlyIncomeResult = mysqli_query($conn, "
    SELECT DATE_FORMAT(payment_date, '%Y-%m') AS month, SUM(amount) AS total
    FROM payments
    WHERE status = 'paid'
    GROUP BY month
    ORDER BY month DESC
");

// Occupancy stats
$totalBeds = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM beds"))['total'];
$occupiedBeds = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM allocations WHERE status='active'"))['total'];

$occupancyRate = $totalBeds > 0 ? round(($occupiedBeds / $totalBeds) * 100, 1) : 0;

// Recent payments
$paymentsResult = mysqli_query($conn, "
    SELECT p.*, u.full_name
    FROM payments p
    LEFT JOIN allocations a ON p.allocation_id = a.id
    LEFT JOIN users u ON a.student_id = u.id
    ORDER BY p.payment_date DESC
    LIMIT 10
");
?>

<div class="container-fluid py-4">

    <h1 class="fw-bold text-center mb-4">Reports & Analytics</h1>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5>Total Income</h5>
                    <h2 class="fw-bold text-success">$<?= number_format($totalIncome, 2); ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5>Occupied Beds</h5>
                    <h2 class="fw-bold"><?= $occupiedBeds; ?> / <?= $totalBeds; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5>Occupancy Rate</h5>
                    <h2 class="fw-bold text-info"><?= $occupancyRate; ?>%</h2>
                </div>
            </div>
        </div>

    </div>

    <!-- Monthly Income -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            Monthly Income
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Month</th>
                        <th>Total Income</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($monthlyIncomeResult) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($monthlyIncomeResult)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['month']); ?></td>
                                <td>$<?= number_format($row['total'], 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-muted">No data available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Recent Payments
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered text-center">
                <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Student</th>
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
                                <td>$<?= number_format($pay['amount'], 2); ?></td>
                                <td><?= htmlspecialchars($pay['payment_date']); ?></td>
                                <td>
                                    <span class="badge bg-<?= $pay['status']=='paid'?'success':'warning'; ?>">
                                        <?= htmlspecialchars($pay['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-muted">No payments found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include('includes/dashboardfooter.php'); ?>