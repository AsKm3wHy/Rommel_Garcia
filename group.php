<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
include_once("header.php");

class Database {
    private $host;
    private $username;
    private $password;
    private $database;
    private $conn;
    public function __construct() {
        $this->host = getenv('DB_HOST');
        $this->username = getenv('DB_USER');
        $this->password = getenv('DB_PASS');
        $this->database = getenv('DB_NAME');
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->database,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    public function getConnection() {
        return $this->conn;
    }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the raw POST data
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if ($data) {
        $package = $data["package"];
        $full_name = $data["full_name"];
        $email = $data["email"];
        $phone = $data["phone"];
        $booking_date = $data["booking_date"];
        $booking_time = $data["booking_time"];

        // Validate inputs
        if (empty($package) || empty($full_name) || empty($email) || empty($phone) || empty($booking_date) || empty($booking_time)) {
            echo json_encode(["success" => false, "message" => "All fields are required"]);
            exit;
        }

        // Create database connection
        $database = new Database();
        $conn = $database->getConnection();

        // Check for time slot conflicts
        $stmt = $conn->prepare("SELECT * FROM appointments WHERE booking_date = ? AND booking_time = ?");
        $stmt->execute([$booking_date, $booking_time]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            echo json_encode(["success" => false, "message" => "This time slot is already booked. Please select another time."]);
            exit;
        }

        // Insert appointment
        $stmt = $conn->prepare("INSERT INTO appointments (package, full_name, email, phone, booking_date, booking_time) VALUES (?, ?, ?, ?, ?, ?)");
        $result = $stmt->execute([$package, $full_name, $email, $phone, $booking_date, $booking_time]);

        if ($result) {
            $id = $conn->lastInsertId();
            echo json_encode([
                "success" => true,
                "message" => "Appointment booked successfully",
                "id" => $id,
                "full_name" => $full_name,
                "booking_date" => $booking_date,
                "booking_time" => $booking_time,
                "package" => $package
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to book appointment"]);
        }
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="img/Header-Pic/rommel-logo-v3.svg">
    <title>GROUP | Rommel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- <link rel="icon" href="img/core-img/1.png"> -->
    <!-- <link rel="icon" href="img/core-img/favicon.png"> -->
    <!-- animate on scroll css  -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- ===== Link Swiper's CSS ===== -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <!-- ===== Fontawesome CDN Link ===== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- ===== CSS ===== -->

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/group.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div id="preloader">
        <div class="loader"></div>
    </div>
    <?php echo $header; ?>


    <!-- <ul id="social-sidebar" data-aos="fade-right" data-aos-duration="3000" style="z-index: 200">
        <li>
            <a class="entypo-facebook" href="https://www.facebook.com/rommelgarciadigitalvideoandphotography"
                target="_blank"><span>Facebook</span></a>
        </li>

    </ul> -->
    <section class="pricing">
        <div class="container ">

            <div class="row">
                <div class="col">
                    <div class="plan-card">
                        <h2>GROUP<span>For business services</span></h2>
                        <div class="etiquet-price">
                            <p>1,500.00</p>
                            <div></div>
                        </div>
                        <div class="benefits-list">
                            <ul>
                                <li><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z">
                                        </path>
                                    </svg><span>6 Pax</span></li>
                                <li><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z">
                                        </path>
                                    </svg><span>30 Minutes Self-Portrait</span></li>
                                <li><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z">
                                        </path>
                                    </svg><span>3 Backdrop Color</span></li>
                                <li><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z">
                                        </path>
                                    </svg><span>6 4r size Print</span></li>
                            </ul>
                            <p class="all-copy">All Digital copies are free</p>
                        </div>
                    </div>
                </div>
                <div class="col" style="border: 1px solid #dbdbdb; border-radius: 10px;">
                    <h5 class="text-center py-3">Set Your Appointment with Ease</h5>
                    <form id="appointmentForm" action="">
                        <input type="text" name="package" value="GROUP" hidden>
                        <div class="input-group">
                            <input required type="text" name="fullName" autocomplete="off" class="input">
                            <label class="user-label" for="fullName">Full Name</label>
                        </div>
                        <div class="input-group">
                            <input required type="email" name="email" autocomplete="off" class="input">
                            <label class="user-label" for="email">Email</label>
                        </div>
                        <div class="input-group">
                            <input required type="number" name="phone" min="0" autocomplete="off" class="input">
                            <label class="user-label" for="phone">Phone Number</label>
                        </div>
                        <div class="date-time">
                            <div class="input-group">
                                <input type="date" name="date" min="" autocomplete="off" class="input">
                                <label class="user-label">Date</label>
                            </div>
                            <div class="input-group">
                                <input type="time" name="time" min="08:00" max="17:00" autocomplete="off" class="input">
                                <label class="user-label">Time</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-sub btn-primary">Submit</button>
                    </form>
                </div>


                <div id="confirmationModal" class="modal"
                    style="display: none; position: fixed; top:0; left:0; width:100%; height:100%; background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
                    <div style="background: #fff; padding: 20px; border-radius: 10px; max-width: 400px; width: 90%;">
                        <div class="d-flex justify-content-between">
                            <h4>Appointment Details</h4>
                            <button id="closeModal" class="btn-x ">X</button>
                        </div>
                        <div class="success">
                            <center>Successfully Submitted!</center>
                        </div>
                        <div id="modalContent"></div>
                    </div>
                </div>
            </div>
        </div>



    </section>


    <?php echo $footer; ?>
</body>



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
    data-cf-beacon='{"rayId":"699023133d611baa","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2021.9.0","si":100}'>
    </script>
</script>
<!-- animate on scroll js  -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init();
</script>



<script src="js-package/packages.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('appointmentForm');
            const modal = document.getElementById('confirmationModal');
            const modalContent = document.getElementById('modalContent');
            const closeModal = document.getElementById('closeModal');

            // Set minimum date to today
            const dateInput = form.querySelector('input[name="date"]');
            const today = new Date().toISOString().split('T')[0];
            dateInput.min = today;

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = {
                    package: "GROUP",
                    full_name: form.fullName.value,
                    email: form.email.value,
                    phone: form.phone.value,
                    booking_date: form.date.value,
                    booking_time: form.time.value
                };

                // Create XMLHttpRequest object
                const xhr = new XMLHttpRequest();
                xhr.open('POST', window.location.href, true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        try {
                            const result = JSON.parse(xhr.responseText);
                            
                            if (result.success) {
                                // Display success message and appointment details
                                modalContent.innerHTML = `
                                    <div class="mt-3">
                                        <p><strong>Booking ID:</strong> ${result.id}</p>
                                        <p><strong>Name:</strong> ${result.full_name}</p>
                                        <p><strong>Date:</strong> ${result.booking_date}</p>
                                        <p><strong>Time:</strong> ${result.booking_time}</p>
                                        <p><strong>Package:</strong> ${result.package}</p>
                                        <p><strong>Price:</strong> ₱1,500.00</p>
                                    </div>
                                `;
                                modal.style.display = 'flex';
                                form.reset();
                            } else {
                                alert(result.message || 'Failed to book appointment. Please try again.');
                            }
                        } catch (error) {
                            console.error('Error parsing response:', error);
                            alert('An error occurred. Please try again later.');
                        }
                    } else {
                        console.error('Request failed with status:', xhr.status);
                        alert('An error occurred. Please try again later.');
                    }
                };
                
                xhr.onerror = function() {
                    console.error('Request failed');
                    alert('An error occurred. Please try again later.');
                };
                
                xhr.send(JSON.stringify(formData));
            });

            // Close modal when clicking the X button
            closeModal.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>