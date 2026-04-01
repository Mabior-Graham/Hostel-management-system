<?php

include('includes/dashboardheader.php');

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Access denied.";
    header("Location: ../login.php");
    exit;
}

// Validate team ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid team selected.";
    header("Location: teams.php");
    exit;
}

$team_id = (int) $_GET['id'];

// Fetch team
$stmt = $conn->prepare("SELECT * FROM teams WHERE id = ?");
$stmt->bind_param("i", $team_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Team not found.";
    header("Location: teams.php");
    exit;
}

$team = $result->fetch_assoc();
$stmt->close();

// Fetch leagues for dropdown
$leagues_res = mysqli_query($conn, "SELECT id, name, season FROM leagues WHERE status='active' ORDER BY name ASC");
?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Edit Team</h2>
        <a href="teams.php" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="../actions/update_team.php">

                <input type="hidden" name="id" value="<?= $team['id']; ?>">

                <!-- Team Name -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Team Name</label>
                    <input type="text" name="name" class="form-control"
                           value="<?= htmlspecialchars($team['name']); ?>" required>
                </div>

                <!-- League -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">League</label>
                    <select name="league_id" class="form-select" required>
                        <?php while ($league = mysqli_fetch_assoc($leagues_res)): ?>
                            <option value="<?= $league['id']; ?>"
                                <?= $league['id'] == $team['league_id'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($league['name'].' ('.$league['season'].')'); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- City -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">City</label>
                    <input type="text" name="city" class="form-control"
                           value="<?= htmlspecialchars($team['city']); ?>">
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="teams.php" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Team
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<?php include('includes/dashboardfooter.php'); ?>
