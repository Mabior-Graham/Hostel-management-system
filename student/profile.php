<?php
session_start();
include('includes/dashboardheader.php'); 
require_once('../config/db.php'); // database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Access denied.";
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Handle optional messages
$success = $_SESSION['success'] ?? '';
$error   = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);
?>

<!-- Hero Section -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, #002147, #004080);">
    <div class="container text-center">
        <h1 class="fw-bold mb-2">My Profile</h1>
        <p class="lead mb-0">View and update your account information for your University of Juba application.</p>
    </div>
</section>

<!-- Profile Form Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- Session Messages -->
                <?php if($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Profile Form -->
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="../actions/update_profile.php" method="POST">

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current">
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold text-white">Update Profile</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include('includes/dashboardfooter.php'); ?>
