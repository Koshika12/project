<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();  // Stop further execution
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Planning</title>
    
    <!-- Importing Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Miniver&family=Poppins:ital,wght@0,400;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">
    
    <!-- Linking the external CSS file -->
     <link rel="stylesheet" href="style4.css">
    <!-- Linking Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
    .button.read-more {
        display: inline-block;
        padding: 10px 20px;
        font-size: 1rem;
        font-weight: 500;
        color: white;
        background-color: #ff8c00;
        border: none;
        border-radius: 25px;
        text-transform: uppercase;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .button.read-more:hover {
        background-color: #ff5c00; /* Darker orange when hovered */
        transform: translateY(-2px); /* Slightly lift the button */
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2); /* Enhance shadow on hover */
    }
   </style>

</head>
<body>
    <!-- Header/Navbar -->
    <header>
        <nav class="navbar section-content">
            <a href="#" class="nav-logo">
                <h2 class="logo-text">Glory</h2>
            </a>
            <ul class="nav-menu">
               <!-- <button id="menu-close-button" class="fas fa-times"></button>-->
                <li class="nav-item">
                    <a href="home.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="about.html" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="#services" class="nav-link">Services</a>
                </li>
                <li class="nav-item">
                    <a href="#gallery" class="nav-link">Gallery</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Review</a>
                </li>
                <li class="nav-item">
                    <a href="contact.php" class="nav-link">Contact</a>
                </li>
                <li class="nav-item">
                   <a href="logout.php" class="nav-link logout-btn">Logout</a>
                </li>         
                </ul>
           <!-- <button id="menu-open-button" class="fas fa-bars"></button>-->
           
           
        </nav>
    </header>
    <main>
        <!-- Hero section -->
        <section class="hero-section">
            <div class="section-content">
                <div class="hero-details">
                    <h2 class="title">Event Planner</h2>
                    <h3 class="subtitle">A touch of sophistication, a world of possibilities.</h3>
                    <p class="description">Welcome to our website where "FROM PLANNING TO THE DAY'S GLORY, WE MAKE EVERY EVENT A STORY."</p>
                    <div class="buttons">
                        <a href="#" class="button book-now">Book Now</a>
                        <a href="contact.php" class="button contact-us">Contact Us</a>
                    </div>
                </div>
                <div class="hero-image-wrapper">
                <img src="3.png" alt="Event Planning Hero Image" class="hero-image">
                </div>
            </div>
        </section>

        <!--About Section-->

<section class="about-section" id="about">
    <div class="section-content">
        <div class="about-image-wrapper">
            <img src="1.jpg" alt="about" class="about-image">
        </div>
        <div class="about-details">
            <h2 class="section-title">About Us</h2>
            <!-- Display a short excerpt of the text -->
            <p class="text">
                At Glory, we believe every occasion deserves to shine. Whether it's a corporate gathering or a wedding, 
                our team of dedicated professionals is here to turn your vision into reality...
            </p>
            <!-- Read More Button -->
            
            <a href="about.html" class="button read-more">Read More</a>

            <div class="social-link-list">
                <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
        </div>
    </div>
</section>


        <!--Gallery section-->
        <section class="gallery-section" id="gallery">
            <h2 class="section-title">Gallery</h2>
            <div class="section-content">
                <ul class="gallery-list">
                    <li class="gallery-item">
                        <img src="g1.jpg" alt="Gallery" class="gallery-image">
                    </li>
                    <li class="gallery-item">
                        <img src="g2.jpg" alt="Gallery" class="gallery-image">
                    </li>
                    <li class="gallery-item">
                        <img src="g3.jpg" alt="Gallery" class="gallery-image">
                    </li>
                    <li class="gallery-item">
                        <img src="g4.jpg" alt="Gallery" class="gallery-image">
                    </li>
                    <li class="gallery-item">
                        <img src="g5.jpg" alt="Gallery" class="gallery-image">
                    </li>  
                    <li class="gallery-item">
                        <img src="g6.jpg" alt="Gallery" class="gallery-image">
                    </li>              
                </ul>
            </div>
        </section>

        <!--footer section-->
        <footer class="footer-section">
    <div class="section-content">
        <!-- Navigation Links -->
        <nav class="footer-nav">
            <ul class="footer-nav-list">
                <li><a href="home.php" class="footer-link">Home</a></li>
                <li><a href="#about" class="footer-link">About</a></li>
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


    </main>

    <script src="script.js"></script>
</body>
</html>
