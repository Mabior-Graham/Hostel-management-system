<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hostel Management System</title>

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="../assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</head>
<body>


<!-- Guest Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" 
     style="background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); backdrop-filter: blur(8px); box-shadow: 0 6px 20px rgba(0,0,0,0.25);">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php">
            <span style="width:10px;height:10px;border-radius:50%;background:#00ffd5;display:inline-block;"></span>
            HMS
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#guestNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="guestNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-3">
                <li class="nav-item">
                    <a class="nav-link active fw-semibold" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="about.php">About Us</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="contact.php">Contact</a>
                </li>
            </ul>

           <!-- Right Actions -->
        <div class="d-flex gap-2">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <!-- User NOT logged in -->
                <a href="login.php" class="btn btn-outline-info btn-sm px-3">Login</a>
                <a href="register.php" class="btn btn-info btn-sm px-3 text-dark fw-semibold">Register</a>
            <?php else: ?>
                <!-- User IS logged in -->
                <a href="../actions/logout.php" class="btn btn-danger btn-sm px-3">Logout</a>
            <?php endif; ?>
        </div>

        </div>

    </div>
</nav>
