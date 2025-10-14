<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
include_once("header.php");

class Database
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $conn;
    public function __construct()
    {
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
    public function getConnection()
    {
        return $this->conn;
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);
    if ($data) {
        $package = $data["package"];
        $full_name = $data["full_name"];
        $email = $data["email"];
        $phone = $data["phone"];
        $booking_date = $data["booking_date"];
        $booking_time = $data["booking_time"];
        if (empty($package) || empty($full_name) || empty($email) || empty($phone) || empty($booking_date) || empty($booking_time)) {
            echo json_encode(["success" => false, "message" => "All fields are required"]);
            exit;
        }
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare("SELECT * FROM appointments WHERE booking_date = ? AND booking_time = ?");
        $stmt->execute([$booking_date, $booking_time]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($existing) {
            echo json_encode(["success" => false, "message" => "This time slot is already booked. Please select another time."]);
            exit;
        }
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
    <title>Package 3 | Rommel</title>
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
    <link rel="stylesheet" href="css/graduate-package3.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
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
                <div class="col d-flex justify-content-center align-items-center">
                    <div class="plan-card">
                        <h2>GRADUATE<span>Package 3</span></h2>
                        <div class="etiquet-price">
                            <p>2,599.00</p>
                            <div></div>
                        </div>
                        <div class="benefits-list">
                            <p class="all-shot">8 SHOTS</p>
                            <ul>
                                <li><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z">
                                        </path>
                                    </svg><span>1 Toga Shot with cap</span></li>
                                <li><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z">
                                        </path>
                                    </svg><span>1 Toga Shot without cap</span></li>
                                <li><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z">
                                        </path>
                                    </svg><span>1 Formal Shot</span></li>
                                <li><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z">
                                        </path>
                                    </svg><span>1 Creative Shot</span></li>
                            </ul>

                        </div>

                        <div class="benefits-list">
                            <p class="all-shot">CREATIVE SHOT</p>
                            <ul>
                                <li><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z">
                                        </path>
                                    </svg><span>Academic Gown</span></li>
                                <li><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z">
                                        </path>
                                    </svg><span>Filipiniana Alampay</span></li>
                                <li><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z">
                                        </path>
                                    </svg><span>Barong Tagalog</span></li>
                            </ul>
                        </div>
                        <div class="benefits-list">
                            <p class="all-shot">COPY</p>
                            <ul>
                                <li><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z">
                                        </path>
                                    </svg><span>Hardcopy</span></li>
                                <li><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z">
                                        </path>
                                    </svg><span>Softcopy</span></li>
                                <li><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z">
                                        </path>
                                    </svg><span>Edited</span></li>
                            </ul>
                        </div>
                        <div class="button-get-plan">
                            <a href="graduate-package2.php">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-rocket">
                                    <path
                                        d="M156.6 384.9L125.7 353.1C117.2 345.5 114.2 333.1 117.1 321.8C120.1 312.9 124.1 301.3 129.8 288H24C15.38 288 7.414 283.4 3.146 275.9C-1.123 268.4-1.042 259.2 3.357 251.8L55.83 163.3C68.79 141.4 92.33 127.1 117.8 127.1H200C202.4 124 204.8 120.3 207.2 116.7C289.1-4.07 411.1-8.142 483.9 5.275C495.6 7.414 504.6 16.43 506.7 28.06C520.1 100.9 516.1 222.9 395.3 304.8C391.8 307.2 387.1 309.6 384 311.1V394.2C384 419.7 370.6 443.2 348.7 456.2L260.2 508.6C252.8 513 243.6 513.1 236.1 508.9C228.6 504.6 224 496.6 224 488V380.8C209.9 385.6 197.6 389.7 188.3 392.7C177.1 396.3 164.9 393.2 156.6 384.9V384.9zM384 167.1C406.1 167.1 424 150.1 424 127.1C424 105.9 406.1 87.1 384 87.1C361.9 87.1 344 105.9 344 127.1C344 150.1 361.9 167.1 384 167.1z">
                                    </path>
                                </svg>
                                <span>SEE PREVIEW</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col frames">
                    <div class="text-center">
                        <h1 class="py-2">With Frame</h1>
                    </div>
                    <div class="d-flex py-2">
                        <h1 class="px-2">1x</h1>
                        <h6>11" x 14" <br> Double Glass Frame</h6>
                    </div>
                    <div class="d-flex py-2">
                        <h1 class="px-2">3x</h1>
                        <h6>8" x 10" <br> Printed Copy</h6>
                    </div>
                    <div class="d-flex py-2">
                        <h1 class="px-2">4x</h1>
                        <h6>8" x 7" <br> Printed Copy</h6>
                    </div>
                    <div class="d-flex py-2">
                        <h1 class="px-2">8x</h1>
                        <h6>2.5" x 3.5" <br> Wallet Size</h6>
                    </div>
                </div>
                <div class="col forms">
                    <h5 class="text-center py-3">Set Your Appointment with Ease</h5>
                    <form id="appointmentForm" action="">
                        <input type="text" name="package" value="GRADUATE Package 3" hidden>
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

    <h1 class="title-grad">Celebrate Your Milestone with Memorable Moments</h1>

    <!-- Swiper container for graduate package gallery -->
    <section class="graduate-gallery">
        <div class="swiper graduateSwiper container">
            <div class="swiper-wrapper content">

                <!-- Swiper slide item 1 -->
                <div class="swiper-slide card">
                    <div class="card-content">
                        <div class="gallery-item">
                            <img src="my image/13.jpg" alt="Graduate Photo 1">
                        </div>
                    </div>
                </div>

                <!-- Swiper slide item 2 -->
                <div class="swiper-slide card">
                    <div class="card-content">
                        <div class="gallery-item">
                            <img src="my image/15.jpg" alt="Graduate Photo 2">
                        </div>
                    </div>
                </div>

                <!-- Swiper slide item 3 -->
                <div class="swiper-slide card">
                    <div class="card-content">
                        <div class="gallery-item">
                            <img src="img/indeximage/IMG_9279.JPG" alt="Graduate Photo 3">
                        </div>
                    </div>
                </div>

                <!-- Swiper slide item 4 -->
                <div class="swiper-slide card">
                    <div class="card-content">
                        <div class="gallery-item">
                            <img src="my image/14.jpg" alt="Graduate Photo 4">
                        </div>
                    </div>
                </div>

                <!-- Swiper slide item 5 -->
                <div class="swiper-slide card">
                    <div class="card-content">
                        <div class="gallery-item">
                            <img src="my image/21.jpg" alt="Graduate Photo 5">
                        </div>
                    </div>
                </div>

                <!-- Swiper slide item 6 -->
                <div class="swiper-slide card">
                    <div class="card-content">
                        <div class="gallery-item">
                            <img src="my image/18.jpg" alt="Graduate Photo 6">
                        </div>
                    </div>
                </div>

                <!-- Swiper slide item 7 -->
                <div class="swiper-slide card">
                    <div class="card-content">
                        <div class="gallery-item">
                            <img src="my image/19.jpg" alt="Graduate Photo 7">
                        </div>
                    </div>
                </div>

                <!-- Swiper slide item 8 -->
                <div class="swiper-slide card">
                    <div class="card-content">
                        <div class="gallery-item">
                            <img src="my image/20.jpg" alt="Graduate Photo 8">
                        </div>
                    </div>
                </div>

                <!-- Swiper slide item 9 -->
                <div class="swiper-slide card">
                    <div class="card-content">
                        <div class="gallery-item">
                            <img src="my image/22.jpg" alt="Graduate Photo 9">
                        </div>
                    </div>
                </div>

                <!-- Swiper slide item 10 -->
                <div class="swiper-slide card">
                    <div class="card-content">
                        <div class="gallery-item">
                            <img src="my image/f2.jpg" alt="Graduate Photo 10">
                        </div>
                    </div>
                </div>

                <!-- Swiper slide item 11 -->
                <div class="swiper-slide card">
                    <div class="card-content">
                        <div class="gallery-item">
                            <img src="img/indeximage/IMG_9282.JPG" alt="Graduate Photo 11">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Swiper navigation buttons -->
        <div class="swiper-button-next graduate-next"></div>
        <div class="swiper-button-prev graduate-prev"></div>
        <div class="swiper-pagination graduate-pagination"></div>
    </section>

    <!-- Lightbox for image preview -->
    <div class="lightbox">
        <div class="wrapper">
            <header>
                <div class="details">
                    <!-- <i class="uil uil-camera"></i>
                    <span>Image Preview</span> -->
                </div>
                <div class="buttons"><i class="close-icon uil uil-times"></i></div>
            </header>
            <div class="preview-img">
                <div class="img"><img src="" alt="preview-img"></div>
            </div>
        </div>
    </div>

    <?php echo $footer; ?>
</body>

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script>
    // Initialize graduate gallery Swiper
    var graduateSwiper = new Swiper('.graduateSwiper', {
        spaceBetween: 30,
        grabCursor: true,
        loop: true,
        pagination: {
            el: ".graduate-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".graduate-next",
            prevEl: ".graduate-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1
            },
            768: {
                slidesPerView: 2
            },
            1024: {
                slidesPerView: 3
            },
            1150: {
                slidesPerView: 4
            }
        }
    });

    // Lightbox functionality for gallery images
    const allImages = document.querySelectorAll(".graduateSwiper .gallery-item img");
    const lightbox = document.querySelector(".lightbox");
    const closeImgBtn = lightbox.querySelector(".close-icon");

    allImages.forEach(img => {
        img.addEventListener("click", () => showLightbox(img.src));
    });

    const showLightbox = (img) => {
        lightbox.querySelector("img").src = img;
        lightbox.classList.add("show");
        document.body.style.overflow = "hidden";
    }

    closeImgBtn.addEventListener("click", () => {
        lightbox.classList.remove("show");
        document.body.style.overflow = "auto";
    });
</script>

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
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('appointmentForm');
        const modal = document.getElementById('confirmationModal');
        const modalContent = document.getElementById('modalContent');
        const closeModal = document.getElementById('closeModal');

        // Set minimum date to today
        const dateInput = form.querySelector('input[name=\"date\"]');
        const today = new Date().toISOString().split('T')[0];
        dateInput.min = today;

        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = {
                package: "GRADUATE Package 3",
                full_name: form.fullName.value,
                email: form.email.value,
                phone: form.phone.value,
                booking_date: form.date.value,
                booking_time: form.time.value
            };

            try {
                const response = await fetch('/API/api/bookings/create.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();

                if (result.success) {
                    // Display success message and appointment details
                    modalContent.innerHTML = `
                            <div class=\"mt-3\">
                                <p><strong>Booking ID:</strong> ${result.id}</p>
                                <p><strong>Name:</strong> ${result.full_name}</p>
                                <p><strong>Date:</strong> ${result.booking_date}</p>
                                <p><strong>Time:</strong> ${result.booking_time}</p>
                                <p><strong>Package:</strong> ${result.package}</p>
                                <p><strong>Price:</strong> ₱2,599.00</p>
                            </div>
                        `;
                    modal.style.display = 'flex';
                    form.reset();
                } else {
                    alert(result.message || 'Failed to book appointment. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again later.');
            }
        });

        // Close modal when clicking the X button
        closeModal.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        // Close modal when clicking outside
        window.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>
</body>

</html>