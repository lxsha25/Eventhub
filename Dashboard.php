<?php
$events = [
    ["title" => "Music Fiesta", "category" => "Music", "date" => "2025-05-10", "url" => "event_details.php?id=1", "bg" => "images/music_fiesta.png", "color" => "#ff9999"],
    ["title" => "Tech Conference 2025", "category" => "Technology", "date" => "2025-06-15", "url" => "event_details.php?id=2", "bg" => "images/tech_conference.jpg", "color" => "#99ccff"],
    ["title" => "Food Carnival", "category" => "Food", "date" => "2025-04-22", "url" => "event_details.php?id=3", "bg" => "images/food_carnival.jpg", "color" => "#ffcc99"],
    ["title" => "Startup Pitch Fest", "category" => "Business", "date" => "2025-07-05", "url" => "event_details.php?id=4", "bg" => "images/startup_pitchfest.jpg", "color" => "#b3e6b3"],
    ["title" => "Jazz Night", "category" => "Music", "date" => "2025-05-22", "url" => "event_details.php?id=5", "bg" => "images/jazz_night.jpg", "color" => "#cc99ff"],
    ["title" => "IPL: CSK vs MI", "category" => "Sports", "date" => "2025-04-08", "url" => "event_details.php?id=6", "bg" => "images/ipl_csk_mi.jpg", "color" => "#ffe066"],
    ["title" => "IPL: RCB vs KKR", "category" => "Sports", "date" => "2025-04-10", "url" => "event_details.php?id=7", "bg" => "images/ipl_rcb_kkr.jpg", "color" => "#ffb366"],
    ["title" => "IPL: DC vs RR", "category" => "Sports", "date" => "2025-04-12", "url" => "event_details.php?id=8", "bg" => "images/ipl_dc_rr.jpg", "color" => "#99e6e6"],
    ["title" => "IPL: LSG vs GT", "category" => "Sports", "date" => "2025-04-15", "url" => "event_details.php?id=9", "bg" => "images/ipl_lsg_gt.jpg", "color" => "#d5f4e6"],
    ["title" => "IPL: PBKS vs SRH", "category" => "Sports", "date" => "2025-04-18", "url" => "event_details.php?id=10", "bg" => "images/ipl_pbks_srh.jpg", "color" => "#f4cccc"],
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>EventHub Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #b2fefa, #0ed2f7);
            margin: 0;
        }
        .navbar {
            background: #002244;
            padding: 15px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .navbar .logo {
            font-size: 22px;
            font-weight: bold;
        }
        .navbar .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
        }
        .navbar .nav-links a:hover {
            color: #00ffff;
        }
        h1 {
            text-align: center;
            color: #003366;
            margin-top: 20px;
        }
        .filter {
            text-align: center;
            margin: 20px 0;
        }
        select {
            padding: 8px 12px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .events-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        a.event-link {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo">🎟️ EventHub</div>
        <div class="nav-links">
            <a href="#">Home</a>
            <a href="#">My Bookings</a>
            <a href="#">Support</a>
            <a href="#">Logout</a>
        </div>
    </div>

    <h1>Welcome to EventHub Dashboard</h1>

    <div class="filter">
        <label for="categorySelect">Filter by Category: </label>
        <select id="categorySelect" onchange="filterEvents()">
            <option value="All">All</option>
            <option value="Music">Music</option>
            <option value="Technology">Technology</option>
            <option value="Food">Food</option>
            <option value="Business">Business</option>
            <option value="Sports">Sports</option>
        </select>
    </div>

    <div class="events-container" id="eventsContainer">
        <?php foreach ($events as $event): ?>
            <a href="<?= $event['url'] ?>" class="event-link">
                <div class="event-card" data-category="<?= $event['category'] ?>"
                    style="
                        background: <?= $event['color'] ?> url('<?= $event['bg'] ?>') center/cover no-repeat;
                        padding: 20px;
                        height: 200px;
                        border-radius: 15px;
                        box-shadow: 0 4px 6px rgba(0,0,0,0.3);
                        color: white;
                        position: relative;
                        overflow: hidden;
                        transition: transform 0.3s ease, box-shadow 0.3s ease;
                        display: flex;
                        flex-direction: column;
                        justify-content: flex-end;
                        cursor: pointer;">
                    <div style="background: rgba(0,0,0,0.6); padding: 10px; border-radius: 10px;">
                        <div style="font-size:18px; font-weight:bold;"><?= $event['title'] ?></div>
                        <div style="font-size:14px;"><?= $event['category'] ?> | <?= $event['date'] ?></div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <script>
        function filterEvents() {
            const selected = document.getElementById('categorySelect').value;
            const cards = document.querySelectorAll('.event-card');

            cards.forEach(card => {
                const category = card.getAttribute('data-category');
                card.parentElement.style.display = (selected === 'All' || category === selected) ? 'block' : 'none';
            });
        }
    </script>

</body>
</html>
