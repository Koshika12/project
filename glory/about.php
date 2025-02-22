<?php
session_start(); // Start the session


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="style3.css">
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
        <section class="about" id="about">
            <h1 class="heading"><span>About </span>Us</h1>
            <div class="row">
                <div class="video-container">
                    <video src="https://www.shutterstock.com/shutterstock/videos/3399131505/preview/stock-footage-nepali-indian-wedding-ring-exchange-at-hindu-culture-nepali-wedding-ringing.webm" loop autoplay muted></video>
                    <h3>Best Event Organizer</h3>
                </div>

                <div class="content">
                    <h3>WHY CHOOSE US?</h3>
                    <p>At Glory, we pride ourselves on our ability to create memorable events tailored to your unique needs. From intimate celebrations to grand-scale productions, we ensure every detail is meticulously planned and flawlessly executed.
                         Our team works closely with you, taking the time to understand your preferences and aspirations, so every element of your event reflects your vision.
                        With a wealth of experience and a passion for perfection, we specialize in transforming spaces into stunning backdrops that captivate and inspire. 
                        From elegant décor to innovative themes, our creativity knows no bounds. We handle everything, from logistics and vendor coordination to on-site management, ensuring a seamless experience for you and your guests.
                        At Glory, we don't just plan events; we create unforgettable experiences that leave lasting impressions. Trust us to bring your dreams to life and make every moment shine with excellence and elegance.
                        
                    </p>
                </div>
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
    <script src="script.js"></script>
</body>
</html>
