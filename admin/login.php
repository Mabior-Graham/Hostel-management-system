<?php include('includes/dashboardheader.php');
// Fetch all rooms with type
$roomsResult = mysqli_query($conn, "
    SELECT r.*, rt.name AS room_type
    FROM rooms r
    LEFT JOIN room_types rt ON r.room_type_id = rt.id
    ORDER BY r.floor, r.room_number
");
?>


<div class="container-fluid py-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold mb-2">Rooms Management</h1>
        <p class="text-muted">View all rooms with images and details</p>
    </div>

    <!-- Alert Messages -->
    <?php
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
            . $_SESSION['error'] .
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
            . $_SESSION['success'] .
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['success']);
    }
    ?>

    <!-- Rooms Grid -->
    <div class="row g-4">
        <?php while($room = mysqli_fetch_assoc($roomsResult)): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm h-100">
                <?php if (!empty($room['image'])): ?>
                    <img src="../uploads/<?php echo $room['image']); ?>" class="card-img-top" alt="Room Image" style="height:200px; object-fit:cover;">
                <?php else: ?>
                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:200px;">
                        No Image
                    </div>
                <?php endif; ?>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Room <?= htmlspecialchars($room['room_number']); ?> - <?= htmlspecialchars($room['room_type']); ?></h5>
                    <p class="card-text mb-1"><strong>Floor:</strong> <?= htmlspecialchars($room['floor']); ?></p>
                    <p class="card-text mb-1"><strong>Status:</strong> <span class="text-capitalize"><?= htmlspecialchars($room['status']); ?></span></p>
                    <?php if (!empty($room['notes'])): ?>
                        <p class="card-text mb-2"><strong>Notes:</strong> <?= htmlspecialchars($room['notes']); ?></p>
                    <?php endif; ?>

                    <div class="mt-auto d-flex justify-content-between">
                        <a href="edit_room.php?id=<?= $room['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="../actions/delete_room.php?id=<?= $room['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this room?');">Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>

        <?php if (mysqli_num_rows($roomsResult) === 0): ?>
        <div class="col-12 text-center">
            <p class="text-muted">No rooms found.</p>
        </div>
        <?php endif; ?>
    </div>
</div>


<!-- Add Room Modal -->
<div class="modal fade" id="addRoomModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="../actions/add_room.php" class="modal-content" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title">Add Room</h5>
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

        <div class="mb-3">
            <label class="form-label">Room Image</label>
            <input type="file" name="room_image" class="form-control" accept="image/*">
            <small class="text-muted">Optional. JPG, PNG, GIF. Max 2MB.</small>
        </div>

    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary fw-bold">Add Room</button>
    </div>

</form>

    </div>
</div>

<?php include('includes/dashboardfooter.php'); ?>
