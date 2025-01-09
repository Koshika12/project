<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'events');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch pending bookings with event names
$pendingBookings = $conn->query("SELECT id, name, email, date, event, booking_number, status FROM appointments WHERE status='pending'");

// Fetch accepted bookings with event names
$acceptedBookings = $conn->query("SELECT id, name, email, date, event, booking_number, status FROM appointments WHERE status='accepted'");

// Fetch contact queries
$contactQueries = $conn->query("SELECT * FROM contact_form");

// Accept a booking
if (isset($_POST['accept_booking'])) {
    $bookingId = $_POST['booking_id'];
    $conn->query("UPDATE appointments SET status='accepted' WHERE id=$bookingId");
    header("Location: admin_dashboard.php");
}

// Delete a booking if the date is in the past
if (isset($_POST['delete_booking'])) {
    $bookingId = $_POST['booking_id'];
    $conn->query("DELETE FROM appointments WHERE id=$bookingId");
    header("Location: admin_dashboard.php");  // Refresh the page after deletion
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <style>
        /* General Reset and Body Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

       /* Sidebar Styling */
.sidebar {
    height: 100%;
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #333;
    color: white;
    padding-top: 20px;
    display: flex;
    flex-direction: column;
}

/* Sidebar Links Styling */
.sidebar a {
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
    margin: 0; /* No gaps between menu items */
    font-weight: bold;
    transition: background-color 0.3s;
}

/* Hover Effect for Sidebar Links */
.sidebar a:hover {
    background-color: #575757;
}

/* Ensure Logout button is at the bottom */
.sidebar .logout-button {
    margin-top: auto; /* Pushes the Logout button to the bottom */
    background-color: #dc3545;  /* Red background */
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    font-size: 1rem;
    width: 100%;                /* Full width button */
    text-align: center;
    transition: background-color 0.3s;
}

.sidebar .logout-button:hover {
    background-color: #c82333;  /* Darker red on hover */
}


        /* Main Content Area */
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 2rem;
        }

        /* Table Layout */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #218838;
        }

        .delete-button {
            background-color: #dc3545;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        .booking-actions {
            display: flex;
            gap: 10px;
        }
        /* Logout Button Styling */
         .logout-button {

              background-color: #dc3545; /* Red background */
                   color: white;
                    border: none;
             padding: 10px 15px;
           cursor: pointer;
          font-size: 1rem;
          width: 100%; /* Full width button */
            text-align: center;
             transition: background-color 0.3s;
          }



         .logout-button:hover {
              background-color: #c82333; /* Darker red on hover */
          }


        /* Query Section Styling */
        .query {
            background-color: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .query p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2 style="text-align:center;color:white;">Admin Panel</h2>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_calendar.php">Calendar</a>
        <a href="manage_events.php">Manage Events</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
    <div class="main-content">
        <header>Admin Dashboard</header>

        <!-- Pending Bookings Section -->
        <section>
            <h2>Pending Bookings</h2>
            <table>
                <thead>
                    <tr>
                        <th>Booking Number</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Status</th>  <!-- Added Status Column -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $pendingBookings->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['booking_number']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= $row['event']; ?></td>
                            <td><?= $row['date']; ?></td>
                            <td><?= $row['status']; ?></td>  <!-- Display the Status -->
                            <td class="booking-actions">
                                <form method="POST">
                                    <input type="hidden" name="booking_id" value="<?= $row['id']; ?>">
                                    <button type="submit" name="accept_booking" class="button">Accept</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <!-- Accepted Bookings Section -->
        <section>
            <h2>Accepted Bookings</h2>
            <table>
                <thead>
                    <tr>
                        <th>Booking Number</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Status</th>  <!-- Added Status Column -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $acceptedBookings->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['booking_number']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= $row['event']; ?></td>
                            <td><?= $row['date']; ?></td>
                            <td><?= $row['status']; ?></td>  <!-- Display the Status -->
                            <td class="booking-actions">
                                <?php if (strtotime($row['date']) < time()): ?>
                                    <form method="POST">
                                        <input type="hidden" name="booking_id" value="<?= $row['id']; ?>">
                                        <button type="submit" name="delete_booking" class="button delete-button">Delete</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <!-- Contact Queries Section -->
        <section>
            <h2>Contact Queries</h2>
            <?php while ($row = $contactQueries->fetch_assoc()): ?>
                <div class="query">
                    <p><strong>Name:</strong> <?= $row['name']; ?></p>
                    <p><strong>Message:</strong> <?= $row['message']; ?></p>
                </div>
            <?php endwhile; ?>
        </section>
    </div>
</body>
</html>
