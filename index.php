<?php include('includes/header.php'); ?>

<!-- Hero / Intro Section -->
<section class="py-5 d-flex align-items-center position-relative" 
         style="min-height: 90vh; background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);">
    <div class="container text-white position-relative">
        <div class="row align-items-center">

            <div class="col-md-7">
                <span class="badge bg-info text-dark mb-3 px-3 py-2">Student Project</span>

                <h1 class="fw-bold display-4 mb-3">
                    Hostel <br>Management System
                </h1>

                <p class="lead mb-4 text-light">
                    A simple web-based system to manage rooms, bed allocation, student check-ins, and rent payments — all in one place.
                </p>

                <div class="d-flex gap-2 flex-wrap">
                    <a href="register.php" class="btn btn-info btn-lg text-dark fw-semibold">
                        Get Started
                    </a>
                    <a href="login.php" class="btn btn-outline-light btn-lg">
                        Login
                    </a>
                </div>
            </div>

            <div class="col-md-5 text-center d-none d-md-block">
                <img src="assets/images/hotel_hero.png" 
                     class="img-fluid rounded-4 shadow-lg" 
                     alt="HMS Dashboard">
            </div>

        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5" style="background: #0b1c22;">
    <div class="container text-center text-white">
        <h2 class="fw-bold mb-2">Why Choose Our HMS?</h2>
        <p class="text-light mb-5">Built for students, simple to use, powerful enough for real hostels.</p>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="p-4 h-100 rounded-4" 
                     style="background: rgba(255,255,255,0.06); backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                    <i class="bi bi-door-open display-4 text-info mb-3"></i>
                    <h5 class="fw-bold">Room & Bed Management</h5>
                    <p class="text-light">
                        Create rooms, manage beds, and track which ones are vacant or occupied.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 h-100 rounded-4" 
                     style="background: rgba(255,255,255,0.06); backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                    <i class="bi bi-calendar-check display-4 text-info mb-3"></i>
                    <h5 class="fw-bold">Student Allocation</h5>
                    <p class="text-light">
                        Assign students to rooms and manage check-in and check-out dates easily.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 h-100 rounded-4" 
                     style="background: rgba(255,255,255,0.06); backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                    <i class="bi bi-cash-coin display-4 text-info mb-3"></i>
                    <h5 class="fw-bold">Payments Tracking</h5>
                    <p class="text-light">
                        Record rent payments and instantly see who has paid or is pending.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Highlight Section -->
<section class="py-5 position-relative text-white" 
         style="background: url('assets/images/hotel_lobby.jpg') center/cover no-repeat;">
    <div style="position:absolute; inset:0; background: rgba(15, 32, 39, 0.85);"></div>

    <div class="container position-relative text-center">
        <h2 class="fw-bold mb-3">Manage Your Hostel Effortlessly</h2>
        <p class="mb-4 text-light">
            HMS connects administrators and students on one platform, ensuring smooth room allocation,
            simple rent tracking, and transparent records.
        </p>
        <a href="register.php" class="btn btn-info btn-lg text-dark fw-semibold">
            Get Started Today
        </a>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 text-center text-white" 
         style="background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);">
    <div class="container">
        <h2 class="fw-bold mb-3">Take Control of Your Hostel</h2>
        <p class="mb-4 text-light">
            Start managing rooms, students, and payments with confidence.
        </p>
        <a href="login.php" class="btn btn-outline-light btn-lg">
            Login Now
        </a>
    </div>
</section>

<?php include('includes/footer.php'); ?>
