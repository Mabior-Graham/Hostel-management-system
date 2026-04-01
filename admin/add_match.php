<?php

include('includes/dashboardheader.php');

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Access denied.";
    header("Location: ../login.php");
    exit;
}

// Fetch leagues
$leagues_res = mysqli_query($conn, "SELECT id, name FROM leagues ORDER BY name ASC");

// Fetch teams
$teams_res = mysqli_query($conn, "SELECT id, name FROM teams ORDER BY name ASC");
?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">Add New Match</h1>
        <a href="matches.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Back to Matches
        </a>
    </div>

    <!-- Feedback messages -->
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="../actions/add_match.php" method="POST">

                <!-- League -->
                <div class="mb-3">
                    <label class="form-label">League</label>
                    <select name="league_id" class="form-select" required>
                        <option value="" disabled selected>-- Select League --</option>
                        <?php while($league = mysqli_fetch_assoc($leagues_res)): ?>
                            <option value="<?= $league['id']; ?>"><?= htmlspecialchars($league['name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Home Team -->
                <div class="mb-3">
                    <label class="form-label">Home Team</label>
                    <select name="home_team_id" class="form-select" required>
                        <option value="" disabled selected>-- Select Home Team --</option>
                        <?php while($team = mysqli_fetch_assoc($teams_res)): ?>
                            <option value="<?= $team['id']; ?>"><?= htmlspecialchars($team['name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <?php
                // Reset teams result pointer for away team
                mysqli_data_seek($teams_res, 0);
                ?>

                <!-- Away Team -->
                <div class="mb-3">
                    <label class="form-label">Away Team</label>
                    <select name="away_team_id" class="form-select" required>
                        <option value="" disabled selected>-- Select Away Team --</option>
                        <?php while($team = mysqli_fetch_assoc($teams_res)): ?>
                            <option value="<?= $team['id']; ?>"><?= htmlspecialchars($team['name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Match Date -->
                <div class="mb-3">
                    <label class="form-label">Match Date</label>
                    <input type="date" name="match_date" class="form-control" required>
                </div>

                <!-- Venue -->
                <div class="mb-3">
                    <label class="form-label">Venue</label>
                    <input type="text" name="venue" class="form-control" placeholder="Enter venue" required>
                </div>

                <!-- Optional: Initial Scores -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Home Score</label>
                        <input type="number" name="home_score" class="form-control" min="0" placeholder="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Away Score</label>
                        <input type="number" name="away_score" class="form-control" min="0" placeholder="0">
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="" disabled selected>-- Select Status --</option>
                        <option value="Scheduled">Scheduled</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Add Match
                </button>
            </form>
        </div>
    </div>

</div>

<?php include('includes/dashboardfooter.php'); ?>
