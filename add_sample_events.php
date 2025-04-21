
<?php
include 'db_connect.php';

echo "<div style='font-family: Arial, sans-serif; padding: 20px;'>";

$events = [
    ['Jazz Night', '2025-09-12', 'Downtown Club', 'Enjoy smooth jazz with top artists.'],
    ['Startup Meetup', '2025-10-05', 'Innovation Hub', 'Network with fellow entrepreneurs.'],
    ['Book Fair', '2025-11-20', 'Convention Center', 'Books from various genres and authors.'],
    ['Comedy Show', '2025-12-01', 'Laugh Lounge', 'Stand-up comedy night.'],
    ['Gaming Expo', '2026-01-15', 'Expo Hall', 'Showcasing the latest in gaming.']
];

echo "<h2 style='color: #2c3e50;'>Inserting Events:</h2>";

foreach ($events as $event) {
    $name = $event[0];
    $date = $event[1];
    $venue = $event[2];
    $description = $event[3];

    $sql = "INSERT INTO events (name, date, venue, description) VALUES ('$name', '$date', '$venue', '$description')";
    if (mysqli_query($conn, $sql)) {
        echo "<p style='color: green; margin: 5px 0;'>✔️ Event '<strong>$name</strong>' added successfully.</p>";
    } else {
        echo "<p style='color: red; margin: 5px 0;'>❌ Error adding event '<strong>$name</strong>': " . mysqli_error($conn) . "</p>";
    }
}

echo "</div>";

mysqli_close($conn);
?>
