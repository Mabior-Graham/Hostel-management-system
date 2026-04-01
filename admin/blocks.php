<?php
include('includes/dashboardheader.php');

// Fetch all blocks
$blocksResult = mysqli_query($conn, "SELECT * FROM blocks ORDER BY name");
?>

<div class="container-fluid py-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold mb-2">Hostel Blocks Management</h1>
        <p class="text-muted">View and manage all hostel blocks/buildings</p>
    </div>

    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-info fw-bold" data-bs-toggle="modal" data-bs-target="#addBlockModal">
            <i class="bi bi-plus-circle me-1"></i> Add Block
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

    <!-- Blocks Table -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Block Name</th>
                    <th>Description</th>
                    <th>Number of Floors</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($blocksResult) > 0): ?>
                    <?php $i = 1; ?>
                    <?php while($block = mysqli_fetch_assoc($blocksResult)): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($block['name']); ?></td>
                            <td><?= htmlspecialchars($block['description']); ?></td>
                            <td><?= htmlspecialchars($block['floor_count']); ?></td>
                            <td>
                               
                                <a href="../actions/delete_block.php?id=<?= $block['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this block?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-muted">No blocks found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Block Modal -->
<div class="modal fade" id="addBlockModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="../actions/add_block.php" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Hostel Block</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Block Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Block A" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Optional description"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Number of Floors</label>
                    <input type="number" name="floor_count" class="form-control" placeholder="3" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-info fw-bold">Add Block</button>
            </div>
        </form>
    </div>
</div>

<?php include('includes/dashboardfooter.php'); ?>
