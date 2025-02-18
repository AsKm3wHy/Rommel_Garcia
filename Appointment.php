<?php
define('AUTHORIZED', true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/config.php';

$appointmentManager = new AppointmentManager();

$name = $phone = $email = $photobooth_type = $appointment_type = $price = '';
$successMessage = null;
$errorMessage = null;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET['name'])) {
        $name = htmlspecialchars(trim($_GET['name']));
    }
    if (isset($_GET['phone'])) {
        $phone = htmlspecialchars(trim($_GET['phone']));
    }
    if (isset($_GET['email'])) {
        $email = htmlspecialchars(trim($_GET['email']));
    }
    if (isset($_GET['photobooth_type'])) {
        $photobooth_type = htmlspecialchars(trim($_GET['photobooth_type']));
    }
    if (isset($_GET['appointment_type'])) {
        $appointment_type = htmlspecialchars(trim($_GET['appointment_type']));
    }
    if (isset($_GET['price'])) {
        $price = htmlspecialchars(trim($_GET['price']));
    }

}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. CSRF Protection (IMPORTANT!)
    if (!CSRFProtection::verifyToken($_POST['csrf_token'])) {
        http_response_code(403); // Forbidden
        $errorMessage = "CSRF token validation failed. Please refresh the page and try again.";
    } else {

        // 2. Get and Sanitize Form Data (Always sanitize!)
        $name = htmlspecialchars(trim($_POST['name'])); // From the hidden field
        $phone = htmlspecialchars(trim($_POST['phone'])); // From the hidden field
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); // Sanitize email
        $photobooth_type = htmlspecialchars(trim($_POST['photobooth_type'])); // Hidden field
        $appointment_type = htmlspecialchars(trim($_POST['appointment_type'])); // Hidden field
        $price_raw = htmlspecialchars(trim($_POST['price'])); // Hidden field
        $price = str_replace(['₱', ' '], '', $price_raw);
        $appointment_date = trim($_POST['appointment_date']);
        $appointment_time = htmlspecialchars(trim($_POST['appointment_time']));



        $errors = [];
        if (empty($name)) {
            $errors[] = "Name is required.";
        }
        if (empty($phone)) {
            $errors[] = "Phone is required.";
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Valid email is required.";
        }
        if (empty($appointment_type)) {
            $errors[] = "Appointment Type is required.";
        }
        if (empty($price) || !is_numeric($price)) {
            $errors[] = "Price is required and must be a number.";
        }
        if (empty($photobooth_type)) {
            $errors[] = "Photobooth Type is required.";
        }
        if (empty($appointment_date)) {
            $errors[] = "Appointment Date is required.";
        }
        if (empty($appointment_time)) {
            $errors[] = "Appointment Time is required.";
        }

        if (empty($errors)) {
            $appointmentData = [
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'appointment_type' => $appointment_type,
                'price' => $price,
                'photobooth_type' => $photobooth_type,
                'appointment_date' => $appointment_date,
                'appointment_time' => $appointment_time
            ];

            $result = $appointmentManager->createAppointment($appointmentData);

            if ($result['success']) {
                // Success!
                $successMessage = "Appointment created successfully! Reference number: " . sanitizeOutput($result['reference_number']);
                // Log the action
                logActivity('Appointment Confirmed', "Reference Number: " . $result['reference_number'] . ", Name: $name", 'Admin'); // Example log
                // Redirect or clear the form
            } else {
                // Error
                $errorMessage = "Error creating appointment: " . $result['message'];
                logActivity('Appointment Confirmation Failed', "Error: " . $result['message'] . ", Data: " . json_encode($appointmentData), 'Admin');
            }
        }
    }
}
$csrfToken = CSRFProtection::generateToken();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="img/Header-Pic/rommel-logo-v3.svg">
    <title>Rommel | Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- animate on scroll css  -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/Appointment.css">
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

                        <form action="https://scontinues22.wixsite.com/mysite" method="post">
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

                        <a class="nav-brand" href="index.php" z>
                            <img src="img/Header-Pic/rommel-logo-v3.svg" alt="logo" style="margin-top:0; width:5rem;">
                        </a>

                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <div class="classy-menu">

                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <div class="classynav">
                                <ul id="nav">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active"><a href="Appointment.php">Appointment</a></li>
                                    <li><a href="gallery.php">Gallery</a></li>
                                    <li><a href="faq.php">FAQ</a></li>
                                </ul>


                            </div>

                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <section class="breadcrumb-area bg-img bg-overlay jarallax"
        style="background-image:url(img/indexImage/IMG_9287.JPG)">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-content text-center">
                        <h2 class="page-title">A P O I N T M E N T</h2>
                        <nav aria-label="breadcrumb">

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>

    <div class="lx-portfolio-area section-padding-80 clearfix">
        <div class="container-fluid">

            <div class="container1">

                <div class="left-section">
                    <h1>Book an Appointment</h1>
                    <!-- <div class="reminder">
                        Please be on time for your appointment.
                    </div> -->

                    <div class="form-group">
                        <label for="name">Name: (Fullname)</label>
                        <input type="text" id="name" name="name" placeholder="Full Name" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Contact #:</label>
                        <input type="number" id="phone" name="phone" placeholder="Phone Number" min="1"
                            pattern="[0-9]{0,11}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Email Address" required>
                    </div>

                    <label for="appointment">Select an Appointment Type:</label>
                    <select id="appointment" name="appointment" required onchange="updatePrice()">
                        <option value="SOLO">SOLO</option>
                        <option value="DUO">DUO</option>
                        <option value="TRIO">TRIO</option>
                        <option value="QUAD">QUAD</option>
                        <option value="DELUXE">DELUXE</option>
                        <option value="GRADUATE">GRADUATE</option>
                        <option value="GROUP">GROUP</option>
                        <option value="PACKAGE 1">PACKAGE 1</option>
                        <option value="PACKAGE 2">PACKAGE 2</option>
                        <option value="PACKAGE 3">PACKAGE 3</option>
                        <option value="PACKAGE 4">PACKAGE 4</option>
                    </select>

                    <label for="text">Price:</label>
                    <input class="php" id="price" type="text" value="₱ 500" readonly>
                </div>

                <div class="partition"></div>

                <div class="calendar-container">
                    <label for="btn1" style="text-align: left;">Photobooth Type: </label>
                    <div class="button-container">
                        <button class="btn1" id="personalBtn">360 Video</button>
                        <button class="btn1" id="videoBtn">Self Mirror</button>
                        <button class="btn1" id="portraitBtn">Self-Portrait</button>
                    </div>
                    <div class="month-select">
                        <button class="nav-btn" id="prev-month">&#10094;</button>
                        <div>
                            <label for="month-select">Select Month:</label>
                            <select id="month-select"
                                style=" background-color: rgb(255 255 255 / 0%) !important;"></select>
                            <label for="year-select">Select Year:</label>
                            <select id="year-select"
                                style=" background-color: rgb(255 255 255 / 0%) !important;"></select>
                        </div>
                        <button class="nav-btn" id="next-month">&#10095;</button>
                    </div>

                    <div class="calendar" id="calendar"></div>

                    <div class="selected-date" id="selected-date"></div>

                    <div class="available-times" id="available-times"></div>

                    <form id="appointment-form">
                        <hr><br>
                        <input type="hidden" id="referenceNumber" name="referenceNumber" value="">
                        <input type="hidden" id="nameHidden" name="name" value="">
                        <input type="hidden" id="phoneHidden" name="phone" value="">
                        <input type="hidden" id="emailHidden" name="email" value="">
                        <input type="hidden" id="appointmentTypeHidden" name="appointmentType" value="">
                        <input type="hidden" id="priceHidden" name="price" value="">
                        <input type="hidden" id="photoboothTypeHidden" name="photoboothType" value="">


                        <button type="submit" class="submit-btn">Book Appointment</button>
                    </form>
                </div>
            </div>

            <dialog id="dialog">
                <?php if (isset($successMessage)): ?>
                    <p style="color: green;"><?php echo sanitizeOutput($successMessage); ?></p>
                <?php endif; ?>

                <?php if (isset($errorMessage)): ?>
                    <p style="color: red;"><?php echo sanitizeOutput($errorMessage); ?></p>
                <?php endif; ?>

                <?php if (isset($errors) && !empty($errors)): ?>
                    <div style="color: red;">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo sanitizeOutput($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="csrf_token"
                        value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">

                    <label for="name" style="margin-bottom: 0!important;">Name: </label>
                    <input type="text" id="dialogName" name="name" value="<?php echo sanitizeOutput($name); ?>"
                        readonly>

                    <label for="number" style="margin-bottom: 0!important;">Contact: </label>
                    <input type="number" id="dialogPhone" name="phone" value="<?php echo sanitizeOutput($phone); ?>"
                        readonly>

                    <label for="email" style="margin-bottom: 0!important;">Email: </label>
                    <input type="email" id="dialogEmail" name="email" value="<?php echo sanitizeOutput($email); ?>"
                        readonly>

                    <label for="photobooth" style="margin-bottom: 0!important;">Photobooth Type: </label>
                    <input type="text" id="dialogPhotoboothType" name="photobooth_type"
                        value="<?php echo sanitizeOutput($photobooth_type); ?>" readonly>

                    <label for="type" style="margin-bottom: 0!important;">Appointment Type: </label>
                    <input type="text" id="dialogAppointmentType" name="appointment_type"
                        value="<?php echo sanitizeOutput($appointment_type); ?>" readonly>

                    <label for="date" style="margin-bottom: 0!important;">Date & Time: </label>
                    <div class="datetime">
                        <input type="text" id="dialogDate" value="<?php echo sanitizeOutput($appointment_date); ?>"
                            readonly><input type="text" id="dialogTime"
                            value="<?php echo sanitizeOutput($appointment_time); ?>" readonly>
                    </div>

                    <label for="price" style="margin-bottom: 0!important;">Total: </label>
                    <input type="text" id="dialogPrice" name="price" value="<?php echo sanitizeOutput($price); ?>"
                        readonly style="margin-bottom: 1rem !important;">

                    <input type="hidden" name="appointment_date" value="<?php echo date('Y-m-d'); ?>">
                    <input type="hidden" name="appointment_time" value="<?php echo date('g:i A'); ?>">


                    <button class="submit-btn" type="submit">Confirm</button>
                </form>
                <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
            </dialog>

            <!-- <script>
                function generateRandomReferenceNumber() {
                    const min = 10000000;
                    const max = 99999999;
                    return Math.floor(Math.random() * (max - min + 1)) + min;
                }

                document.addEventListener('DOMContentLoaded', () => {
                    document.getElementById("referenceNumber").value = generateRandomReferenceNumber();
                });
            </script> -->

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const appointmentForm = document.getElementById('appointment-form');
                    const dialog = document.getElementById('dialog');

                    appointmentForm.addEventListener('submit', (event) => {
                        event.preventDefault();

                        const name = document.getElementById('name').value;
                        const phone = document.getElementById('phone').value;
                        const email = document.getElementById('email').value;
                        const appointmentType = document.getElementById('appointment').value;
                        const price = document.getElementById('price').value;
                        const referenceNumber = document.getElementById('referenceNumber').value;
                        const photoboothType = document.querySelector('.button-container .active1')
                            .textContent;

                        document.getElementById('dialogName').value = name;
                        document.getElementById('dialogPhone').value = phone;
                        document.getElementById('dialogEmail').value = email;
                        document.getElementById('dialogAppointmentType').value = appointmentType;
                        document.getElementById('dialogPrice').value = price;
                        document.getElementById('dialogPhotoboothType').value = photoboothType;
                        document.getElementById('dialogDate').value = selectedDate;
                        document.getElementById('dialogTime').value = selectedTime;


                        dialog.showModal();
                    });
                });
            </script>



            <script>
                let buttonSelected = false;

                const personalBtn = document.getElementById('personalBtn');
                const videoBtn = document.getElementById('videoBtn');
                const portraitBtn = document.getElementById('portraitBtn');

                function setActiveButton(selectedButton) {
                    // Remove active class from all buttons
                    personalBtn.classList.remove('active1', 'personal');
                    videoBtn.classList.remove('active1', 'video');
                    portraitBtn.classList.remove('active1', 'portrait');

                    if (selectedButton === 'personal') {
                        personalBtn.classList.add('active1', 'personal');
                    } else if (selectedButton === 'video') {
                        videoBtn.classList.add('active1', 'video');
                    } else if (selectedButton === 'portrait') {
                        portraitBtn.classList.add('active1', 'portrait');
                    }

                    buttonSelected = true;
                    enableSubmitButton();
                }

                personalBtn.addEventListener('click', () => setActiveButton('personal'));
                videoBtn.addEventListener('click', () => setActiveButton('video'));
                portraitBtn.addEventListener('click', () => setActiveButton('portrait'));

                function enableSubmitButton() {
                    const submitButton = document.querySelector('.submit-btn');
                    if (buttonSelected) {
                        submitButton.disabled = false;
                    } else {
                        submitButton.disabled = true;
                    }
                }

                document.addEventListener('DOMContentLoaded', enableSubmitButton);
            </script>

            <script>
                const availableTimes = {
                    1: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    2: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    3: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    4: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    5: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    6: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    7: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    8: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    9: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    10: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    11: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    12: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    13: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    14: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    15: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    16: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    17: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    18: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    19: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    20: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    21: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    22: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    23: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    24: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    25: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    26: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    27: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    28: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    29: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    30: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ],
                    31: ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM',
                        '5:00 PM'
                    ]
                };

                let selectedDate = null;
                let selectedTimeSlot = null;

                const today = new Date();
                let currentMonth = today.getMonth();
                let currentYear = today.getFullYear();

                function populateMonthYear() {
                    const monthSelect = document.getElementById('month-select');
                    const yearSelect = document.getElementById('year-select');

                    monthSelect.innerHTML = '';
                    const months = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];
                    months.forEach((month, index) => {
                        const option = document.createElement('option');
                        option.value = index;
                        option.textContent = month;
                        monthSelect.appendChild(option);
                    });

                    yearSelect.innerHTML = '';
                    for (let year = 2025; year <= 2030; year++) {
                        const option = document.createElement('option');
                        option.value = year;
                        option.textContent = year;
                        yearSelect.appendChild(option);
                    }

                    monthSelect.value = currentMonth;
                    yearSelect.value = currentYear;
                }

                function generateCalendar() {
                    const calendar = document.getElementById('calendar');
                    const selectedDateDisplay = document.getElementById('selected-date');
                    const availableTimesSection = document.getElementById('available-times');
                    const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
                    const lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0);
                    const totalDaysInMonth = lastDayOfMonth.getDate();
                    const availableDates = Object.keys(availableTimes).map(Number);

                    calendar.innerHTML = '';

                    const daysOfWeek = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
                    daysOfWeek.forEach(day => {
                        const dayElement = document.createElement('div');
                        dayElement.innerText = day;
                        calendar.appendChild(dayElement);
                    });

                    for (let i = 0; i < firstDayOfMonth.getDay(); i++) {
                        const emptyElement = document.createElement('div');
                        calendar.appendChild(emptyElement);
                    }

                    for (let day = 1; day <= totalDaysInMonth; day++) {
                        const dateElement = document.createElement('div');
                        dateElement.innerText = day;

                        const today = new Date();
                        const todayDay = today.getDate();
                        const todayMonth = today.getMonth();
                        const todayYear = today.getFullYear();

                        if (
                            currentYear < todayYear ||
                            (currentYear === todayYear && currentMonth < todayMonth) ||
                            (currentYear === todayYear && currentMonth === todayMonth && day < todayDay)
                        ) {
                            dateElement.classList.add('disabled');
                            dateElement.style.pointerEvents = 'none';
                            dateElement.style.opacity = 0.5;
                        } else if (availableDates.includes(day)) {
                            dateElement.classList.add('available');
                            dateElement.addEventListener('click', () => {
                                selectedDate = day;
                                selectedDateDisplay.innerText =
                                    `Selected Date: ${currentMonth + 1}/${day}/${currentYear}`;
                                displayAvailableTimes(day);
                            });
                        }

                        calendar.appendChild(dateElement);
                    }
                }

                function displayAvailableTimes(day) {
                    const availableTimesSection = document.getElementById('available-times');
                    availableTimesSection.innerHTML = '';

                    if (availableTimes[day]) {
                        availableTimes[day].forEach(time => {
                            const timeSlot = document.createElement('div');
                            timeSlot.classList.add('time-slot');
                            timeSlot.innerText = time;
                            timeSlot.addEventListener('click', () => {
                                selectTimeSlot(timeSlot, time);
                            });
                            availableTimesSection.appendChild(timeSlot);
                        });

                        document.getElementById('appointment-form').style.display = 'block';
                    } else {
                        availableTimesSection.innerText = 'No available times for this date.';
                        document.getElementById('appointment-form').style.display = 'none';
                        selectedDateDisplay.innerText = '';
                    }
                }

                function selectTimeSlot(timeSlotElement, time) {
                    const selectedDateDisplay = document.getElementById('selected-date');
                    selectedDateDisplay.innerText =
                        `Selected Date: ${currentMonth + 1}/${selectedDate}/${currentYear} at ${time}`;

                    if (selectedTimeSlot) {
                        selectedTimeSlot.classList.remove('selected');
                    }

                    selectedTimeSlot = timeSlotElement;
                    selectedTimeSlot.classList.add('selected');
                }

                // Navigation buttons
                document.getElementById('prev-month').onclick = function () {
                    if (currentMonth === 0) {
                        currentMonth = 11;
                        currentYear--;
                    } else {
                        currentMonth--;
                    }
                    populateMonthYear();
                    generateCalendar();
                };

                document.getElementById('next-month').onclick = function () {
                    if (currentMonth === 11) {
                        currentMonth = 0;
                        currentYear++;
                    } else {
                        currentMonth++;
                    }
                    populateMonthYear();
                    generateCalendar();
                };

                document.getElementById('month-select').addEventListener('change', function () {
                    currentMonth = parseInt(this.value);
                    generateCalendar();
                });

                document.getElementById('year-select').addEventListener('change', function () {
                    currentYear = parseInt(this.value);
                    generateCalendar();
                });

                populateMonthYear();
                generateCalendar();
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const accordions = document.querySelectorAll('.faq-accordion');

                    if (accordions.length > 0) {
                        accordions.forEach(button => {
                            button.addEventListener('click', function () {
                                this.classList.toggle('active');
                                const panel = this.nextElementSibling;

                                if (panel.style.maxHeight) {
                                    panel.style.maxHeight = null;
                                } else {
                                    panel.style.maxHeight = panel.scrollHeight + "px";
                                }
                            });
                        });
                    }
                });
            </script>

        </div>
    </div>

    <footer>
        <div class="wrapper">
            <div class="containerUp">
                <div class="social-info">
                    <h2>Rommel Garcia Digital Video and Photography </h2>
                </div>
            </div>
            <hr>
            <div class="containerDown">
                <div class="last">

                </div>
            </div>
        </div>
    </footer>
</body>

<script>
    function updateCounter() {
        fetch('https://api.countapi.xyz/update/uimonk/youtubechannel/?amount=1')
            .then(res => res.json())
            .then(data => counterElement.innerHTML = data.value)
    }
    updateCounter()
    counterElement = document.getElementsByClassName('count')[0];
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
<!-- animate on scroll js  -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init();
</script>

<script>
    function updatePrice() {
        var appointment = document.getElementById("appointment").value;
        var priceInput = document.getElementById("price");
        let price = 500;

        if (appointment === "SOLO") {
            price = 500;
        } else if (appointment === "DUO") {
            price = 800;
        } else if (appointment === "TRIO") {
            price = 900;
        } else if (appointment === "QUAD") {
            price = 1000;
        } else if (appointment === "DELUXE") {
            price = 2500;
        } else if (appointment === "GROUP") {
            price = 1500;
        } else if (appointment === "PACKAGE 1") {
            price = 899;
        } else if (appointment === "PACKAGE 2") {
            price = 1599;
        } else if (appointment === "PACKAGE 3") {
            price = 2599;
        } else if (appointment === "PACKAGE 4") {
            price = 3599;
        }

        priceInput.value = "₱ " + price;
    }
</script>
</body>

</html>