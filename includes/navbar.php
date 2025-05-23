<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Tusaale ahaan, waxaad u isticmaali kartaa $_SESSION['role'] si aad u kala soocdo user types
$user_logged_in = isset($_SESSION['user_id']);
$user_role = $_SESSION['role'] ?? null;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <i class="fas fa-stethoscope me-2"></i>Mubaarak Hospital
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>

        <?php if (!$user_logged_in): ?>
          <li class="nav-item"><a class="nav-link" href="doctors.php">Doctors</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>

        <?php else: ?>
          <?php if ($user_role === 'patient'): ?>
            <li class="nav-item"><a class="nav-link" href="../patient/dashboard.php">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="patient/messages.php">Messages</a></li>
          <?php elseif ($user_role === 'doctor'): ?>
            <li class="nav-item"><a class="nav-link" href="doctor/dashboard.php">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="doctor/patients.php">Patients</a></li>
          <?php elseif ($user_role === 'admin'): ?>
            <li class="nav-item"><a class="nav-link" href="admin/dashboard.php">Admin Panel</a></li>
          <?php endif; ?>

          <li class="nav-item"><a class="nav-link" href="../index.php">Logout</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
