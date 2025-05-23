<?php
// Include database connection
include 'config/db.php';

// Handle form submission
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password']; // NOT hashed (sidaad sheegtay)
    $image = $_FILES['profile_image']['name'];
    $tmp_name = $_FILES['profile_image']['tmp_name'];
    $target_dir = "uploads/";
    $role = "patient";

    // Save image
    if (!is_dir($target_dir)) {
        mkdir($target_dir);
    }
    move_uploaded_file($tmp_name, $target_dir . $image);

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email already exists!";
    } else {
        $sql = "INSERT INTO users (fullname, email, password, profile_image, role) 
                VALUES ('$fullname', '$email', '$password', '$image', '$role')";
        if (mysqli_query($conn, $sql)) {
            $success = "Registered successfully! You can now <a href='login.php'>Login</a>.";
        } else {
            $error = "Registration failed: " . mysqli_error($conn);
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container my-5">
  <h2 class="text-center mb-4">Patient Registration</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
  <?php elseif ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 600px;">
    <div class="mb-3">
      <label for="fullname" class="form-label">Full Name</label>
      <input type="text" class="form-control" name="fullname" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email Address</label>
      <input type="email" class="form-control" name="email" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="text" class="form-control" name="password" required>
    </div>

    <div class="mb-3">
      <label for="profile_image" class="form-label">Profile Picture</label>
      <input type="file" class="form-control" name="profile_image" accept="image/*" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Register</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>
