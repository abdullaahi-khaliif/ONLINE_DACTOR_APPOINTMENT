<?php
include '../config/db.php';
session_start();

if (isset($_GET['action']) && $_GET['action'] === 'get_schedules') {
    $doctor_id = intval($_GET['doctor_id']);

    // Jadwalada la heli karo: aan la book gareyn + taariikhda maanta ama ka dambeeya
    $query = "SELECT id, schedule_date, start_time, end_time 
              FROM schedules 
              WHERE doctor_id = $doctor_id 
              AND is_booked = 0 
              AND schedule_date >= CURDATE()
              ORDER BY schedule_date, start_time";

    $result = mysqli_query($conn, $query);

    $schedules = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $schedules[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($schedules);
    exit;
}
?>
