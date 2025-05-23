<?php
include '../includes/auth.php';
include '../config/db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $cancel = "UPDATE appointments SET status = 'cancelled' WHERE id = $id";
    if (mysqli_query($conn, $cancel)) {
        header("Location: appointments.php");
        exit();
    } else {
        echo "Error cancelling appointment.";
    }
}
?>