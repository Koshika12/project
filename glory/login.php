<?php
// Start session to track user login state
session_start();

// Database connection details
$servername = "localhost";
$username = "root";  // Your MySQL username
$password = "";      // Your MySQL password
$dbname = "events";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error variables
$loginErrors = [];

// Handle Login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $loginEmail = $_POST['loginEmail']; // Use email for login
    $loginPassword = $_POST['loginPassword'];

    // Prepare SQL query to check if the email exists
    $loginQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($loginQuery);
    $stmt->bind_param("s", $loginEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $loginErrors['email'] = "Email not found.";
    } else {
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($loginPassword, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];  // Use name instead of username
            $_SESSION['email'] = $user['email'];

            // Redirect to a landing page or dashboard
            header("Location: home.php");
            exit();  // Stop further code execution
        } else {
            $loginErrors['password'] = "Incorrect password.";
        }
    }
}

// Handle Registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    // Check if 'regName' is set in the POST data
    if (isset($_POST['regName'])) {
        $regName = trim($_POST['regName']); // Trim to remove spaces
    } else {
        echo "<script>alert('Name is required');</script>";
        exit(); // Stop further execution if the name is not provided
    }

    $regEmail = trim($_POST['regEmail']); // Trim to remove spaces
    $regPassword = password_hash($_POST['regPassword'], PASSWORD_DEFAULT);  // Hash the password

    // Validate email format
    if (!filter_var($regEmail, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format. Please use a valid email address.');</script>";
    } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|org|net|edu|gov|info)$/", $regEmail)) {
        echo "<script>alert('Invalid email domain. Please use a valid domain like .com, .org, .net, etc.');</script>";
    } else {
        // Check if email already exists
        $checkQuery = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $regEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Email already taken.');</script>";
        } else {
            // Insert new user into the database
            $insertQuery = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sss", $regName, $regEmail, $regPassword);
            if ($stmt->execute()) {
                echo "<script>alert('Registration successful! You can now log in.');</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
        }
    }
}


// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style2.css">
    <style>
        .bg-video, .bg-video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
    </style>
</head>
<body>
    <!-- Background Video -->
    <div class="bg-video-container">
        <!-- Uncomment the following line to add a video background -->
        <!-- <video class="bg-video" autoplay muted loop>
            <source src="path_to_video.mp4" type="video/mp4">
        </video> -->
    </div>

    <div class="container">
        <!-- Login Form -->
        <div class="form-box login">
    <form action="login.php" method="POST">
        <h1>Login</h1>
        <div class="input-box">
            <input type="email" name="loginEmail" placeholder="Email" required>
            <i class='bx bxs-user'></i>
            <div class="error-message">
                <?php if (isset($loginErrors['email'])) echo $loginErrors['email']; ?>
            </div>
        </div>
        <div class="input-box">
            <input type="password" name="loginPassword" placeholder="Password" required>
            <i class='bx bxs-lock-alt'></i>
            <div class="error-message">
                <?php if (isset($loginErrors['password'])) echo $loginErrors['password']; ?>
            </div>
        </div>
        <div class="forgot-link">
            <a href="#">Forgot password?</a>
        </div>
        <button type="submit" name="login" class="btn">Login</button>
        <p>or login with social platforms</p>
        <div class="social-icons">
            <a href="#"><i class='bx bxl-google'></i></a>
            <a href="#"><i class='bx bxl-facebook'></i></a>
            <a href="#"><i class='bx bxl-twitter'></i></a>
            <a href="#"><i class='bx bxl-instagram'></i></a>
        </div>
    </form>
</div>


        <!-- Registration Form -->
        <div class="form-box register">
    <form action="login.php" method="POST">
        <h1>Registration</h1>
        <div class="input-box">
            <input type="text" name="regName" placeholder="Name" required>
            <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
            <input type="email" name="regEmail" placeholder="Email" required>
            <i class='bx bxs-envelope'></i>
        </div>
        <div class="input-box">
            <input type="password" name="regPassword" placeholder="Password" required>
            <i class='bx bxs-lock-alt'></i>
        </div>
        <button type="submit" name="register" class="btn">Register</button>
        <p>or register with social platforms</p>
        <div class="social-icons">
            <a href="#"><i class='bx bxl-google'></i></a>
            <a href="#"><i class='bx bxl-facebook'></i></a>
            <a href="#"><i class='bx bxl-twitter'></i></a>
            <a href="#"><i class='bx bxl-instagram'></i></a>
        </div>
    </form>
</div>


        <!-- Toggle Panel -->
        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Welcome to Glory!</h1>
                <p>Don't have an account?</p>
                <button class="btn register-btn">Register</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>Welcome Back!</h1>
                <p>Already have an account?</p>
                <button class="btn login-btn">Login</button>
            </div>
        </div>
    </div>

    <script src="script2.js"></script>
</body>
</html>
