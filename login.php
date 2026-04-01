<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php"); // redirect to dashboard or homepage
    exit;
}
?>

<?php include('includes/header.php'); ?>

<!-- Login Hero Section -->
<section class="py-5 d-flex align-items-center text-white"
         style="min-height: 45vh; background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);">
    <div class="container text-center">
        <span class="badge bg-info text-dark mb-3 px-3 py-2">Welcome Back</span>
        <h1 class="display-5 fw-bold">Login to HMS</h1>
        <p class="lead text-light">Enter your credentials to access your Hostel Management System account.</p>
    </div>
</section>

<!-- Login Form Section -->
<section class="py-5" style="background:#0b1c22;">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-5 col-lg-4">
                <div class="p-4 rounded-4"
                     style="background: rgba(255,255,255,0.06); backdrop-filter: blur(10px); box-shadow: 0 10px 25px rgba(0,0,0,0.35); color:#fff;">

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

                    <!-- Login Form -->
                    <form method="post" action="actions/login.php">

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" 
                                   class="form-control bg-transparent text-white border-secondary" 
                                   placeholder="name@example.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" 
                                   class="form-control bg-transparent text-white border-secondary" 
                                   placeholder="Enter your password" required>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-info text-dark fw-semibold btn-lg">
                                Login
                            </button>
                        </div>

                    </form>

                    <!-- Links -->
                    <div class="text-center mt-3">
                        <small class="text-light">
                            Don’t have an account?
                            <a href="register.php" class="text-info text-decoration-none">Register Here</a>
                        </small>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>
