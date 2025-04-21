
<?php
session_start();
include 'db_connect.php';

$logged_in = isset($_SESSION['user_id']);
$today = date('Y-m-d');

// Hardcoded events (same as dashboard)
$events_data = [
    [
        "id" => 1,
        "title" => "Music Fiesta",
        "description" => "Enjoy live performances by top artists in an electrifying atmosphere.",
        "location" => "Open Grounds, City Center",
        "date" => "2025-04-20",
        "available_tickets" => 120,
        "category" => "Music"
    ],
    [
        "id" => 2,
        "title" => "Tech Conference 2025",
        "description" => "Dive into the future of technology with top industry leaders.",
        "location" => "Tech Hub Auditorium",
        "date" => "2025-05-10",
        "available_tickets" => 80,
        "category" => "Technology"
    ],
    [
        "id" => 3,
        "title" => "Food Carnival",
        "description" => "Taste delicious dishes from around the world.",
        "location" => "Central Park",
        "date" => "2025-04-25",
        "available_tickets" => 200,
        "category" => "Food"
    ],
    [
        "id" => 4,
        "title" => "Startup Pitch Fest",
        "description" => "Watch budding entrepreneurs pitch their ideas to investors.",
        "location" => "Innovation Hall",
        "date" => "2025-05-15",
        "available_tickets" => 60,
        "category" => "Business"
    ],
    [
        "id" => 5,
        "title" => "Jazz Night",
        "description" => "Experience the soothing tunes of live jazz music.",
        "location" => "City Jazz Club",
        "date" => "2025-04-30",
        "available_tickets" => 50,
        "category" => "Music"
    ],
    [
        "id" => 6,
        "title" => "IPL: CSK vs MI",
        "description" => "Thrilling cricket action between CSK and MI.",
        "location" => "Stadium A",
        "date" => "2025-04-22",
        "available_tickets" => 500,
        "category" => "Sports"
    ],
    [
        "id" => 7,
        "title" => "IPL: RCB vs KKR",
        "description" => "Watch RCB face off against KKR in this high-voltage match.",
        "location" => "Stadium B",
        "date" => "2025-04-23",
        "available_tickets" => 500,
        "category" => "Sports"
    ],
    [
        "id" => 8,
        "title" => "IPL: DC vs RR",
        "description" => "Exciting clash between DC and RR under the floodlights.",
        "location" => "Stadium C",
        "date" => "2025-04-24",
        "available_tickets" => 500,
        "category" => "Sports"
    ],
    [
        "id" => 9,
        "title" => "IPL: LSG vs GT",
        "description" => "Catch LSG vs GT in a battle of tactics and power-hitting.",
        "location" => "Stadium D",
        "date" => "2025-04-26",
        "available_tickets" => 500,
        "category" => "Sports"
    ],
    [
        "id" => 10,
        "title" => "IPL: PBKS vs SRH",
        "description" => "Witness PBKS take on SRH in a nail-biting encounter.",
        "location" => "Stadium E",
        "date" => "2025-04-27",
        "available_tickets" => 500,
        "category" => "Sports"
    ]
];

$calendar_events = array_map(function ($event) {
    return [
        'title' => $event['title'],
        'start' => $event['date'],
        'url' => 'book_ticket.php?event_id=' . $event['id']
    ];
}, $events_data);

$image_map = [
    "Music Fiesta" => "https://cdn-icons-png.flaticon.com/512/727/727245.png",
    "Tech Conference 2025" => "https://images.unsplash.com/photo-1537432376769-00a3d7c5f195?fit=crop&w=800&q=80",
    "Food Carnival" => "https://images.unsplash.com/photo-1604908177073-8aa355ba1d10?fit=crop&w=800&q=80",
    "Startup Pitch Fest" => "https://images.unsplash.com/photo-1519389950473-47ba0277781c?fit=crop&w=800&q=80",
    "Jazz Night" => "https://images.unsplash.com/photo-1544936207-ef5c3e12480b?fit=crop&w=800&q=80",
    "IPL: CSK vs MI" => "https://img.freepik.com/free-vector/cricket-stadium-night-match-background-design_1017-45444.jpg",
    "IPL: RCB vs KKR" => "https://img.freepik.com/premium-vector/cricket-tournament-sports-banner-poster_1302-24797.jpg",
    "IPL: DC vs RR" => "https://img.freepik.com/free-vector/realistic-cricket-tournament-banner-with-golden-cup_1017-44800.jpg",
    "IPL: LSG vs GT" => "https://img.freepik.com/premium-vector/ipl-cricket-league-banner_715435-40.jpg",
    "IPL: PBKS vs SRH" => "https://img.freepik.com/free-vector/flat-design-cricket-stadium-background_23-2148701435.jpg"
];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Explore Events - EventHub</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, rgba(243,244,246,1), rgba(255,245,230,1), rgba(240,248,255,1));
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 1200px;
      margin: 30px auto;
      padding: 0 20px;
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
      color: #1f2937;
    }
    .search-bar {
      text-align: center;
      margin-bottom: 30px;
    }
    .search-bar input {
      padding: 10px;
      width: 60%;
      max-width: 500px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }
    .event-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
    }
    .event-card {
      background: linear-gradient(135deg, rgba(173,216,230,0.3), rgba(221,160,221,0.3), rgba(210,180,140,0.3));
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }
    .event-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }
    .event-card .content {
      padding: 15px;
    }
    .event-card h3 {
      margin: 0 0 10px;
      color: #111827;
    }
    .event-card p {
      margin: 5px 0;
      color: #4b5563;
    }
    .event-card a {
      display: inline-block;
      margin-top: 10px;
      background: #3b82f6;
      color: white;
      padding: 10px 15px;
      border-radius: 6px;
      text-decoration: none;
    }
  </style>
</head>
<body>
<div class="container">
  <h1>Upcoming Events</h1>

  <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search events by title or category...">
  </div>

  <div class="event-grid" id="eventGrid">
    <?php foreach ($events_data as $event): ?>
      <div class="event-card">
        <img src="<?= $image_map[$event['title']] ?? '#' ?>" alt="<?= htmlspecialchars($event['title']) ?>">
        <div class="content">
          <h3><?= htmlspecialchars($event['title']) ?></h3>
          <p><?= htmlspecialchars($event['description']) ?></p>
          <p><strong>📍 <?= htmlspecialchars($event['location']) ?></strong></p>
          <p>📅 <?= date('F j, Y', strtotime($event['date'])) ?></p>
          <p>🎟️ Tickets Left: <?= $event['available_tickets'] ?></p>
          <a href="book_ticket.php?event_id=<?= $event['id'] ?>">Book Now</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
  const searchInput = document.getElementById('searchInput');
  const eventCards = document.querySelectorAll('.event-card');

  searchInput.addEventListener('input', function () {
    const query = this.value.toLowerCase();
    eventCards.forEach(card => {
      const title = card.querySelector('h3').textContent.toLowerCase();
      const category = card.querySelector('p:nth-of-type(2)').textContent.toLowerCase();
      if (title.includes(query) || category.includes(query)) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  });
</script>
</body>
</html>
