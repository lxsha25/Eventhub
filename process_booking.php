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

// Handle POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $event_id = intval($_POST['event_id']);
    $event_title = $conn->real_escape_string($_POST['event_title']);
    $event_price = floatval($_POST['event_price']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $quantity = intval($_POST['quantity']);
    $total_price = $event_price * $quantity;
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Process Booking | EventHub</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, rgb(142, 68, 173), rgb(93, 64, 55));
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .payment-box {
            background: rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
        }
        .payment-box h1 { font-size: 28px; margin-bottom: 20px; }
        .payment-box p { font-size: 18px; margin-bottom: 30px; }
        .payment-box button {
            padding: 12px 24px;
            background-color: #00ffcc;
            color: #002244;
            font-weight: bold;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .payment-box button:hover {
            background-color: #00e6b8;
        }
    </style>
</head>
<body>

<div class="payment-box">
    <h1>Proceed to Payment</h1>
    <p><strong>Event:</strong> <?= $event_title ?><br>
    <strong>Name:</strong> <?= $name ?><br>
    <strong>Email:</strong> <?= $email ?><br>
    <strong>Tickets:</strong> <?= $quantity ?><br>
    <strong>Total:</strong> ₹<?= $total_price ?></p>

    <button id="rzp-button">Pay with Razorpay</button>
</div>

<script>
    const options = {
        key: "rzp_test_EhYRMVTvRHz5Ec", // Test Key ID
        amount: <?= $total_price * 100 ?>, // In paise
        currency: "INR",
        name: "EventHub",
        description: "Booking for <?= $event_title ?>",
        handler: function (response) {
            // After successful payment, insert into DB and redirect
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'success.php';

            const fields = {
                event_id: "<?= $event_id ?>",
                event_title: "<?= $event_title ?>",
                event_price: "<?= $event_price ?>",
                name: "<?= $name ?>",
                email: "<?= $email ?>",
                quantity: "<?= $quantity ?>"
            };

            for (let key in fields) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = fields[key];
                form.appendChild(input);
            }

            document.body.appendChild(form);
            form.submit();
        },
        prefill: {
            name: "<?= $name ?>",
            email: "<?= $email ?>"
        },
        theme: {
            color: "#00ffcc"
        }
    };

    const rzp = new Razorpay(options);
    document.getElementById("rzp-button").onclick = function (e) {
        rzp.open();
        e.preventDefault();
    };
</script>

</body>
</html>
