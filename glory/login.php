<?php
// Start session to track user login state
session_start();

// Database connection details
$servername = "localhost";
$username = "root";  // Your MySQL username
$password = "";      // Your MySQL password
$dbname = "user_system";  // Your database name

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
    $loginUsername = $_POST['loginUsername'];
    $loginPassword = $_POST['loginPassword'];

    // Prepare SQL query to check if the username exists
    $loginQuery = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($loginQuery);
    $stmt->bind_param("s", $loginUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $loginErrors['username'] = "Username not found.";
    } else {
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($loginPassword, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
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
// Handle Registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $regUsername = $_POST['regUsername'];
    $regEmail = $_POST['regEmail'];
    $regPassword = password_hash($_POST['regPassword'], PASSWORD_DEFAULT);  // Hash the password

    // Validate email format
    if (!filter_var($regEmail, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format. Please use a valid email address.";
    } else {
        // Check if username or email already exists
        $checkQuery = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("ss", $regUsername, $regEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Username or Email already taken.";
        } else {
            // Insert new user into the database
            $insertQuery = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sss", $regUsername, $regEmail, $regPassword);
            if ($stmt->execute()) {
                echo "Registration successful! You can now log in.";
            } else {
                echo "Error: " . $stmt->error;
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
    z-index: -1;  /* Ensure the video stays behind other content */
}

</style>
</head>
<body>
    <!-- Background Video -->
    <div class="bg-video-container">
    <!--<video class="bg-video" autoplay muted loop>
        <source src="https://video-previews.elements.envatousercontent.com/h264-video-previews/93cfc877-995d-4ef6-a445-aa7684f0aa62/21467849.mp4" type="video/mp4">
    </video>-->
</div>
    <div class="container">
        <!-- Login Form -->
        <div class="form-box login">
            <form action="login.php" method="POST">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" name="loginUsername" placeholder="Username" required>
                    <i class='bx bxs-user'></i>
                    <div class="error-message">
                <?php if (isset($loginErrors['username'])) echo $loginErrors['username']; ?>
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
                    <input type="text" name="regUsername" placeholder="Username" required>
                    <i class='bx bxs-user'></i>
                    <?php 
                    if (isset($_SESSION['register_error'])) {
                        echo $_SESSION['register_error'];
                        unset($_SESSION['register_error']);  // Clear the error after displaying
                    }
                ?>
                </div>
                <div class="input-box">
                    <input type="email" name="regEmail" placeholder="Email" required>
                    <i class='bx bxs-envelope'></i>
                    <?php 
                    if (isset($_SESSION['register_error'])) {
                        echo $_SESSION['register_error'];
                        unset($_SESSION['register_error']);  // Clear the error after displaying
                    }
                ?>
                </div>

                <div class="input-box">
                    <input type="password" name="regPassword" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                    <div class="error-message">
                <?php if (isset($registerErrors['general'])) echo $registerErrors['general']; ?>
            </div>
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

    <script src="script2.js" >
</script>
</body>
</html>
