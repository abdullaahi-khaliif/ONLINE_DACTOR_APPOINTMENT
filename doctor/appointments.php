<?php
include '../includes/auth.php';
include '../config/db.php';

$doctor_id = $_SESSION['user_id'];

$query = "SELECT a.*, u.fullname AS patient_name
          FROM appointments a
          JOIN users u ON a.patient_id = u.id
          WHERE a.doctor_id = $doctor_id
          ORDER BY a.appointment_date DESC";

$result = mysqli_query($conn, $query);
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>


<div class="container my-5">
  <h2>My Appointments</h2>
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Patient</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $row['patient_name']; ?></td>
        <td><?php echo $row['appointment_date']; ?></td>
        <td><?php echo $row['appointment_time']; ?></td>
        <td><?php echo ucfirst($row['status']); ?></td>
        <td>
          <?php if ($row['status'] == 'pending'): ?>
            <a href="appointments.php?confirm=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">Confirm</a>
            <a href="appointments.php?cancel=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Cancel</a>
          <?php else: ?>
            <span class="text-muted">No Actions</span>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php
// Action handling
if (isset($_GET['confirm'])) {
    $id = $_GET['confirm'];
    mysqli_query($conn, "UPDATE appointments SET status = 'confirmed' WHERE id = $id");
    header("Location: appointments.php");
    exit;
}
if (isset($_GET['cancel'])) {
    $id = $_GET['cancel'];
    mysqli_query($conn, "UPDATE appointments SET status = 'cancelled' WHERE id = $id");
    header("Location: appointments.php");
    exit;
}
?>

<?php include '../includes/footer.php'; ?>
