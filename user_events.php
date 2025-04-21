<?php
session_start();
include 'db_connect.php';

// Get today's date
$today = date('Y-m-d');

// Fetch only upcoming events
$sql = "SELECT * FROM events WHERE date >= ? ORDER BY date ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Events - EventHub</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 20px;">

    <div style="max-width: 1200px; margin: auto;">
        <h1 style="text-align: center; color: #1e293b;">🧾 My Upcoming Events</h1>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 30px;">

            <?php
            if ($result && $result->num_rows > 0) {
                while ($event = $result->fetch_assoc()) {
                    echo "<div style='background: #ffffff; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);'>";
                    echo "<h2 style='margin: 0; color: #111827;'>" . htmlspecialchars($event['title']) . "</h2>";
                    echo "<p style='color: #64748b;'>" . htmlspecialchars($event['description']) . "</p>";
                    echo "<p style='color: #2563eb;'>📅 " . date("F j, Y", strtotime($event['date'])) . "</p>";
                    echo "<p style='color: #065f46;'>📍 " . htmlspecialchars($event['location']) . "</p>";
                    echo "<p style='color: #d97706;'>🎟️ " . $event['available_tickets'] . " tickets left</p>";
                    echo "<a href='book_ticket.php?event_id=" . $event["id"] . "' style='display: inline-block; margin-top: 10px; padding: 10px 15px; background-color: #3b82f6; color: white; text-decoration: none; border-radius: 8px;'>View & Book</a>";
                    echo "</div>";
                }
            } else {
                echo "<p style='text-align: center; color: #6b7280;'>No upcoming events available right now.</p>";
            }
            ?>

        </div>
    </div>

</body>
</html>
