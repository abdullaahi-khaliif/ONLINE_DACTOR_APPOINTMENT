<?php
include '../includes/auth.php';
include '../config/db.php';

$id = $_GET['id'] ?? 0;
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $id"));

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $profile_image = $_FILES['profile_image']['name'];
    $tmp = $_FILES['profile_image']['tmp_name'];

    if (!empty($profile_image)) {
        move_uploaded_file($tmp, "../uploads/$profile_image");
    } else {
        $profile_image = $user['profile_image']; // Keep old image
    }

    $update = "UPDATE users SET fullname = '$fullname', email = '$email', password = '$password', profile_image = '$profile_image' WHERE id = $id";
    if (mysqli_query($conn, $update)) {
        $success = "User updated successfully.";
        $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $id")); // Refresh data
    } else {
        $error = "Failed to update user.";
    }
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 p-0">
      <?php include 'sidebar.php'; ?>
    </div>

    <!-- Main content -->
    <div class="col-md-10 p-4">
      <h2 class="mb-4">Edit User</h2>

      <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

      <form method="POST" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Full Name</label>
          <input type="text" name="fullname" class="form-control" value="<?php echo $user['fullname']; ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Password</label>
          <input type="text" name="password" class="form-control" value="<?php echo $user['password']; ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Profile Image</label>
          <input type="file" name="profile_image" class="form-control">
          <?php if ($user['profile_image']): ?>
            <img src="../uploads/<?php echo $user['profile_image']; ?>" class="img-thumbnail mt-2" width="100">
          <?php endif; ?>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Update User</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include '../includes/footer.php'; ?>
