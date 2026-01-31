<?php
require_once "../config/db.php";
include "../includes/header.php";

if (!isset($_GET['id'])) die("ID missing");

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM occupants WHERE occupant_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$occupant = $stmt->get_result()->fetch_assoc();

if (!$occupant) die("Occupant not found");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name  = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);

    $update = $conn->prepare(
        "UPDATE occupants SET full_name=?, email=?, phone=? WHERE occupant_id=?"
    );
    $update->bind_param("sssi", $name, $email, $phone, $id);
    $update->execute();

    header("Location: occupants.php");
    exit;
}
?>

<h2>Edit Occupant</h2>

<form method="POST">
    <input type="text" name="full_name"
           value="<?= htmlspecialchars($occupant['full_name']) ?>" required><br><br>

    <input type="email" name="email"
           value="<?= htmlspecialchars($occupant['email']) ?>"><br><br>

    <input type="text" name="phone"
           value="<?= htmlspecialchars($occupant['phone']) ?>"><br><br>

    <button type="submit">Update</button>
</form>

<?php include "../includes/footer.php"; ?>
<?php
require_once "../config/db.php";
include "../includes/header.php";

if (!isset($_GET['id'])) die("ID missing");

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM occupants WHERE occupant_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$occupant = $stmt->get_result()->fetch_assoc();

if (!$occupant) die("Occupant not found");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name  = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);

    $update = $conn->prepare(
        "UPDATE occupants SET full_name=?, email=?, phone=? WHERE occupant_id=?"
    );
    $update->bind_param("sssi", $name, $email, $phone, $id);
    $update->execute();

    header("Location: occupants.php");
    exit;
}
?>

<h2>Edit Occupant</h2>

<form method="POST">
    <input type="text" name="full_name"
           value="<?= htmlspecialchars($occupant['full_name']) ?>" required><br><br>

    <input type="email" name="email"
           value="<?= htmlspecialchars($occupant['email']) ?>"><br><br>

    <input type="text" name="phone"
           value="<?= htmlspecialchars($occupant['phone']) ?>"><br><br>

    <button type="submit">Update</button>
</form>

<?php include "../includes/footer.php"; ?>
