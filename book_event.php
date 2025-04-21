<?php
$events = [
    1 => ["title" => "Music Fiesta", "price" => 499],
    2 => ["title" => "Tech Conference 2025", "price" => 999],
    3 => ["title" => "Food Carnival", "price" => 299],
    4 => ["title" => "Startup Pitch Fest", "price" => 599],
    5 => ["title" => "Jazz Night", "price" => 399],
    6 => ["title" => "IPL: CSK vs MI", "price" => 750],
    7 => ["title" => "IPL: RCB vs KKR", "price" => 850],
    8 => ["title" => "IPL: DC vs RR", "price" => 800],
    9 => ["title" => "IPL: LSG vs GT", "price" => 700],
    10 => ["title" => "IPL: PBKS vs SRH", "price" => 750],
];

$id = $_GET['id'] ?? 0;
$event = $events[$id] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $event ? 'Book - ' . $event['title'] : 'Invalid Event' ?> | EventHub</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #8e44ad, #5d4037); /* violet-brown */
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .booking-form {
            background: rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #00ffcc;
            color: #002244;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background-color: #00e6b8;
        }
        .event-info {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php if ($event): ?>
    <form class="booking-form" method="POST" action="process_booking.php">
        <h2>🎫 Book Tickets</h2>
        <div class="event-info">
            <p><strong>Event:</strong> <?= $event['title'] ?></p>
            <p><strong>Price:</strong> ₹<?= $event['price'] ?></p>
        </div>
        <input type="hidden" name="event_id" value="<?= $id ?>">
        <input type="hidden" name="event_title" value="<?= $event['title'] ?>">
        <input type="hidden" name="event_price" value="<?= $event['price'] ?>">

        <label for="name">Your Name</label>
        <input type="text" name="name" id="name" required>

        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" required>

        <label for="quantity">Tickets</label>
        <select name="quantity" id="quantity" required>
            <?php for ($i = 1; $i <= 10; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
        </select>

        <button type="submit">Confirm Booking</button>
    </form>
<?php else: ?>
    <div class="booking-form">
        <h2>Event Not Found</h2>
        <p>Sorry, we couldn't find the selected event.</p>
    </div>
<?php endif; ?>

</body>
</html>
