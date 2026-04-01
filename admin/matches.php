<?php

include('includes/dashboardheader.php');

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Access denied.";
    header("Location: ../login.php");
    exit;
}

// Fetch matches with related league and teams
$sql = "SELECT m.id, m.match_date, m.venue, m.home_score, m.away_score, m.status,
               l.name AS league_name,
               t1.name AS home_team,
               t2.name AS away_team
        FROM matches m
        LEFT JOIN leagues l ON m.league_id = l.id
        LEFT JOIN teams t1 ON m.home_team_id = t1.id
        LEFT JOIN teams t2 ON m.away_team_id = t2.id
        ORDER BY m.match_date DESC";

$result = mysqli_query($conn, $sql);
?>

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">Matches</h1>
        <a href="add_match.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Match
        </a>
    </div>

    <!-- Feedback messages -->
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <!-- Matches Table -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>League</th>
                        <th>Home Team</th>
                        <th>Away Team</th>
                        <th>Venue</th>
                        <th>Date</th>
                        <th>Score</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php $i=1; while($match = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= htmlspecialchars($match['league_name']); ?></td>
                                <td><?= htmlspecialchars($match['home_team']); ?></td>
                                <td><?= htmlspecialchars($match['away_team']); ?></td>
                                <td><?= htmlspecialchars($match['venue']); ?></td>
                                <td><?= date('d M Y', strtotime($match['match_date'])); ?></td>
                                <td>
                                    <?= is_null($match['home_score']) ? '-' : $match['home_score']; ?> 
                                    : 
                                    <?= is_null($match['away_score']) ? '-' : $match['away_score']; ?>
                                </td>
                                <td><?= htmlspecialchars($match['status']); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="edit_match.php?id=<?= $match['id']; ?>" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <a href="../actions/delete_match.php?id=<?= $match['id']; ?>" class="btn btn-sm btn-danger"
                                           onclick="return confirm('Delete this match?');">
                                           <i class="bi bi-trash"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">No matches found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include('includes/dashboardfooter.php'); ?>
