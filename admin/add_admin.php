<?php
include '../includes/auth.php';
include '../config/db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email already exists!";
    } else {
        $sql = "INSERT INTO users (fullname, email, password, role)
                VALUES ('$name', '$email', '$password', 'admin')";
        if (mysqli_query($conn, $sql)) {
            $success = "Admin added successfully.";
        } else {
            $error = "Failed to add admin.";
        }
    }
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2 p-0">
      <?php include 'sidebar.php'; ?>
    </div>
    <div class="col-md-10 p-4">
      <h2 class="mb-4">Add New Admin</h2>

      <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input type="text" name="fullname" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="text" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Admin</button>
      </form>
    </div>
  </div>
</div>
<?php include '../includes/footer.php'; ?>
