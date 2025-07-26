<?php
include_once("header.php");
?>
<!DOCTYPE html>
<html lang="en-PH">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Rommel Garcia Digital Video & Photography</title>
    <meta name="description" content="Premier event-focused videography and photography in Guimba, Nueva Ecija. Weddings, milestones, and more—book your trusted team today!" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="css/tailwind.css" />
    <link rel="stylesheet" href="css/material-ui-components.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #1a1a1a;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Performance-optimized background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #f5576c);
            background-size: 400% 400%;
            animation: gradientShift 20s ease infinite;
            will-change: background-position;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Glass morphism utilities */
        .glass {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
        }

        .glass-button {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* UIverse Animations - Performance Optimized */
        .uiverse-starfish {
            position: fixed;
            top: 10%;
            left: 5%;
            width: 60px;
            height: 60px;
            z-index: 1;
            opacity: 0.6;
            pointer-events: none;
        }

        .uiverse-starfish .starfish {
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            border-radius: 50%;
            position: relative;
            transform-origin: center;
            animation: starfishFloat 8s ease-in-out infinite;
        }

        @keyframes starfishFloat {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .uiverse-robin {
            position: fixed;
            top: 20%;
            right: 8%;
            width: 50px;
            height: 50px;
            z-index: 1;
            opacity: 0.5;
            pointer-events: none;
        }

        .uiverse-robin .robin {
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #48dbfb, #0abde3);
            border-radius: 50%;
            position: relative;
            animation: robinGlow 6s ease-in-out infinite;
        }

        @keyframes robinGlow {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.8; }
        }

        .uiverse-gecko {
            position: fixed;
            bottom: 15%;
            left: 10%;
            width: 40px;
            height: 40px;
            z-index: 1;
            opacity: 0.4;
            pointer-events: none;
        }

        .uiverse-gecko .gecko {
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #ff9ff3, #f368e0);
            border-radius: 50%;
            animation: geckoPulse 7s ease-in-out infinite;
        }

        @keyframes geckoPulse {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.1) rotate(90deg); }
        }

        .uiverse-donkey {
            position: fixed;
            top: 60%;
            right: 15%;
            width: 45px;
            height: 45px;
            z-index: 1;
            opacity: 0.3;
            pointer-events: none;
        }

        .uiverse-donkey .donkey {
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #54a0ff, #2e86de);
            border-radius: 50%;
            animation: donkeyBounce 9s ease-in-out infinite;
        }

        @keyframes donkeyBounce {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-15px) scale(1.1); }
        }

        .uiverse-zebra {
            position: fixed;
            bottom: 25%;
            right: 8%;
            width: 55px;
            height: 55px;
            z-index: 1;
            opacity: 0.4;
            pointer-events: none;
        }

        .uiverse-zebra .zebra {
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #5f27cd, #341f97);
            border-radius: 50%;
            animation: zebraSpin 10s linear infinite;
        }

        @keyframes zebraSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .uiverse-cheetah {
            position: fixed;
            top: 40%;
            left: 15%;
            width: 35px;
            height: 35px;
            z-index: 1;
            opacity: 0.5;
            pointer-events: none;
        }

        .uiverse-cheetah .cheetah {
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #ff9f43, #ee5a24);
            border-radius: 50%;
            animation: cheetahRun 5s ease-in-out infinite;
        }

        @keyframes cheetahRun {
            0%, 100% { transform: translateX(0) scale(1); }
            50% { transform: translateX(10px) scale(1.05); }
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), 
                        url('img/indexImage/IMG_9290.JPG') center/cover no-repeat;
            z-index: -1;
        }

        .hero-content {
            text-align: center;
            max-width: 800px;
            padding: 2rem;
            z-index: 2;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            color: #fff;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            line-height: 1.2;
        }

        .hero p {
            font-size: clamp(1.1rem, 2.5vw, 1.4rem);
            color: rgba(255,255,255,0.9);
            margin-bottom: 2.5rem;
            font-weight: 300;
        }

        /* Section Styles */
        .section {
            padding: 5rem 0;
            position: relative;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 600;
            text-align: center;
            margin-bottom: 1rem;
            color: #fff;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .section-subtitle {
            text-align: center;
            color: rgba(255,255,255,0.8);
            font-size: 1.1rem;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Package Cards */
        .package-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .package-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }

        .package-card:hover::before {
            left: 100%;
        }

        .package-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .package-image {
            width: 100%;
            height: 200px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .package-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .package-card:hover .package-image img {
            transform: scale(1.05);
        }

        .package-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 0.5rem;
        }

        .package-price {
            font-size: 2rem;
            font-weight: 700;
            color: #ffd700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .package-features {
            list-style: none;
            margin-bottom: 1.5rem;
        }

        .package-features li {
            color: rgba(255,255,255,0.9);
            padding: 0.3rem 0;
            position: relative;
            padding-left: 1.5rem;
        }

        .package-features li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #4ade80;
            font-weight: bold;
        }

        /* Portfolio Grid */
        .portfolio-item {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            aspect-ratio: 1;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .portfolio-item:hover {
            transform: scale(1.02);
        }

        .portfolio-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .portfolio-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: #fff;
            padding: 1.5rem;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .portfolio-item:hover .portfolio-overlay {
            transform: translateY(0);
        }

        /* Contact Form */
        .contact-form {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 2.5rem;
        }

        .form-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 1rem;
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.15);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .section {
                padding: 3rem 0;
            }
            
            .package-card {
                margin-bottom: 2rem;
            }
        }

        /* Performance optimizations */
        .will-change-transform {
            will-change: transform;
        }

        .will-change-opacity {
            will-change: opacity;
        }

        /* Reduce motion for users who prefer it */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>
    <!-- Performance-optimized background -->
    <div class="bg-animation"></div>

    <!-- UIverse Animations -->
    <div class="uiverse-starfish">
        <div class="starfish"></div>
    </div>
    <div class="uiverse-robin">
        <div class="robin"></div>
    </div>
    <div class="uiverse-gecko">
        <div class="gecko"></div>
    </div>
    <div class="uiverse-donkey">
        <div class="donkey"></div>
    </div>
    <div class="uiverse-zebra">
        <div class="zebra"></div>
    </div>
    <div class="uiverse-cheetah">
        <div class="cheetah"></div>
    </div>

    <?php echo $header; ?>

    <main>
        <!-- Hero Section -->
        <section class="hero" id="hero">
            <div class="hero-content" data-aos="fade-up">
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6">
                    Capturing Life's Most Treasured Moments
                </h1>
                <p class="text-xl md:text-2xl text-white/90 mb-10 font-light">
                    Professional Videography and Photography Services for Every Occasion
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#contact" class="glass-button px-8 py-4 rounded-full text-white font-semibold text-lg">
                        Book Your Event
                    </a>
                    <a href="#services" class="glass-button px-8 py-4 rounded-full text-white font-semibold text-lg">
                        See Our Services
                    </a>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="section" id="about">
            <div class="container mx-auto px-4">
                <h2 class="section-title">About Us</h2>
                <p class="section-subtitle">
                    With unwavering commitment to quality and service, we bring artistry and professionalism to every event—your story is our passion.
                </p>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-12">
                    <div class="glass-card p-6 text-center">
                        <div class="text-4xl mb-4">📸</div>
                        <h3 class="text-xl font-semibold text-white mb-2">Wedding Coverage</h3>
                        <p class="text-white/80">Complete wedding documentation with cinematic video production</p>
                    </div>
                    <div class="glass-card p-6 text-center">
                        <div class="text-4xl mb-4">🎉</div>
                        <h3 class="text-xl font-semibold text-white mb-2">Event Photography</h3>
                        <p class="text-white/80">Birthday, anniversary, and milestone celebrations</p>
                    </div>
                    <div class="glass-card p-6 text-center">
                        <div class="text-4xl mb-4">👨‍🎓</div>
                        <h3 class="text-xl font-semibold text-white mb-2">Graduate Packages</h3>
                        <p class="text-white/80">Specialized photography for academic achievements</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="section" id="services">
            <div class="container mx-auto px-4">
                <h2 class="section-title">Our Photography Packages</h2>
                <p class="section-subtitle">
                    From solo portraits to group celebrations, we have the perfect package for every occasion
                </p>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
                    <!-- Solo Package -->
                    <div class="package-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="package-image">
                            <img src="img/pic/Solo.png" alt="Solo Package" />
                        </div>
                        <h3 class="package-title">Solo Package</h3>
                        <div class="package-price">₱199.00</div>
                        <ul class="package-features">
                            <li>1-2 Pax</li>
                            <li>10 Minutes Self-Portrait</li>
                            <li>1 Backdrop Color</li>
                            <li>Free use of basic props</li>
                            <li>Unlimited Soft Copy</li>
                        </ul>
                        <a href="solo.php" class="glass-button px-6 py-3 rounded-full text-white font-semibold block text-center">
                            View Details
                        </a>
                    </div>

                    <!-- Trio Package -->
                    <div class="package-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="package-image">
                            <img src="img/pic/Trio.png" alt="Trio Package" />
                        </div>
                        <h3 class="package-title">Trio Package</h3>
                        <div class="package-price">₱900.00</div>
                        <ul class="package-features">
                            <li>3 Pax</li>
                            <li>20 Minutes Self-Portrait</li>
                            <li>2 Backdrop Colors</li>
                            <li>4 4R Size Prints</li>
                            <li>All Digital Copies Free</li>
                        </ul>
                        <a href="trio.php" class="glass-button px-6 py-3 rounded-full text-white font-semibold block text-center">
                            View Details
                        </a>
                    </div>

                    <!-- Quad Package -->
                    <div class="package-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="package-image">
                            <img src="img/pic/Quad.png" alt="Quad Package" />
                        </div>
                        <h3 class="package-title">Quad Package</h3>
                        <div class="package-price">₱1,200.00</div>
                        <ul class="package-features">
                            <li>4 Pax</li>
                            <li>30 Minutes Session</li>
                            <li>3 Backdrop Colors</li>
                            <li>6 4R Size Prints</li>
                            <li>Professional Editing</li>
                        </ul>
                        <a href="quad.php" class="glass-button px-6 py-3 rounded-full text-white font-semibold block text-center">
                            View Details
                        </a>
                    </div>

                    <!-- Graduate Package -->
                    <div class="package-card" data-aos="fade-up" data-aos-delay="400">
                        <div class="package-image">
                            <img src="img/pic/Graduate.png" alt="Graduate Package" />
                        </div>
                        <h3 class="package-title">Graduate Package</h3>
                        <div class="package-price">₱800.00</div>
                        <ul class="package-features">
                            <li>1 Pax</li>
                            <li>15 Minutes Self-Portrait</li>
                            <li>1 Backdrop Color</li>
                            <li>2 4R Size Prints</li>
                            <li>All Digital Copies Free</li>
                        </ul>
                        <a href="graduate.php" class="glass-button px-6 py-3 rounded-full text-white font-semibold block text-center">
                            View Details
                        </a>
                    </div>

                    <!-- Deluxe Package -->
                    <div class="package-card" data-aos="fade-up" data-aos-delay="500">
                        <div class="package-image">
                            <img src="img/pic/Deluxee.png" alt="Deluxe Package" />
                        </div>
                        <h3 class="package-title">Deluxe Package</h3>
                        <div class="package-price">₱1,500.00</div>
                        <ul class="package-features">
                            <li>5-8 Pax</li>
                            <li>45 Minutes Session</li>
                            <li>Multiple Backdrops</li>
                            <li>10 4R Size Prints</li>
                            <li>Premium Editing</li>
                        </ul>
                        <a href="deluxe.php" class="glass-button px-6 py-3 rounded-full text-white font-semibold block text-center">
                            View Details
                        </a>
                    </div>

                    <!-- Group Package -->
                    <div class="package-card" data-aos="fade-up" data-aos-delay="600">
                        <div class="package-image">
                            <img src="img/pic/Group.png" alt="Group Package" />
                        </div>
                        <h3 class="package-title">Group Package</h3>
                        <div class="package-price">₱2,000.00</div>
                        <ul class="package-features">
                            <li>9+ Pax</li>
                            <li>60 Minutes Session</li>
                            <li>All Backdrop Colors</li>
                            <li>15 4R Size Prints</li>
                            <li>Professional Album</li>
                        </ul>
                        <a href="group.php" class="glass-button px-6 py-3 rounded-full text-white font-semibold block text-center">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Portfolio Section -->
        <section class="section" id="portfolio">
            <div class="container mx-auto px-4">
                <h2 class="section-title">Portfolio Highlights</h2>
                <p class="section-subtitle">
                    Explore our work across different photography styles and packages
                </p>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-12">
                    <div class="portfolio-item" data-category="solo">
                        <img src="img/pic/Solo1.JPG" alt="Solo Portrait" />
                        <div class="portfolio-overlay">
                            <h4 class="font-semibold">Solo Portrait</h4>
                            <p class="text-sm">Professional headshots</p>
                        </div>
                    </div>
                    <div class="portfolio-item" data-category="trio">
                        <img src="img/pic/Trio1.jpg" alt="Trio Session" />
                        <div class="portfolio-overlay">
                            <h4 class="font-semibold">Trio Session</h4>
                            <p class="text-sm">Group portraits</p>
                        </div>
                    </div>
                    <div class="portfolio-item" data-category="quad">
                        <img src="img/pic/Quad1.JPG" alt="Quad Session" />
                        <div class="portfolio-overlay">
                            <h4 class="font-semibold">Quad Session</h4>
                            <p class="text-sm">Family portraits</p>
                        </div>
                    </div>
                    <div class="portfolio-item" data-category="group">
                        <img src="img/pic/Group1.jpg" alt="Group Session" />
                        <div class="portfolio-overlay">
                            <h4 class="font-semibold">Group Session</h4>
                            <p class="text-sm">Large group photos</p>
                        </div>
                    </div>
                    <div class="portfolio-item" data-category="graduate">
                        <img src="img/pic/Graduate.jpg" alt="Graduate Session" />
                        <div class="portfolio-overlay">
                            <h4 class="font-semibold">Graduate Session</h4>
                            <p class="text-sm">Graduation portraits</p>
                        </div>
                    </div>
                    <div class="portfolio-item" data-category="solo">
                        <img src="img/pic/Solo4.JPG" alt="Solo Portrait" />
                        <div class="portfolio-overlay">
                            <h4 class="font-semibold">Solo Portrait</h4>
                            <p class="text-sm">Professional shots</p>
                        </div>
                    </div>
                    <div class="portfolio-item" data-category="trio">
                        <img src="img/pic/Trio2.jpg" alt="Trio Session" />
                        <div class="portfolio-overlay">
                            <h4 class="font-semibold">Trio Session</h4>
                            <p class="text-sm">Family moments</p>
                        </div>
                    </div>
                    <div class="portfolio-item" data-category="quad">
                        <img src="img/pic/Quad2.JPG" alt="Quad Session" />
                        <div class="portfolio-overlay">
                            <h4 class="font-semibold">Quad Session</h4>
                            <p class="text-sm">Group celebrations</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="section" id="contact">
            <div class="container mx-auto px-4">
                <h2 class="section-title">Contact & Booking</h2>
                <p class="section-subtitle">
                    Ready to capture your special moments? Get in touch with us today.
                </p>
                
                <div class="grid lg:grid-cols-2 gap-8 mt-12">
                    <!-- Contact Info -->
                    <div class="glass-card p-8">
                        <h3 class="text-2xl font-semibold text-white mb-6">Get In Touch</h3>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <div class="text-2xl">📞</div>
                                <div>
                                    <p class="text-white/80">Phone</p>
                                    <a href="tel:+63-999-999-9999" class="text-white font-semibold">+63-999-999-9999</a>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="text-2xl">✉️</div>
                                <div>
                                    <p class="text-white/80">Email</p>
                                    <a href="mailto:rommelgarciadigitalvideo@gmail.com" class="text-white font-semibold">rommelgarciadigitalvideo@gmail.com</a>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="text-2xl">📍</div>
                                <div>
                                    <p class="text-white/80">Location</p>
                                    <p class="text-white font-semibold">Guimba, Nueva Ecija, Philippines</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <h4 class="text-white font-semibold mb-4">Follow Us</h4>
                            <div class="flex space-x-4">
                                <a href="https://www.facebook.com/rommelgarciadigitalvideoandphotography" target="_blank" class="glass-button p-3 rounded-full">
                                    <span class="text-xl">📘</span>
                                </a>
                                <a href="https://rommelgarcia.com" target="_blank" class="glass-button p-3 rounded-full">
                                    <span class="text-xl">🌐</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="contact-form">
                        <h3 class="text-2xl font-semibold text-white mb-6">Book Your Session</h3>
                        <form action="#" method="post" class="space-y-4">
                            <div>
                                <label class="block text-white/80 mb-2">Name</label>
                                <input type="text" name="name" required class="form-input w-full" placeholder="Your Name" />
                            </div>
                            <div>
                                <label class="block text-white/80 mb-2">Service Needed</label>
                                <select name="service" required class="form-input w-full">
                                    <option value="">Select a Service</option>
                                    <option>Wedding</option>
                                    <option>Birthday</option>
                                    <option>Anniversary</option>
                                    <option>Christening</option>
                                    <option>Graduate Session</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-white/80 mb-2">Date</label>
                                <input type="date" name="date" required class="form-input w-full" />
                            </div>
                            <div>
                                <label class="block text-white/80 mb-2">Message</label>
                                <textarea name="message" required class="form-input w-full h-32 resize-none" placeholder="How can we help you?"></textarea>
                            </div>
                            <button type="submit" class="glass-button px-8 py-4 rounded-full text-white font-semibold w-full">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php echo $footer; ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        // Initialize AOS with performance optimizations
        AOS.init({ 
            duration: 800, 
            once: true, 
            offset: 100,
            easing: 'ease-out-cubic'
        });

        // GSAP for smooth animations
        gsap.registerPlugin(ScrollTrigger);

        // Performance-optimized animations
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // GSAP animations for package cards
            gsap.from('.package-card', {
                duration: 0.8,
                y: 50,
                opacity: 0,
                stagger: 0.1,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: '.package-card',
                    start: 'top 80%',
                    end: 'bottom 20%',
                    toggleActions: 'play none none reverse'
                }
            });

            // GSAP animations for portfolio items
            gsap.from('.portfolio-item', {
                duration: 0.6,
                scale: 0.8,
                opacity: 0,
                stagger: 0.05,
                ease: 'back.out(1.7)',
                scrollTrigger: {
                    trigger: '.portfolio-item',
                    start: 'top 85%',
                    end: 'bottom 15%',
                    toggleActions: 'play none none reverse'
                }
            });

            // Performance optimization: Reduce animation complexity on lower-end devices
            const isLowEndDevice = navigator.hardwareConcurrency <= 4 || 
                                 navigator.deviceMemory <= 4;
            
            if (isLowEndDevice) {
                // Disable complex animations for better performance
                document.querySelectorAll('.uiverse-starfish, .uiverse-robin, .uiverse-gecko, .uiverse-donkey, .uiverse-zebra, .uiverse-cheetah').forEach(el => {
                    el.style.display = 'none';
                });
                
                // Reduce animation duration
                gsap.globalTimeline.timeScale(0.5);
            }
        });

        // Form handling
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            // Add your form submission logic here
            alert('Thank you for your message! We will get back to you soon.');
        });
    </script>
</body>
</html> 