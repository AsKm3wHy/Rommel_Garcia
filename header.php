<?php
$header = ' 
<header class="header-area" role="banner" itemscope itemtype="https://schema.org/WPHeader">
    <div class="main-header-area">
        <div class="classy-nav-container breakpoint-off">
            <div class="container">
                <nav class="classy-navbar justify-content-between" id="lxNav" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
                    <a class="nav-brand" href="index.php" data-aos="fade-right" data-aos-duration="3000" aria-label="Rommel Garcia Photography Home">
                        <img src="img/Header-Pic/rommel-logo-v3.svg" alt="Rommel Garcia Photography Logo" width="80" height="80" style="margin-top:0; width:5rem;">
                    </a>

                    <div class="classy-navbar-toggler" aria-label="Menu Toggle">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>

                    <div class="classy-menu">
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>

                        <div class="classynav" data-aos="fade-left" data-aos-duration="3000">
                            <ul id="nav" role="menubar">
                                <li role="menuitem"><a href="index.php" title="Home Page">Home</a></li>
                                <li role="menuitem"><a href="gallery.php" title="Photo Gallery">Gallery</a></li>
                                <li role="menuitem"><a href="faq.php" title="Frequently Asked Questions">FAQ</a></li>
                                <li role="menuitem"><a href="contactUs.php" title="Contact Information">Contact Us</a></li>
                                
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>';

$footer = '
<footer class="footer-area" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
    <div class="footer-top-area section-padding-80-0">
        <div class="container">
            <div class="row align-items-center justify-content-between" style="display: flex; flex-wrap: wrap; align-items: center;">
                <!-- Logo -->
                <div class="footer-logo-area" style="flex: 0 0 200px; display: flex; align-items: center; justify-content: center;">
                    <img src="img/Header-Pic/rommel-logo-v3.svg" alt="Rommel Garcia Photography Logo" style="width: 120px; height: auto;">
                </div>
                <!-- Website Info -->
                <div class="footer-info-area" style="flex: 1 1 400px; min-width: 250px; padding: 0 30px; text-align: left;">
                    <h5 itemprop="name" class="mb-20" style="color: #f7b315; font-weight: 600;">Rommel Garcia Digital Video and Photography</h5>
                    <p class="mb-20" itemprop="description" style="color: #cccccc;">Professional photography and digital video services in Guimba, Nueva Ecija. Specializing in graduation photos, weddings, events, portraits, and creative photography packages.</p>
                    <div class="contact-info" style="margin-top: 10px;">
                        <div class="single-contact-info d-flex align-items-center mb-10">
                            <div class="icon mr-10">
                                <i class="fas fa-map-marker-alt" style="color: #f7b315;"></i>
                            </div>
                            <div class="text">
                                <span itemprop="addressLocality">Guimba</span>, 
                                <span itemprop="addressRegion">Nueva Ecija</span>, 
                                <span itemprop="addressCountry">Philippines</span>
                            </div>
                        </div>
                        <div class="single-contact-info d-flex align-items-center mb-10">
                            <div class="icon mr-10">
                                <i class="fas fa-clock" style="color: #f7b315;"></i>
                            </div>
                            <div class="text">
                                Monday - Friday: 8:00 AM - 5:00 PM
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Quick Links -->
                <div class="footer-links-area" style="flex: 0 0 180px; min-width: 180px; text-align: left;">
                    <h5 class="mb-20" style="color: #f7b315; font-weight: 600;">Quick Links</h5>
                    <ul class="footer-links" style="list-style: none; padding: 0; margin: 0;">
                        <li><a href="index.php"><i class="fas fa-angle-right mr-2"></i>Home</a></li>
                        <li><a href="gallery.php"><i class="fas fa-angle-right mr-2"></i>Gallery</a></li>
                        <li><a href="faq.php"><i class="fas fa-angle-right mr-2"></i>FAQ</a></li>
                        <li><a href="contactUs.php"><i class="fas fa-angle-right mr-2"></i>Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <div class="footer-copyright">
                        <p class="mb-0">&copy; ' . date('Y') . ' Rommel Garcia Digital Video and Photography. All rights reserved.</p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</footer>

<style>
/* Footer Styles */
.footer-area {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: #ffffff;
    position: relative;
}

.footer-area::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, #f7b315, transparent);
}

.footer-top-area {
    padding: 80px 0 40px;
}

.footer-widget-area h5 {
    color: #f7b315;
    font-weight: 600;
    margin-bottom: 25px;
    position: relative;
}

.footer-widget-area h5::after {
    content: "";
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 30px;
    height: 2px;
    background: #f7b315;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    color: #cccccc;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
}

.footer-links a:hover {
    color: #f7b315;
    transform: translateX(5px);
}

.contact-info .single-contact-info {
    margin-bottom: 15px;
}

.contact-info .icon {
    width: 20px;
    text-align: center;
}

.contact-info .text p {
    color: #cccccc;
    font-size: 14px;
    line-height: 1.6;
}

.social-links {
    display: flex;
    gap: 15px;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(247, 179, 21, 0.1);
    color: #f7b315;
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid rgba(247, 179, 21, 0.3);
}

.social-link:hover {
    background: #f7b315;
    color: #1a1a1a;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(247, 179, 21, 0.3);
}

.contact-buttons .btn {
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    padding: 10px 20px;
}

.contact-buttons .btn-primary {
    background: #f7b315;
    color: #1a1a1a;
}

.contact-buttons .btn-primary:hover {
    background: #e6a800;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(247, 179, 21, 0.3);
}

.contact-buttons .btn-outline-primary {
    border: 2px solid #f7b315;
    color: #f7b315;
    background: transparent;
}

.contact-buttons .btn-outline-primary:hover {
    background: #f7b315;
    color: #1a1a1a;
    transform: translateY(-2px);
}

.footer-bottom-area {
    background: rgba(0, 0, 0, 0.3);
    padding: 20px 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.footer-copyright p {
    color: #999999;
    font-size: 14px;
    margin: 0;
}

.footer-bottom-links a {
    color: #999999;
    text-decoration: none;
    margin-left: 20px;
    font-size: 14px;
    transition: color 0.3s ease;
}

.footer-bottom-links a:hover {
    color: #f7b315;
}

/* Responsive Design */
@media (max-width: 768px) {
    .footer-top-area {
        padding: 60px 0 30px;
    }
    
    .footer-widget-area {
        margin-bottom: 40px;
    }
    
    .social-links {
        justify-content: center;
        margin-bottom: 20px;
    }
    
    .contact-buttons {
        text-align: center;
    }
    
    .footer-bottom-links {
        text-align: center !important;
        margin-top: 15px;
    }
    
    .footer-bottom-links a {
        margin: 0 10px;
    }
}

@media (max-width: 576px) {
    .footer-links a {
        font-size: 14px;
    }
    
    .contact-info .text p {
        font-size: 13px;
    }
    
    .social-link {
        width: 35px;
        height: 35px;
    }
}
</style>';

$gallery = '
    <div class="lx-portfolio-area section-padding-80 clearfix" data-aos="fade-up" data-aos-duration="3000">
    <div class="title-gallery text-center">
        <h2>GALLERY</h2>
    </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="lx-projects-menu wow fadeInUp" data-wow-delay="100ms">
                        <div class="portfolio-menu text-center">
                            <button class="btn active" data-filter="*">All</button>
                            <button class="btn" data-filter=".solo">Solo</button>
                            <button class="btn" data-filter=".duo">Duo</button>
                            <button class="btn" data-filter=".trio">Trio</button>
                            <button class="btn" data-filter=".quad">Quad</button>
                            <button class="btn" data-filter=".deluxe">Deluxe</button>
                            <button class="btn" data-filter=".group">Group</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row lx-portfolio">

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp trio"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/indexImage/empty.png" alt="">
                        <div class="hover-content">
                            <a href="img/indexImage/empty.png" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp solo"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Solo1.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Solo1.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp duo" data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/empty.png" alt="">
                        <div class="hover-content">
                            <a href="img/indexImage/empty.png" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp quad"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Quad1.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Quad1.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp solo"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Solo4.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Solo4.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp quad"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Quad2.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Quad2.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp solo"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Solo3.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Solo3.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp quad"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Quad3.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Quad3.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp quad"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Quad 8.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Quad 8.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp solo"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Solo2.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Solo2.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp solo"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Solo5.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Solo5.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp duo" data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/indexImage/empty.png" alt="">
                        <div class="hover-content">
                            <a href="img/indexImage/empty.png" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp trio"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Trio1.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Trio1.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp trio"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/indexImage/empty.png" alt="">
                        <div class="hover-content">
                            <a href="img/indexImage/empty.png" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp quad"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Quad 4.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Quad 4.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp quad"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Quad 6.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Quad 6.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>


                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp deluxe"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/indexImage/empty.png" alt="">
                        <div class="hover-content">
                            <a href="img/indexImage/empty.png" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp duo" data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/indexImage/empty.png" alt="">
                        <div class="hover-content">
                            <a href="img/indexImage/empty.png" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp quad"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Quad 5.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Quad 5.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp quad"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Quad 7.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Quad 7.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp trio"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Trio3.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Trio3.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp deluxe"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/indexImage/empty.png" alt="">
                        <div class="hover-content">
                            <a href="img/indexImage/empty.png" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp trio"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Trio2.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Trio2.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp trio
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Trio4.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Trio4.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp trio
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/indexImage/empty.png" alt="">
                        <div class="hover-content">
                            <a href="img/indexImage/empty.png" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp group"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/pic/Group1.jpg" alt="">
                        <div class="hover-content">
                            <a href="img/pic/Group1.jpg" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp group"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/indexImage/empty.png" alt="">
                        <div class="hover-content">
                            <a href="img/indexImage/empty.png" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp group"
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/indexImage/empty.png" alt="">
                        <div class="hover-content">
                            <a href="img/indexImage/empty.png" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp deluxe
                    data-wow-delay="100ms">
                    <div class="single-portfolio-content">
                        <img src="img/indexImage/empty.png" alt="">
                        <div class="hover-content">
                            <a href="img/indexImage/empty.png" class="portfolio-img">+</a>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-12 text-center wow fadeInUp" data-wow-delay="800ms">
                        <!-- <a href="#" class="btn lx-btn btn-2 mt-15">View More</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
';