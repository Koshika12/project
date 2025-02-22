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

// Fetch contact queries
$contactQueries = $conn->query("SELECT * FROM contact_form");

// Handle admin response
if (isset($_POST['send_response'])) {
    $query_id = $_POST['query_id'];
    $response = $conn->real_escape_string($_POST['response']);
    
    // Update the contact_form with the admin response
    $conn->query("UPDATE contact_form SET response='$response' WHERE id=$query_id");

    // Refresh the page after response submission
    header("Location: manage_contact.php"); // Refresh the page after response
    exit();
}

// Handle message deletion
if (isset($_POST['delete_message'])) {
    $query_id = $_POST['query_id'];
    
    // Delete the query from the contact_form
    $conn->query("DELETE FROM contact_form WHERE id=$query_id");

    // Refresh the page after deletion
    header("Location: manage_contact.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Contact Queries</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
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
        .sidebar a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .sidebar .logout-button {
            margin-top: auto;
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
            text-align: center;
            transition: background-color 0.3s;
        }
        .sidebar .logout-button:hover {
            background-color: #c82333;
        }
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
        .feedback-form {
            margin-top: 10px;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
        }
        .submit-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 5px;
        }
        .submit-btn:hover {
            background-color: #218838;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 5px;
        }
        .delete-btn:hover {
            background-color: #c82333;
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
        <a href="manage_contact.php">Contact Queries</a>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>

    <div class="main-content">
    <header>Contact Queries</header>
    <section>
        <h2>Contact Queries</h2>
        <?php while ($row = $contactQueries->fetch_assoc()): ?>
            <div class="query">
                <p><strong>Name:</strong> <?= htmlspecialchars($row['name']); ?></p>
                <p><strong>Message:</strong> <?= htmlspecialchars($row['message']); ?></p>
                <p><strong>Response:</strong> <?= $row['response'] ? htmlspecialchars($row['response']) : "No response yet."; ?></p>

                <?php if (!$row['response']): ?>
                    <form method="POST" class="response-form">
                        <input type="hidden" name="query_id" value="<?= $row['id']; ?>">
                        <textarea name="response" placeholder="Write your response..." required></textarea>
                        <button type="submit" name="send_response" class="submit-btn">Send Response</button>
                    </form>
                <?php endif; ?>
                
                <!-- Delete Button Form -->
                <form method="POST" class="delete-form" style="margin-top: 10px;">
                    <input type="hidden" name="query_id" value="<?= $row['id']; ?>">
                    <button type="submit" name="delete_message" class="delete-btn">Delete Message</button>
                </form>
            </div>
        <?php endwhile; ?>
    </section>
</div>
</body>
</html>

<?php
// Close the database connection at the end
$conn->close();
?>
