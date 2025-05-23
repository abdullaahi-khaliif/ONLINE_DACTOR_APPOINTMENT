<?php
include '../includes/auth.php';
include '../config/db.php';

$patients = mysqli_query($conn, "SELECT * FROM users WHERE role = 'patient'");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 p-0">
      <?php include 'sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="col-md-10 p-4">
      <h2 class="mb-4">Manage Patients</h2>
      <table class="table table-bordered table-hover">
        <thead class="table-success">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while ($row = mysqli_fetch_assoc($patients)): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row['fullname']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
              <a href="edit_patient.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
              <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirm delete?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
