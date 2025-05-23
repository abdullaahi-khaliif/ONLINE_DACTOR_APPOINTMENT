<?php
include '../includes/auth.php';
include '../config/db.php';

$user_id = $_SESSION['user_id'];

// Fetch all appointments of this patient
$sql = "SELECT a.*, u.fullname AS doctor_name
        FROM appointments a
        JOIN users u ON a.doctor_id = u.id
        WHERE a.patient_id = $user_id
        ORDER BY a.appointment_date DESC, a.appointment_time DESC";

$result = mysqli_query($conn, $sql);
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
      <h2 class="mb-4">My Appointments</h2>

      <table class="table table-bordered table-hover table-striped">
        <thead class="table-primary">
          <tr>
            <th>#</th>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Message</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($result) > 0): 
            $i = 1;
            while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
              <td><?php echo $row['appointment_date']; ?></td>
              <td><?php echo $row['appointment_time']; ?></td>
              <td>
                <span class="badge bg-<?php
                  switch ($row['status']) {
                    case 'pending': echo 'warning'; break;
                    case 'confirmed': echo 'success'; break;
                    case 'completed': echo 'info'; break;
                    case 'cancelled': echo 'danger'; break;
                  }
                ?>">
                  <?php echo ucfirst($row['status']); ?>
                </span>
              </td>
              <td><?php echo $row['message']; ?></td>
              <td>
                <?php if ($row['status'] === 'pending'): ?>
                  <a href="reschedule.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Reschedule</a>
                  <a href="cancel.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure to cancel this appointment?');">Cancel</a>
                <?php else: ?>
                  <em>N/A</em>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; else: ?>
            <tr><td colspan="7" class="text-center">No appointments found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
