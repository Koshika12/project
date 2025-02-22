<?php
session_start(); // Start the session


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>
    <link rel="stylesheet" href="event.css">
    <style>
        /* General Styling */
        body {
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 0;
        }

        .hero-section {
            background: url('hero-bg.jpg') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 80px 20px;
        }

        .hero-section h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            color:black;
        }

        .hero-section p {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color:black;
        }

        .hero-section .cta-button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #f3961c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .hero-section .cta-button:hover {
            background-color: #d17c15;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .service-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease;
            background-color: white;
        }

        .service-card:hover {
            transform: scale(1.05);
        }

        .service-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .service-card .service-content {
            padding: 20px;
        }

        .service-card h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .service-card p {
            font-size: 1rem;
            margin-bottom: 15px;
            color: #555;
        }

        .service-card .read-more {
            text-decoration: none;
            color: #f3961c;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .service-card .read-more:hover {
            color: #d17c15;
        }

        .testimonials {
            background-color: #faf4f5;
            padding: 40px 20px;
            text-align: center;
        }

        .testimonials h2 {
            margin-bottom: 20px;
        }

        .testimonials p {
            font-size: 1.1rem;
            max-width: 800px;
            margin: 0 auto 10px;
        }

        .cta-section {
            background-color: #252525;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        .cta-section h2 {
            margin-bottom: 20px;
        }

        .cta-section a {
            display: inline-block;
            padding: 12px 30px;
            background-color: #f3961c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .cta-section a:hover {
            background-color: #d17c15;
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
                <li class="nav-item"><a href="home.php" class="nav-link">Gallery</a></li>
                
                <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
                <li class="nav-item">
                    <a href="<?php echo isset($_SESSION['user_id']) ? 'logout.php' : 'login.php'; ?>" class="nav-link"> <?php echo isset($_SESSION['user_id']) ? 'Logout' : 'Login'; ?> </a>
                </li>
            </ul>
        </nav>
    </header>



    <section class="hero-section">
        <h1>Our Services</h1>
        <p>Delivering excellence in every event we organize.</p>
        <a href="contact.php" class="cta-button">Contact Us</a>
    </section>

    <section class="services">
        <div class="services-grid">
            <div class="service-card">
                <img src="corporate.jpg" alt="Corporate Events">
                <div class="service-content">
                    <h3>Corporate Events</h3>
                    <p>Host professional and memorable corporate gatherings tailored to your needs.</p>
                    <a href="corporate.php" class="read-more">Learn More</a>
                </div>
            </div>
            <div class="service-card">
                <img src="social.jpg" alt="Social Events">
                <div class="service-content">
                    <h3>Social Events</h3>
                    <p>Warm, joyful, and unforgettable social gatherings, from reunions to galas.</p>
                    <a href="social.php" class="read-more">Learn More</a>
                </div>
            </div>
            <div class="service-card">
                <img src="sport.jpg" alt="Sports Events">
                <div class="service-content">
                    <h3>Sports Events</h3>
                    <p>Manage tournaments and championships of all scales with precision.</p>
                    <a href="sports.php" class="read-more">Learn More</a>
                </div>
            </div>
            <div class="service-card">
                <img src="culture.jpg" alt="Cultural Events">
                <div class="service-content">
                    <h3>Cultural Events</h3>
                    <p>Celebrate traditions with vibrant festivals and sacred ceremonies.</p>
                    <a href="cultural.php" class="read-more">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <h2>What Our Clients Say</h2>
        <p>"Thank you for making our  event seamless and unforgettable!"</p>
        <p>"The team brought our family reunion to life with warmth and care."</p>
    </section>

    <section class="cta-section">
        <h2>Ready to Plan Your Event?</h2>
        <a href="contact.php">Get a Free Consultation</a>
    </section>
    <footer class="footer-section">
        <div class="section-content">
            <nav class="footer-nav">
                <ul class="footer-nav-list">
                    <li><a href="home.php" class="footer-link">Home</a></li>
                    <li><a href="about.php" class="footer-link">About</a></li>
                    <li><a href="service.php" class="footer-link">Services</a></li>
                    <li><a href="contact.php" class="footer-link">Contact</a></li>
                </ul>
            </nav>
            <div class="footer-contact">
                <p><strong>Address:</strong> Kamaladi, Nepal</p>
                <p><strong>Phone:</strong> +977-9813166771</p>
                <p><strong>Email:</strong> info@glory.com</p>
            </div>
            <p>&copy; 2024 Glory Events. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
