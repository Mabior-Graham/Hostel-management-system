<?php 
include('includes/dashboardheader.php');

// Fetch all rooms with type
$roomsResult = mysqli_query($conn, "
    SELECT r.*, rt.name AS room_type
    FROM rooms r
    LEFT JOIN room_types rt ON r.room_type_id = rt.id
    ORDER BY r.floor, r.room_number
");

// Fetch room types for modal
$roomTypesResult = mysqli_query($conn, "SELECT * FROM room_types ORDER BY name");
?>

<div class="container-fluid py-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold mb-2">Hostel Rooms Management</h1>
        <p class="text-muted">View all hostel rooms with bed capacity and details</p>
    </div>

    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-info fw-bold" data-bs-toggle="modal" data-bs-target="#addRoomModal">
            <i class="bi bi-plus-circle me-1"></i> Add Room
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

    <!-- Rooms Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-info">
                <tr>
                    <th>#</th>
                    <th>Room Number</th>
                    <th>Type</th>
                    <th>Floor</th>
                    <th>Bed Capacity</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($roomsResult) > 0): ?>
                    <?php $counter = 1; ?>
                    <?php while($room = mysqli_fetch_assoc($roomsResult)): ?>
                        <tr>
                            <td><?= $counter++; ?></td>
                            <td><?= htmlspecialchars($room['room_number']); ?></td>
                            <td><?= htmlspecialchars($room['room_type']); ?></td>
                            <td><?= htmlspecialchars($room['floor']); ?></td>
                            <td><?= htmlspecialchars($room['bed_capacity'] ?? 'N/A'); ?></td>
                            <td class="text-capitalize"><?= htmlspecialchars($room['status']); ?></td>
                            <td><?= htmlspecialchars($room['notes'] ?? '-'); ?></td>
                            <td>
                               
                                <a href="../actions/delete_room.php?id=<?= $room['id']; ?>" 
                                   class="btn btn-sm btn-danger mb-1" 
                                   onclick="return confirm('Are you sure you want to delete this room?');">
                                    <i class="bi bi-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-muted">No rooms found in this hostel.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Room Modal -->
<div class="modal fade" id="addRoomModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="../actions/add_room.php" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Add Hostel Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Room Number</label>
                    <input type="text" name="room_number" class="form-control" placeholder="101" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Room Type</label>
                    <select name="room_type_id" class="form-select" required>
                        <option value="">-- Select Room Type --</option>
                        <?php while($type = mysqli_fetch_assoc($roomTypesResult)): ?>
                            <option value="<?= $type['id']; ?>"><?= htmlspecialchars($type['name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Floor</label>
                    <input type="number" name="floor" class="form-control" placeholder="1">
                </div>

                <div class="mb-3">
                    <label class="form-label">Bed Capacity</label>
                    <input type="number" name="bed_capacity" class="form-control" placeholder="2">
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
                <button type="submit" class="btn btn-info fw-bold">Add Room</button>
            </div>
        </form>
    </div>
</div>

<?php include('includes/dashboardfooter.php'); ?>
