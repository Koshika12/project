<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer through Composer's autoloader
require 'phpmailer/vendor/autoload.php';

// Database connection
$conn = new mysqli('localhost', 'root', '', 'events');
if ($conn->connect_error) {
    die("Database connection failed.");
}

// Get user details for editing
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "User not found.";
        exit();
    }
} else {
    header("Location: manage_users.php");
    exit();
}

// Handle form submission to update user details
if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $status = $conn->real_escape_string($_POST['status']);
    $password = !empty($_POST['password']) ? $_POST['password'] : null;

    // Hash password if provided
    $hashedPassword = $password ? password_hash($password, PASSWORD_DEFAULT) : null;

    // Update user details
    $stmt = $conn->prepare(
        "UPDATE users SET name = ?, email = ?, status = ?, password = IFNULL(?, password) WHERE id = ?"
    );
    $stmt->bind_param("ssssi", $name, $email, $status, $hashedPassword, $id);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Send email notification if password was updated
        if ($password) {
            $mail = new PHPMailer(true);

            try {
                // SMTP configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = getenv('SMTP_EMAIL'); // Use environment variables
                $mail->Password = getenv('SMTP_PASSWORD'); // Use environment variables
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Email settings
                $mail->setFrom(getenv('SMTP_EMAIL'), 'Admin');
                $mail->addAddress($email, $name);
                $mail->Subject = "Your Password Has Been Changed";
                $mail->isHTML(true); // Use HTML content
                $mail->Body = "
                    <p>Hello <strong>$name</strong>,</p>
                    <p>Your password has been changed by an administrator. Here are your new login details:</p>
                    <p><strong>Email:</strong> $email<br>
                    <strong>Password:</strong> $password</p>
                    <p>Please log in and change your password as soon as possible for security reasons.</p>
                    <p>Thank you!</p>
                ";
                $mail->AltBody = "Hello $name,\n\nYour password has been changed. Login with Email: $email and Password: $password.";

                // Send email
                $mail->send();
                echo "<script>alert('Password update email sent to $email.');</script>";
            } catch (Exception $e) {
                echo "<script>alert('Failed to send email: {$mail->ErrorInfo}');</script>";
            }
        }

        // Redirect to manage_users.php
        header("Location: manage_users.php?update=success");
        exit();
    } else {
        echo "<script>alert('No changes were made to the user details.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        /* General styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 50px auto;
            border: 1px solid #eaeaea;
            transition: box-shadow 0.3s ease;
        }

        .form-container:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #007bff;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input, select, button {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            text-transform: uppercase;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #0056b3;
            transform: scale(1.02);
        }

        button:active {
            transform: scale(1);
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit User</h2>
        <form method="POST" action="edit_users.php">
            <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']); ?>" />

            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']); ?>" required />

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']); ?>" required />

            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="active" <?= $user['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?= $user['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
            </select>

            <label for="password">Password (Leave blank to keep unchanged)</label>
            <input type="password" name="password" id="password" placeholder="New Password" />

            <button type="submit" name="update_user">Update User</button>
        </form>
        <a href="manage_users.php">Cancel</a>
    </div>
</body>
</html>
