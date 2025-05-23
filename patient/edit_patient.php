<?php
include '../includes/auth.php';
include '../config/db.php';

// Hubi in user-ka yahay patient
if ($_SESSION['role'] !== 'patient') {
    header("Location: unauthorized.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$patient = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id AND role = 'patient'"));

if (!$patient) {
    echo "<div class='alert alert-danger m-4'>Patient not found.</div>";
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Optional: use password_hash()
    
    $profile_image = $_FILES['profile_image']['name'];
    $tmp = $_FILES['profile_image']['tmp_name'];

    if (!empty($profile_image)) {
        move_uploaded_file($tmp, "../uploads/$profile_image");
    } else {
        $profile_image = $patient['profile_image'];
    }

    $update = "UPDATE users 
               SET fullname = '$fullname', email = '$email', password = '$password', profile_image = '$profile_image' 
               WHERE id = $user_id";

    if (mysqli_query($conn, $update)) {
        $success = "Profile updated successfully.";
        $patient = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id"));
    } else {
        $error = "Failed to update profile.";
    }
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container my-5">
  <h2 class="mb-4">Edit My Profile</h2>

  <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

  <form method="POST" enctype="multipart/form-data" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Full Name</label>
      <input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($patient['fullname']); ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($patient['email']); ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Password</label>
      <input type="text" name="password" class="form-control" value="<?php echo htmlspecialchars($patient['password']); ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Profile Image</label>
      <input type="file" name="profile_image" class="form-control">
      <?php if ($patient['profile_image']): ?>
        <img src="../uploads/<?php echo $patient['profile_image']; ?>" class="img-thumbnail mt-2" width="100">
      <?php endif; ?>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Update Profile</button>
    </div>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
