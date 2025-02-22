<?php
$conn = new mysqli('localhost', 'root', '', 'events');

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all events securely using a prepared statement
$query = "SELECT * FROM events";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
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

        /* Add space between Manage Events and Add New Event button */
        .main-content a.button {
            margin-top: 30px; /* Adds space above the Add New Event button */
            display: inline-block; /* Ensures it's not affected by other elements */
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

        /* Table Styling */
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f1f1f1;
        }

        table tr:nth-child(even) {
            background-color: #fafafa;
        }

        .button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .button:hover {
            background-color: #218838;
        }

        /* Action Button Styling */
        .delete-button {
            color: #dc3545;
            text-decoration: none;
            font-size: 14px;
        }

        .delete-button:hover {
            text-decoration: underline;
        }
        
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2 style="text-align:center;color:white;">Admin Panel</h2>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_calendar.php">Calendar</a>
        <a href="manage_events.php">Manage Events</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="manage_contact.php">Contact Queries</a>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            Manage Events
        </header>
        <main>
            <section>
                <a href="add_event.php" class="button">Add New Event</a>
                <table>
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['event_name']); ?></td>
                                <td><?= htmlspecialchars($row['event_description']); ?></td>
                                <td><?= htmlspecialchars($row['event_date']); ?></td>
                                <td><?= htmlspecialchars($row['status']); ?></td>
                                
                                <td>
                                    <a href="edit_event.php?id=<?= urlencode($row['id']); ?>">Edit</a> |
                                    <a href="delete_event.php?id=<?= urlencode($row['id']); ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>
