<?php
include '../includes/auth.php';
include '../config/db.php';

$patient_id = $_SESSION['user_id'];

// Message sending
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $doctor_id = $_POST['doctor_id'];
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ($patient_id, $doctor_id, '$msg')";
    mysqli_query($conn, $sql);
}

// Doctors list
$doctors = mysqli_query($conn, "SELECT * FROM users WHERE role = 'doctor'");

// All messages related to this patient
$messages = mysqli_query($conn, "
    SELECT m.*, 
           s.fullname AS sender_name, 
           r.fullname AS receiver_name 
    FROM messages m
    JOIN users s ON m.sender_id = s.id
    JOIN users r ON m.receiver_id = r.id
    WHERE m.sender_id = $patient_id OR m.receiver_id = $patient_id
    ORDER BY m.sent_at DESC
");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 p-0">
      <?php include 'patient_sidebar.php'; ?>
    </div>

    <!-- Main content -->
    <div class="col-md-10 p-4">
      <h2 class="mb-4">Messages</h2>

      <form method="POST" class="mb-4">
        <div class="mb-3">
          <label class="form-label">Select Doctor</label>
          <select name="doctor_id" class="form-control" required>
            <option value="">Choose...</option>
            <?php while ($d = mysqli_fetch_assoc($doctors)): ?>
              <option value="<?php echo $d['id']; ?>"><?php echo $d['fullname']; ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Your Message</label>
          <textarea name="message" class="form-control" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Send</button>
      </form>

      <h4>Message History</h4>
      <ul class="list-group">
        <?php while ($m = mysqli_fetch_assoc($messages)): ?>
          <li class="list-group-item">
            <strong>
              <?php echo $m['sender_id'] == $patient_id ? "You" : "Dr. {$m['sender_name']}"; ?>:
            </strong>
            <?php echo htmlspecialchars($m['message']); ?>
            <br><small class="text-muted"><?php echo $m['sent_at']; ?></small>
          </li>
        <?php endwhile; ?>
      </ul>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
