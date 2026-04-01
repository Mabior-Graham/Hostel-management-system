<?php include('includes/header.php'); ?>

<!-- About Hero Section -->
<section class="py-5 d-flex align-items-center text-white" 
         style="min-height: 70vh; background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);">
    <div class="container text-center">
        <span class="badge bg-info text-dark mb-3 px-3 py-2">About HMS</span>

        <h1 class="fw-bold display-5 mb-4">About Our Hostel Management System</h1>

        <p class="lead mb-4 text-light">
            HMS is a web-based system built as a student project to simplify hostel operations.
            It helps administrators manage rooms, beds, student allocations, and payments in one place.
        </p>

        <p class="mb-4 text-light">
            The system focuses on simplicity, clarity, and ease of use. It’s suitable for learning purposes,
            final year projects, or small hostels that want to move from paper records to digital management.
        </p>

        <div class="d-flex justify-content-center gap-2 flex-wrap">
            <a href="register.php" class="btn btn-info btn-lg text-dark fw-semibold">
                Get Started
            </a>
            <a href="login.php" class="btn btn-outline-light btn-lg">
                Login
            </a>
        </div>
    </div>
</section>

<!-- Mission / Vision -->
<section class="py-5" style="background: #0b1c22;">
    <div class="container text-center text-white">
        <h2 class="fw-bold mb-4">Our Purpose</h2>

        <div class="row g-4 justify-content-center">

            <div class="col-md-5">
                <div class="p-4 rounded-4 h-100"
                     style="background: rgba(255,255,255,0.06); backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                    <i class="bi bi-bullseye display-5 text-info mb-3"></i>
                    <h5 class="fw-bold">Our Mission</h5>
                    <p class="text-light">
                        To provide a simple and reliable hostel management system that helps administrators
                        manage students, rooms, and payments efficiently.
                    </p>
                </div>
            </div>

            <div class="col-md-5">
                <div class="p-4 rounded-4 h-100"
                     style="background: rgba(255,255,255,0.06); backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                    <i class="bi bi-eye display-5 text-info mb-3"></i>
                    <h5 class="fw-bold">Our Vision</h5>
                    <p class="text-light">
                        To help small hostels and student residences transition into simple digital systems
                        for better organization and transparency.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Key Features -->
<section class="py-5" style="background: #08161b;">
    <div class="container text-center text-white">
        <h2 class="fw-bold mb-5">Key Features</h2>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="p-4 h-100 rounded-4"
                     style="background: rgba(255,255,255,0.06); backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                    <i class="bi bi-door-open display-4 text-info mb-3"></i>
                    <h5 class="fw-bold">Room & Bed Management</h5>
                    <p class="text-light">
                        Add rooms, manage bed availability, and track occupancy in real time.
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
                        Track rent payments and view pending balances at a glance.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>
