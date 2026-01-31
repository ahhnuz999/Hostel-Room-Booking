<?php
require_once "../config/db.php";

if (!isset($_GET['id'])) {
    die("Room ID missing");
}

$room_id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM rooms WHERE room_id = ?");
$stmt->bind_param("i", $room_id);
$stmt->execute();

header("Location: rooms.php");
exit;
