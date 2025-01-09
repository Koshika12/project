<?php
// Add event to the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventName = $_POST['event_name'];
    $eventDescription = $_POST['event_description'];
    $eventDate = $_POST['event_date'];
    $status = $_POST['status'];

    // Initialize image path
    $imagePath = '';

    // Image upload (if needed)
    if ($_FILES['event_image']['error'] == 0) {
        // Validate the image file (to make sure it's an actual image)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['event_image']['type'];
        
        if (in_array($fileType, $allowedTypes)) {
            // Sanitize the file name to avoid any issues
            $imagePath = 'uploads/' . basename($_FILES['event_image']['name']);

            // Ensure the uploads directory exists and is writable
            if (move_uploaded_file($_FILES['event_image']['tmp_name'], $imagePath)) {
                // File uploaded successfully
            } else {
                echo "Error uploading the image.";
            }
        } else {
            echo "Invalid file type. Only JPEG, PNG, and GIF images are allowed.";
            exit;
        }
    }

    // Create a database connection
    $conn = new mysqli('localhost', 'root', '', 'events');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL Injection
    $stmt = $conn->prepare("INSERT INTO events (event_name, event_description, event_date, status, event_image) 
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $eventName, $eventDescription, $eventDate, $status, $imagePath);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: manage_events.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Event</title>
    <style>
        /* General Styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f9;
            color: #333;
        }

        header {
            background-color: #2d2d2d;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 20px;
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
            font-size: 14px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        /* Main Section Styling */
        main {
            padding: 20px;
            max-width: 900px;
            margin: 0 auto;
        }

        section {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 14px;
            color: #555;
        }

        input[type="text"], input[type="date"], textarea, select, input[type="file"] {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            box-sizing: border-box;
        }

        input[type="text"]:focus, input[type="date"]:focus, textarea:focus, select:focus, input[type="file"]:focus {
            outline: none;
            border-color: #4CAF50;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

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

        /* Table style (for navigation) */
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

    </style>
</head>
<body>
    <header>
        <h1>Add New Event</h1>
        <nav>
            <a href="manage_events.php">Manage Events</a>
        </nav>
    </header>
    <main>
        <section>
            <form action="add_event.php" method="POST" enctype="multipart/form-data">
                <label for="event_name">Event Name</label>
                <input type="text" name="event_name" required>

                <label for="event_description">Event Description</label>
                <textarea name="event_description" required></textarea>

                <label for="event_date">Event Date</label>
                <input type="date" name="event_date" required>

                <label for="status">Status</label>
                <select name="status" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>

                <label for="event_image">Event Image</label>
                <input type="file" name="event_image">

                <button type="submit">Add Event</button>
            </form>
        </section>
    </main>
</body>
</html>
