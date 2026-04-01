<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
                    

<?php include('includes/dashboardheader.php'); ?>
           




            <h3 class="mb-4">Manage Users</h3>

            <!-- Flash messages -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th width="180">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM users ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0):
                            $i = 1;
                            while ($user = mysqli_fetch_assoc($result)):
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <?php if ($user['account_status'] === 'active'): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($user['account_status'] === 'active'): ?>
                                    <a href="../actions/deactivateuser.php?id=<?php echo $user['id']; ?>&action=deactivate"
                                       class="btn btn-sm btn-warning"
                                       >
                                       Deactivate
                                    </a>
                                <?php else: ?>
                                    <a href="../actions/activateuser.php?id=<?php echo $user['id']; ?>&action=activate"
                                       class="btn btn-sm btn-success"
                                       onclick="return confirm('Activate this user?');">
                                       Activate
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No users found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

    





        

<?php include('includes/dashboardfooter.php'); ?>
