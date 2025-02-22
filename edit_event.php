<?php
// Fetch the event to be edited securely
$eventId = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Sanitizing the input

if ($eventId === 0) {
    die('Invalid event ID.');
}

$conn = new mysqli('localhost', 'root', '', 'events');

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch event details securely using prepared statement
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $eventId);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();

if (!$event) {
    die("Event not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventName = $_POST['event_name'];
    $eventDescription = $_POST['event_description'];
    $eventDate = $_POST['event_date'];
    $status = $_POST['status'];

    // Image upload (optional)
    if ($_FILES['event_image']['error'] == 0) {
        $imagePath = 'uploads/' . basename($_FILES['event_image']['name']);
        move_uploaded_file($_FILES['event_image']['tmp_name'], $imagePath);
    } else {
        $imagePath = $event['event_image']; // Keep the old image if not uploaded
    }

    // Update event using prepared statement
    $updateStmt = $conn->prepare("UPDATE events SET event_name = ?, event_description = ?, event_date = ?, status = ?, event_image = ? WHERE id = ?");
    $updateStmt->bind_param("sssssi", $eventName, $eventDescription, $eventDate, $status, $imagePath, $eventId);
    $updateStmt->execute();

    // Close the connection and redirect
    $updateStmt->close();
    $conn->close();
    header("Location: manage_events.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        nav {
            margin-top: 10px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        /* Main Section Styling */
        main {
            padding: 20px;
            width: 80%;
            margin: 0 auto;
        }

        section {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            color: #333;
        }

        input[type="text"], input[type="date"], textarea, select, input[type="file"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        input[type="text"]:focus, input[type="date"]:focus, textarea:focus, select:focus, input[type="file"]:focus {
            outline: none;
            border-color: #007BFF;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            padding: 12px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Button Styling for Navigation */
        a.button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        a.button:hover {
            background-color: #218838;
        }

    </style>
</head>
<body>
    <header>
        <h1>Edit Event</h1>
        <nav>
            <a href="manage_events.php">Manage Events</a>
        </nav>
    </header>
    <main>
        <section>
            <form action="edit_event.php?id=<?= htmlspecialchars($event['id']); ?>" method="POST" enctype="multipart/form-data">
                <label for="event_name">Event Name</label>
                <input type="text" name="event_name" value="<?= htmlspecialchars($event['event_name']); ?>" required>

                <label for="event_description">Event Description</label>
                <textarea name="event_description" required><?= htmlspecialchars($event['event_description']); ?></textarea>

                <label for="event_date">Event Date</label>
                <input type="date" name="event_date" value="<?= htmlspecialchars($event['event_date']); ?>" required>

                <label for="status">Status</label>
                <select name="status" required>
                    <option value="active" <?= $event['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?= $event['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                </select>

                <label for="event_image">Event Image</label>
                <input type="file" name="event_image">
                <button type="submit">Update Event</button>
            </form>
        </section>
    </main>
</body>
</html>
