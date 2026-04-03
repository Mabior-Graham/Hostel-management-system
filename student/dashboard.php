<?php 
include('includes/dashboardheader.php');

$student_id = $_SESSION['user_id'];

// =====================
// FETCH DATA
// =====================

// Allocation (latest)
$allocationResult = mysqli_query($conn, "
    SELECT a.*, r.room_number, b.bed_number
    FROM allocations a
    LEFT JOIN rooms r ON a.room_id = r.id
    LEFT JOIN beds b ON a.bed_id = b.id
    WHERE a.student_id = '$student_id'
    ORDER BY a.created_at DESC
    LIMIT 1
");
$allocation = mysqli_fetch_assoc($allocationResult);

// Total Paid
$totalPaidResult = mysqli_query($conn, "
    SELECT SUM(p.amount) AS total_paid
    FROM payments p
    LEFT JOIN allocations a ON p.allocation_id = a.id
    WHERE a.student_id = '$student_id' AND p.status='paid'
");
$totalPaid = mysqli_fetch_assoc($totalPaidResult)['total_paid'] ?? 0;

// Complaints Count
$complaintsResult = mysqli_query($conn, "
    SELECT COUNT(*) AS total FROM complaints 
    WHERE student_id = '$student_id'
");
$totalComplaints = mysqli_fetch_assoc($complaintsResult)['total'] ?? 0;

// Active complaints
$activeComplaintsResult = mysqli_query($conn, "
    SELECT COUNT(*) AS total FROM complaints 
    WHERE student_id = '$student_id' AND status != 'resolved'
");
$activeComplaints = mysqli_fetch_assoc($activeComplaintsResult)['total'] ?? 0;
?>

<div class="container-fluid py-4">

    <!-- Welcome -->
    <div class="mb-4 text-center">
        <h1 class="fw-bold">Welcome, <?= htmlspecialchars($_SESSION['full_name']); ?> 👋</h1>
        <p class="text-muted">Here’s your hostel overview</p>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">

        <!-- Room -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h6>My Room</h6>
                    <h4 class="fw-bold">
                        <?= $allocation ? htmlspecialchars($allocation['room_number']) : 'N/A'; ?>
                    </h4>
                    <small class="text-muted">Room Number</small>
                </div>
            </div>
        </div>

        <!-- Bed -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h6>My Bed</h6>
                    <h4 class="fw-bold">
                        <?= $allocation ? htmlspecialchars($allocation['bed_number']) : 'N/A'; ?>
                    </h4>
                    <small class="text-muted">Bed Space</small>
                </div>
            </div>
        </div>

        <!-- Payments -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h6>Total Paid</h6>
                    <h4 class="fw-bold text-success">
                        $<?= number_format($totalPaid, 2); ?>
                    </h4>
                    <small class="text-muted">Payments Made</small>
                </div>
            </div>
        </div>

        <!-- Complaints -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h6>Active Complaints</h6>
                    <h4 class="fw-bold text-warning">
                        <?= $activeComplaints; ?>
                    </h4>
                    <small class="text-muted">Unresolved Issues</small>
                </div>
            </div>
        </div>

    </div>

    <!-- Detailed Section -->
    <div class="row g-4">

        <!-- Allocation Details -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    My Allocation
                </div>
                <div class="card-body">
                    <?php if($allocation): ?>
                        <p><strong>Room:</strong> <?= htmlspecialchars($allocation['room_number']); ?></p>
                        <p><strong>Bed:</strong> <?= htmlspecialchars($allocation['bed_number']); ?></p>
                        <p><strong>Start Date:</strong> <?= htmlspecialchars($allocation['start_date']); ?></p>
                        <p><strong>End Date:</strong> 
                            <?= $allocation['end_date'] ? htmlspecialchars($allocation['end_date']) : 'Not set'; ?>
                        </p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-success">
                                <?= htmlspecialchars($allocation['status']); ?>
                            </span>
                        </p>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            You have not been allocated a room yet.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Complaints Overview -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Complaints Overview
                </div>
                <div class="card-body">
                    <p><strong>Total Complaints:</strong> <?= $totalComplaints; ?></p>
                    <p><strong>Active:</strong> <?= $activeComplaints; ?></p>
                    <p><strong>Resolved:</strong> <?= $totalComplaints - $activeComplaints; ?></p>

                    <a href="complaints.php" class="btn btn-info btn-sm mt-2">
                        View Complaints
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include('includes/dashboardfooter.php'); ?>