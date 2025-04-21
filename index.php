<?php
session_start();
$isLoggedIn = isset($_SESSION["user_id"]);

$events = [
    [
        "title" => "Music Fest 2025",
        "date" => "2025-05-12",
        "location" => "Central Park, NY",
        "image" => "images/music_fest.jpg",
    ],
    [
        "title" => "Tech Expo",
        "date" => "2025-06-01",
        "location" => "Silicon Valley, CA",
        "image" => "images/tech_expo.jpg",
    ],
    [
        "title" => "Food Carnival",
        "date" => "2025-04-20",
        "location" => "Chicago, IL",
        "image" => "images/food_carnival.jpg",
    ],
    [
        "title" => "Comedy Night",
        "date" => "2025-05-05",
        "location" => "Austin, TX",
        "image" => "images/comedy_night.jpg",
    ]
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to EventHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="margin:0;font-family:sans-serif;background:#a0d6d3;">

<!-- Header -->
<header style="background:#1f2937;color:white;padding:20px;text-align:center;">
    <h1 style="margin:0;font-size:36px;">🎟️ Welcome to <span style="color:#3b82f6;">EventHub</span></h1>
    <p style="margin:5px 0 0;font-size:18px;">Your one-stop event ticket booking platform</p>
</header>

<!-- Navbar -->
<nav style="background:#374151;display:flex;flex-wrap:wrap;justify-content:center;gap:20px;padding:10px;">
    <a href="index.php" style="color:white;text-decoration:none;padding:10px 14px;font-size:16px;">Home</a>
    <a href="browse_events.php" style="color:white;text-decoration:none;padding:10px 14px;font-size:16px;">Browse Events</a>
    <?php if ($isLoggedIn): ?>
        <a href="dashboard.php" style="color:white;text-decoration:none;padding:10px 14px;font-size:16px;">Dashboard</a>
        <a href="logout.php" style="color:white;text-decoration:none;padding:10px 14px;font-size:16px;">Logout</a>
    <?php else: ?>
        <a href="login.php" style="color:white;text-decoration:none;padding:10px 14px;font-size:16px;">Login</a>
        <a href="register.php" style="color:white;text-decoration:none;padding:10px 14px;font-size:16px;">Register</a>
    <?php endif; ?>
</nav>

<!-- Main Welcome -->
<div style="display:flex;align-items:center;justify-content:center;padding:50px 20px;background:linear-gradient(to right, #7f5af0, #2cb67d);">
    <div style="background:white;padding:40px;border-radius:15px;box-shadow:0 8px 18px rgba(0,0,0,0.2);text-align:center;max-width:700px;width:100%;">
        <h2 style="color:#111827;font-size:28px;">Discover Amazing Events</h2>
        <p style="color:#6b7280;font-size:18px;">Book tickets in just a few clicks.</p>
        <?php if (!$isLoggedIn): ?>
        <div style="margin-top:25px;">
            <a href="login.php" style="margin:10px;padding:12px 24px;background:#3b82f6;color:white;text-decoration:none;border-radius:6px;font-size:16px;">Login</a>
            <a href="register.php" style="margin:10px;padding:12px 24px;background:#10b981;color:white;text-decoration:none;border-radius:6px;font-size:16px;">Register</a>
        </div>
        <?php else: ?>
        <div style="margin-top:25px;">
            <a href="dashboard.php" style="padding:12px 24px;background:#3b82f6;color:white;text-decoration:none;border-radius:6px;font-size:16px;">Go to Dashboard</a>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Event Cards Section -->
<div style="padding:50px 20px;">
    <h2 style="text-align:center;color:#1f2937;margin-bottom:30px;font-size:28px;">🎉 Upcoming Events</h2>
    <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:30px;">
        <?php foreach ($events as $event): 
            $mapLink = "https://www.google.com/maps/search/" . urlencode($event['location']);
            $detailsLink = "event_details.php?title=" . urlencode($event['title']);
        ?>
        <div class="event-card" style="width:500px;max-width:100%;border-radius:16px;overflow:hidden;background-color:white;box-shadow:0 4px 12px rgba(0,0,0,0.2);transition:transform 0.3s ease;">
            <div style="height:300px;background:url('<?= $event['image'] ?>') no-repeat center center;background-size:cover;"></div>
            <div style="padding:20px;">
                <h3 style="margin:0;font-size:24px;color:#1f2937;"><?= $event['title'] ?></h3>
                <p style="margin:8px 0;font-size:16px;color:#4b5563;">📅 <?= $event['date'] ?></p>
                <p style="margin:0 0 15px;font-size:16px;color:#4b5563;">📍 <a href="<?= $mapLink ?>" target="_blank" style="color:#3b82f6;text-decoration:underline;"><?= $event['location'] ?></a></p>
                <a href="<?= $detailsLink ?>" style="display:inline-block;margin-top:10px;padding:10px 20px;background:#3b82f6;color:white;text-decoration:none;border-radius:6px;font-size:15px;">Book Now</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Footer -->
<footer style="background:#1f2937;color:white;text-align:center;padding:20px;font-size:16px;">
    <p>&copy; 2025 EventHub. All rights reserved.</p>
</footer>

<!-- Script: Hover + Scroll Reveal -->
<script>
    document.querySelectorAll('.event-card').forEach(card => {
        card.addEventListener('mouseover', () => {
            card.style.transform = "scale(1.03)";
        });
        card.addEventListener('mouseout', () => {
            card.style.transform = "scale(1)";
        });
    });

    window.addEventListener('scroll', () => {
        document.querySelectorAll('.event-card').forEach((el, i) => {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight) {
                el.style.opacity = 1;
                el.style.transform = "translateY(0)";
                el.style.transition = `all 0.6s ease ${i * 0.1}s`;
            }
        });
    });

    document.querySelectorAll('.event-card').forEach(el => {
        el.style.opacity = 0;
        el.style.transform = "translateY(40px)";
    });
</script>

</body>
</html>
