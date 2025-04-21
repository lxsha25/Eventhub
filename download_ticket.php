<?php
require_once('tcpdf/tcpdf.php');

// Database connection
$conn = new mysqli("localhost", "root", "", "eventhub_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get booking ID from GET request
$booking_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($booking_id <= 0) {
    die("Invalid ticket ID.");
}

// Fetch booking details
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("No booking found.");
}

$booking = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Create a new PDF instance
$pdf = new TCPDF('P', 'mm', 'A5', true, 'UTF-8', false);
$pdf->SetCreator('EventHub');
$pdf->SetAuthor('EventHub');
$pdf->SetTitle('Your Event Ticket');
$pdf->SetMargins(15, 15, 15);
$pdf->AddPage();

// Styling
$html = '
<style>
    h1 { color: #4A148C; text-align: center; }
    p { font-size: 14px; }
    .ticket-box {
        border: 2px dashed #4A148C;
        padding: 15px;
        border-radius: 10px;
        background-color: #f9f9f9;
    }
</style>

<h1>🎟 Event Ticket</h1>
<div class="ticket-box">
    <p><strong>Booking ID:</strong> ' . $booking['id'] . '</p>
    <p><strong>Name:</strong> ' . htmlspecialchars($booking['name']) . '</p>
    <p><strong>Email:</strong> ' . htmlspecialchars($booking['email']) . '</p>
    <p><strong>Event:</strong> ' . htmlspecialchars($booking['event_title']) . '</p>
    <p><strong>Quantity:</strong> ' . $booking['quantity'] . '</p>
    <p><strong>Total Paid:</strong> ₹' . number_format($booking['total_price'], 2) . '</p>
    <p><strong>Payment ID:</strong> ' . htmlspecialchars($booking['razorpay_payment_id']) . '</p>
    <p><strong>Date:</strong> ' . date('d M Y, h:i A', strtotime($booking['booking_date'] ?? 'now')) . '</p>
</div>

<p style="text-align:center; margin-top:20px;">Show this ticket at the event entry. Thank you for choosing EventHub!</p>
';

// Output PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('EventHub_Ticket_' . $booking['id'] . '.pdf', 'I'); // Use 'D' for download
