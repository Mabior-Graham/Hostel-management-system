<?php
include('includes/dashboardheader.php');

// Fetch all room types
$roomTypesResult = mysqli_query($conn, "SELECT * FROM room_types ORDER BY name");
?>

<div class="container-fluid py-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold mb-2">Room Types Management</h1>
        <p class="text-muted">Add, edit, or delete room types with their monthly prices</p>
    </div>

    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#addRoomTypeModal">
            <i class="bi bi-plus-circle me-1"></i> Add Room Type
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

    <!-- Room Types Table -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Room Type</th>
                    <th>Price (per month)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($roomTypesResult) > 0): $i = 1; ?>
                    <?php while($type = mysqli_fetch_assoc($roomTypesResult)): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($type['name']); ?></td>
                            <td>$<?= number_format($type['price'], 2); ?></td>
                            <td>
                               
                                <a href="../actions/delete_room_type.php?id=<?= $type['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this room type?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-muted">No room types found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Room Type Modal -->
<div class="modal fade" id="addRoomTypeModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="../actions/add_room_type.php" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Room Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Room Type Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Single, Double, Suite..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price (per month)</label>
                    <input type="number" name="price" class="form-control" placeholder="e.g., 200" min="0" step="0.01" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary fw-bold">Add Room Type</button>
            </div>
        </form>
    </div>
</div>

<?php include('includes/dashboardfooter.php'); ?>
