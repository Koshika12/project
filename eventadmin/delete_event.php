<?php
// Delete event
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    $conn = new mysqli('localhost', 'root', '', 'events');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->query("DELETE FROM events WHERE id = $eventId");
    $conn->close();

    header("Location: manage_events.php");
}
?>
