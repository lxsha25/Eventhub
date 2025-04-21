<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$today = date('Y-m-d');
$sql = "SELECT * FROM events WHERE date >= ? ORDER BY date ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();

$calendar_events = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $calendar_events[] = [
            'title' => $row['title'],
            'start' => $row['date'],
            'url' => 'book_ticket.php?event_id=' . $row['id'],
        ];
        $events_data[] = $row;
    }
} else {
    $events_data = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Browse Events - EventHub</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #1f2937;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }
        h1, h2 {
            text-align: center;
            color: #1e293b;
        }
        .event-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .event-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .event-card h3 {
            margin: 0 0 10px;
            color: #111827;
        }
        .event-card p {
            margin: 5px 0;
            color: #4b5563;
        }
        .event-card form {
            margin-top: 10px;
        }
        .event-card button {
            padding: 10px 15px;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        #calendar {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div><strong>EventHub</strong></div>
    <div>
        <a href="index.php">Home</a>
        <a href="browse_events.php">Browse Events</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h1>🎟️ Browse & Book Events</h1>

    <!-- Card view -->
    <div class="event-grid">
        <?php if (!empty($events_data)): ?>
            <?php foreach ($events_data as $event): ?>
                <div class="event-card">
                    <h3><?= htmlspecialchars($event["title"]) ?></h3>
                    <p><?= htmlspecialchars($event["description"]) ?></p>
                    <p><strong>📍 <?= htmlspecialchars($event["location"]) ?></strong></p>
                    <p>📅 <?= date("F j, Y", strtotime($event["date"])) ?></p>
                    <p>🎟️ Tickets Left: <?= $event["available_tickets"] ?></p>

                    <form action="book_ticket.php" method="POST">
                        <input type="hidden" name="event_id" value="<?= $event["id"] ?>">
                        <button type="submit">Book Now</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; color: #6b7280;">No upcoming events found.</p>
        <?php endif; ?>
    </div>

    <!-- Calendar view -->
    <h2 style="margin-top: 60px;">📅 Calendar View</h2>
    <div id='calendar'></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            },
            events: <?= json_encode($calendar_events) ?>,
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                if (info.event.url) {
                    window.location.href = info.event.url;
                }
            }
        });
        calendar.render();
    });
</script>

</body>
</html>
