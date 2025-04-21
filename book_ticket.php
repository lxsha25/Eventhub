<?php
session_start();
include 'db_connect.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();

$name = $user['name'] ?? '';
$email = $user['email'] ?? '';

// Get event details
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

if (!$event_id) {
    echo "Invalid event.";
    exit;
}

$event_stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$event_stmt->bind_param("i", $event_id);
$event_stmt->execute();
$event_result = $event_stmt->get_result();

if ($event_result->num_rows === 0) {
    echo "Event not found.";
    exit;
}

$event = $event_result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Book Tickets - <?= htmlspecialchars($event['title']) ?> | EventHub</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      padding: 20px;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: white;
      border-radius: 10px;
      padding: 25px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h2 {
      color: #1f2937;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-top: 15px;
    }
    input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      background: #3b82f6;
      color: white;
      padding: 10px 20px;
      margin-top: 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .success {
      background: #d1fae5;
      padding: 10px;
      color: #065f46;
      margin-top: 15px;
      border-radius: 6px;
    }
    .error {
      background: #fee2e2;
      padding: 10px;
      color: #991b1b;
      margin-top: 15px;
      border-radius: 6px;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Book Tickets: <?= htmlspecialchars($event['title']) ?></h2>
  <p><strong>Date:</strong> <?= date('F j, Y', strtotime($event['date'])) ?></p>
  <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
  <p><strong>Tickets Available:</strong> <?= $event['available_tickets'] ?></p>

  <form id="bookingForm">
    <input type="hidden" name="event_id" value="<?= $event['id'] ?>">

    <label for="name">Your Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required>

    <label for="email">Your Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

    <label for="tickets">Number of Tickets:</label>
    <input type="number" name="tickets" min="1" max="<?= $event['available_tickets'] ?>" required>

    <button type="submit">Book Now</button>

    <div id="response"></div>
  </form>
</div>

<script>
  const form = document.getElementById('bookingForm');
  const responseBox = document.getElementById('response');

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    responseBox.innerHTML = '';

    const formData = new FormData(form);

    fetch('book.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        responseBox.innerHTML = `<div class="success">${data.message}</div>`;
        form.reset();
      } else {
        responseBox.innerHTML = `<div class="error">${data.message}</div>`;
      }
    })
    .catch(() => {
      responseBox.innerHTML = `<div class="error">Something went wrong. Please try again.</div>`;
    });
  });
</script>

</body>
</html>
