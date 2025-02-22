<?php
$conn = new mysqli('localhost', 'root', '', 'events');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$bookingNumber = $_POST['booking_number'];

$query = "DELETE FROM appointments WHERE booking_number = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $bookingNumber);

if ($stmt->execute()) {
    echo "<p class='success'>Your booking has been successfully canceled.</p>";
} else {
    echo "<p class='error'>Error canceling booking.</p>";
}

$stmt->close();
$conn->close();
?>
