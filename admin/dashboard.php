<?php
include '../includes/auth.php';
include '../config/db.php';

$patients = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role = 'patient'"));
$doctors = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role = 'doctor'"));
$appointments = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM appointments"));
$prescriptions = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM prescriptions"));
?>

<?php include '../includes/header.php'; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-2 p-0">
      <?php include 'sidebar.php'; ?>
    </div>

    <div class="col-md-10">
      <div class="container my-5">
        <h2 class="mb-4">Admin Dashboard</h2>
        <div class="row g-4">
          <div class="col-md-3">
            <div class="card text-center bg-info text-white shadow">
              <div class="card-body">
                <h5>Patients</h5>
                <p class="display-6"><?php echo $patients; ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card text-center bg-primary text-white shadow">
              <div class="card-body">
                <h5>Doctors</h5>
                <p class="display-6"><?php echo $doctors; ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card text-center bg-success text-white shadow">
              <div class="card-body">
                <h5>Appointments</h5>
                <p class="display-6"><?php echo $appointments; ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card text-center bg-warning text-white shadow">
              <div class="card-body">
                <h5>Prescriptions</h5>
                <p class="display-6"><?php echo $prescriptions; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
