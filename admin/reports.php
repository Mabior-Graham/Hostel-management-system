<?php
include('includes/dashboardheader.php');

// Fetch summary counts
$roomsCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_rooms FROM rooms"))['total_rooms'];
$bedsCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_beds FROM beds"))['total_beds'];
$studentsCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_students FROM students"))['total_students'];
$allocationsCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_allocations FROM allocations"))['total_allocations'];
$paymentsCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_payments FROM payments"))['total_payments'];
$complaintsCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_complaints FROM complaints"))['total_complaints'];

// Total payments amount
$totalPayments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(amount) AS total_amount FROM payments"))['total_amount'] ?? 0;
?>

<div class="container-fluid py-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold mb-2">Reports & Summary</h1>
        <p class="text-muted">Overview of hostel operations and statistics</p>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-5">

        <div class="col-md-4 col-lg-2">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h5>Total Rooms</h5>
                    <h3 class="fw-bold"><?= $roomsCount; ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h5>Total Beds</h5>
                    <h3 class="fw-bold"><?= $bedsCount; ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h5>Total Students</h5>
                    <h3 class="fw-bold"><?= $studentsCount; ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h5>Total Allocations</h5>
                    <h3 class="fw-bold"><?= $allocationsCount; ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h5>Total Payments</h5>
                    <h3 class="fw-bold">$<?= number_format($totalPayments, 2); ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h5>Complaints</h5>
                    <h3 class="fw-bold"><?= $complaintsCount; ?></h3>
                </div>
            </div>
        </div>

    </div>

    <!-- Recent Payments Table -->
    <div class="mb-5">
        <h3 class="fw-bold mb-3">Recent Payments</h3>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
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
                    <?php
                    $paymentsResult = mysqli_query($conn, "
                        SELECT p.*, s.full_name, r.room_number, b.bed_number
                        FROM payments p
                        LEFT JOIN students s ON p.student_id = s.id
                        LEFT JOIN rooms r ON p.room_id = r.id
                        LEFT JOIN beds b ON p.bed_id = b.id
                        ORDER BY p.payment_date DESC
                        LIMIT 10
                    ");
                    if(mysqli_num_rows($paymentsResult) > 0):
                        $i = 1;
                        while($p = mysqli_fetch_assoc($paymentsResult)):
                    ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($p['full_name']); ?></td>
                            <td><?= htmlspecialchars($p['room_number']); ?></td>
                            <td><?= htmlspecialchars($p['bed_number']); ?></td>
                            <td>$<?= number_format($p['amount'], 2); ?></td>
                            <td><?= $p['payment_date']; ?></td>
                            <td>
                                <span class="badge <?= $p['status'] === 'paid' ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                    <?= ucfirst($p['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr>
                            <td colspan="7" class="text-muted">No payments found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Complaints Table -->
    <div>
        <h3 class="fw-bold mb-3">Recent Complaints</h3>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Room</th>
                        <th>Bed</th>
                        <th>Complaint</th>
                        <th>Status</th>
                        <th>Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $complaintsResult = mysqli_query($conn, "
                        SELECT c.*, s.full_name, r.room_number, b.bed_number
                        FROM complaints c
                        LEFT JOIN students s ON c.student_id = s.id
                        LEFT JOIN rooms r ON c.room_id = r.id
                        LEFT JOIN beds b ON c.bed_id = b.id
                        ORDER BY c.created_at DESC
                        LIMIT 10
                    ");
                    if(mysqli_num_rows($complaintsResult) > 0):
                        $i = 1;
                        while($c = mysqli_fetch_assoc($complaintsResult)):
                    ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($c['full_name']); ?></td>
                            <td><?= htmlspecialchars($c['room_number']); ?></td>
                            <td><?= htmlspecialchars($c['bed_number']); ?></td>
                            <td><?= htmlspecialchars($c['description']); ?></td>
                            <td>
                                <span class="badge <?= $c['status'] === 'resolved' ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                    <?= ucfirst($c['status']); ?>
                                </span>
                            </td>
                            <td><?= $c['created_at']; ?></td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr>
                            <td colspan="7" class="text-muted">No complaints found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('includes/dashboardfooter.php'); ?>
