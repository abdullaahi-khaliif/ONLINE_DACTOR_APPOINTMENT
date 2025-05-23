<?php
session_start();
include 'config/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hubi in user jiro
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Set session values
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];

        // Redirect according to role
        if ($user['role'] === 'admin') {
            header("Location: admin/dashboard.php");
        } elseif ($user['role'] === 'doctor') {
            header("Location: doctor/dashboard.php");
        } else {
            header("Location: patient/dashboard.php");
        }
        exit();
    } else {
        $error = "Incorrect email or password!";
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container my-5">
  <h2 class="text-center mb-4">Login</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
  <?php endif; ?>

  <form method="POST" class="mx-auto" style="max-width: 500px;">
    <div class="mb-3">
      <label for="email" class="form-label">Email Address</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="text" name="password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Login</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>
