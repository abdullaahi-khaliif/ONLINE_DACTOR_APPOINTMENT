<?php
include '../includes/auth.php';
include '../config/db.php';

$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $specialization = $_POST['specialization'];
    $bio = $_POST['bio'];

    $image = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email already exists!";
    } else {
        if (!empty($image)) {
            move_uploaded_file($tmp, "../uploads/$image");
        }
        $sql_user = "INSERT INTO users (fullname, email, password, role, profile_image)
                     VALUES ('$name', '$email', '$password', 'doctor', '$image')";
        if (mysqli_query($conn, $sql_user)) {
            $user_id = mysqli_insert_id($conn);
            $sql_doc = "INSERT INTO doctors (user_id, specialization, bio)
                        VALUES ($user_id, '$specialization', '$bio')";
            mysqli_query($conn, $sql_doc);
            $success = "Doctor added successfully.";
        } else {
            $error = "Failed to add doctor.";
        }
    }
}

$doctors = mysqli_query($conn, "SELECT * FROM users WHERE role = 'doctor'");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2 p-0">
      <?php include 'sidebar.php'; ?>
    </div>

    <div class="col-md-10 p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Manage Doctors</h2>
        <button class="btn btn-success" data-bs-toggle="collapse" data-bs-target="#addForm">+ Add Doctor</button>
      </div>

      <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

      <div id="addForm" class="collapse mb-4">
        <form method="POST" enctype="multipart/form-data" class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Full Name</label>
            <input type="text" name="fullname" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Password</label>
            <input type="text" name="password" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Profile Photo</label>
            <input type="file" name="photo" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label">Specialization</label>
            <select name="specialization" class="form-control" required>
              <option value="">-- Select Specialization --</option>
              <option value="Anesthesiology">Anesthesiology</option>
              <option value="Cardiology">Cardiology</option>
              <option value="Dermatology">Dermatology</option>
              <option value="Emergency Medicine">Emergency Medicine</option>
              <option value="Endocrinology">Endocrinology</option>
              <option value="Family Medicine">Family Medicine</option>
              <option value="Gastroenterology">Gastroenterology</option>
              <option value="Geriatrics">Geriatrics</option>
              <option value="Hematology">Hematology</option>
              <option value="Infectious Disease">Infectious Disease</option>
              <option value="Internal Medicine">Internal Medicine</option>
              <option value="Nephrology">Nephrology</option>
              <option value="Neurology">Neurology</option>
              <option value="Obstetrics & Gynecology (OB/GYN)">Obstetrics & Gynecology (OB/GYN)</option>
              <option value="Oncology">Oncology</option>
              <option value="Ophthalmology">Ophthalmology</option>
              <option value="Orthopedics">Orthopedics</option>
              <option value="Otolaryngology (ENT)">Otolaryngology (ENT)</option>
              <option value="Pathology">Pathology</option>
              <option value="Pediatrics">Pediatrics</option>
              <option value="Plastic Surgery">Plastic Surgery</option>
              <option value="Psychiatry">Psychiatry</option>
              <option value="Pulmonology">Pulmonology</option>
              <option value="Radiology">Radiology</option>
              <option value="Rheumatology">Rheumatology</option>
              <option value="Urology">Urology</option>
              <option value="Allergy & Immunology">Allergy & Immunology</option>
              <option value="Sports Medicine">Sports Medicine</option>
              <option value="Sleep Medicine">Sleep Medicine</option>
            </select>
          </div>
          <div class="col-md-12">
            <label class="form-label">Doctor Bio</label>
            <textarea name="bio" class="form-control" rows="3"></textarea>
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Add Doctor</button>
          </div>
        </form>
      </div>

      <table class="table table-bordered table-hover">
        <thead class="table-primary">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while ($row = mysqli_fetch_assoc($doctors)): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row['fullname']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
              <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
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
