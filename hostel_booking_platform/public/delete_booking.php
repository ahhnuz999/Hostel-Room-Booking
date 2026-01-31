<?php
require_once "../config/db.php";

if (!isset($_GET['id'])) {
    header("Location: bookings.php");
    exit;
}

$booking_id = (int) $_GET['id'];

$stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();

header("Location: bookings.php");
exit;
