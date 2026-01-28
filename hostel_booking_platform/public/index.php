<?php
require_once "../config/db.php";
include "../includes/header.php";
?>

<div class="welcome-section">
    <h2>Welcome to Hostel Booking System</h2>
    <p>Manage rooms, occupants, and bookings efficiently</p>
    <p>Use the navigation above or quick actions below to get started</p>
</div>

<div class="quick-actions">
    <a href="rooms.php" class="action-card">
        <div class="icon">🚪</div>
        <h3>Manage Rooms</h3>
        <p>View, add, edit, and delete rooms</p>
    </a>
    
    <a href="occupants.php" class="action-card">
        <div class="icon">👥</div>
        <h3>Manage Occupants</h3>
        <p>View and manage occupants information</p>
    </a>
    
    <a href="bookings.php" class="action-card">
        <div class="icon">📅</div>
        <h3>View Bookings</h3>
        <p>See all bookings and availability</p>
    </a>
    
    <a href="add_booking.php" class="action-card">
        <div class="icon">➕</div>
        <h3>New Booking</h3>
        <p>Create a new room booking</p>
    </a>
    
    <a href="search.php" class="action-card">
        <div class="icon">🔍</div>
        <h3>Search</h3>
        <p>Search rooms and bookings</p>
    </a>
</div>

<?php include "../includes/footer.php"; ?>
