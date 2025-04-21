<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "eventhub_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize and receive POST data
$event_id = $_POST['event_id'] ?? 0;
$event_title = $_POST['event_title'] ?? '';
$event_price = $_POST['event_price'] ?? 0;
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$quantity = $_POST['quantity'] ?? 1;
$payment_id = $_POST['razorpay_payment_id'] ?? '';

// Insert booking
$stmt = $conn->prepare("INSERT INTO bookings (event_id, event_title, name, email, quantity, total_price, razorpay_payment_id, booking_date) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
$total_price = $event_price * $quantity;
$stmt->bind_param("issssid", $event_id, $event_title, $name, $email, $quantity, $total_price, $payment_id);

if ($stmt->execute()) {
    // Store booking ID in session for ticket download
    session_start();
    $_SESSION['booking_id'] = $stmt->insert_id;
    header("Location: success.php");
    exit();
} else {
    echo "Booking failed!";
}

$conn->close();
?>
