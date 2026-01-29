<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Booking System</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header>
    <h1>🏨 Hostel / Room Booking System</h1>
    <nav>
        <a href="index.php" <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : ''; ?>>🏠 Home</a>
        <a href="rooms.php" <?php echo basename($_SERVER['PHP_SELF']) == 'rooms.php' ? 'class="active"' : ''; ?>>🚪 Rooms</a>
        <a href="occupants.php" <?php echo basename($_SERVER['PHP_SELF']) == 'occupants.php' ? 'class="active"' : ''; ?>>👥 Occupants</a>
        <a href="bookings.php" <?php echo basename($_SERVER['PHP_SELF']) == 'bookings.php' ? 'class="active"' : ''; ?>>📅 Bookings</a>
        <a href="search.php" <?php echo basename($_SERVER['PHP_SELF']) == 'search.php' ? 'class="active"' : ''; ?>>🔍 Search</a>
    </nav>
</header>

<div class="container">
