<?php include('includes/dashboardheader.php');
// Check if room ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid room ID.";
    header("Location: rooms.php");
    exit;
}

$roomId = intval($_GET['id']);

// Fetch room data
$roomResult = mysqli_query($conn, "SELECT * FROM rooms WHERE id = $roomId");
if (mysqli_num_rows($roomResult) === 0) {
    $_SESSION['error'] = "Room not found.";
    header("Location: rooms.php");
    exit;
}

$room = mysqli_fetch_assoc($roomResult);

// Fetch all room types
$roomTypesResult = mysqli_query($conn, "SELECT * FROM room_types ORDER BY name");
?>


<div class="container py-5">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Edit Room <?= htmlspecialchars($room['room_number']); ?></h1>
        <p class="text-muted">Update room details and image</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
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

            <!-- Edit Room Form -->
            <form method="post" action="../actions/edit_room.php" enctype="multipart/form-data" class="card p-4 shadow-sm border-0">
                <input type="hidden" name="id" value="<?= $room['id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Room Number</label>
                    <input type="text" name="room_number" class="form-control" value="<?= htmlspecialchars($room['room_number']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Room Type</label>
                    <select name="room_type_id" class="form-select" required>
                        <option value="">-- Select Room Type --</option>
                        <?php while($type = mysqli_fetch_assoc($roomTypesResult)): ?>
                            <option value="<?= $type['id']; ?>" <?= $room['room_type_id'] == $type['id'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($type['name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Floor</label>
                    <input type="number" name="floor" class="form-control" value="<?= htmlspecialchars($room['floor']); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="available" <?= $room['status'] === 'available' ? 'selected' : ''; ?>>Available</option>
                        <option value="booked" <?= $room['status'] === 'booked' ? 'selected' : ''; ?>>Booked</option>
                        <option value="maintenance" <?= $room['status'] === 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2"><?= htmlspecialchars($room['notes']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Room Image</label>
                    <input type="file" name="image" class="form-control">
                    <?php if(!empty($room['image']) && file_exists('../uploads/'.$room['image'])): ?>
                        <img src="../uploads/<?= htmlspecialchars($room['image']); ?>" alt="Room Image" class="img-thumbnail mt-2" style="max-width:150px;">
                    <?php endif; ?>
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary fw-bold">Update Room</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include('includes/dashboardfooter.php'); ?>
