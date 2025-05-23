<?php
include '../includes/auth.php';
include '../config/db.php';

$doctor_id = $_SESSION['user_id'];
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $image = $_FILES['profile_image']['name'];
    $tmp_name = $_FILES['profile_image']['tmp_name'];

    $sql = "UPDATE users SET fullname = '$fullname', email = '$email'";
    if (!empty($password)) {
        $sql .= ", password = '$password'";
    }
    if (!empty($image)) {
        move_uploaded_file($tmp_name, "../uploads/$image");
        $sql .= ", profile_image = '$image'";
    }
    $sql .= " WHERE id = $doctor_id";

    if (mysqli_query($conn, $sql)) {
        $success = "Profile updated successfully.";
    } else {
        $error = "Failed to update profile.";
    }
}

$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $doctor_id"));
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container my-5">
  <h2>My Profile</h2>

  <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="fullname" class="form-control" value="<?php echo $user['fullname']; ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">New Password (optional)</label>
      <input type="text" name="password" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Profile Image</label>
      <input type="file" name="profile_image" class="form-control">
      <?php if ($user['profile_image']): ?>
        <img src="../uploads/<?php echo $user['profile_image']; ?>" width="100" class="mt-2">
      <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Update Profile</button>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
