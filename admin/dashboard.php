<?php 
include('includes/dashboardheader.php'); 

// Fetch summary counts
$totalRoomsResult = mysqli_query($conn, "SELECT COUNT(*) AS total_rooms FROM rooms");
$totalBedsResult = mysqli_query($conn, "SELECT COUNT(*) AS total_beds FROM beds");
$totalStudentsResult = mysqli_query($conn, "SELECT COUNT(*) AS total_students FROM users WHERE role='student'");
$totalAllocationsResult = mysqli_query($conn, "SELECT COUNT(*) AS total_allocations FROM allocations");

$totalRooms = mysqli_fetch_assoc($totalRoomsResult)['total_rooms'];
$totalBeds = mysqli_fetch_assoc($totalBedsResult)['total_beds'];
$totalStudents = mysqli_fetch_assoc($totalStudentsResult)['total_students'];
$totalAllocations = mysqli_fetch_assoc($totalAllocationsResult)['total_allocations'];

// Fetch recent allocations (last 5)
$recentAllocationsResult = mysqli_query($conn, "
    SELECT a.id, u.full_name AS student_name, r.room_number, b.bed_number, a.start_date, a.end_date
    FROM allocations a
    LEFT JOIN users u ON a.student_id = u.id
    LEFT JOIN rooms r ON a.room_id = r.id
    LEFT JOIN beds b ON a.bed_id = b.id
    ORDER BY a.allocation_date DESC
    LIMIT 5
");
?>

<div class="container-fluid py-4">
    <h1 class="fw-bold mb-4 text-center">Admin Dashboard</h1>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Total Rooms</h5>
                    <h2 class="fw-bold"><?= $totalRooms; ?></h2>
                    <i class="bi bi-door-open-fill fs-2 text-info"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Total Beds</h5>
                    <h2 class="fw-bold"><?= $totalBeds; ?></h2>
                    <i class="bi bi-layers-fill fs-2 text-success"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Total Students</h5>
                    <h2 class="fw-bold"><?= $totalStudents; ?></h2>
                    <i class="bi bi-people-fill fs-2 text-warning"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Total Allocations</h5>
                    <h2 class="fw-bold"><?= $totalAllocations; ?></h2>
                    <i class="bi bi-check2-square fs-2 text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Allocations -->
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Recent Allocations</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Room</th>
                        <th>Bed</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($recentAllocationsResult) > 0): ?>
                        <?php $i=1; ?>
                        <?php while($alloc = mysqli_fetch_assoc($recentAllocationsResult)): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= htmlspecialchars($alloc['student_name']); ?></td>
                                <td><?= htmlspecialchars($alloc['room_number']); ?></td>
                                <td><?= htmlspecialchars($alloc['bed_number']); ?></td>
                                <td><?= htmlspecialchars($alloc['start_date']); ?></td>
                                <td><?= htmlspecialchars($alloc['end_date']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-muted">No recent allocations found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('includes/dashboardfooter.php'); ?>
