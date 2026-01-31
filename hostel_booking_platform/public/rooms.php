<?php
require_once "../config/db.php";
include "../includes/header.php";

$result = $conn->query("SELECT * FROM rooms ORDER BY room_number");
?>

<div class="page-actions">
    <h2>🚪 Rooms Management</h2>
    <a href="add_room.php" class="btn btn-success">➕ Add New Room</a>
</div>

<?php if ($result && $result->num_rows > 0): ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Type</th>
                    <th>Capacity</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($row['room_number']) ?></strong></td>
                    <td><?= htmlspecialchars($row['room_type']) ?></td>
                    <td><?= htmlspecialchars($row['capacity']) ?> persons</td>
                    <td>₹<?= number_format($row['price'], 2) ?></td>
                    <td>
                        <span style="padding: 5px 10px; border-radius: 4px; font-weight: 500; 
                              background: <?= $row['status'] == 'available' ? '#d4edda' : '#f8d7da' ?>; 
                              color: <?= $row['status'] == 'available' ? '#155724' : '#721c24' ?>;">
                            <?= ucfirst(htmlspecialchars($row['status'])) ?>
                        </span>
                    </td>
                    <td>
                        <a href="edit_room.php?id=<?= $row['room_id'] ?>">✏️ Edit</a> |
                        <a href="delete_room.php?id=<?= $row['room_id'] ?>" 
                           class="delete"
                           onclick="return confirm('Are you sure you want to delete this room?')">🗑️ Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="empty-state">
        <div class="icon">🚪</div>
        <p>No rooms found</p>
        <a href="add_room.php" class="btn btn-success">Add Your First Room</a>
    </div>
<?php endif; ?>

<?php include "../includes/footer.php"; ?>
