<?php
include '../includes/auth.php';
include '../config/db.php';

$doctor_id = $_SESSION['user_id'];

$total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM appointments WHERE doctor_id = $doctor_id")); 
$upcoming = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM appointments WHERE doctor_id = $doctor_id AND status = 'confirmed'"));
$completed = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM appointments WHERE doctor_id = $doctor_id AND status = 'completed'"));
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-2 p-0">
      <?php include 'doctor_sidebar.php'; ?>
    </div>

    <div class="col-md-10 p-4">
      <h2 class="mb-4">Doctor Dashboard</h2>
      <div class="row g-4">
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
              <h5>Upcoming</h5>
              <p class="display-6 text-warning"><?php echo $upcoming; ?></p>
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
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
