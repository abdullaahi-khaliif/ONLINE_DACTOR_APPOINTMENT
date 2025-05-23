<?php
$host = "localhost";
$user = "root";         // default user for XAMPP
$password = "";         // default password for XAMPP is empty
$database = "doctor_appointment";  // magaca database-kaaga

// Xiriirka database
$conn = mysqli_connect($host, $user, $password, $database);

// Haddii xiriirka fashilmo
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
