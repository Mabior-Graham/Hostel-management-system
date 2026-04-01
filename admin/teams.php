<?php

include('includes/dashboardheader.php');

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Access denied.";
    header("Location: ../login.php");
    exit;
}

// Fetch teams with their leagues
$sql = "
    SELECT t.id, t.name AS team_name, t.city, t.created_at, l.name AS league_name, l.season
    FROM teams t
    LEFT JOIN leagues l ON t.league_id = l.id
    ORDER BY t.created_at DESC
";
$result = mysqli_query($conn, $sql);

// Fetch leagues for the Add modal dropdown
$leagues_res = mysqli_query($conn, "SELECT id, name, season FROM leagues WHERE status='active' ORDER BY name ASC");
?>

<?php
// Fetch team managers
$managers = mysqli_query(
    $conn,
    "SELECT id, full_name 
     FROM users 
     WHERE role = 'team_manager' 
     ORDER BY full_name ASC"
);
?>

<div class="container-fluid py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-0">Manage Teams</h1>
            <p class="text-muted">Add, edit, and delete teams in each league</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeamModal">
            <i class="bi bi-plus-circle me-1"></i> Add Team
        </button>
    </div>

    <!-- Teams Table -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Team Name</th>
                        <th>League</th>
                        <th>City</th>
                        <th>Created</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php $i=1; while ($team = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= htmlspecialchars($team['team_name']); ?></td>
                                <td><?= htmlspecialchars($team['league_name'].' ('.$team['season'].')'); ?></td>
                                <td><?= htmlspecialchars($team['city']); ?></td>
                                <td><?= date('d M Y', strtotime($team['created_at'])); ?></td>
                                <td>
                                    <a href="edit_team.php?id=<?= $team['id']; ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="../actions/delete_team.php?id=<?= $team['id']; ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Delete this team?');">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No teams found.</td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Team Modal -->
<div class="modal fade" id="addTeamModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="../actions/add_team.php" class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add New Team</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Team Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">League</label>
                    <select name="league_id" class="form-select" required>
                        <option value="">-- Select League --</option>
                        <?php while ($league = mysqli_fetch_assoc($leagues_res)): ?>
                            <option value="<?= $league['id']; ?>">
                                <?= htmlspecialchars($league['name'].' ('.$league['season'].')'); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" placeholder="Optional">
                </div>

                <!-- Team Manager -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Team Manager</label>
                    <select name="manager_id" class="form-select" required>
                        <option value="">-- Select Manager --</option>

                        <?php if (mysqli_num_rows($managers) === 0): ?>
                            <option disabled>No team managers available</option>
                        <?php else: ?>
                            <?php while ($manager = mysqli_fetch_assoc($managers)): ?>
                                <option value="<?= $manager['id']; ?>">
                                    <?= htmlspecialchars($manager['full_name']); ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>

            <!-- Team Logo -->
            <div class="mb-3">
                <label class="form-label fw-bold">Team Logo</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
                <small class="text-muted">Optional (PNG, JPG)</small>
            </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Team</button>
            </div>

        </form>
    </div>
</div>

<?php include('includes/dashboardfooter.php'); ?>
