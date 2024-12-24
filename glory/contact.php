<?php
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

// Server-side validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $event_type = trim($_POST['event_type']);
    $event_date = trim($_POST['event_date']);
    $message = trim($_POST['message']);

    // Check for empty fields
    if (empty($name) || empty($email) || empty($phone) || empty($event_type) || empty($event_date) || empty($message)) {
        echo "<script>alert('All fields are required.'); window.location.href='contact.php';</script>";
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.location.href='contact.php';</script>";
        exit;
    }

    // Validate phone number format
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo "<script>alert('Phone number must be 10 digits.'); window.location.href='contact.php';</script>";
        exit;
    }

    // Check for date conflicts
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM contact_form WHERE event_date = :event_date");
        $stmt->bindParam(':event_date', $event_date);
        $stmt->execute();
        $dateExists = $stmt->fetchColumn();

        if ($dateExists > 0) {
            echo "<script>alert('The selected date is already booked. Please choose a different date.'); window.location.href='contact.php';</script>";
            exit;
        }
    } catch (PDOException $e) {
        echo "<script>alert('An error occurred while checking the event date.'); window.location.href='contact.php';</script>";
        exit;
    }

    // Insert data into the database
    try {
        $stmt = $conn->prepare("INSERT INTO contact_form (name, email, phone, event_type, event_date, message) VALUES (:name, :email, :phone, :event_type, :event_date, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':event_type', $event_type);
        $stmt->bindParam(':event_date', $event_date);
        $stmt->bindParam(':message', $message);
        $stmt->execute();

        echo "<script>alert('Thank you for contacting us! Your event has been scheduled.'); window.location.href='contact.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Failed to submit your request. Please try again.'); window.location.href='contact.php';</script>";
    }
}
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
                <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
                <li class="nav-item"><a href="#services" class="nav-link">Services</a></li>
                <li class="nav-item"><a href="#gallery" class="nav-link">Gallery</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Review</a></li>
                <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link logout-btn">Logout</a></li>
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
                <p>Kamaladi, kathmandu </p>
            </li>
            <li class="contact-info">
                <i class="fa-regular fa-envelope"></i>
                <p>glory@gmail.com </p>
            </li>
            <li class="contact-info">
                <i class="fa-solid fa-phone"></i>
                <p> +977-9813166771 </p>
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
        <form action="contact.php" method="POST" class="contact-form">
    <input type="text" name="name" placeholder="Enter Your Name" class="form-input" required>
    <input type="email" name="email" placeholder="Enter Your Email" class="form-input" required>
    <input type="text" name="phone" placeholder="Enter Your Number" class="form-input" pattern="[0-9]*" required>
    <select name="event_type" class="form-input" required>
        <option value="" disabled selected hidden>Select Events</option>
        <option value="Corporate Events">Corporate Events</option>
        <option value="Sports Events">Sports Events</option>
        <option value="Social Events">Social Events</option>
        <option value="Cultural And Traditional Events">Cultural And Traditional Events</option>
    </select>
    <input type="date" name="event_date" class="form-input" required>
    <textarea name="message" placeholder="Your message" class="form-input" required></textarea>
    <button type="submit" class="submit-button">Submit</button>
</form>

    </div>
</section>
    </main>
    <footer class="footer-section">
        <div class="section-content">
            <!-- Navigation Links -->
            <nav class="footer-nav">
                <ul class="footer-nav-list">
                    <li><a href="home.php" class="footer-link">Home</a></li>
                    <li><a href="about.html" class="footer-link">About</a></li>
                    <li><a href="#services" class="footer-link">Services</a></li>
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
   <script src="script.js">
    </script>
    </body>
    </html>