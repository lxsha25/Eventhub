<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include 'db_connect.php';

$name = $_SESSION["user_name"];
$role = $_SESSION["role"];

// Add new event (admin only)
if ($role === 'admin' && $_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $desc = $_POST["description"];
    $date = $_POST["date"];
    $location = $_POST["location"];
    $total = intval($_POST["total_tickets"]);

    $stmt = $conn->prepare("INSERT INTO events (title, description, date, location, total_tickets, available_tickets) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssii", $title, $desc, $date, $location, $total, $total);
    $stmt->execute();
}

// Delete event (admin only)
if ($role === 'admin' && isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);
    $conn->query("DELETE FROM events WHERE id=$id");
}

$events = $conn->query("SELECT * FROM events ORDER BY date ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - EventHub</title>
    <script>
        function confirmDelete(title, id) {
            if (confirm("Are you sure you want to delete '" + title + "'?")) {
                window.location.href = 'dashboard_admin.php?delete=' + id;
            }
        }

        function validateForm() {
            const form = document.forms["eventForm"];
            for (let field of ["title", "description", "date", "location", "total_tickets"]) {
                if (!form[field].value.trim()) {
                    alert("Please fill out all fields.");
                    return false;
                }
            }
            return true;
        }
    </script>
</head>
<body style="font-family:'Segoe UI',sans-serif;background:#f3f4f6;padding:30px;">

    <!-- User Dashboard -->
    <div style="max-width:600px;margin:auto;background:#fff;padding:30px;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,0.1);margin-bottom:40px;">
        <h2 style="color:#1f2937;">👋 Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
        <p style="margin-bottom:20px;">You are logged in as: <strong><?php echo $role; ?></strong></p>

        <div style="display:flex;flex-direction:column;gap:10px;">
            <a href="events.php" style="padding:10px;background:#3b82f6;color:white;text-decoration:none;border-radius:6px;text-align:center;">🎫 Browse Events</a>
            <a href="my_bookings.php" style="padding:10px;background:#10b981;color:white;text-decoration:none;border-radius:6px;text-align:center;">📋 My Bookings</a>
            <a href="logout.php" style="padding:10px;background:#ef4444;color:white;text-decoration:none;border-radius:6px;text-align:center;">🚪 Logout</a>
        </div>
    </div>

    <!-- Admin Panel -->
    <?php if ($role === 'admin'): ?>
    <div style="max-width:800px;margin:auto;">
        <h2 style="text-align:center;color:#1f2937;">⚙️ Admin Controls</h2>

        <form name="eventForm" method="POST" onsubmit="return validateForm()" style="background:white;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.1);margin-bottom:30px;">
            <h3 style="margin-top:0;">➕ Add New Event</h3>
            <input type="text" name="title" placeholder="Title" required style="width:100%;margin-bottom:10px;padding:8px;"><br>
            <textarea name="description" placeholder="Description" required style="width:100%;margin-bottom:10px;padding:8px;"></textarea><br>
            <input type="date" name="date" required style="width:100%;margin-bottom:10px;padding:8px;"><br>
            <input type="text" name="location" placeholder="Location" required style="width:100%;margin-bottom:10px;padding:8px;"><br>
            <input type="number" name="total_tickets" placeholder="Total Tickets" required min="1" style="width:100%;margin-bottom:10px;padding:8px;"><br>
            <button type="submit" style="background:#10b981;color:white;padding:10px 20px;border:none;border-radius:6px;">Add Event</button>
        </form>

        <?php if ($events && $events->num_rows > 0): ?>
            <?php while ($e = $events->fetch_assoc()): ?>
                <div style="background:white;padding:15px;margin-bottom:12px;border-radius:8px;box-shadow:0 1px 5px rgba(0,0,0,0.05);">
                    <strong style="font-size:16px;"><?php echo htmlspecialchars($e["title"]); ?></strong><br>
                    <span style="color:#374151;">📅 <?php echo $e["date"]; ?> | 📍 <?php echo htmlspecialchars($e["location"]); ?></span><br>
                    <span style="color:#4b5563;">🎟️ <?php echo $e["available_tickets"]; ?>/<?php echo $e["total_tickets"]; ?> tickets available</span>
                    <br>
                    <button onclick="confirmDelete('<?php echo addslashes($e["title"]); ?>', <?php echo $e["id"]; ?>)"
                        style="margin-top:8px;background:#ef4444;color:white;padding:6px 14px;border:none;border-radius:5px;cursor:pointer;">
                        Delete
                    </button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;color:#6b7280;">No events found.</p>
        <?php endif; ?>
    </div>
    <?php endif; ?>

</body>
</html>
