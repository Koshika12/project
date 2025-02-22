<?php
session_start();
$user_id = $_SESSION['user_id']; // Get logged-in user ID

$conn = new mysqli('localhost', 'root', '', 'events');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user has any unread responses
$result = $conn->query("SELECT * FROM contact_form WHERE user_id = $user_id AND response IS NOT NULL AND seen = 0");
$unreadMessages = [];
while ($row = $result->fetch_assoc()) {
    $unreadMessages[] = $row;
}

// If there are unread messages, mark them as seen (so the popup doesn't appear again)
if (!empty($unreadMessages)) {
    $conn->query("UPDATE contact_form SET seen = 1 WHERE user_id = $user_id AND response IS NOT NULL");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        /* Popup Styling */
        #popup {
            display: none; /* Initially hidden */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            background: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            z-index: 1000;
        }
        #popup-overlay {
            display: none; /* Initially hidden */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .close-btn {
            background: red;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- Popup Overlay -->
<div id="popup-overlay"></div>

<!-- Popup Window -->
<div id="popup">
    <h2>New Response from Admin</h2>
    <div id="popup-content"></div>
    <button class="close-btn" onclick="closePopup()">Close</button>
</div>

<script>
    function closePopup() {
        document.getElementById('popup').style.display = 'none';
        document.getElementById('popup-overlay').style.display = 'none';
    }

    // Show the popup if there are unread messages
    let unreadMessages = <?php echo json_encode($unreadMessages); ?>;
    if (unreadMessages.length > 0) {
        let content = "";
        unreadMessages.forEach(msg => {
            content += `<p><strong>Your Message:</strong> ${msg.message}</p>`;
            content += `<p><strong>Admin Response:</strong> ${msg.response}</p><hr>`;
        });
        document.getElementById('popup-content').innerHTML = content;
        document.getElementById('popup').style.display = 'block';
        document.getElementById('popup-overlay').style.display = 'block';
    }
</script>

</body>
</html>
