<?php
include '../includes/auth.php';
include '../config/db.php';

$user_id = $_SESSION['user_id'];

// Fetch user info
$query = "SELECT fullname, profile_image FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Appointment stats
$total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM appointments WHERE patient_id = $user_id"));
$pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM appointments WHERE patient_id = $user_id AND status = 'pending'"));
$completed = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM appointments WHERE patient_id = $user_id AND status = 'completed'"));
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 p-0">
      <?php include 'patient_sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="col-md-10 p-4">
      <h2 class="mb-4">Welcome, <?php echo htmlspecialchars($user['fullname']); ?></h2>

      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <div class="card text-center shadow">
            <div class="card-body">
              <h5>Total Appointments</h5>
              <p class="display-6"><?php echo $total; ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center shadow">
            <div class="card-body">
              <h5>Pending</h5>
              <p class="display-6 text-warning"><?php echo $pending; ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center shadow">
            <div class="card-body">
              <h5>Completed</h5>
              <p class="display-6 text-success"><?php echo $completed; ?></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Profile Summary + Quick Links -->
      <div class="row">
        <div class="col-md-4">
          <div class="card shadow">
            <img src="../uploads/<?php echo $user['profile_image'] ?: 'default.png'; ?>" class="card-img-top" alt="Profile" style="object-fit: cover; height: 250px;">
            <div class="card-body text-center">
              <h5 class="card-title"><?php echo $user['fullname']; ?></h5>
              <a href="edit_patient.php" class="btn btn-outline-primary btn-sm">Edit Profile</a>
            </div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="card shadow h-100">
            <div class="card-body">
              <h4>Quick Actions</h4>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="appointments.php">📅 View Appointments</a></li>
                <li class="list-group-item"><a href="book.php">➕ Book New Appointment</a></li>
                <li class="list-group-item"><a href="messages.php">💬 Messages</a></li>
                <li class="list-group-item"><a href="prescriptions.php">📄 My Prescriptions</a></li>
                <li class="list-group-item"><a href="../logout.php">🚪 Logout</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
