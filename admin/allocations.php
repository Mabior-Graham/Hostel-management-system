<?php
include('includes/dashboardheader.php');

// Fetch all allocations with student, room, bed details
$allocationsResult = mysqli_query($conn, "
    SELECT a.id AS allocation_id, u.id AS student_id, u.full_name, r.id AS room_id, r.room_number, b.id AS bed_id, b.bed_number,
           a.start_date, a.end_date
    FROM allocations a
    LEFT JOIN users u ON a.student_id = u.id
    LEFT JOIN beds b ON a.bed_id = b.id
    LEFT JOIN rooms r ON b.room_id = r.id
    ORDER BY r.room_number, b.bed_number
");

// Fetch rooms and beds for allocation form
$roomsResult = mysqli_query($conn, "SELECT id, room_number FROM rooms ORDER BY room_number");
$bedsResult = mysqli_query($conn, "SELECT id, bed_number, room_id FROM beds ORDER BY room_id, bed_number");

// Fetch students (from users table) who are not yet allocated
$studentsResult = mysqli_query($conn, "
    SELECT u.id, u.full_name 
    FROM users u
    WHERE u.role = 'student'
    AND u.id NOT IN (SELECT student_id FROM allocations)
    ORDER BY u.full_name
");
?>

<div class="container-fluid py-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold mb-2">Room & Bed Allocations</h1>
        <p class="text-muted">Allocate students to rooms and beds</p>
    </div>

    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-info fw-bold" data-bs-toggle="modal" data-bs-target="#allocateModal">
            <i class="bi bi-plus-circle me-1"></i> Allocate Student
        </button>
    </div>

    <!-- Alert Messages -->
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Allocations Table -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Room</th>
                    <th>Bed</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($allocationsResult) > 0): ?>
                    <?php $i = 1; ?>
                    <?php while($alloc = mysqli_fetch_assoc($allocationsResult)): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($alloc['full_name'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($alloc['room_number'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($alloc['bed_number'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($alloc['start_date'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($alloc['end_date'] ?? 'N/A'); ?></td>
                            <td>
                                <a href="edit_allocation.php?id=<?= $alloc['allocation_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="../actions/deallocate_student.php?id=<?= $alloc['allocation_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to deallocate this student?');">Deallocate</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-muted">No allocations found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Allocate Student Modal -->
<div class="modal fade" id="allocateModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="../actions/allocate_student.php" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Allocate Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Student</label>
                    <select name="student_id" class="form-select" required>
                        <option value="">-- Select Student --</option>
                        <?php while($student = mysqli_fetch_assoc($studentsResult)): ?>
                            <option value="<?= $student['id']; ?>"><?= htmlspecialchars($student['full_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Room</label>
                    <select name="room_id" class="form-select" required>
                        <option value="">-- Select Room --</option>
                        <?php while($room = mysqli_fetch_assoc($roomsResult)): ?>
                            <option value="<?= $room['id']; ?>"><?= htmlspecialchars($room['room_number']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bed</label>
                    <select name="bed_id" class="form-select" required>
                        <option value="">-- Select Bed --</option>
                        <?php 
                        mysqli_data_seek($bedsResult, 0);
                        while($bed = mysqli_fetch_assoc($bedsResult)): ?>
                            <option value="<?= $bed['id']; ?>">
                                <?= htmlspecialchars('Room '.$bed['room_id'].' - Bed '.$bed['bed_number']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control">
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-info fw-bold">Allocate</button>
            </div>
        </form>
    </div>
</div>

<?php include('includes/dashboardfooter.php'); ?>
