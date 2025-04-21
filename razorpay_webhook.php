<?php
// razorpay_webhook.php

// Razorpay credentials (test mode)
$webhook_secret = "your_webhook_secret_here"; // Set this in Razorpay dashboard

// Capture raw POST payload
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '';

// Verify signature
function verifySignature($payload, $signature, $secret) {
    $generated = hash_hmac('sha256', $payload, $secret);
    return hash_equals($generated, $signature);
}

if (!verifySignature($payload, $signature, $webhook_secret)) {
    http_response_code(400);
    echo "Invalid Signature";
    exit;
}

// Decode the payload
$data = json_decode($payload, true);
$event = $data['event'] ?? '';

if ($event === 'payment.captured') {
    $paymentId = $data['payload']['payment']['entity']['id'] ?? '';
    $amount = $data['payload']['payment']['entity']['amount'] / 100.0;

    // Optional: log the payment (for testing)
    file_put_contents('payment_log.txt', date('Y-m-d H:i:s') . " - Payment Captured: $paymentId - ₹$amount\n", FILE_APPEND);

    // Update bookings table
    $conn = new mysqli("localhost", "root", "", "eventhub_db"); // Adjust DB credentials
    if ($conn->connect_error) {
        http_response_code(500);
        exit("Database connection failed.");
    }

    $stmt = $conn->prepare("UPDATE bookings SET razorpay_payment_id = ?, total_price = ? WHERE razorpay_payment_id IS NULL LIMIT 1");
    $stmt->bind_param("sd", $paymentId, $amount);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    http_response_code(200);
    echo "Payment Recorded";
} else {
    http_response_code(200);
    echo "Webhook received but not processed: $event";
}
?>
