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
<footer role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
    <div class="wrapper">
        <div class="containerUp">
            <div class="social-info">
                <h2 itemprop="name">Rommel Garcia Digital Video and Photography</h2>
            </div>
        </div>
        <hr>
        <div class="containerDown">
            <div class="last">
            </div>
        </div>
    </div>
</footer>';

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