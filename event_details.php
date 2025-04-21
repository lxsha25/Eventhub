<?php
$events = [
    1 => ["title" => "Music Fiesta", "category" => "Music", "date" => "2025-05-10", "location" => "Goa, India", "description" => "A vibrant celebration of music.", "price" => 499],
    2 => ["title" => "Tech Conference 2025", "category" => "Technology", "date" => "2025-06-15", "location" => "Bengaluru, India", "description" => "Explore the future of tech innovation.", "price" => 999],
    3 => ["title" => "Food Carnival", "category" => "Food", "date" => "2025-04-22", "location" => "Delhi, India", "description" => "Taste cuisines from around the world.", "price" => 299],
    4 => ["title" => "Startup Pitch Fest", "category" => "Business", "date" => "2025-07-05", "location" => "Mumbai, India", "description" => "Pitch your ideas to top investors.", "price" => 599],
    5 => ["title" => "Jazz Night", "category" => "Music", "date" => "2025-05-22", "location" => "Chennai, India", "description" => "Smooth and soulful jazz tunes.", "price" => 399],
    6 => ["title" => "IPL: CSK vs MI", "category" => "Sports", "date" => "2025-04-08", "location" => "Chennai, India", "description" => "A thrilling IPL cricket match.", "price" => 750],
    7 => ["title" => "IPL: RCB vs KKR", "category" => "Sports", "date" => "2025-04-10", "location" => "Bengaluru, India", "description" => "Battle of giants in IPL.", "price" => 850],
    8 => ["title" => "IPL: DC vs RR", "category" => "Sports", "date" => "2025-04-12", "location" => "Delhi, India", "description" => "Another epic IPL showdown.", "price" => 800],
    9 => ["title" => "IPL: LSG vs GT", "category" => "Sports", "date" => "2025-04-15", "location" => "Lucknow, India", "description" => "Catch the action live!", "price" => 700],
    10 => ["title" => "IPL: PBKS vs SRH", "category" => "Sports", "date" => "2025-04-18", "location" => "Mohali, India", "description" => "A power-packed IPL match.", "price" => 750],
];

$id = $_GET['id'] ?? 0;
$event = $events[$id] ?? null;

function generateMapLink($location) {
    return "https://www.google.com/maps/search/" . urlencode($location);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $event ? $event['title'] : 'Event Not Found' ?> | EventHub</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #8e44ad, #5d4037);
            color: #fff;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
        }
        h1 {
            margin-bottom: 20px;
        }
        .details {
            font-size: 18px;
            line-height: 1.6;
        }
        .map-link {
            display: inline-block;
            margin-top: 10px;
            color: #00ffff;
            text-decoration: underline;
        }
        .map-link:hover {
            color: #00e6e6;
        }
        .form-group {
            margin-top: 25px;
        }
        input {
            padding: 10px;
            border-radius: 8px;
            border: none;
            width: 100%;
            margin-top: 5px;
            margin-bottom: 15px;
        }
        .pay-btn {
            padding: 12px 24px;
            background: #00ffcc;
            color: #002244;
            font-weight: bold;
            font-size: 16px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .pay-btn:hover {
            background: #00e6b8;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<?php if ($event): ?>
    <div class="container">
        <h1><?= $event['title'] ?></h1>
        <div class="details">
            <p><strong>Category:</strong> <?= $event['category'] ?></p>
            <p><strong>Date:</strong> <?= $event['date'] ?></p>
            <p><strong>Location:</strong> <?= $event['location'] ?> 
                <a class="map-link" href="<?= generateMapLink($event['location']) ?>" target="_blank">📍 View on Map</a>
            </p>
            <p><strong>Description:</strong> <?= $event['description'] ?></p>
            <p><strong>Ticket Price:</strong> ₹<?= $event['price'] ?></p>
        </div>

        <form id="payment-form">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="quantity">Number of Tickets</label>
                <input type="number" id="quantity" value="1" min="1" required>
            </div>
            <button type="button" class="pay-btn" onclick="startRazorpay()">Pay with Razorpay</button>
        </form>
    </div>

    <script>
        function startRazorpay() {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const quantity = parseInt(document.getElementById('quantity').value);
            const price = <?= $event['price'] ?>;
            const amount = price * quantity * 100;

            if (!name || !email || quantity < 1) {
                alert("Please fill all details correctly.");
                return;
            }

            var options = {
                "key": "rzp_test_EhYRMVTvRHz5Ec",
                "amount": amount,
                "currency": "INR",
                "name": "<?= $event['title'] ?>",
                "description": "Ticket Booking",
                "handler": function (response) {
                    // Send booking details to backend
                    fetch('process.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: new URLSearchParams({
                            event_id: <?= $id ?>,
                            event_title: "<?= $event['title'] ?>",
                            event_price: price,
                            name: name,
                            email: email,
                            quantity: quantity,
                            razorpay_payment_id: response.razorpay_payment_id
                        })
                    }).then(res => res.ok ? window.location.href = 'success.php' : alert("Failed to book!"));
                },
                "prefill": { name: name, email: email },
                "theme": { "color": "#00ffcc" }
            };

            var rzp = new Razorpay(options);
            rzp.open();
        }
    </script>
<?php else: ?>
    <div class="container">
        <h1>Event Not Found</h1>
        <p>Sorry, the event you are looking for does not exist.</p>
    </div>
<?php endif; ?>

</body>
</html>
