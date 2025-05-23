<?php
include '../includes/auth.php';
include '../config/db.php';

$doctor_id = $_SESSION['user_id'];

$query = "SELECT DISTINCT u.id, u.fullname, u.email, u.profile_image
          FROM appointments a
          JOIN users u ON a.patient_id = u.id
          WHERE a.doctor_id = $doctor_id";

$patients = mysqli_query($conn, $query);
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container my-5">
  <h2 class="mb-4">My Patients</h2>

  <div class="row g-4">
    <?php while ($p = mysqli_fetch_assoc($patients)): ?>
      <div class="col-md-4">
        <div class="card shadow">
          <img src="../uploads/<?php echo $p['profile_image']; ?>" class="card-img-top" alt="Patient" style="height: 250px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title"><?php echo $p['fullname']; ?></h5>
            <p class="card-text"><?php echo $p['email']; ?></p>
            <a href="chat.php?user_id=<?php echo $p['id']; ?>" class="btn btn-outline-primary btn-sm">Message</a>
            <a href="prescribe.php?patient_id=<?php echo $p['id']; ?>" class="btn btn-outline-success btn-sm">Prescribe</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
