<?php
require_once "../config/db.php";
include "../includes/header.php";

// Fetch rooms & occupants
$rooms = $conn->query("SELECT * FROM rooms WHERE status='available' ORDER BY room_number");
$occupants = $conn->query("SELECT * FROM occupants ORDER BY full_name");

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $room_id = (int)$_POST["room_id"];
    $occupant_id = (int)$_POST["occupant_id"];
    $check_in = $_POST["check_in"];
    $check_out = $_POST["check_out"];

    // Availability check
    $check = $conn->prepare(
        "SELECT * FROM bookings
         WHERE room_id = ?
         AND check_in < ?
         AND check_out > ?"
    );
    $check->bind_param("iss", $room_id, $check_out, $check_in);
    $check->execute();
    $conflict = $check->get_result();

    if ($conflict->num_rows > 0) {
        $error = "Room is not available for the selected dates. Please choose different dates.";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO bookings (room_id, occupant_id, check_in, check_out)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("iiss", $room_id, $occupant_id, $check_in, $check_out);
        
        if ($stmt->execute()) {
            header("Location: bookings.php");
            exit;
        } else {
            $error = "Failed to create booking. Please try again.";
        }
    }
}
?>

<h2>➕ Create New Booking</h2>

<?php if ($error): ?>
    <div class="message error">⚠️ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="form-container">
    <form method="POST">
        <div class="form-group">
            <label>Select Room: *</label>
            <select name="room_id" required>
                <option value="">Choose an available room</option>
                <?php while ($r = $rooms->fetch_assoc()): ?>
                    <option value="<?= $r['room_id'] ?>">
                        <?= htmlspecialchars($r['room_number']) ?> - 
                        <?= htmlspecialchars($r['room_type']) ?> 
                        (₹<?= number_format($r['price'], 2) ?>/night)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Select Occupant: *</label>
            <select name="occupant_id" required>
                <option value="">Choose an occupant</option>
                <?php while ($o = $occupants->fetch_assoc()): ?>
                    <option value="<?= $o['occupant_id'] ?>">
                        <?= htmlspecialchars($o['full_name']) ?> 
                        (<?= htmlspecialchars($o['email']) ?>)
                    </option>
                <?php endwhile; ?>
            </select>
            <small>Don't see the occupant? <a href="add_occupant.php">Add new occupant</a></small>
        </div>

        <div class="form-group">
            <label>Check-in Date: *</label>
            <input type="date" name="check_in" min="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="form-group">
            <label>Check-out Date: *</label>
            <input type="date" name="check_out" min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">📅 Create Booking</button>
            <a href="bookings.php" class="btn btn-secondary">❌ Cancel</a>
        </div>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
