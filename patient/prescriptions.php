<?php
include '../includes/auth.php';
include '../config/db.php';

$patient_id = $_SESSION['user_id'];

$query = "SELECT p.*, u.fullname AS doctor_name
          FROM prescriptions p
          JOIN users u ON p.doctor_id = u.id
          WHERE p.patient_id = $patient_id
          ORDER BY p.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container-fluid">
  <div class="row">
    <!-- Patient Sidebar -->
    <div class="col-md-2 p-0">
      <?php include 'patient_sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="col-md-10 p-4">
      <h2 class="mb-4">My Prescriptions</h2>

      <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Doctor</th>
            <th>Date</th>
            <th>Prescription</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($result) > 0):
            $i = 1;
            while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
              <td><?php echo date("Y-m-d", strtotime($row['created_at'])); ?></td>
              <td><?php echo nl2br(htmlspecialchars($row['content'])); ?></td>
            </tr>
          <?php endwhile; else: ?>
            <tr><td colspan="4" class="text-center">No prescriptions found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
