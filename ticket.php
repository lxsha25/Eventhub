<?php
// Example ticket details (in real case, fetch from DB using session or booking ID)
$eventTitle = "IPL: CSK vs MI";
$eventDate = "2025-04-08";
$eventTime = "7:30 PM";
$venue = "Wankhede Stadium, Mumbai";
$userName = "Laxman Mohan";
$ticketID = "EVT12345678";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ticket Confirmation | EventHub</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #8e44ad, #5d4037);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .ticket-container {
            background: rgba(0, 0, 0, 0.3);
            padding: 30px;
            border-radius: 15px;
            width: 350px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            text-align: center;
        }
        .ticket-container h1 {
            margin-bottom: 10px;
            font-size: 26px;
        }
        .ticket-info {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            margin: 20px 0;
            border-radius: 10px;
            font-size: 16px;
        }
        .ticket-id {
            font-size: 14px;
            margin-bottom: 10px;
            color: #ffd700;
        }
        .download-btn {
            background: #00ffcc;
            color: #002244;
            padding: 10px 20px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 10px;
            display: inline-block;
            margin-top: 10px;
            transition: background 0.3s ease;
        }
        .download-btn:hover {
            background: #00e6b8;
        }
    </style>
</head>
<body>

<div class="ticket-container" id="ticket">
    <h1>🎫 Event Ticket</h1>
    <div class="ticket-id">Ticket ID: <?= $ticketID ?></div>
    <div class="ticket-info">
        <p><strong>Name:</strong> <?= $userName ?></p>
        <p><strong>Event:</strong> <?= $eventTitle ?></p>
        <p><strong>Date:</strong> <?= $eventDate ?></p>
        <p><strong>Time:</strong> <?= $eventTime ?></p>
        <p><strong>Venue:</strong> <?= $venue ?></p>
    </div>
    <a class="download-btn" href="#" onclick="window.print()">🖨️ Print / Download</a>
</div>

</body>
</html>
