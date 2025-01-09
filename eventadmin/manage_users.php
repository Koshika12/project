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

// Fetch all users
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sql = "SELECT * FROM users WHERE name LIKE '%$search%' OR email LIKE '%$search%'";
$users = $conn->query($sql);

// Edit user details
if (isset($_POST['edit_user'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $status = $_POST['status'];

    // Check if password is being updated, only update if it's not empty
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, status = ?, password = IFNULL(?, password) WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $email, $status, $password, $id);
    $stmt->execute();
    header("Location: manage_users.php");
    exit();
}

// Delete user
if (isset($_POST['delete_user'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM users WHERE id = $id");
    header("Location: manage_users.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        /* General Reset and Body Styles */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; background-color: #f4f4f4; color: #333; }

        /* Sidebar Styling */
        .sidebar { height: 100%; width: 250px; position: fixed; top: 0; left: 0; background-color: #333; color: white; padding-top: 20px; display: flex; flex-direction: column; }
        .sidebar a { color: white; padding: 10px 15px; text-decoration: none; display: block; margin: 0; font-weight: bold; transition: background-color 0.3s; }
        .sidebar a:hover { background-color: #575757; }
        .sidebar .logout-button { margin-top: auto; background-color: #dc3545; color: white; border: none; padding: 10px 15px; cursor: pointer; font-size: 1rem; width: 100%; text-align: center; transition: background-color 0.3s; }
        .sidebar .logout-button:hover { background-color: #c82333; }

        /* Main Content Area */
        .main-content { margin-left: 250px; padding: 20px; }
        header { background-color: #333; color: white; padding: 20px; text-align: center; font-size: 2rem; margin-bottom: 20px; } /* Added margin-bottom for space */
        
        /* Table Layout */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #007bff; color: white; }
        .button { background-color: #28a745; color: white; border: none; padding: 8px 15px; cursor: pointer; font-size: 1rem; transition: background-color 0.3s; }
        .button:hover { background-color: #218838; }
        .delete-button { background-color: #dc3545; }
        .delete-button:hover { background-color: #c82333; }

        /* Modern Search Box */
        .search-bar { margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .search-bar input { padding: 10px; font-size: 1rem; border-radius: 20px; border: 1px solid #ddd; width: 75%; transition: border-color 0.3s ease; }
        .search-bar input:focus { border-color: #007bff; outline: none; }
        .search-bar button { padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 20px; cursor: pointer; transition: background-color 0.3s; }
        .search-bar button:hover { background-color: #0056b3; }

        .search-bar input::placeholder { color: #aaa; }
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
        <header>Manage Users</header>

        <!-- Modern Search Users Form -->
        <div class="search-bar">
            <form method="GET" action="manage_users.php" style="width:100%">
                <input type="text" name="search" placeholder="Search users by name or email" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" />
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- Users Table -->
        <h2>Users List</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Password</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['status']; ?></td>
                        <td>******</td> <!-- Masked password -->
                        <td>
                            <form method="POST" action="edit_user.php">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>" />
                                <button type="submit">Edit</button>
                            </form>
                            <form method="POST" action="manage_users.php" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>" />
                                <button type="submit" name="delete_user" class="delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

