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
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;900&family=Inter:wght@300;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #fafafa;
            color: #1a1a1a;
            overflow-x: hidden;
        }
        
        .hero-section {
            height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8fafc 0%, #e9ecef 100%), url('img/indexImage/IMG_9290.JPG') center/cover no-repeat;
            overflow: hidden;
        }
        
        .hero-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(3, 1fr);
            gap: 1rem;
            width: 100%;
            height: 100%;
            padding: 2rem;
            position: absolute;
            top: 0;
            left: 0;
        }
        
        .hero-image {
            background-size: cover;
            background-position: center;
            border-radius: 1rem;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .hero-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
            transition: all 0.6s ease;
        }
        
        .hero-image:hover::before {
            background: rgba(0,0,0,0.6);
        }
        
        .hero-image:hover {
            transform: scale(1.15);
            z-index: 10;
        }
        
        .hero-image:nth-child(1) {
            grid-column: 1;
            grid-row: 1;
            background-image: url('img/indexImage/IMG_9290.JPG');
        }
        
        .hero-image:nth-child(2) {
            grid-column: 3;
            grid-row: 1;
            background-image: url('img/pic/Solo1.JPG');
        }
        
        .hero-image:nth-child(3) {
            grid-column: 3;
            grid-row: 2;
            background-image: url('img/pic/Trio1.jpg');
        }
        
        .hero-image:nth-child(4) {
            grid-column: 4;
            grid-row: 2;
            background-image: url('img/pic/Quad1.JPG');
        }
        
        .hero-image:nth-child(5) {
            grid-column: 1;
            grid-row: 3;
            background-image: url('img/pic/Group1.jpg');
        }
        
        .hero-image:nth-child(6) {
            grid-column: 2;
            grid-row: 3;
            background-image: url('img/pic/Graduate.jpg');
        }
        
        .hero-image:nth-child(7) {
            grid-column: 4;
            grid-row: 3;
            background-image: url('img/pic/Deluxee.png');
        }
        
        .hero-content {
            position: relative;
            z-index: 20;
            text-align: center;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            padding: 3rem 4rem;
            border-radius: 2rem;
            box-shadow: 0 25px 50px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.05rem;
            font-weight: 900;
            color: #1a1a1a;
            margin-bottom: 1rem;
            line-height: 1.1;
        }
        
        .hero-subtitle {
            font-size: 1.02rem;
            color: #666;
            margin-bottom: 2rem;
            font-weight: 400;
        }
        
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .cta-primary, .cta-secondary {
            padding: 1rem 2rem;
            border-radius: 3rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .cta-primary {
            background: #1a1a1a;
            color: white;
        }
        
        .cta-primary:hover {
            background: #333;
            transform: translateY(-2px);
        }
        
        .cta-secondary {
            background: transparent;
            color: #1a1a1a;
            border-color: #1a1a1a;
        }
        
        .cta-secondary:hover {
            background: #1a1a1a;
            color: white;
        }
        
        /* Services Advertisement Section */
        .services-ad-section {
            padding: 6rem 2rem;
            background: #f8f9fa;
        }
        
        .services-intro {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .services-intro h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.05rem;
            color: #1a1a1a;
            margin-bottom: 1rem;
        }
        
        .services-intro p {
            font-size: 1.01rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .occasions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .occasion-card {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 1rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .occasion-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-color: #1a1a1a;
        }
        
        .occasion-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .occasion-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            color: #1a1a1a;
            margin-bottom: 1rem;
        }
        
        .occasion-card p {
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.6;
        }
        
        .occasion-card ul {
            list-style: none;
            margin-bottom: 2rem;
            text-align: left;
        }
        
        .occasion-card li {
            padding: 0.3rem 0;
            color: #1a1a1a;
            position: relative;
            padding-left: 1.5rem;
        }
        
        .occasion-card li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #1a1a1a;
            font-weight: bold;
        }
        
        .occasion-btn {
            display: inline-block;
            background: #1a1a1a;
            color: white;
            text-decoration: none;
            padding: 0.8rem 1.05rem;
            border-radius: 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .occasion-btn:hover {
            background: #333;
            transform: translateY(-2px);
            color: white;
        }
        
        /* Value Proposition Section */
        .value-section {
            padding: 6rem 2rem;
            background: #f8f9fa;
        }
        
        .value-content {
            text-align: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .value-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.05rem;
            color: #1a1a1a;
            margin-bottom: 3rem;
        }
        
        .value-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        
        .value-item {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .value-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .value-icon {
            font-size: 2.05rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .value-item h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.03rem;
            color: #1a1a1a;
            margin-bottom: 1rem;
        }
        
        .value-item p {
            color: #666;
            line-height: 1.6;
        }
        
        /* Call to Action Section */
        .cta-section {
            padding: 6rem 2rem;
            background: #1a1a1a;
            color: white;
            text-align: center;
        }
        
        .cta-content {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .cta-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.05rem;
            margin-bottom: 1rem;
        }
        
        .cta-content p {
            font-size: 1.01rem;
            color: #ccc;
            margin-bottom: 2rem;
        }
        
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 3rem;
        }
        
        .cta-features {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }
        
        .feature {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #ccc;
        }
        
        .feature-icon {
            font-size: 1.2rem;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .services-intro h2,
            .value-content h2,
            .cta-content h2 {
                font-size: 2em;
            }
            
            .occasions-grid {
                grid-template-columns: 1fr;
            }
            
            .value-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
            
            .cta-features {
                flex-direction: column;
                align-items: center;
            }
        }
        
        .stats-section {
            padding: 4rem 2rem;
            background: #1a1a1a;
            color: white;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
        }
        
        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #fff;
        }
        
        .stat-label {
            font-size: 1.01rem;
            color: #ccc;
            font-weight: 400;
        }
        
        .contact-section {
            padding: 6rem 2rem;
            background: white;
        }
        
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            max-width: 1000px;
            margin: 0 auto;
            align-items: center;
        }
        
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 1rem;
            transition: all 0.3s ease;
        }
        
        .contact-item:hover {
            background: #1a1a1a;
            color: white;
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            background: #1a1a1a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        .contact-item:hover .contact-icon {
            background: white;
            color: #1a1a1a;
        }
        
        .contact-form {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 1.5rem;
        }
        
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 2px solid transparent;
            border-radius: 0.5rem;
            background: white;
            transition: all 0.3s ease;
        }
        
        .contact-form input:focus,
        .contact-form textarea:focus {
            outline: none;
            border-color: #1a1a1a;
        }
        
        .contact-form button {
            width: 100%;
            padding: 1rem;
            background: #1a1a1a;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .contact-form button:hover {
            background: #333;
        }
        
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        
        .floating-element {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-element:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .floating-element:nth-child(2) {
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }
        
        .floating-element:nth-child(3) {
            bottom: 30%;
            left: 20%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        @media (max-width: 768px) {
            .hero-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: repeat(4, 1fr);
            }
            
            .hero-image:nth-child(1) {
                grid-column: 1 / 3;
                grid-row: 1 / 2;
            }
            
            .hero-title {
                font-size: 2.05rem;
            }
            
            .contact-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <?php echo $header; ?>
    <!-- Floating decorative elements -->
    <div class="floating-elements">
        <div class="floating-element">📷</div>
        <div class="floating-element">🎥</div>
        <div class="floating-element">✨</div>
    </div>
    
    <!-- Hero Section with Image Grid -->
    <section class="hero-section">
        <div class="hero-grid">
            <div class="hero-image" data-aos="fade-up" data-aos-delay="100"></div>
            <div class="hero-image" data-aos="fade-up" data-aos-delay="200"></div>
            <div class="hero-image" data-aos="fade-up" data-aos-delay="300"></div>
            <div class="hero-image" data-aos="fade-up" data-aos-delay="400"></div>
            <div class="hero-image" data-aos="fade-up" data-aos-delay="500"></div>
            <div class="hero-image" data-aos="fade-up" data-aos-delay="600"></div>
            <div class="hero-image" data-aos="fade-up" data-aos-delay="700"></div>
                        </div>

        <div class="hero-content" data-aos="fade-up">         <h1 class="hero-title">Capture Every Moment</h1>
            <p class="hero-subtitle">Professional photography & videography for life's special occasions</p>
            <div class="cta-buttons">
                <a href="appointment.php" class="cta-primary">Book Appointment</a>
                <a href="gallery.php" class="cta-secondary">View Gallery</a>
                            </div>
                </div>
        </section>

    <!-- Services Advertisement Section -->
    <section class="services-ad-section">
        <div class="container">
            <div class="services-intro" data-aos="fade-up">
                <h2 class="section-title">We Provide Services for Any Occasion</h2>
                <p class="section-subtitle">From intimate moments to grand celebrations, we capture every precious memory with professional excellence</p>
        </div>
            
            <div class="occasions-grid">
                <div class="occasion-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="occasion-icon">💒</div>
                    <h3>Weddings</h3>
                    <p>Your special day deserves the finest photography. From pre-wedding shoots to the grand celebration, we capture every magical moment.</p>
                    <ul>
                        <li>Pre-wedding sessions</li>
                        <li>Full day coverage</li>
                        <li>Cinematic videos</li>
                        <li>Professional albums</li>
                                    </ul>
                    <a href="appointment.php" class="occasion-btn">Book Wedding</a>
                    </div>

                <div class="occasion-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="occasion-icon">🎂</div>
                    <h3>Birthdays</h3>
                    <p>Celebrate lifes milestones with beautiful photography. From first birthdays to milestone celebrations, we make every moment count.</p>
                    <ul>
                        <li>Birthday portraits</li>
                        <li>Party documentation</li>
                        <li>Candid moments</li>
                        <li>On-site prints</li>
                                    </ul>
                    <a href="appointment.php" class="occasion-btn">Book Birthday</a>
                    </div>

                <div class="occasion-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="occasion-icon">💕</div>
                    <h3>Anniversaries</h3>
                    <p>Recreate the magic of your love story. Whether it's your first or fiftieth anniversary, we capture the romance and joy.</p>
                    <ul>
                        <li>Couple portraits</li>
                        <li>Romantic sessions</li>
                        <li>Story-driven filming</li>
                        <li>Photo montages</li>
                                    </ul>
                    <a href="appointment.php" class="occasion-btn">Book Anniversary</a>
                    </div>

                <div class="occasion-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="occasion-icon">👶</div>
                    <h3>Christenings</h3>
                    <p>Document your child's spiritual journey with reverence and beauty. We understand the sacred nature of these occasions.</p>
                    <ul>
                        <li>Ceremony coverage</li>
                        <li>Family portraits</li>
                        <li>Religious sensitivity</li>
                        <li>Group photos</li>
                                    </ul>
                    <a href="appointment.php" class="occasion-btn">Book Christening</a>
                    </div>

                <div class="occasion-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="occasion-icon">🕊️</div>
                    <h3>Internments</h3>
                    <p>With compassion and respect, we document these solemn moments for families to cherish and remember their loved ones.</p>
                    <ul>
                        <li>Discreet coverage</li>
                        <li>Compassionate service</li>
                        <li>Memorial documentation</li>
                        <li>Family support</li>
                                    </ul>
                    <a href="appointment.php" class="occasion-btn">Book Service</a>
                    </div>

                <div class="occasion-card" data-aos="fade-up" data-aos-delay="600">
                    <div class="occasion-icon">🎓</div>
                    <h3>Graduations</h3>
                    <p>Celebrate academic achievements with professional graduation photography. From thesis defenses to graduation ceremonies.</p>
                    <ul>
                        <li>Gown portraits</li>
                        <li>Academic regalia</li>
                        <li>Achievement documentation</li>
                        <li>Professional editing</li>
                                    </ul>
                    <a href="appointment.php" class="occasion-btn">Book Graduation</a>
                                </div>
                            </div>
                        </div>
    </section>

    <!-- Value Proposition Section -->
    <section class="value-section">
        <div class="container">
            <div class="value-content" data-aos="fade-up">
                <h2>Why Choose Rommel Garcia Photography?</h2>
                <div class="value-grid">
                    <div class="value-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="value-icon">📸</div>
                        <h3>Professional Equipment</h3>
                        <p>Latest high-resolution cameras and professional lighting for stunning results</p>
                            </div>
                    <div class="value-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="value-icon">⏰</div>
                        <h3>Fast Turnaround</h3>
                        <p>Quick delivery of your photos and videos without compromising quality</p>
                            </div>
                    <div class="value-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="value-icon">💰</div>
                        <h3>Affordable Packages</h3>
                        <p>Starting from ₱199 for solo sessions to comprehensive group packages</p>
                            </div>
                    <div class="value-item" data-aos="fade-up" data-aos-delay="400">
                        <div class="value-icon">🎨</div>
                        <h3>Professional Editing</h3>
                        <p>Expert post-processing to enhance every image to perfection</p>
                            </div>
                    <div class="value-item" data-aos="fade-up" data-aos-delay="500">
                        <div class="value-icon">🚗</div>
                        <h3>Convenient Location</h3>
                        <p>Easy to find in Guimba with parking available for your convenience</p>
                            </div>
                    <div class="value-item" data-aos="fade-up" data-aos-delay="600">
                        <div class="value-icon">💬</div>
                        <h3>Excellent Communication</h3>
                        <p>Clear communication throughout the entire process from booking to delivery</p>
                        </div>
                    </div>
                </div>
                            </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Ready to Create Beautiful Memories?</h2>
                <p>Book your session today and let us capture your special moments with professional excellence</p>
                <div class="cta-buttons">
                    <a href="appointment.php" class="cta-primary">Book Appointment Now</a>
                    <a href="gallery.php" class="cta-secondary">View Our Gallery</a>
                            </div>
                <div class="cta-features">
                    <div class="feature">
                        <span class="feature-icon">✅</span>
                        <span>50% down payment via GCash</span>
                            </div>
                    <div class="feature">
                        <span class="feature-icon">✅</span>
                        <span>Walk-ins welcome (Tue-Fri 1-5 PM)</span>
                            </div>
                    <div class="feature">
                        <span class="feature-icon">✅</span>
                        <span>Free parking available</span>
                            </div>
                            </div>
                            </div>
                            </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-number">500+</div>
                <div class="stat-label">Happy Clients</div>
                            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-number">1000+</div>
                <div class="stat-label">Photos Delivered</div>
                            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-number">50+</div>
                <div class="stat-label">Events Covered</div>
                </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-number">5+</div>
                <div class="stat-label">Years Experience</div>
                            </div>
                            </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="contact-grid">
            <div class="contact-info">
                <div class="contact-item" data-aos="fade-right" data-aos-delay="100">
                    <div class="contact-icon">📞</div>
                    <div>
                        <h3>Call Us</h3>
                        <p>+63-999-999-9999</p>
                            </div>
                            </div>
                <div class="contact-item" data-aos="fade-right" data-aos-delay="200">
                    <div class="contact-icon">📧</div>
                    <div>
                        <h3>Email Us</h3>
                        <p>rommelgarciadigitalvideo@gmail.com</p>
                </div>
                            </div>
                <div class="contact-item" data-aos="fade-right" data-aos-delay="300">
                    <div class="contact-icon">📍</div>
                    <div>
                        <h3>Visit Us</h3>
                        <p>Guimba, Nueva Ecija, Philippines</p>
                            </div>
                            </div>
                <div class="contact-item" data-aos="fade-right" data-aos-delay="400">
                    <div class="contact-icon">📱</div>
                    <div>
                        <h3>Follow Us</h3>
                        <p>Facebook: Rommel Garcia Digital Video</p>
                        </div>
                    </div>
                            </div>
            
            <div class="contact-form" data-aos="fade-left" data-aos-delay="200">
                <h3 style="margin-bottom: 2rem; font-size: 1.5rem; color: #1a1a1a;">Book Your Session</h3>
                <form action="#" method="post">
                    <input type="text" placeholder="Your Name" required>
                    <input type="email" placeholder="Your Email" required>
                    <input type="tel" placeholder="Phone Number" required>
                    <select required>
                        <option value="">Select Package</option>
                        <option value="solo">Solo Package</option>
                        <option value="trio">Trio Package</option>
                        <option value="quad">Quad Package</option>
                        <option value="graduate">Graduate Package</option>
                        <option value="deluxe">Deluxe Package</option>
                        <option value="group">Group Package</option>
                            </select>
                    <input type="date" required>
                    <textarea placeholder="Message (Optional)" rows="4"></textarea>
                    <button type="submit">Book Now</button>
                        </form>
        </div>
      </div>
    </section>

    <?php echo $footer; ?>
    
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
        
        // Smooth scrolling for navigation
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
            
        // Parallax effect for hero images
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelectorAll('.hero-image');
            parallax.forEach(element => {
                const speed = 0.5;
                element.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });
    </script>
</body>
</html>
