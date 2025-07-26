<?php
include_once("header.php");
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from preview.colorlib.com/theme/lx/gallery.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 04 Oct 2021 17:30:38 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Explore Rommel Garcia's professional photography portfolio featuring stunning portraits, events, and creative photography work. Browse through our extensive gallery of high-quality images showcasing our expertise in digital photography and videography.">
    <meta name="keywords" content="photography gallery, professional photographer, portrait photography, event photography, Rommel Garcia, digital photography, photo portfolio, photography services, professional photography gallery">
    <meta name="author" content="Rommel Garcia">
    <meta name="robots" content="index, follow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Rommel Garcia Photography Gallery">
    <meta property="og:description" content="Browse through our collection of professional photography work showcasing portraits, events, and creative photography.">
    <meta property="og:image" content="https://rommelgarcia.com/img/Header-Pic/rommel-logo-v3.svg">
    <meta property="og:url" content="https://rommelgarcia.com/gallery.php">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Rommel Garcia Photography">
    <meta property="fb:pages" content="rommelgarciadigitalvideoandphotography">
    
    <!-- Geo Meta Tags -->
    <meta name="geo.region" content="PH">
    <meta name="geo.placename" content="Philippines">
    
    <!-- Technical Meta Tags -->
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="#000000">
    
    <link rel="canonical" href="https://rommelgarcia.com/gallery.php">
    <link rel="icon" href="img/Header-Pic/rommel-logo-v3.svg">
    <title>Professional Photography Gallery | Rommel Garcia Photography</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="icon" href="img/core-img/favicon.png"> -->

    <link rel="stylesheet" href="A.style.css.pagespeed.cf.0VivtDGN1d.css">
    <!-- animate on scroll css  -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        h1 {
            color: #eaeaea;
        }

        h1 {
            color: #eaeaea;
        }

        @media only screen and (max-width: 767px) {
            h1 {
                font-size: 1.8rem;
            }

            @media only screen and (max-width: 767px) {
                h1 {
                    font-size: 1.8rem;
                }

                .classy-nav-container .classy-navbar .nav-brand {
                    max-width: fit-content;
                    margin-right: 15px;
                }
            }

            .classy-nav-container .classy-navbar .nav-brand {
                max-width: fit-content;
                margin-right: 15px;
            }
        }
    </style>
</head>

<body>

    <div id="preloader">
        <div class="loader"></div>
    </div>


    <div class="top-search-area">
        <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">

                        <button type="button" class="btn close-btn" data-dismiss="modal" style="font-size: 18px;"><i
                                class="fas fa-times-circle"></i></button>

                        <form action="https://preview.colorlib.com/theme/lx/index.html" method="post">
                            <input type="search" name="top-search-bar" class="form-control"
                                placeholder="Search and hit enter...">
                            <button type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <header class="header-area">

        <div class="main-header-area">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">

                    <nav class="classy-navbar justify-content-between" id="lxNav">

                        <a class="nav-brand" href="index.php" data-aos="fade-right" data-aos-duration="3000">
                            <!-- <h1 class="home-logo">Rommel</h1> -->
                            <img src="img/Header-Pic/rommel-logo-v3.svg" alt="logo" style="margin-top:0; width:5rem;">
                        </a>

                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <div class="classy-menu">

                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <div class="classynav" data-aos="fade-left" data-aos-duration="3000">
                                <ul id="nav">
                                    <li><a href="index.php">Home</a></li>
                                    <!-- <li><a href="Appointment.php">Appointment</a></li> -->
                                    <li class="active"><a href="gallery.php">Gallery</a></li>
                                    <li><a href="faq.php">FAQ</a></li>
                                    <li><a href="contactUs.php">Contact Us</a></li>
                                </ul>


                            </div>

                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>


    <section class="breadcrumb-area bg-img bg-overlay jarallax"
        style="background-image:url(img/indexImage/IMG_9279.jpg)">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-content text-center">
                        <h2 class="page-title" data-aos="fade-down" data-aos-duration="2000">G A L L E R Y</h2>
                        <nav aria-label="breadcrumb">

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
// Fetch all images and categories from the gallery table
$mysqli = new mysqli("localhost", "root", "", "rommelgarciaappointments");
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}
$images = [];
$res = $mysqli->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
while ($row = $res->fetch_assoc()) {
    $images[] = $row;
}
$mysqli->close();
// List of all categories
$categories = ["SOLO","DUO","TRIO","QUAD","DELUXE","GROUP","GRADUATE","UNO","DOS","TRES","CUATRO","CINCO","SEIS"];
?>
<section class="gallery-section section-padding-80-0">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="btn-group" role="group" aria-label="Gallery Categories">
                    <button type="button" class="btn btn-outline-dark filter-btn active" data-filter="all">All</button>
                    <?php foreach ($categories as $cat): ?>
                        <button type="button" class="btn btn-outline-dark filter-btn" data-filter="<?php echo strtolower($cat); ?>"><?php echo $cat; ?></button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="row gallery-grid">
            <?php foreach ($images as $img): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 gallery-item" data-category="<?php echo strtolower($img['category']); ?>">
                    <div class="single-portfolio-item">
                        <a href="uploads/gallery/<?php echo htmlspecialchars($img['filename']); ?>" class="portfolio-img" target="_blank">
                            <img src="uploads/gallery/<?php echo htmlspecialchars($img['filename']); ?>" alt="gallery image" class="img-fluid">
                        </a>
                        <div class="portfolio-meta mt-2 text-center">
                            <span class="badge badge-secondary"><?php echo htmlspecialchars($img['category']); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($images)): ?>
                <div class="col-12 text-center"><p>No images in the gallery yet.</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>
<script>
// Simple filter logic for categories
const filterBtns = document.querySelectorAll('.filter-btn');
const galleryItems = document.querySelectorAll('.gallery-item');
filterBtns.forEach(btn => {
    btn.addEventListener('click', function() {
        filterBtns.forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const filter = this.getAttribute('data-filter');
        galleryItems.forEach(item => {
            if (filter === 'all' || item.getAttribute('data-category') === filter) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>

    <div class="follow-area clearfix">
        <div class="container">
            <div class="row">
                <div class="col-12">

                </div>
            </div>
        </div>




        <?php echo $footer; ?>




        <script src="js/jquery.min.js"></script>

        <script src="js/popper.min.js%2bbootstrap.min.js.pagespeed.jc.9S4FA15Zn6.js"></script>
        <script>
            eval(mod_pagespeed_2mSwO3vn68);
        </script>

        <script>
            eval(mod_pagespeed_aQrG1NKKxL);
        </script>

        <script src="js/lx.bundle.js"></script>

        <script src="js/default-assets/active.js"></script>

        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-23581568-13');
        </script>
        <script defer src="../../../static.cloudflareinsights.com/beacon.min.js"
            data-cf-beacon='{"rayId":"699023286d631bc2","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2021.9.0","si":100}'>
        </script>
        <!-- animate on scroll js  -->
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
        <!-- Mirrored from preview.colorlib.com/theme/lx/gallery.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 04 Oct 2021 17:30:46 GMT -->
</body>

</html>