<?php
include '../includes/auth.php';
include '../config/db.php';

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if ($role === 'doctor') {
    $doctor_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM doctors WHERE user_id = $user_id"));
    $doctor_id = $doctor_row['id'];
} elseif ($role === 'admin') {
    $doctor_id = $_POST['doctor_id'] ?? null;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['schedule_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $selected_doctor_id = $role === 'admin' ? $_POST['doctor_id'] : $doctor_id;

    if ($selected_doctor_id && strtotime($date) >= strtotime(date('Y-m-d'))) {
        $insert = "INSERT INTO schedules (doctor_id, schedule_date, start_time, end_time)
                   VALUES ('$selected_doctor_id', '$date', '$start_time', '$end_time')";
        if (mysqli_query($conn, $insert)) {
            $success = "Schedule added successfully.";
        } else {
            $error = "Failed to add schedule.";
        }
    } else {
        $error = "Invalid input.";
    }
}

$doctors = mysqli_query($conn, "SELECT d.id, u.fullname FROM doctors d JOIN users u ON d.user_id = u.id");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<script>
function showDoctorName(selectElement) {
  const selectedText = selectElement.options[selectElement.selectedIndex].text;
  const output = document.getElementById("selected-doctor-name");
  output.innerText = selectedText ? "Selected Doctor: " + selectedText : "";
}
</script>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 p-0">
      <?php include 'sidebar.php'; ?>
    </div>

    <!-- Main content -->
    <div class="col-md-10 p-4">
      <h2 class="mb-4">Add Doctor Schedule</h2>

      <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

      <form method="POST" class="row g-3">
        <?php if ($role === 'admin'): ?>
        <div class="col-md-4">
          <label class="form-label">Select Doctor</label>
          <select name="doctor_id" class="form-control" onchange="showDoctorName(this)" required>
            <option value="">-- Choose Doctor --</option>
            <?php while ($doc = mysqli_fetch_assoc($doctors)): ?>
            <option value="<?php echo $doc['id']; ?>"><?php echo $doc['fullname']; ?></option>
            <?php endwhile; ?>
          </select>
          <div class="form-text text-primary fw-semibold mt-2" id="selected-doctor-name"></div>
        </div>
        <?php endif; ?>

        <div class="col-md-4">
          <label class="form-label">Date</label>
          <input type="date" name="schedule_date" class="form-control" required>
        </div>
        <div class="col-md-2">
          <label class="form-label">Start Time</label>
          <input type="time" name="start_time" class="form-control" required>
        </div>
        <div class="col-md-2">
          <label class="form-label">End Time</label>
          <input type="time" name="end_time" class="form-control" required>
        </div>
        <div class="col-md-12">
          <button type="submit" class="btn btn-primary">Add Schedule</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
