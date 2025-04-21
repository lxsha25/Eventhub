<?php
session_start();

// For development/testing, set dummy email if not logged in
// Remove this in production
if (!isset($_SESSION['user_email'])) {
    // TEMP fallback for testing only
    // $_SESSION['user_email'] = 'testuser@example.com'; // Uncomment for testing
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// DB Connection
$conn = new mysqli("localhost", "root", "", "eventhub_database"); // Use correct DB name
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Logged in user's email
$email = $_SESSION['user_email'];

// Fetch tickets for this user
$sql = "SELECT * FROM bookings WHERE email = ? ORDER BY booking_date DESC";
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
            background: linear-gradient(to right, #4a148c, #00695c);
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
            padding: 40px;
            margin: 0;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 36px;
        }
        .ticket-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .ticket {
            background: #ffffff10;
            border-radius: 16px;
            padding: 25px;
            width: 300px;
            backdrop-filter: blur(4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }
        .ticket h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .ticket p {
            margin: 4px 0;
            font-size: 14px;
        }
        .no-tickets {
            text-align: center;
            font-size: 18px;
            margin-top: 50px;
        }
        .back-btn {
            display: block;
            margin: 30px auto 0;
            text-align: center;
            padding: 10px 20px;
            background: #00ffcc;
            color: #002244;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>🎫 My Tickets</h1>
    <div class="ticket-container">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="ticket">
                    <h2><?= htmlspecialchars($row['event_title']) ?></h2>
                    <p><strong>Name:</strong> <?= htmlspecialchars($row['name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
                    <p><strong>Quantity:</strong> <?= $row['quantity'] ?></p>
                    <p><strong>Total:</strong> ₹<?= $row['total_price'] ?></p>
                    <p><strong>Booked on:</strong> <?= date("d M Y, h:i A", strtotime($row['booking_date'])) ?></p>
                    <p><strong>Payment ID:</strong> <?= $row['razorpay_payment_id'] ?: 'N/A' ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-tickets">You have not booked any tickets yet.</div>
        <?php endif; ?>
    </div>

    <a href="dashboard.php" class="back-btn">⬅ Back to Dashboard</a>
</body>
</html>
