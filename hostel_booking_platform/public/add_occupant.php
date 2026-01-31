<?php
require_once "../config/db.php";
include "../includes/header.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name  = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);

    if ($name) {
        $stmt = $conn->prepare(
            "INSERT INTO occupants (full_name, email, phone) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $name, $email, $phone);
        
        if ($stmt->execute()) {
            header("Location: occupants.php");
            exit;
        } else {
            $error = "Failed to add occupant. Please try again.";
        }
    } else {
        $error = "Full name is required.";
    }
}
?>

<h2>➕ Add New Occupant</h2>

<?php if ($error): ?>
    <div class="message error">⚠️ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="form-container">
    <form method="POST">
        <div class="form-group">
            <label>Full Name: *</label>
            <input type="text" name="full_name" placeholder="Enter full name" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" placeholder="email@example.com">
        </div>

        <div class="form-group">
            <label>Phone:</label>
            <input type="tel" name="phone" placeholder="+1 234 567 8900">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">💾 Add Occupant</button>
            <a href="occupants.php" class="btn btn-secondary">❌ Cancel</a>
        </div>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
