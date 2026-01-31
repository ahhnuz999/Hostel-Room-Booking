<?php
require_once "../config/db.php";
include "../includes/header.php";

if (!isset($_GET['id'])) {
    header("Location: rooms.php");
    exit;
}

$room_id = (int)$_GET['id'];
$error = "";

// Fetch existing room
$stmt = $conn->prepare("SELECT * FROM rooms WHERE room_id = ?");
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();
$room = $result->fetch_assoc();

if (!$room) {
    header("Location: rooms.php");
    exit;
}

// Update logic
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $room_number = trim($_POST["room_number"]);
    $room_type   = trim($_POST["room_type"]);
    $capacity    = (int)$_POST["capacity"];
    $price       = (float)$_POST["price"];
    $status      = $_POST["status"];

    $update = $conn->prepare(
        "UPDATE rooms 
         SET room_number=?, room_type=?, capacity=?, price=?, status=? 
         WHERE room_id=?"
    );
    $update->bind_param(
        "ssidsi",
        $room_number,
        $room_type,
        $capacity,
        $price,
        $status,
        $room_id
    );
    
    if ($update->execute()) {
        header("Location: rooms.php");
        exit;
    } else {
        $error = "Failed to update room. Please try again.";
    }
}
?>

<h2>✏️ Edit Room</h2>

<?php if ($error): ?>
    <div class="message error">⚠️ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="form-container">
    <form method="POST">
        <div class="form-group">
            <label>Room Number: *</label>
            <input type="text" name="room_number" 
                   value="<?= htmlspecialchars($room['room_number']) ?>" required>
        </div>

        <div class="form-group">
            <label>Room Type: *</label>
            <select name="room_type" required>
                <option value="Single" <?= $room['room_type']=='Single'?'selected':'' ?>>Single</option>
                <option value="Double" <?= $room['room_type']=='Double'?'selected':'' ?>>Double</option>
                <option value="Triple" <?= $room['room_type']=='Triple'?'selected':'' ?>>Triple</option>
                <option value="Dorm" <?= $room['room_type']=='Dorm'?'selected':'' ?>>Dorm</option>
                <option value="Suite" <?= $room['room_type']=='Suite'?'selected':'' ?>>Suite</option>
            </select>
        </div>

        <div class="form-group">
            <label>Capacity: *</label>
            <input type="number" name="capacity" min="1" max="10"
                   value="<?= htmlspecialchars($room['capacity']) ?>" required>
        </div>

        <div class="form-group">
            <label>Price per Night: *</label>
            <input type="number" name="price" step="0.01" min="0"
                   value="<?= htmlspecialchars($room['price']) ?>" required>
        </div>

        <div class="form-group">
            <label>Status: *</label>
            <select name="status">
                <option value="available" <?= $room['status']=='available'?'selected':'' ?>>Available</option>
                <option value="maintenance" <?= $room['status']=='maintenance'?'selected':'' ?>>Maintenance</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">💾 Update Room</button>
            <a href="rooms.php" class="btn btn-secondary">❌ Cancel</a>
        </div>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
