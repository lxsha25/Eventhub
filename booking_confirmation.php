<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation - EventHub</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f3e5f5, #ffe0b2);
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .confirmation-box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
        }
        .confirmation-box h1 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .confirmation-box p {
            color: #555;
            font-size: 16px;
        }
        .confirmation-box a {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 20px;
            background-color: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="confirmation-box">
        <h1>🎉 Booking Confirmed!</h1>
        <p>Thank you for booking your ticket with EventHub.<br>
        A confirmation email has been sent to your inbox.</p>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
