<?php
require_once "../config/db.php";
include "../includes/header.php";

$search = "";
$query = "
    SELECT 
        b.booking_id,
        r.room_number,
        r.room_type,
        o.full_name,
        b.check_in,
        b.check_out
    FROM bookings b
    JOIN rooms r ON b.room_id = r.room_id
    JOIN occupants o ON b.occupant_id = o.occupant_id
";

// Apply search filter if provided
if (isset($_GET['search']) && trim($_GET['search']) !== "") {
    $search = $conn->real_escape_string(trim($_GET['search']));
    $query .= " WHERE r.room_number LIKE '%$search%' 
                OR o.full_name LIKE '%$search%' ";
}

$query .= " ORDER BY b.check_in DESC";
$result = $conn->query($query);
?>

<div class="page-actions">
    <h2>📅 Bookings Management</h2>
    <a href="add_booking.php" class="btn btn-success">➕ Add New Booking</a>
</div>

<div class="search-form">
    <form method="get" action="">
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
               placeholder="🔍 Search by room number or occupant name...">
        <button type="submit" class="btn">Search</button>
        <?php if (!empty($search)): ?>
            <a href="bookings.php" class="btn btn-secondary">Clear</a>
        <?php endif; ?>
    </form>
</div>

<?php if ($result && $result->num_rows > 0): ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Occupant</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($row['room_number']) ?></strong></td>
                    <td><?= htmlspecialchars($row['room_type']) ?></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= date('M d, Y', strtotime($row['check_in'])) ?></td>
                    <td><?= date('M d, Y', strtotime($row['check_out'])) ?></td>
                    <td>
                        <a href="edit_booking.php?id=<?= $row['booking_id'] ?>">✏️ Edit</a> |
                        <a href="delete_booking.php?id=<?= $row['booking_id'] ?>"
                           class="delete"
                           onclick="return confirm('Are you sure you want to delete this booking?');">
                            🗑️ Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="empty-state">
        <div class="icon">📅</div>
        <p><?= !empty($search) ? 'No bookings found matching your search' : 'No bookings found' ?></p>
        <a href="add_booking.php" class="btn btn-success">Create Your First Booking</a>
    </div>
<?php endif; ?>

<?php include "../includes/footer.php"; ?>
