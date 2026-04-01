<?php
include('includes/dashboardheader.php');

// Fetch all beds with room info
$bedsResult = mysqli_query($conn, "
    SELECT b.*, r.room_number, rt.name AS room_type
    FROM beds b
    LEFT JOIN rooms r ON b.room_id = r.id
    LEFT JOIN room_types rt ON r.room_type_id = rt.id
    ORDER BY r.room_number, b.bed_number
");

// Fetch rooms for modal select
$roomsResult = mysqli_query($conn, "SELECT r.id, r.room_number, rt.name AS room_type 
                                   FROM rooms r 
                                   LEFT JOIN room_types rt ON r.room_type_id = rt.id 
                                   ORDER BY r.room_number");
?>

<div class="container-fluid py-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold mb-2">Beds Management</h1>
        <p class="text-muted">View and manage all beds in the hostel</p>
    </div>

    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-info fw-bold" data-bs-toggle="modal" data-bs-target="#addBedModal">
            <i class="bi bi-plus-circle me-1"></i> Add Bed
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

    <!-- Beds Table -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Bed Number</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($bedsResult) > 0): ?>
                    <?php $i = 1; ?>
                    <?php while($bed = mysqli_fetch_assoc($bedsResult)): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($bed['room_number']); ?></td>
                            <td><?= htmlspecialchars($bed['room_type']); ?></td>
                            <td><?= htmlspecialchars($bed['bed_number']); ?></td>
                            <td class="text-capitalize"><?= htmlspecialchars($bed['status']); ?></td>
                            <td><?= htmlspecialchars($bed['notes'] ?? '-'); ?></td>
                            <td>
                                
                                <a href="../actions/delete_bed.php?id=<?= $bed['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this bed?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-muted">No beds found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Bed Modal -->
<div class="modal fade" id="addBedModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="../actions/add_bed.php" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Bed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Room</label>
                    <select name="room_id" class="form-select" required>
                        <option value="">-- Select Room --</option>
                        <?php while($room = mysqli_fetch_assoc($roomsResult)): ?>
                            <option value="<?= $room['id']; ?>">
                                <?= htmlspecialchars($room['room_number'] . ' - ' . $room['room_type']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bed Number</label>
                    <input type="text" name="bed_number" class="form-control" placeholder="1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="available" selected>Available</option>
                        <option value="booked">Booked</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Optional"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-info fw-bold">Add Bed</button>
            </div>
        </form>
    </div>
</div>

<?php include('includes/dashboardfooter.php'); ?>
