<!-- <?php
// DB Connection
$conn = new mysqli("localhost", "root", "", "eventhub_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$eventId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";

// Fetch Event Title
$event = $conn->query("SELECT title FROM events WHERE id = $eventId")->fetch_assoc();
$eventTitle = $event ? $event['title'] : "Event Not Found";

// Handle Booking Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $tickets = intval($_POST["tickets"]);

    if ($name && $email && $tickets > 0) {
        $conn->query("INSERT INTO bookings (event_id, name, email, tickets) VALUES ($eventId, '$name', '$email', $tickets)");
        $message = "🎉 Booking successful for <strong>$eventTitle</strong>!";
    } else {
        $message = "⚠️ Please fill in all fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Ticket - <?= htmlspecialchars($eventTitle) ?></title>
</head>
<body style="font-family:Segoe UI,sans-serif;background:#eef2f7;margin:0;padding:40px;">

    <div style="max-width:600px;margin:auto;background:white;padding:30px;border-radius:15px;box-shadow:0 5px 15px rgba(0,0,0,0.1);">
        <h2 style="margin-top:0;color:#0077cc;">Book Tickets for <?= htmlspecialchars($eventTitle) ?></h2>

        <?php if ($message): ?>
            <div style="background:#f0f8ff;border-left:5px solid #0077cc;padding:10px 15px;margin:15px 0;color:#333;">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="post" style="display:flex;flex-direction:column;gap:15px;">
            <input type="text" name="name" placeholder="Your Name" required
                   style="padding:12px;border:1px solid #ccc;border-radius:8px;">
            <input type="email" name="email" placeholder="Your Email" required
                   style="padding:12px;border:1px solid #ccc;border-radius:8px;">
            <input type="number" name="tickets" placeholder="No. of Tickets" required min="1"
                   style="padding:12px;border:1px solid #ccc;border-radius:8px;">

            <button type="submit"
                style="padding:12px;background:#28a745;color:white;border:none;border-radius:8px;font-weight:bold;cursor:pointer;">
                🎟️ Confirm Booking
            </button>
        </form>

        <a href="event_details.php?id=<?= $eventId ?>" style="display:inline-block;margin-top:20px;text-decoration:none;color:#0077cc;">
            ← Back to Event Details
        </a>
    </div>
</body>
</html> -->


<?php
// DB Connection
$conn = new mysqli("localhost", "root", "", "eventhub_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$eventId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";

// Fetch Event Title
$event = $conn->query("SELECT title FROM events WHERE id = $eventId")->fetch_assoc();
$eventTitle = $event ? $event['title'] : "Event Not Found";

// Handle Booking Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $tickets = intval($_POST["tickets"]);

    if ($name && $email && $tickets > 0) {
        $conn->query("INSERT INTO bookings (event_id, name, email, tickets) VALUES ($eventId, '$name', '$email', $tickets)");
        $message = "🎉 Booking successful for <strong>$eventTitle</strong>!";
    } else {
        $message = "⚠️ Please fill in all fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Ticket - <?= htmlspecialchars($eventTitle) ?></title>
</head>
<body style="font-family:Segoe UI,sans-serif;
             margin:0;
             padding:40px;
             background: linear-gradient(135deg, #3fd2c7, #a3e635);">

    <div style="max-width:600px;
                margin:auto;
                background:white;
                padding:30px;
                border-radius:15px;
                box-shadow:0 5px 15px rgba(0,0,0,0.1);">
        <h2 style="margin-top:0;color:#0077cc;">Book Tickets for <?= htmlspecialchars($eventTitle) ?></h2>

        <?php if ($message): ?>
            <div style="background:#f0f8ff;
                        border-left:5px solid #0077cc;
                        padding:10px 15px;
                        margin:15px 0;
                        color:#333;">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="post" style="display:flex;flex-direction:column;gap:15px;">
            <input type="text" name="name" placeholder="Your Name" required
                   style="padding:12px;border:1px solid #ccc;border-radius:8px;">
            <input type="email" name="email" placeholder="Your Email" required
                   style="padding:12px;border:1px solid #ccc;border-radius:8px;">
            <input type="number" name="tickets" placeholder="No. of Tickets" required min="1"
                   style="padding:12px;border:1px solid #ccc;border-radius:8px;">

            <button type="submit"
                style="padding:12px;background:#28a745;color:white;border:none;border-radius:8px;font-weight:bold;cursor:pointer;">
                🎟️ Confirm Booking
            </button>
        </form>

        <a href="event_details.php?id=<?= $eventId ?>" style="display:inline-block;margin-top:20px;text-decoration:none;color:#0077cc;">
            ← Back to Event Details
        </a>
    </div>

</body>
</html>
