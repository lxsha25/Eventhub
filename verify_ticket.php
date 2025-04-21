<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "eventhub_database";
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$booking_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify Ticket | EventHub</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9f9f9;
            padding: 30px;
            text-align: center;
            color: #333;
        }
        .container {
            background: white;
            border-radius: 10px;
            padding: 25px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0px 5px 15px rgba(0,0,0,0.1);
        }
        .valid {
            color: green;
        }
        .invalid {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
<?php
if ($booking_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
    $stmt->close();

    if ($booking) {
        echo "<h2 class='valid'>✅ Valid Ticket</h2>";
        echo "<p><strong>Event:</strong> " . htmlspecialchars($booking['event_title']) . "</p>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($booking['name']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($booking['email']) . "</p>";
        echo "<p><strong>Quantity:</strong> " . $booking['quantity'] . "</p>";
        echo "<p><strong>Total Paid:</strong> ₹" . $booking['total_price'] . "</p>";
        echo "<p><strong>Payment ID:</strong> " . htmlspecialchars($booking['razorpay_payment_id']) . "</p>";
        echo "<p><strong>Booked On:</strong> " . $booking['created_at'] . "</p>";
    } else {
        echo "<h2 class='invalid'>❌ Invalid or Expired Ticket</h2>";
    }
} else {
    echo "<h2 class='invalid'>❌ No Ticket ID Provided</h2>";
}
?>
</div>

</body>
</html>
