<?php
include '../includes/auth.php';
include '../config/db.php';

$doctor_id = $_SESSION['user_id'];
$patient_id = $_GET['patient_id'] ?? null;
$appointment_id = $_GET['appointment_id'] ?? 'NULL'; // optional

$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];

    $sql = "INSERT INTO prescriptions (appointment_id, doctor_id, patient_id, content)
            VALUES ($appointment_id, $doctor_id, $patient_id, '$content')";
    if (mysqli_query($conn, $sql)) {
        $success = "Prescription submitted successfully.";
    }
}

// fetch patient name
$p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT fullname FROM users WHERE id = $patient_id"));
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container my-5">
  <h2 class="mb-4">Write Prescription for <?php echo $p['fullname']; ?></h2>

  <?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Prescription Details</label>
      <textarea name="content" class="form-control" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
