<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'events');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];

// Fetch booking details based on email
$sql = "SELECT * FROM appointments WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Fetch the status of the booking
        $status = strtolower($row['status']); // Make sure status is in lowercase for consistency

        // Determine the class and text based on status
        if ($status == 'accepted') {
            $statusClass = 'accepted';
            $statusText = 'Accepted';
        } elseif ($status == 'rejected') {
            $statusClass = 'rejected';
            $statusText = 'Rejected';
        } else {
            $statusClass = 'pending';
            $statusText = 'Pending';
        }

        // Output the booking details with status
        echo "
        <div class='booking-info'>
            <h3>Booking Number: {$row['booking_number']}</h3>
            <p>Email: {$row['email']}</p>
            <p>Event: {$row['event']}</p>
            <p>Date: {$row['date']}</p>
            <p class='$statusClass'>Status: $statusText</p>
            <button class='cancel-button' data-booking='{$row['booking_number']}'>Cancel Booking</button>
        </div>";
    }
} else {
    echo "<p>No bookings found with this email.</p>";
}

$conn->close();
?>
