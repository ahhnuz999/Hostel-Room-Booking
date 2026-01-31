<?php
require_once "../config/db.php";
include "../includes/header.php";

if (!isset($_GET['id'])) {
    header("Location: bookings.php");
    exit;
}

$booking_id = (int) $_GET['id'];

// Fetch booking
$stmt = $conn->prepare("
    SELECT * FROM bookings WHERE booking_id = ?
");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

if (!$booking) {
    echo "<p>Booking not found.</p>";
    include "../includes/footer.php";
    exit;
}

// Fetch rooms & occupants
$rooms = $conn->query("SELECT * FROM rooms");
$occupants = $conn->query("SELECT * FROM occupants");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $room_id = (int)$_POST["room_id"];
    $occupant_id = (int)$_POST["occupant_id"];
    $check_in = $_POST["check_in"];
    $check_out = $_POST["check_out"];

    $update = $conn->prepare("
        UPDATE bookings 
        SET room_id=?, occupant_id=?, check_in=?, check_out=? 
        WHERE booking_id=?
    ");
    $update->bind_param("iissi", $room_id, $occupant_id, $check_in, $check_out, $booking_id);
    $update->execute();

    header("Location: bookings.php");
    exit;
}
?>

<h2>Edit Booking</h2>

<form method="POST">
    <label>Room:</label><br>
    <select name="room_id" required>
        <?php while ($r = $rooms->fetch_assoc()): ?>
            <option value="<?= $r['room_id'] ?>"
                <?= $r['room_id'] == $booking['room_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($r['room_number']) ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Occupant:</label><br>
    <select name="occupant_id" required>
        <?php while ($o = $occupants->fetch_assoc()): ?>
            <option value="<?= $o['occupant_id'] ?>"
                <?= $o['occupant_id'] == $booking['occupant_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($o['full_name']) ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Check-in:</label><br>
    <input type="date" name="check_in"
           value="<?= htmlspecialchars($booking['check_in']) ?>" required><br><br>

    <label>Check-out:</label><br>
    <input type="date" name="check_out"
           value="<?= htmlspecialchars($booking['check_out']) ?>" required><br><br>

    <button type="submit">Update Booking</button>
</form>

<?php include "../includes/footer.php"; ?>
