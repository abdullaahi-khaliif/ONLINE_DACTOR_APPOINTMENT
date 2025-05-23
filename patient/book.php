<?php
include '../includes/auth.php';
include '../config/db.php';

$patient_id = $_SESSION['user_id'];
$doctors = mysqli_query($conn, "SELECT d.id AS doctor_id, u.fullname FROM doctors d JOIN users u ON d.user_id = u.id");

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $schedule_id = $_POST['schedule_id'];
    $note = mysqli_real_escape_string($conn, $_POST['message']);

    $schedule = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM schedules WHERE id = $schedule_id AND is_booked = FALSE"));

    if ($schedule) {
        $insert = "INSERT INTO appointments (doctor_id, patient_id, appointment_date, appointment_time, message, status)
                   VALUES ('$doctor_id', '$patient_id', '{$schedule['schedule_date']}', '{$schedule['start_time']}', '$note', 'pending')";
        if (mysqli_query($conn, $insert)) {
            mysqli_query($conn, "UPDATE schedules SET is_booked = TRUE WHERE id = $schedule_id");
            $message = "Appointment booked successfully.";
        } else {
            $message = "Failed to book.";
        }
    } else {
        $message = "Schedule not available.";
    }
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<script>
function loadSchedules(doctorId) {
  const scheduleSelect = document.getElementById('schedule_id');
  const statusText = document.getElementById('availability_message');
  scheduleSelect.innerHTML = '';
  statusText.textContent = 'Checking availability...';

  fetch('doctor_schedule_action.php?action=get_schedules&doctor_id=' + doctorId)
    .then(res => res.json())
    .then(data => {
      scheduleSelect.innerHTML = '';
      if (data.length > 0) {
        data.forEach(s => {
          const opt = document.createElement('option');
          opt.value = s.id;
          opt.text = `${s.schedule_date} | ${s.start_time} - ${s.end_time}`;
          scheduleSelect.appendChild(opt);
        });
        statusText.textContent = 'Available slots found.';
        statusText.className = 'text-success';
      } else {
        const opt = document.createElement('option');
        opt.value = '';
        opt.text = 'Not Available';
        scheduleSelect.appendChild(opt);
        statusText.textContent = 'Doctor not available at this time.';
        statusText.className = 'text-danger';
      }
    })
    .catch(error => {
      const opt = document.createElement('option');
      opt.text = 'Error loading schedule';
      scheduleSelect.appendChild(opt);
      statusText.textContent = 'Error fetching schedule.';
      statusText.className = 'text-danger';
    });
}
</script>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 p-0">
      <?php include 'patient_sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="col-md-10 p-4">
      <h2>Book Appointment</h2>
      <?php if ($message): ?><div class="alert alert-info"><?php echo $message; ?></div><?php endif; ?>

      <form method="POST" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Select Doctor</label>
          <select name="doctor_id" class="form-control" onchange="loadSchedules(this.value)" required>
            <option value="">-- Choose Doctor --</option>
            <?php while ($d = mysqli_fetch_assoc($doctors)): ?>
            <option value="<?php echo $d['doctor_id']; ?>"><?php echo $d['fullname']; ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">Available Schedule</label>
          <select name="schedule_id" id="schedule_id" class="form-control" required>
            <option value="">Select doctor first</option>
          </select>
          <div id="availability_message" class="form-text mt-1 text-muted">Please select a doctor to view availability.</div>
        </div>

        <div class="col-md-12">
          <label class="form-label">Message (Optional)</label>
          <textarea name="message" class="form-control" rows="3" placeholder="Write your symptoms or reason..."></textarea>
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-success">Book Now</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
