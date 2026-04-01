<?php include('includes/header.php'); ?>

<!-- Contact Hero Section -->
<section class="py-5 d-flex align-items-center text-white" 
         style="min-height: 60vh; background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);">
    <div class="container text-center">
        <span class="badge bg-info text-dark mb-3 px-3 py-2">Contact HMS</span>

        <h1 class="fw-bold display-5 mb-4">Get in Touch</h1>
        <p class="lead text-light mb-0">
            Have questions or need support? Send us a message and we’ll respond as soon as possible.
        </p>
    </div>
</section>

<!-- Contact Form & Info -->
<section class="py-5" style="background:#0b1c22;">
    <div class="container text-white">
        <div class="row g-4 align-items-stretch">

            <!-- Contact Form -->
            <div class="col-md-7">
                <div class="p-4 rounded-4 h-100"
                     style="background: rgba(255,255,255,0.06); backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                    <h3 class="fw-bold mb-3">Send Us a Message</h3>

                    <form action="actions/send_message.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control bg-transparent text-white border-secondary" id="name" name="name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control bg-transparent text-white border-secondary" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control bg-transparent text-white border-secondary" id="subject" name="subject" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control bg-transparent text-white border-secondary" id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-info text-dark fw-semibold px-4">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-md-5">
                <div class="p-4 rounded-4 h-100"
                     style="background: rgba(255,255,255,0.06); backdrop-filter: blur(8px); box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                    <h3 class="fw-bold mb-3">Our Contact Info</h3>

                    <p class="mb-2">
                        <i class="bi bi-geo-alt-fill me-2 text-info"></i>
                        123 Main Street, Juba, South Sudan
                    </p>
                    <p class="mb-2">
                        <i class="bi bi-telephone-fill me-2 text-info"></i>
                        +211 920 000 000
                    </p>
                    <p class="mb-2">
                        <i class="bi bi-envelope-fill me-2 text-info"></i>
                        info@hms-demo.com
                    </p>
                    <p class="mb-0">
                        <i class="bi bi-clock-fill me-2 text-info"></i>
                        Mon – Sat: 8:00 AM – 8:00 PM
                    </p>

                    <hr class="border-secondary my-4">

                    <p class="small text-light mb-0">
                        This contact form is for demo purposes in the student project.
                        You can connect it to email later if needed.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>
