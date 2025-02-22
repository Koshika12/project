<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'events';
$username = 'root';
$password = '';
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get logged-in user ID
$user_id = $_SESSION['user_id'] ?? null;

// Insert contact form data into the database if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['message'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);
    $created_at = date('Y-m-d H:i:s'); // Set current timestamp

    if ($user_id) {
        // Prepare and execute the insert statement
        $stmt = $conn->prepare("INSERT INTO contact_form (user_id, name, email, phone, message, created_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $name, $email, $phone, $message, $created_at]);
    }
}

// Check if the user has any unread responses
$unreadMessages = [];
if ($user_id) {
    $stmt = $conn->prepare("SELECT * FROM contact_form WHERE user_id = ? AND response IS NOT NULL AND seen = 0");
    $stmt->execute([$user_id]);
    $unreadMessages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // If there are unread messages, mark them as seen (so the popup doesn't appear again)
    if (!empty($unreadMessages)) {
        $stmt = $conn->prepare("UPDATE contact_form SET seen = 1 WHERE user_id = ? AND response IS NOT NULL");
        $stmt->execute([$user_id]);
    }
}

$conn = null; // Close the connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Popup Styling */
        .popup-btn {
    display: block;
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    width: fit-content;
    margin: 20px auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.popup-btn:hover {
    background-color: #0056b3;
}

        #popup {
            display: none;
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
            display: none;
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
          /*footer*/
    .footer-section {
        padding: 20px 0;
        background: var(--dark-color);
        color: var(--white-color);
        font-family: 'Poppins', sans-serif;
    }
    
    .footer-section .section-content {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-between;
        align-items: flex-start;
    }
    
    /* Navigation and Address Section */
    .footer-nav-address {
        display: flex;
        gap: 40px; /* Space between navigation and address */
    }
    
    .footer-section .footer-nav-list {
        list-style-type: disc;
        padding-left: 20px;
        margin: 0;
    }
    
    .footer-section .footer-link {
        color: var(--white-color);
        text-decoration: none;
        font-size: 1rem;
        transition: color 0.3s ease;
    }
    
    .footer-section .footer-link:hover {
        color: var(--secondary-color);
    }
    
    .footer-section .footer-contact {
        font-size: 0.9rem;
        line-height: 1.6;
    }
    
    .footer-section .footer-contact p {
        margin: 0;
    }
    
    /* Social Links */
    .footer-section .social-link-list {
        display: flex;
        gap: 20px;
    }
    
    .footer-section .social-link {
        font-size: 1.5rem;
        color: var(--white-color);
        transition: color 0.3s ease, transform 0.3s ease;
    }
    
    .footer-section .social-link:hover {
        color: var(--secondary-color);
        transform: scale(1.1);
    }
    
    /* Policies */
    .footer-section .policy-text {
        font-size: 0.9rem;
        display: flex;
        align-items: center;
    }
    
    .footer-section .policy-link {
        color: var(--white-color);
        text-decoration: none;
        margin: 0 5px;
        transition: color 0.3s ease;
    }
    
    .footer-section .policy-link:hover {
        color: var(--secondary-color);
    }
    
    /* Back-to-Top Button */
    .back-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: var(--secondary-color);
        color: var(--white-color);
        font-size: 1.2rem;
        padding: 10px 15px;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease, transform 0.3s ease;
        display: none;
    }
    
    .back-to-top:hover {
        background-color: var(--secondary-color-hover);
        transform: scale(1.1);
    }
    
    body.scrolled .back-to-top {
        display: block;
    }
    </style>
</head>
<body>
<header>
    <nav class="navbar section-content">
        <a href="#" class="nav-logo">
            <h2 class="logo-text">Glory</h2>
        </a>
        <ul class="nav-menu">
            <li class="nav-item"><a href="home.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
            <li class="nav-item"><a href="service.php" class="nav-link">Services</a></li>
            <li class="nav-item"><a href="#gallery" class="nav-link">Gallery</a></li>
            <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
            <li class="nav-item">
                <a href="<?php echo isset($_SESSION['user_id']) ? 'logout.php' : 'login.php'; ?>" class="nav-link"> <?php echo isset($_SESSION['user_id']) ? 'Logout' : 'Login'; ?> </a>
            </li>
        </ul>
    </nav>
</header>

<main>
    <section class="contact-section">
        <h2 class="section-title">Contact Us</h2>
        <div class="section-content">
            <ul class="contact-info-list">
                <li class="contact-info">
                    <i class="fa-solid fa-location-crosshairs"></i>
                    <p>Kamaladi, Kathmandu</p>
                </li>
                <li class="contact-info">
                    <i class="fa-regular fa-envelope"></i>
                    <p>glory@gmail.com</p>
                </li>
                <li class="contact-info">
                    <i class="fa-solid fa-phone"></i>
                    <p>+977-9813166771</p>
                </li>
                <li class="contact-info">
                    <i class="fa-regular fa-clock"></i>
                    <p> Monday - Friday: 9:00 AM - 5:00 PM </p>
                </li>
                <li class="contact-info">
                    <i class="fa-regular fa-clock"></i>
                    <p> Saturday: 10:00 AM - 5:00 PM </p>
                </li>
                <li class="contact-info">
                    <i class="fa-regular fa-clock"></i>
                    <p> Sunday: Closed </p>
                </li>
            </ul>
            <?php if ($user_id): ?>
                <form action="contact.php" method="POST" class="contact-form">
                    <input type="text" name="name" placeholder="Enter Your Name" class="form-input" required>
                    <input type="email" name="email" placeholder="Enter Your Email" class="form-input" required>
                    <input type="text" name="phone" placeholder="Enter Your Number" class="form-input" pattern="[0-9]*" required>
                    <textarea name="message" placeholder="Your Message" class="form-input" required></textarea>
                    <button type="submit" class="submit-button">Submit</button>
                </form>
                <?php if (!empty($unreadMessages)): ?>
                    <button onclick="showPopup()" class="popup-btn">You have new responses from Admin</button>
                <?php endif; ?>
            <?php else: ?>
                <p><strong>You must</strong> <a href="login.php">login</a> to <strong>send a message</strong>.</p>
            <?php endif; ?>
        </div>
    </section>
</main>
<footer class="footer-section">
        <div class="section-content">
            <!-- Navigation Links -->
            <nav class="footer-nav">
                <ul class="footer-nav-list">
                    <li><a href="home.php" class="footer-link">Home</a></li>
                    <li><a href="about.php" class="footer-link">About</a></li>
                    <li><a href="service.php" class="footer-link">Services</a></li>
                    <li><a href="contact.php" class="footer-link">Contact</a></li>
                </ul>
            </nav>
    
            <!-- Contact Information -->
            <div class="footer-contact">
                <p><strong>Address:</strong> Kamaladi, Nepal</p>
                <p><strong>Phone:</strong> +977-9813166771</p>
                <p><strong>Email:</strong> info@glory.com</p>
            </div>
    
            <!-- Social Links -->
            <div class="social-link-list">
                <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
    
            <!-- Policies -->
            <p class="policy-text">
                <a href="#" class="policy-link">Privacy Policy</a>
                <span class="separator">&#x2022;</span>
                <a href="#" class="policy-link">Refund Policy</a>
            </p>
    
            <!-- Copyright -->
            <p class="copyright-text">&copy;2024 GLORY</p>
        </div>
        <button class="back-to-top">↑</button>
    </footer>

<div id="popup-overlay"></div>
<div id="popup">
    <h2>New Response from Admin</h2>
    <div id="popup-content"></div>
    <button class="close-btn" onclick="closePopup()">Close</button>
</div>

<script>

    function showPopup() {
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
    }
    function closePopup() {
    document.getElementById('popup').style.display = 'none';
    document.getElementById('popup-overlay').style.display = 'none';
}

</script>
</body>
</html>