<?php 
include('includes/dashboardheader.php');

$student_id = $_SESSION['user_id'];

// Fetch student's allocation
$result = mysqli_query($conn, "
    SELECT 
        a.*,
        r.room_number,
        r.floor,
        rt.name AS room_type,
        b.bed_number
    FROM allocations a
    LEFT JOIN rooms r ON a.room_id = r.id
    LEFT JOIN room_types rt ON r.room_type_id = rt.id
    LEFT JOIN beds b ON a.bed_id = b.id
    WHERE a.student_id = '$student_id'
    ORDER BY a.created_at DESC
    LIMIT 1
");

$allocation = mysqli_fetch_assoc($result);
?>

<div class="container-fluid py-4">

    <div class="text-center mb-4">
        <h1 class="fw-bold">My Room</h1>
        <p class="text-muted">View your hostel room and bed allocation</p>
    </div>

    <?php if($allocation): ?>

        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-lg border-0">
                    
                    <div class="card-header text-white text-center"
                         style="background: linear-gradient(135deg, #1e3c72, #2a5298);">
                        <h4 class="mb-0">Room Allocation Details</h4>
                    </div>

                    <div class="card-body">

                        <p><strong>Room Number:</strong> 
                            <?= htmlspecialchars($allocation['room_number']); ?>
                        </p>

                        <p><strong>Room Type:</strong> 
                            <?= htmlspecialchars($allocation['room_type'] ?? 'N/A'); ?>
                        </p>

                        <p><strong>Floor:</strong> 
                            <?= htmlspecialchars($allocation['floor']); ?>
                        </p>

                        <p><strong>Bed Number:</strong> 
                            <?= htmlspecialchars($allocation['bed_number']); ?>
                        </p>

                        <p><strong>Start Date:</strong> 
                            <?= htmlspecialchars($allocation['start_date']); ?>
                        </p>

                        <p><strong>End Date:</strong> 
                            <?= $allocation['end_date'] ? htmlspecialchars($allocation['end_date']) : 'Not set'; ?>
                        </p>

                        <p><strong>Status:</strong> 
                            <span class="badge bg-<?= $allocation['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                <?= htmlspecialchars($allocation['status']); ?>
                            </span>
                        </p>

                    </div>

                </div>

            </div>
        </div>

    <?php else: ?>

        <div class="text-center">
            <div class="alert alert-warning">
                You have not been allocated a room yet.
            </div>
        </div>

    <?php endif; ?>

</div>

<?php include('includes/dashboardfooter.php'); ?>