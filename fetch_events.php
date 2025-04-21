<?php
header('Content-Type: application/json');
include 'db_connect.php';

// --- Fetch from MySQL Database ---
$mysqlEvents = [];
$result = $conn->query("SELECT id, title, description, location, date, category, available_tickets FROM events");
while ($row = $result->fetch_assoc()) {
    $mysqlEvents[] = [
        'id' => 'db-' . $row['id'],
        'title' => $row['title'],
        'description' => $row['description'],
        'location' => $row['location'],
        'start' => $row['date'],
        'category' => $row['category'],
        'available_tickets' => $row['available_tickets'],
        'source' => 'Database'
    ];
}

// --- Static Hardcoded Events (same as dashboard.php) ---
$staticEvents = [
    [
        'id' => 'static-1',
        'title' => 'Music Fiesta',
        'description' => 'Enjoy live performances by top artists in an electrifying atmosphere.',
        'location' => 'Open Grounds, City Center',
        'start' => '2025-04-20',
        'category' => 'Music',
        'available_tickets' => 120,
        'source' => 'Static'
    ],
    [
        'id' => 'static-2',
        'title' => 'Tech Conference 2025',
        'description' => 'Dive into the future of technology with top industry leaders.',
        'location' => 'Tech Hub Auditorium',
        'start' => '2025-05-10',
        'category' => 'Technology',
        'available_tickets' => 80,
        'source' => 'Static'
    ],
    [
        'id' => 'static-3',
        'title' => 'Food Carnival',
        'description' => 'Taste delicious dishes from around the world.',
        'location' => 'Central Park',
        'start' => '2025-04-25',
        'category' => 'Food',
        'available_tickets' => 200,
        'source' => 'Static'
    ],
    [
        'id' => 'static-4',
        'title' => 'Startup Pitch Fest',
        'description' => 'Watch budding entrepreneurs pitch their ideas to investors.',
        'location' => 'Innovation Hall',
        'start' => '2025-05-15',
        'category' => 'Business',
        'available_tickets' => 60,
        'source' => 'Static'
    ]
];

// --- External Events (Mock API Simulation) ---
$externalEvents = [];

$externalEvents[] = [
    'id' => 'api-evt1',
    'title' => 'Eventbrite Hackathon',
    'description' => 'A 24-hour hackathon to solve real-world problems.',
    'location' => 'Online',
    'start' => '2025-05-18',
    'category' => 'Hackathon',
    'available_tickets' => 150,
    'source' => 'Eventbrite'
];

$externalEvents[] = [
    'id' => 'api-evt2',
    'title' => 'Meetup: AI & Robotics',
    'description' => 'Meet industry experts and discuss AI trends.',
    'location' => 'Tech Park Auditorium',
    'start' => '2025-05-22',
    'category' => 'Meetup',
    'available_tickets' => 100,
    'source' => 'Meetup'
];

// --- Combine All Events ---
$allEvents = array_merge($mysqlEvents, $staticEvents, $externalEvents);

// --- Format for FullCalendar or Card View ---
$formattedEvents = array_map(function ($event) {
    return [
        'title' => $event['title'],
        'start' => $event['start'],
        'url' => 'book_ticket.php?event_id=' . urlencode($event['id']),
        'extendedProps' => [
            'location' => $event['location'],
            'description' => $event['description'],
            'category' => $event['category'],
            'available_tickets' => $event['available_tickets'],
            'source' => $event['source']
        ]
    ];
}, $allEvents);

// --- Output JSON ---
echo json_encode($formattedEvents);
?>
