<?php
// Start the session
session_start();
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
     <link rel="stylesheet" href="home.css">
     
    <!-- Linking Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!--linking swiper css-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
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
            <a href="home.php" class="nav-logo">
                <h2 class="logo-text">Glory</h2>
            </a>
            <ul class="nav-menu">
               <li class="nav-item">
                    <a href="home.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="about.php" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="service.php" class="nav-link">Services</a>
                </li>
                <li class="nav-item">
                    <a href="#gallery" class="nav-link">Gallery</a>
                </li>
                <li class="nav-item">
    <a href="<?php echo isset($_SESSION['user_id']) ? 'my_booking.php' : 'login.php'; ?>" class="nav-link">
        Check Booking
    </a>
</li>

                
                <li class="nav-item">
                    <a href="contact.php" class="nav-link">Contact</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo isset($_SESSION['user_id']) ? 'logout.php' : 'login.php'; ?>" class="nav-link"> <?php echo isset($_SESSION['user_id']) ? 'Logout' : 'Login'; ?> </a>
                </li>
            </ul>
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
                    <a href="<?php echo isset($_SESSION['user_id']) ? 'book.php' : 'login.php'; ?>" class="button book-now">Book Now</a>

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
            <a href="about.php" class="button read-more">Read More</a>

            <div class="social-link-list">
                <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
        </div>
    </div>
</section>



      <!--service section-->
      <!-- Services Section -->
      <section class="services-section" id="services">
    <div class="section-content">
        <h2 class="section-title">Our Services</h2>
        <div class="services-list">
            <!-- Corporate Events -->
            <div class="service-box">
                <div class="service-image-wrapper">
                    <img src="corporate.jpg" alt="Corporate Events" class="service-image">
                </div>
                <div class="service-details">
                    <h3 class="service-title">Corporate Events</h3>
                    <p class="service-description">
                        Host professional and memorable corporate gatherings tailored to your needs...
                    </p>
                    <a href="corporate.php" class="button read-more">Read More</a>
                </div>
            </div>

            <!-- Social Events -->
            <div class="service-box">
                <div class="service-image-wrapper">
                    <img src="social.jpg" alt="Social Events" class="service-image">
                </div>
                <div class="service-details">
                    <h3 class="service-title">Social Events</h3>
                    <p class="service-description">
                        Whether it’s a gala, a family reunion, or a community gathering, 
                        we ensure every detail reflects warmth, connection, and joy, making your occasion truly special...
                    </p>
                    <a href="social.php" class="button read-more">Read More</a>
                </div>
            </div>

            <!-- Sports Events -->
            <div class="service-box">
                <div class="service-image-wrapper">
                    <img src="sport.jpg" alt="Sports Events" class="service-image">
                </div>
                <div class="service-details">
                    <h3 class="service-title">Sports Events</h3>
                    <p class="service-description">
                        From tournaments to championships, we manage sports events of all scales...
                    </p>
                    <a href="sports.php" class="button read-more">Read More</a>
                </div>
            </div>

            <!-- Cultural and Traditional Events -->
            <div class="service-box">
                <div class="service-image-wrapper">
                    <img src="culture.jpg" alt="Cultural Events" class="service-image">
                </div>
                <div class="service-details">
                    <h3 class="service-title">Cultural And Traditional Events</h3>
                    <p class="service-description">
                        From vibrant festivals to sacred ceremonies, we craft experiences that honor age-old customs while creating unforgettable memories...
                    </p>
                    <a href="cultural.php" class="button read-more">Read More</a>
                </div>
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
    <button class="back-to-top">&#8593;</button>
</footer>

    </main>
    <!--linking swiper script-->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
     
    <!--linking custom script-->
    <script src="script.js"></script>
    <script>
          /* initialize Swiper*/
             const swiper = new Swiper('.slider-container', {
               loop: true,
             spaceBetween: 25,

                 // Pagination
                  pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true,
          },

                // Navigation arrows
                  navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
                     },
                 // Responsive breakpoints
                     breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
                     },
                   });
     </script>
</body>
</html>
