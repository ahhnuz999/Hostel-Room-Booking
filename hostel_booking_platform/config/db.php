<?php
$host = "localhost";
$user = "root";        // default XAMPP user
$password = "";        // default XAMPP password
$database = "hostel_booking";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed");
}
?>
