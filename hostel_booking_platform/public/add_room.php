<?php
require_once "../config/db.php";
include "../includes/header.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $room_number = trim($_POST["room_number"]);
    $room_type   = trim($_POST["room_type"]);
    $capacity    = (int)$_POST["capacity"];
    $price       = (float)$_POST["price"];

    if ($room_number && $room_type && $capacity > 0) {
        $stmt = $conn->prepare(
            "INSERT INTO rooms (room_number, room_type, capacity, price) 
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssid", $room_number, $room_type, $capacity, $price);
        
        if ($stmt->execute()) {
            header("Location: rooms.php");
            exit;
        } else {
            $error = "Failed to add room. Please try again.";
        }
    } else {
        $error = "Please fill in all required fields with valid values.";
    }
}
?>

<h2>➕ Add New Room</h2>

<?php if ($error): ?>
    <div class="message error">⚠️ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="form-container">
    <form method="POST">
        <div class="form-group">
            <label>Room Number: *</label>
            <input type="text" name="room_number" placeholder="e.g., A101" required>
        </div>

        <div class="form-group">
            <label>Room Type: *</label>
            <select name="room_type" required>
                <option value="">Select Room Type</option>
                <option value="Single">Single</option>
                <option value="Double">Double</option>
                <option value="Triple">Triple</option>
                <option value="Dorm">Dorm</option>
                <option value="Suite">Suite</option>
            </select>
        </div>

        <div class="form-group">
            <label>Capacity: *</label>
            <input type="number" name="capacity" min="1" max="10" placeholder="Number of persons" required>
        </div>

        <div class="form-group">
            <label>Price per Night: *</label>
            <input type="number" name="price" step="0.01" min="0" placeholder="e.g., 1500.00" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">💾 Add Room</button>
            <a href="rooms.php" class="btn btn-secondary">❌ Cancel</a>
        </div>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
