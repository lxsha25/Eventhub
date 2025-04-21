<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$name = $_SESSION["name"] ?? "John Doe";
$email = $_SESSION["email"] ?? "john@example.com";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile - EventHub</title>
</head>
<body style="margin:0;font-family:sans-serif;background: linear-gradient(rgba(63,94,251,0.7), rgba(252,70,107,0.7)), url('images/profile_bg.jpg') no-repeat center center fixed; background-size: cover;">

    <!-- Header -->
    <header style="background:rgba(0,0,0,0.7);color:white;padding:20px;text-align:center;">
        <h1 style="margin:0;">👤 Your Profile</h1>
    </header>

    <!-- Navbar -->
    <nav style="background:rgba(31,41,55,0.9);display:flex;justify-content:center;gap:20px;padding:10px;">
        <a href="dashboard.php" style="color:white;text-decoration:none;padding:8px 12px;">Dashboard</a>
        <a href="index.php" style="color:white;text-decoration:none;padding:8px 12px;">Home</a>
        <a href="logout.php" style="color:white;text-decoration:none;padding:8px 12px;">Logout</a>
    </nav>

    <!-- Profile Card -->
    <div style="max-width:500px;margin:40px auto;background:#8b5cf6;padding:30px;border-radius:15px;box-shadow:0 5px 20px rgba(0,0,0,0.3);text-align:center;color:white;">
        <img src="images/default_user.png" alt="Profile Picture" style="width:120px;height:120px;border-radius:50%;margin-bottom:20px;border:3px solid white;">
        <h2 style="margin:0 0 10px;"><?= htmlspecialchars($name) ?></h2>
        <p style="margin:5px 0;">📧 <?= htmlspecialchars($email) ?></p>

        <hr style="margin:20px 0;border-color:white;">

        <h3>🎯 Interests</h3>
        <p>Music festivals, tech expos, stand-up comedy, cricket matches.</p>

        <h3>📝 Bio</h3>
        <p>Event enthusiast. Love discovering new experiences. Always ready to explore the next big thing. Frequent attendee of music and tech events.</p>

        <h3>📍 Location</h3>
        <p>New York, USA</p>

        <h3>🎟️ Last Event Attended</h3>
        <p>Music Fest 2024 - Central Park</p>

        <div style="margin-top:25px;">
            <a href="edit_profile.php" style="padding:10px 20px;background:white;color:#8b5cf6;text-decoration:none;border-radius:5px;font-weight:bold;">Edit Profile</a>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background:rgba(0,0,0,0.7);color:white;text-align:center;padding:15px;">
        <p>&copy; 2025 EventHub. All rights reserved.</p>
    </footer>

</body>
</html>
