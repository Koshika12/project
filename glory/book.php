<?php

// Database connection
$conn = new mysqli('localhost', 'root', '', 'events');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$bookingMessage = "";

// Handle new booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $event = $_POST['event_type'];
    $date = $_POST['date'];
    $phone = $_POST['phone'];

    $currentDate = date('Y-m-d');
    if ($date < $currentDate) {
        $bookingMessage = "The selected date has already passed.";
    } else {
        // Check the number of bookings for the selected date
        $query = "SELECT COUNT(*) AS total_bookings FROM appointments WHERE date = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $totalBookings = $row['total_bookings'];

        if ($totalBookings >= 4) {
            $bookingMessage = "This date has reached the maximum booking limit (4 bookings per day). Please select another date.";
        } else {
            // Generate unique booking number
            $bookingNumber = "BKN-" . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));

            $query = "INSERT INTO appointments (name, email, phone, event, date, booking_number) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssss", $name, $email, $phone, $event, $date, $bookingNumber);

            if ($stmt->execute()) {
                $bookingMessage = "Your booking has been confirmed! Booking Number: " . $bookingNumber;
            } else {
                $bookingMessage = "Error booking event: " . $conn->error;
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link rel="stylesheet" href="style4.css">
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        main {
            width: 100%;
            max-width: 400px;
        }

        /* Booking box styling */
        .booking-box {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Success and error messages */
        .message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .message.success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Input fields styling */
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* Button styling */
        button {
            background-color: #28a745;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background-color: #218838;
        }

        /* Back to home button */
        .back-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 10px;
            font-weight: bold;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<main>
    <div class="booking-box">
        <?php if (!empty($bookingMessage)) : ?>
            <h2>Booking Status</h2>
            <p class="message <?php echo strpos($bookingMessage, 'confirmed') !== false ? 'success' : 'error'; ?>">
                <?php echo $bookingMessage; ?>
            </p>
            <a href="home.php" class="back-button">Back to Home</a>
        <?php else : ?>
            <form id="bookingForm" action="book.php" method="POST">
                <h2>Book Your Event</h2>
                <input type="text" name="name" placeholder="Enter Your Name" required>
                <input type="email" name="email" placeholder="Enter Your Email" required>
                <input type="text" name="phone" placeholder="Enter Your Number" required>
                <select name="event_type" required>
                    <option value="" disabled selected hidden>Select Events</option>
                    <option value="Corporate Events">Corporate Events</option>
                    <option value="Sports Events">Sports Events</option>
                    <option value="Social Events">Social Events</option>
                    <option value="Cultural And Traditional Events">Cultural And Traditional Events</option>
                </select>
                <input type="date" name="date" id="date" required>
                <button type="submit">Book Now</button>
            </form>
        <?php endif; ?>
    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dateInput = document.getElementById("date");
        const today = new Date().toISOString().split("T")[0];
        dateInput.setAttribute("min", today);
    });
</script>

</body>
</html>
