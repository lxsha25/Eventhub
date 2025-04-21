<?php
session_start();
include 'db_connect.php';

$email = $_SESSION['email'] ?? '';
if (!$email) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM bookings WHERE email = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Tickets | EventHub</title>
    <style>
        body {
            background: linear-gradient(to right, #8e44ad, #5d4037);
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .ticket-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .ticket-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin: 15px;
            width: 300px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        .ticket-card h2 {
            margin-bottom: 10px;
            font-size: 22px;
            color: #00ffcc;
        }
        .ticket-card p {
            margin: 6px 0;
            font-size: 15px;
        }
        .qr-code {
            margin-top: 15px;
        }
        .qr-code img {
            width: 160px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        .back-btn {
            display: block;
            text-align: center;
            margin-top: 30px;
        }
        .back-btn a {
            text-decoration: none;
            padding: 10px 20px;
            background: #00ffcc;
            color: #002244;
            border-radius: 10px;
            font-weight: bold;
            transition: 0.3s;
        }
        .back-btn a:hover {
            background: #00e6b8;
        }
    </style>
</head>
<body>
    <h1>🎟️ My Tickets</h1>

    <div class="ticket-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="ticket-card">
                    <h2><?= htmlspecialchars($row['event_title']) ?></h2>
                    <p><strong>Name:</strong> <?= htmlspecialchars($row['name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
                    <p><strong>Quantity:</strong> <?= $row['quantity'] ?></p>
                    <p><strong>Total:</strong> ₹<?= $row['total_price'] ?></p>
                    <p><strong>Booked On:</strong> <?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></p>
                    
                    <!-- QR Code Display -->
                    <div class="qr-code">
                        <img src="My_Event_Page.png" alt="QR Code">
                        <p style="font-size: 13px;">Scan this QR at the event</p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;">No tickets found.</p>
        <?php endif; ?>
    </div>

    <div class="back-btn">
        <a href="dashboard.php">⬅ Back to Dashboard</a>
    </div>
</body>
</html>
