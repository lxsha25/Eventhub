<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';
$name = $_SESSION["user_name"];
$role = $_SESSION["role"];

// Add or Update event
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $desc = $_POST["description"];
    $date = $_POST["date"];
    $location = $_POST["location"];
    $total = intval($_POST["total_tickets"]);
    $event_id = isset($_POST["event_id"]) ? intval($_POST["event_id"]) : null;

    if ($event_id) {
        $stmt = $conn->prepare("UPDATE events SET title=?, description=?, date=?, location=?, total_tickets=?, available_tickets=? WHERE id=?");
        $stmt->bind_param("ssssiii", $title, $desc, $date, $location, $total, $total, $event_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO events (title, description, date, location, total_tickets, available_tickets) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssii", $title, $desc, $date, $location, $total, $total);
    }
    $stmt->execute();
}

// Delete event
if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);
    $conn->query("DELETE FROM events WHERE id=$id");
}

$events = $conn->query("SELECT * FROM events ORDER BY date ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - EventHub</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        body { background: #f3f4f6; padding: 20px; }
        .navbar { background: #1f2937; padding: 15px; color: white; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: white; text-decoration: none; margin-left: 15px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    </style>
    <script>
        function confirmDelete(title, id) {
            if (confirm("Are you sure you want to delete '" + title + "' ?")) {
                window.location.href = 'dashboard_admin.php?delete=' + id;
            }
        }
        function editEvent(id, title, description, date, location, total) {
            document.getElementById('event_id').value = id;
            document.getElementById('title').value = title;
            document.getElementById('description').value = description;
            document.getElementById('date').value = date;
            document.getElementById('location').value = location;
            document.getElementById('total_tickets').value = total;
        }
    </script>
</head>
<body>
<div class="navbar">
    <h2>⚙️ Admin Panel</h2>
    <div>
        <a href="dashboard_admin.php">Dashboard</a>
        <a href="events.php">Events</a>
        <a href="logout.php" style="color: #f87171;">Logout</a>
    </div>
</div>
<div class="container">
    <h2 style="text-align:center;color:#1f2937;">👋 Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
    <p style="text-align:center;">You are logged in as: <strong><?php echo $role; ?></strong></p>

    <form method="POST" style="background:white;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.1);margin-bottom:30px;">
        <h3>➕ Add/Edit Event</h3>
        <input type="hidden" name="event_id" id="event_id">
        <input type="text" name="title" id="title" placeholder="Title" required style="width:100%;margin-bottom:10px;padding:8px;">
        <textarea name="description" id="description" placeholder="Description" required style="width:100%;margin-bottom:10px;padding:8px;"></textarea>
        <input type="date" name="date" id="date" required style="width:100%;margin-bottom:10px;padding:8px;">
        <input type="text" name="location" id="location" placeholder="Location" required style="width:100%;margin-bottom:10px;padding:8px;">
        <input type="number" name="total_tickets" id="total_tickets" placeholder="Total Tickets" required min="1" style="width:100%;margin-bottom:10px;padding:8px;">
        <button type="submit" style="background:#10b981;color:white;padding:10px 20px;border:none;border-radius:6px;">Save Event</button>
    </form>

    <?php if ($events && $events->num_rows > 0): ?>
        <?php while ($e = $events->fetch_assoc()): ?>
            <div style="background:white;padding:15px;margin-bottom:12px;border-radius:8px;box-shadow:0 1px 5px rgba(0,0,0,0.05);">
                <strong style="font-size:16px;"> <?php echo htmlspecialchars($e["title"]); ?> </strong><br>
                <span style="color:#374151;"> 📅 <?php echo $e["date"]; ?> | 📍 <?php echo htmlspecialchars($e["location"]); ?> </span><br>
                <span style="color:#4b5563;"> 🎟️ <?php echo $e["available_tickets"]; ?>/<?php echo $e["total_tickets"]; ?> tickets available </span>
                <br>
                <button onclick="editEvent(<?php echo $e['id']; ?>, '<?php echo addslashes($e['title']); ?>', '<?php echo addslashes($e['description']); ?>', '<?php echo $e['date']; ?>', '<?php echo addslashes($e['location']); ?>', <?php echo $e['total_tickets']; ?>)" style="margin-top:8px;background:#3b82f6;color:white;padding:6px 14px;border:none;border-radius:5px;cursor:pointer;">Edit</button>
                <button onclick="confirmDelete('<?php echo addslashes($e["title"]); ?>', <?php echo $e["id"]; ?>)" style="margin-top:8px;background:#ef4444;color:white;padding:6px 14px;border:none;border-radius:5px;cursor:pointer;">Delete</button>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;color:#6b7280;">No events found.</p>
    <?php endif; ?>
</div>
</body>
</html>
