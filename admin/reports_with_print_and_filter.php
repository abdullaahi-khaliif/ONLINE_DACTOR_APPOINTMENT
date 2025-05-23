<?php
include '../includes/auth.php';
include '../config/db.php';

$search = $_GET['search'] ?? '';
$search_sql = $search ? "AND (u.fullname LIKE '%$search%' OR d.fullname LIKE '%$search%')" : "";

$appointments = mysqli_query($conn, "SELECT a.*, u.fullname AS patient_name, d.fullname AS doctor_name 
                                     FROM appointments a
                                     JOIN users u ON a.patient_id = u.id
                                     JOIN users d ON a.doctor_id = d.id
                                     WHERE 1=1 $search_sql
                                     ORDER BY a.appointment_date DESC");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<style>
@media print {
  body * {
    visibility: hidden;
  }
  #printArea, #printArea * {
    visibility: visible;
  }
  #printArea {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
  }
}
</style>

<script>
function printReport() {
  window.print();
}
</script>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-2 p-0">
      <?php include 'sidebar.php'; ?>
    </div>

    <div class="col-md-10 p-4">
      <h2 class="mb-4">Reports - All Appointments</h2>

      <form method="GET" class="mb-3 d-flex justify-content-between flex-wrap no-print">
        <div class="input-group mb-2 me-2">
          <input type="text" name="search" class="form-control" placeholder="Search by doctor or patient..." value="<?php echo htmlspecialchars($search); ?>">
          <button type="submit" class="btn btn-primary">Filter</button>
        </div>
        <div class="btn-group mb-2">
          <button type="button" class="btn btn-secondary" onclick="printReport()">🖨 Print Report</button>
          <a href="export_appointments_csv.php" class="btn btn-outline-success">📥 Export CSV</a>
          <a href="export_appointments_excel.php" class="btn btn-outline-primary">📊 Export Excel</a>
        </div>
      </form>

      <div id="printArea">
        <table class="table table-bordered table-striped table-hover">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Patient</th>
              <th>Doctor</th>
              <th>Date</th>
              <th>Time</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; while ($r = mysqli_fetch_assoc($appointments)): ?>
              <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $r['patient_name']; ?></td>
                <td><?php echo $r['doctor_name']; ?></td>
                <td><?php echo $r['appointment_date']; ?></td>
                <td><?php echo $r['appointment_time']; ?></td>
                <td><?php echo ucfirst($r['status']); ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
