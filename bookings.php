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

// Fetch all bookings
$result = $conn->query("SELECT * FROM bookings ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Bookings | Admin Panel - EventHub</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, rgb(142, 68, 173), rgb(93, 64, 55));
            color: white;
            padding: 30px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            overflow: hidden;
        }
        th, td {
            padding: 14px;
            text-align: left;
        }
        th {
            background-color: rgba(0,0,0,0.3);
        }
        tr:nth-child(even) {
            background-color: rgba(255,255,255,0.05);
        }
        tr:hover {
            background-color: rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>

    <h1>📋 All Bookings - Admin View</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Event ID</th>
                <th>Event Title</th>
                <th>Name</th>
                <th>Email</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Booking Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['event_id']; ?></td>
                    <td><?= htmlspecialchars($row['event_title']); ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= $row['quantity']; ?></td>
                    <td>₹<?= $row['total_price']; ?></td>
                    <td><?= isset($row['created_at']) ? $row['created_at'] : 'N/A'; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>
