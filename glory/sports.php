<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Events</title>
    <link rel="stylesheet" href="style3.css">
    <style>
        /* Hero Section Styling */
        .hero-section {
            position: relative;
            background: url('sport.jpg') no-repeat center center/cover;
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white-color);
            text-align: center;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Dark overlay for contrast */
        }

        .hero-text {
            position: relative;
            z-index: 1;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
        }

        .hero-text p {
            font-size: 1.4rem;
            margin-bottom: 30px;
        }

        .hero-button {
            padding: 15px 30px;
            font-size: 1.2rem;
            background-color: var(--secondary-color);
            color: var(--white-color);
            border-radius: 25px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .hero-button:hover {
            background-color: var(--secondary-color-hover);
            transform: scale(1.1);
        }

        /* Main Content Styling */
        .social-content {
            padding: 60px 20px;
            background-color: var(--light-blue-color);
        }

        .social-content h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        .social-services {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .service-card {
            background-color: var(--white-color);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .service-card img {
            width: 80px;
            margin-bottom: 15px;
        }

        .service-card h3 {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: var(--dark-color);
        }

        .service-card p {
            font-size: 1rem;
            color: var(--medium-gray-color);
        }

        /* Image Gallery */
        .image-gallery {
            padding: 60px 0;
            background-color: var(--light-gray-color);
        }

        .gallery-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            color: var(--dark-color);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .gallery-item:hover {
            transform: scale(1.05);
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-description {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6);
            color: var(--white-color);
            padding: 15px;
            text-align: center;
        }

        .image-description h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .image-description p {
            font-size: 1rem;
        }

        /* Footer Styling */
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
    </style>
</head>
<body>
    <header>
        <nav class="navbar section-content">
            <a href="#" class="nav-logo">
                <h2 class="logo-text"> Glory</h2>
            </a>
            <ul class="nav-menu">
                <li class="nav-item"><a href="home.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
                <li class="nav-item"><a href="#services" class="nav-link">Services</a></li>
                <li class="nav-item"><a href="#gallery" class="nav-link">Gallery</a></li>
                
                <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-text">
            <h1>Unleash the Athlete in You</h1>
            <p>Join us for thrilling sports events, tournaments, and more.</p>
            <a href="service.php" class="hero-button">Explore  Services</a>
        </div>
    </section>

    <!-- Main Content -->
    <main class="social-content">
        <h2>Our Sports Event Services</h2>
        <div class="social-services">
            <div class="service-card">
                <img src="icon1.jpg" alt="Event Planning">
                <h3>Event Planning</h3>
                <p>Organizing exciting sports tournaments and events with top-notch facilities.</p>
            </div>
            <div class="service-card">
                <img src="coach.jpg" alt="Coaching">
                <h3>Coaching</h3>
                <p>Expert coaching to improve your skills and performance in various sports.</p>
            </div>
            <div class="service-card">
                <img src="icon3.webp" alt="Venue Booking">
                <h3>Venue Booking</h3>
                <p>Book premium sports venues for your event or practice sessions.</p>
            </div>
            <div class="service-card">
                <img src="cov.jpg" alt="Event Coverage">
                <h3>Event Coverage</h3>
                <p>Comprehensive event coverage with photography and live streaming.</p>
            </div>
        </div>

        <!-- Image Gallery -->
        <div class="image-gallery">
            <h2 class="gallery-title">Sports Event Highlights</h2>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="football.jpg" alt="Football Match" class="gallery-image">
                    <div class="image-description">
                        <h3>Football Match</h3>
                        <p>Exciting football action on the field.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="basketball.jpg" alt="Basketball Tournament" class="gallery-image">
                    <div class="image-description">
                        <h3>Basketball Tournament</h3>
                        <p>A high-energy basketball competition.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="marathon.jpg" alt="Marathon" class="gallery-image">
                    <div class="image-description">
                        <h3>Marathon</h3>
                        <p>A challenging and rewarding marathon event.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="outdoor_sports.jpg" alt="Outdoor Sports" class="gallery-image">
                    <div class="image-description">
                        <h3>Outdoor Sports</h3>
                        <p>Engage in exciting outdoor sports activities.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer-section">
        <div class="section-content">
            <nav class="footer-nav">
                <ul class="footer-nav-list">
                    <li><a href="home.php" class="footer-link">Home</a></li>
                    <li><a href="about.php" class="footer-link">About</a></li>
                    <li><a href="services.php" class="footer-link">Services</a></li>
                    <li><a href="contact.php" class="footer-link">Contact</a></li>
                </ul>
            </nav>
            <div class="footer-contact">
                <p><strong>Address:</strong> Kamaladi, Nepal</p>
                <p><strong>Phone:</strong> +977-9813166771</p>
                <p><strong>Email:</strong> info@sportsglory.com</p>
            </div>
            <div class="social-link-list">
                <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fa-brands fa-twitter"></i></a>
            </div>
            <p>&copy; 2024 Sports Glory. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
