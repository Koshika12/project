<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corporate Events</title>
    <link rel="stylesheet" href="event.css">
    <style>
        /* Hero Section Styling */
        .hero-section {
            position: relative;
            background: url('corporate.jpg') no-repeat center center/cover;
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
            background: rgba(0, 0, 0, 0.6); /* Adding a dark overlay for text contrast */
        }

        .hero-text {
            position: relative;
            z-index: 1;
        }

        .hero-text h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .hero-text p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .hero-button {
            padding: 10px 25px;
            font-size: 1rem;
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

        /* Content Styling */
        .corporate-content {
            padding: 60px 20px;
            background-color: var(--light-pink-color);
        }

        .corporate-content h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        .corporate-services {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .service-card {
            background-color: var(--white-color);
            padding: 20px;
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
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .service-card p {
            font-size: 1rem;
            color: var(--medium-gray-color);
        }

        /* Image Gallery */
        .image-gallery {
            padding: 40px 0;
        }

        .gallery-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .gallery-box {
            background-color: var(--white-color);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .gallery-description {
            font-size: 1rem;
            color: var(--medium-gray-color);
            margin-bottom: 20px;
            text-align: center;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
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
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

        .footer-nav-address {
            display: flex;
            gap: 40px;
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
                <li class="nav-item"><a href="#services" class="nav-link">Services</a></li>
                <li class="nav-item"><a href="#gallery" class="nav-link">Gallery</a></li>
                
                <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-text">
            <h1>Professional Corporate Events</h1>
            <p>Experience Excellence and Precision for All Your Corporate Needs</p>
            <a href="service.php" class="hero-button">Explore Services</a>
        </div>
    </section>

    <!-- Main Content -->
    <main class="corporate-content">
        <h2>Our Exclusive Corporate Event Services</h2>
        <div class="corporate-services">
            <div class="service-card">
                <img src="icon1.jpg" alt="Event Planning">
                <h3>Event Planning</h3>
                <p>Customized event planning tailored to your corporate goals.</p>
            </div>
            <div class="service-card">
                <img src="icon2.jpg" alt="Tech Support">
                <h3>Tech Support</h3>
                <p>Advanced audio-visual setups for a seamless experience.</p>
            </div>
            <div class="service-card">
                <img src="icon3.jpg" alt="Catering">
                <h3>Catering</h3>
                <p>Delicious menu options crafted by culinary experts.</p>
            </div>
            <div class="service-card">
                <img src="icon4.png" alt="Team Building">
                <h3>Team Building</h3>
                <p>Innovative activities to foster teamwork and collaboration.</p>
            </div>
        </div>

        <!-- Image Gallery -->
        <div class="image-gallery">
            <h2 class="gallery-title">Event Highlights</h2>
              <div class="gallery-grid">
                    <div class="gallery-item">
                        <img src="event1.jpg" alt="Conference" class="gallery-image">
                        <div class="image-description">
                            <h3>Conference</h3>
                            <p>Our impactful conferences bring together industry leaders and visionaries.</p>
                        </div>
                    </div>
                    <div class="gallery-item">
                        <img src="event2.jpg" alt="Product Launch" class="gallery-image">
                        <div class="image-description">
                            <h3>Product Launch</h3>
                            <p>Unveiling the latest innovations with style and excitement.</p>
                        </div>
                    </div>
                    <div class="gallery-item">
                        <img src="event3.jpg" alt="Networking Session" class="gallery-image">
                        <div class="image-description">
                            <h3>Networking Session</h3>
                            <p>Creating opportunities for professionals to connect and collaborate.</p>
                        </div>
                    </div>
                    <div class="gallery-item">
                        <img src="event4.jpg" alt="Team Building Activity" class="gallery-image">
                        <div class="image-description">
                            <h3>Team Building Activity</h3>
                            <p>Strengthening bonds and improving collaboration within teams.</p>
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
                <p><strong>Email:</strong> info@glory.com</p>
            </div>
            <p>&copy; 2024 Glory Events. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
