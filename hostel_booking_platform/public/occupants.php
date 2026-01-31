<?php
require_once "../config/db.php";
include "../includes/header.php";

$result = $conn->query("SELECT * FROM occupants ORDER BY full_name");
?>

<div class="page-actions">
    <h2>👥 Occupants Management</h2>
    <a href="add_occupant.php" class="btn btn-success">➕ Add New Occupant</a>
</div>

<?php if ($result && $result->num_rows > 0): ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><strong><?= htmlspecialchars($row['full_name']) ?></strong></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td>
                    <a href="edit_occupant.php?id=<?= $row['occupant_id'] ?>">✏️ Edit</a> |
                    <a href="delete_occupant.php?id=<?= $row['occupant_id'] ?>"
                       class="delete"
                       onclick="return confirm('Are you sure you want to delete this occupant?')">🗑️ Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="empty-state">
        <div class="icon">👥</div>
        <p>No occupants found</p>
        <a href="add_occupant.php" class="btn btn-success">Add Your First Occupant</a>
    </div>
<?php endif; ?>

<?php include "../includes/footer.php"; ?>
