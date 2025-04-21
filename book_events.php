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

// Get event ID
if (!isset($_GET['id'])) {
    echo "Event not found.";
    exit;
}

$event_id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM events WHERE id = $event_id");

if ($result->num_rows === 0) {
    echo "Event not found.";
    exit;
}

$event = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book <?php echo htmlspecialchars($event['title']); ?> | EventHub</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #6a3093, #a044ff);
            color: #fff;
            padding: 30px;
        }
        .booking-box {
            max-width: 700px;
            margin: auto;
            background: rgba(255,255,255,0.08);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.4);
        }
        h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        img {
            max-width: 100%;
            border-radius: 12px;
            margin-bottom: 15px;
        }
        p {
            font-size: 16px;
        }
        form {
            margin-top: 25px;
        }
        input {
            padding: 10px;
            width: 100%;
            margin: 10px 0;
            border-radius: 8px;
            border: none;
        }
        button {
            padding: 12px 25px;
            background-color: #00ffcc;
            color: #002244;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background-color: #00e6b8;
        }
    </style>
</head>
<body>

<div class="booking-box">
    <h2>🎫 Book for <?php echo htmlspecialchars($event['title']); ?></h2>
    <img src="<?php echo htmlspecialchars($event['image_url']); ?>" alt="Event Image">
    <p><strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></p>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($event['description']); ?></p>
    <p><strong>Price:</strong> ₹<?php echo $event['price']; ?> per ticket</p>

    <form id="paymentForm">
        <input type="hidden" id="event_id" value="<?php echo $event['id']; ?>">
        <input type="hidden" id="event_title" value="<?php echo htmlspecialchars($event['title']); ?>">
        <input type="hidden" id="event_price" value="<?php echo $event['price']; ?>">

        <input type="text" id="name" placeholder="Your Name" required>
        <input type="email" id="email" placeholder="Your Email" required>
        <input type="number" id="quantity" placeholder="No. of Tickets" min="1" required>

        <button type="button" onclick="startPayment()">Proceed to Pay</button>
    </form>
</div>

<script>
    function startPayment() {
        const name = $('#name').val();
        const email = $('#email').val();
        const quantity = parseInt($('#quantity').val());
        const price = parseFloat($('#event_price').val());
        const total = quantity * price * 100; // in paise

        if (!name || !email || quantity < 1) {
            alert('Please fill all the fields properly.');
            return;
        }

        const options = {
            "key": "rzp_test_EhYRMVTvRHz5Ec",
            "amount": total,
            "currency": "INR",
            "name": "EventHub",
            "description": "Ticket Booking - " + $('#event_title').val(),
            "handler": function (response) {
                $.post("success.php", {
                    event_id: $('#event_id').val(),
                    event_title: $('#event_title').val(),
                    event_price: price,
                    name: name,
                    email: email,
                    quantity: quantity
                }, function () {
                    window.location.href = "success.php";
                });
            },
            "prefill": {
                "name": name,
                "email": email
            },
            "theme": {
                "color": "#00ffcc"
            }
        };

        const rzp = new Razorpay(options);
        rzp.open();
    }
</script>

</body>
</html>
