<?php
session_start();
include 'db_connect.php';

// ✅ Handle AJAX fetch request
if (isset($_GET['fetch'])) {
    $events = [];
    $sql = "SELECT * FROM events ORDER BY date ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $events[] = [
                'title' => $row['title'],
                'start' => $row['date'],
                'url' => 'book_ticket.php?event_id=' . $row['id'],
                'color' => getCategoryColor($row['category']),
                'extendedProps' => [
                    'description' => $row['description'],
                    'venue' => $row['venue'],
                    'category' => $row['category']
                ]
            ];
        }
    }

    function getCategoryColor($category) {
        switch (strtolower($category)) {
            case 'music': return '#3b82f6';
            case 'sports': return '#10b981';
            case 'theatre': return '#f59e0b';
            case 'comedy': return '#ef4444';
            default: return '#6366f1';
        }
    }

    header('Content-Type: application/json');
    echo json_encode($events);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Calendar - EventHub</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/tippy.js@6"></script>
    <link href="https://cdn.jsdelivr.net/npm/tippy.js@6/animations/scale.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f3f4f6;
        }
        #calendar {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #1f2937;
        }
        .fc-daygrid-event {
            cursor: pointer;
            font-weight: bold;
        }
        .legend {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px auto;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .legend-color {
            width: 14px;
            height: 14px;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<h2>📅 Event Calendar</h2>

<div class="legend">
    <div class="legend-item"><div class="legend-color" style="background:#3b82f6"></div>Music</div>
    <div class="legend-item"><div class="legend-color" style="background:#10b981"></div>Sports</div>
    <div class="legend-item"><div class="legend-color" style="background:#f59e0b"></div>Theatre</div>
    <div class="legend-item"><div class="legend-color" style="background:#ef4444"></div>Comedy</div>
</div>

<div id='calendar'></div>

<!-- Event Modal -->
<div id="eventModal" style="display:none; position:fixed; top:20%; left:50%; transform:translateX(-50%);
    background:#fff; padding:20px; border-radius:10px; box-shadow:0 4px 16px rgba(0,0,0,0.2); z-index:999;">
    <h3 id="modalTitle" style="margin-top:0;"></h3>
    <p id="modalDescription"></p>
    <p id="modalVenue"></p>
    <button onclick="closeModal()" style="background:#ef4444; color:white; border:none; padding:8px 16px; border-radius:8px;">Close</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            },
            events: 'events_calendar.php?fetch=1', // Fetching events from the same file
            eventDidMount: function(info) {
                tippy(info.el, {
                    content: info.event.extendedProps.description || "No description",
                    theme: 'light-border',
                    placement: 'top',
                    animation: 'scale',
                });
            },
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                document.getElementById("modalTitle").innerText = info.event.title;
                document.getElementById("modalDescription").innerText = "Description: " + (info.event.extendedProps.description || 'N/A');
                document.getElementById("modalVenue").innerText = "Venue: " + (info.event.extendedProps.venue || 'TBA');
                document.getElementById("eventModal").style.display = "block";
            },
            dayCellDidMount: function(info) {
                if (info.date.toDateString() === new Date().toDateString()) {
                    info.el.style.backgroundColor = '#dbeafe';
                }
            }
        });

        calendar.render();
    });

    function closeModal() {
        document.getElementById("eventModal").style.display = "none";
    }
</script>

</body>
</html>
