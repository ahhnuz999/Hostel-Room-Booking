<?php
require_once "../config/db.php";

if (!isset($_GET['id'])) die("ID missing");

$id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM occupants WHERE occupant_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: occupants.php");
exit;
