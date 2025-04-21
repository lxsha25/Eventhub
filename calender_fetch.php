
<?php
// If this request is for JSON events (from AJAX), return them
if (isset($_GET['load']) && $_GET['load'] === 'events') {
    include 'db_connect.php';
    header('Content-Type: application/json');

    $sql = "SELECT name, date FROM events";
    $result = mysqli_query($conn, $sql);

    $events = array();
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = array(
                'title' => $row['name'],
                'start' => $row['date']
            );
        }
    }

    echo json_encode($events);
    mysqli_close($conn);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>EventHub Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
    <style>
        body {
            font-family: sans-serif;
            background: #f9fafb;
            margin: 0;
            padding: 0;
        }
        header {
            background: #1f2937;
            color: white;
            text-align: center;
            padding: 20px;
        }
        h1 {
            margin: 0;
        }
        #calendar {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <header>
        <h1>📅 Event Calendar - EventHub</h1>
        <p>See upcoming events visually</p>
    </header>

    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: 'calendar.php?load=events', // This same file returns JSON
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                height: 'auto',
            });
            calendar.render();
        });
    </script>

</body>
</html>
