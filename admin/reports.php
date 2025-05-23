<?php
include '../includes/auth.php';
include '../config/db.php';

$appointments = mysqli_query($conn, "SELECT a.*, u.fullname AS patient_name, d.fullname AS doctor_name 
                                     FROM appointments a
                                     JOIN users u ON a.patient_id = u.id
                                     JOIN users d ON a.doctor_id = d.id
                                     ORDER BY a.appointment_date DESC");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container my-5">
  <h2>Reports - All Appointments</h2>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Patient</th>
        <th>Doctor</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; while ($r = mysqli_fetch_assoc($appointments)): ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php echo $r['patient_name']; ?></td>
          <td><?php echo $r['doctor_name']; ?></td>
          <td><?php echo $r['appointment_date']; ?></td>
          <td><?php echo $r['appointment_time']; ?></td>
          <td><?php echo ucfirst($r['status']); ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
