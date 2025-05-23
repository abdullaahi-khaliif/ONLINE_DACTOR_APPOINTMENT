<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Online Doctor Appointment - Mubaarak Hospital</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }
    .hero { background-color: #e6f7ff; padding: 60px 0; }
    .doctor-card { box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 15px; overflow: hidden; }
    .footer { background-color: #002d4a; color: white; padding: 20px 0; }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="#"><i class="fas fa-stethoscope me-2"></i>Mubaarak Hospital</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Doctors</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Book Appointment</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero text-center">
  <div class="container">
    <h1 class="display-4 fw-bold">Welcome to Mubaarak Hospital</h1>
    <p class="lead">Book Appointments Online – Chat & Video Call With Doctors</p>
    <a href="register.php" class="btn btn-success btn-lg mt-3">Get Started</a>
  </div>
</section>

<!-- About Section -->
<section class="container my-5">
  <div class="row align-items-center">
    <div class="col-md-6">
      <img src="assets/images/hospital.jpg" class="img-fluid rounded" alt="Hospital Image">
    </div>
    <div class="col-md-6">
      <h2>About Mubaarak Hospital</h2>
      <p>Our hospital offers advanced online doctor appointment services. You can search doctors, book appointments, and even consult through video calls. Join now and manage your health from home.</p>
    </div>
  </div>
</section>

<!-- Featured Doctors -->
<section class="container my-5">
  <h2 class="text-center mb-4">Our Featured Doctors</h2>
  <div class="row g-4">
    <!-- Doctor Card Example -->
    <div class="col-md-4">
      <div class="card doctor-card">
        <img src="assets/images/doctor1.jpg" class="card-img-top" alt="Doctor 1">
        <div class="card-body text-center">
          <h5 class="card-title">Dr. Amin Yusuf</h5>
          <p class="card-text">Cardiologist | Available: Mon–Fri (9AM–4PM)</p>
          <a href="#" class="btn btn-outline-primary btn-sm">View Profile</a>
        </div>
      </div>
    </div>
    <!-- You can add more doctor cards here -->
  </div>
</section>

<!-- Footer -->
<footer class="footer text-center">
  <div class="container">
    <p class="mb-1">&copy; <?php echo date("Y"); ?> Mubaarak Hospital. All Rights Reserved.</p>
    <p class="mb-0">Developed by Group 6 | Online Doctor Appointment System</p>
  </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
