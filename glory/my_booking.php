<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'events');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Booking</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for AJAX -->
    <style>
        .accepted { color: green; font-weight: bold; }
        .pending { color: orange; font-weight: bold; }
        .rejected { color: red; font-weight: bold; }
        .success { color: #008000; font-weight: bold; margin-top: 10px; }
        .error { color: #cc0000; font-weight: bold; margin-top: 10px; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        .booking-box {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
            margin-bottom: 20px;
        }

        .booking-box h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .booking-box input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }

        .booking-box button {
            background: #6a5acd;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .booking-box button:hover { background: #483d8b; }

        .booking-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            max-width: 1200px;
        }

        .booking-info {
            flex: 1 1 calc(33.33% - 20px);
            max-width: 350px;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .cancel-button {
            background: #ff4d4d;
            color: white;
            padding: 8px 15px;
            margin-top: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .cancel-button:hover { background: #cc0000; }

        .back-home {
            display: block;
            margin-top: 15px;
            font-size: 16px;
            color: #6a5acd;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .back-home:hover { color: #483d8b; }
    </style>
</head>
<body>

<main>
    <div class="booking-box">
        <h2>Find Your Booking</h2>
        <form id="search-form">
            <input type="email" name="email" id="email" placeholder="Enter your email" required>
            <button type="submit">Check Booking</button>
        </form>
        <div id="cancelMessage"></div>
        <div id="bookingDetails"></div>

        <a href="home.php" class="back-home">← Back to Home</a>
    </div>
</main>

<script>
$(document).ready(function() {
    // Search for bookings without refreshing
    $("#search-form").submit(function(event) {
        event.preventDefault();
        var email = $("#email").val();

        $.ajax({
            url: "fetch_bookings.php",
            type: "POST",
            data: { email: email },
            success: function(response) {
                $("#bookingDetails").html(response);
            }
        });
    });

    // Cancel Booking using AJAX
    $(document).on("click", ".cancel-button", function() {
        var bookingNumber = $(this).data("booking");
        var email = $("#email").val(); // Get the current email

        $.ajax({
            url: "cancel_booking.php",
            type: "POST",
            data: { booking_number: bookingNumber, email: email },
            success: function(response) {
                $("#cancelMessage").html(response);
                $("#search-form").submit(); // Refresh bookings without reloading page
            }
        });
    });
});
</script>

</body>
</html>
