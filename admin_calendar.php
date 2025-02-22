<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'events');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the year and month from the URL or use defaults
$currentYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$currentMonth = isset($_GET['month']) ? (int)$_GET['month'] : date('m');

// Validate month and year
if ($currentMonth < 1 || $currentMonth > 12) {
    $currentMonth = date('m');
}
if ($currentYear < 1900 || $currentYear > 2100) {
    $currentYear = date('Y');
}

// Fetch accepted bookings for the current month
$bookedDates = [];
$query = "SELECT * FROM appointments WHERE YEAR(date) = $currentYear AND MONTH(date) = $currentMonth AND status='accepted'";
$events = $conn->query($query);

while ($row = $events->fetch_assoc()) {
    $bookedDates[] = date('Y-m-d', strtotime($row['date'])); // Ensure proper date format
}
$conn->close();

// Get the number of days in the current month
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

// Get the first day of the month (0 = Sunday, 1 = Monday, etc.)
$firstDayOfMonth = date('w', strtotime("$currentYear-$currentMonth-01"));

// Generate previous and next month links
$prevMonth = $currentMonth - 1;
$prevYear = $currentYear;
if ($prevMonth < 1) {
    $prevMonth = 12;
    $prevYear--;
}

$nextMonth = $currentMonth + 1;
$nextYear = $currentYear;
if ($nextMonth > 12) {
    $nextMonth = 1;
    $nextYear++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Calendar</title>
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

        /* Calendar Styles */
        .calendar {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
            flex-direction: column;
        }

        .calendar-header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            font-size: 2rem;
            text-align: center;
        }

        .weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background-color: #f4f4f4;
            padding: 10px 0;
            text-align: center;
            font-weight: bold;
            font-size: 1.2rem;
            border-bottom: 1px solid #ddd;
        }

        .weekdays div {
            padding: 10px 0;
            text-transform: uppercase;
        }

        .calendar-body {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-gap: 10px;
            padding: 20px;
        }

        .day {
            text-align: center;
            padding: 20px 0;
            background-color: #fff;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1.2rem;
        }

        .day:hover {
            background-color: #eaeaea;
        }

        .booked {
            background-color: #ff5733;
            color: white;
        }

        .empty {
            visibility: hidden;
        }

        .nav-button {
            background-color: #007bff;
            color: white;
            padding: 5px 15px;
            border-radius: 5px;
            text-decoration: none;
            margin: 10px;
        }

        .nav-button:hover {
            background-color: #0056b3;
        }
      

        /* Button Styling */
        button, a.button {
            background-color: #ff8c00;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 25px;
            border: none;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
            margin: 20px 0;
            transition: all 0.3s ease;
        }

        button:hover, a.button:hover {
            background-color: #ff5c00;
        }

    </style>
</head>
<body>
    <div class="sidebar">
        <h2 style="text-align:center;">Admin Panel</h2>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_calendar.php">Calendar</a>
        <a href="manage_events.php">Manage Events</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="manage_contact.php">Contact Queries</a>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
    <div class="main-content">
        <header>
            Event Calendar
        </header>
        <div class="calendar">
            <div class="calendar-header">
                <a href="?month=<?php echo $prevMonth; ?>&year=<?php echo $prevYear; ?>" class="nav-button">❮</a>
                <h2><?php echo date('F Y', strtotime("$currentYear-$currentMonth-01")); ?></h2>
                <a href="?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>" class="nav-button">❯</a>
            </div>
            <div class="weekdays">
                <div>Sunday</div>
                <div>Monday</div>
                <div>Tuesday</div>
                <div>Wednesday</div>
                <div>Thursday</div>
                <div>Friday</div>
                <div>Saturday</div>
            </div>
            <div class="calendar-body">
            <?php
// Print empty cells for the first day of the month
for ($i = 0; $i < $firstDayOfMonth; $i++) {
    echo '<div class="day empty"></div>';
}

// Get today's date to compare against booked dates
$today = date('Y-m-d');

// Print days of the month
for ($day = 1; $day <= $daysInMonth; $day++) {
    $currentDate = "$currentYear-$currentMonth-" . str_pad($day, 2, '0', STR_PAD_LEFT);

    // Check if the current date is booked and if it's not in the past
    $isBooked = (in_array($currentDate, $bookedDates) && $currentDate >= $today) ? 'booked' : '';

    echo "<div class='day $isBooked'>$day</div>";
}
?>

            </div>
        </div>
    </div>
</body>
</html>
