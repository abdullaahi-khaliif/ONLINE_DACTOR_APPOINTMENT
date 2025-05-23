<?php
include '../includes/auth.php';
include '../config/db.php';

$prescription_id = $_GET['id'] ?? null;

$query = "SELECT p.*, 
                 d.fullname AS doctor_name, 
                 pat.fullname AS patient_name 
          FROM prescriptions p
          JOIN users d ON p.doctor_id = d.id
          JOIN users pat ON p.patient_id = pat.id
          WHERE p.id = $prescription_id";

$result = mysqli_query($conn, $query);
$prescription = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Prescription Print</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: 'Arial', sans-serif; margin: 40px; }
    .prescription-box { border: 1px solid #ccc; padding: 30px; }
    .header { text-align: center; margin-bottom: 30px; }
    .footer { margin-top: 30px; font-size: 0.9em; color: #666; text-align: center; }
    @media print {
      .no-print { display: none; }
    }
  </style>
</head>
<body>

<div class="prescription-box">
  <div class="header">
    <h2>Mubaarak Hospital</h2>
    <p><strong>Doctor:</strong> <?php echo $prescription['doctor_name']; ?></p>
    <p><strong>Patient:</strong> <?php echo $prescription['patient_name']; ?></p>
    <p><strong>Date:</strong> <?php echo date("Y-m-d", strtotime($prescription['created_at'])); ?></p>
  </div>

  <hr>

  <div>
    <h4>Prescription</h4>
    <p><?php echo nl2br(htmlspecialchars($prescription['content'])); ?></p>
  </div>

  <div class="footer">
    <p>Thank you for using Mubaarak Hospital Services</p>
  </div>
</div>

<div class="text-center mt-4 no-print">
  <button onclick="window.print();" class="btn btn-primary">Print Prescription</button>
  <a href="prescriptions.php" class="btn btn-secondary">Back</a>
</div>

</body>
</html>
