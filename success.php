<?php
session_start();
$booking_id = $_SESSION['booking_id'] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Success | EventHub</title>
    <style>
        body {
            background: linear-gradient(to right, #8e44ad, #5d4037);
            color: #fff;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 60px;
            overflow: hidden;
        }
        .box {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 16px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            position: relative;
            z-index: 2;
        }
        h1 {
            font-size: 32px;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
        }
        .qr-ticket {
            margin: 25px auto;
            display: none;
            animation: fadeIn 1s ease-in-out forwards;
        }
        .qr-ticket img {
            width: 220px;
            height: auto;
            border: 4px solid #fff;
            border-radius: 12px;
            background: #fff;
            padding: 10px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        .dashboard-btn {
            background: #00ffcc;
            color: #002244;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin: 15px 5px 0;
            transition: background 0.3s ease;
        }
        .dashboard-btn:hover {
            background: #00e6b8;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: white;
            opacity: 0.8;
            animation: fall 4s linear infinite;
            z-index: 1;
        }
        @keyframes fall {
            0% { transform: translateY(0) rotate(0deg); }
            100% { transform: translateY(100vh) rotate(360deg); }
        }
    </style>

    <script>
        function createConfetti() {
            for (let i = 0; i < 100; i++) {
                let confetti = document.createElement('div');
                confetti.classList.add('confetti');
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.top = Math.random() * -100 + 'px';
                confetti.style.backgroundColor = 'hsl(' + Math.random() * 360 + ', 100%, 70%)';
                confetti.style.animationDuration = 2 + Math.random() * 3 + 's';
                document.body.appendChild(confetti);
            }
        }

        window.onload = function () {
            createConfetti();

            // Show QR code after 3 seconds
            setTimeout(function () {
                const qrDiv = document.getElementById('qr-ticket');
                if (qrDiv) qrDiv.style.display = 'block';
            }, 3000);
        }
    </script>
</head>
<body>
    <div class="box">
        <h1>🎉 Booking Successful!</h1>
        <p>Your ticket has been booked successfully.<br>A confirmation email has been sent.</p>

        <?php if ($booking_id): ?>
            <div class="qr-ticket" id="qr-ticket">
                <p><strong>Your Ticket QR Code:</strong></p>
                <img src="images/qr/My_Event_Page.png" alt="QR Code Ticket">
            </div>
        <?php else: ?>
            <p>⚠️ Booking ID not found. Please check your tickets in <a class="dashboard-btn" href="my_tickets.php">My Tickets</a>.</p>
        <?php endif; ?>

        <a class="dashboard-btn" href="dashboard.php">⬅ Back to Dashboard</a>
    </div>
</body>
</html>
