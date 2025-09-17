<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
require_once 'config/error_handler.php';
require_once 'config/database.php';
require_once 'models/Appointment.php';

// Initialize DB and model
$database = new Database();
$db = $database->getConnection();
$appointmentModel = new Appointment($db);

// Handle search
$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';
$sortField = isset($_GET['sort']) ? $_GET['sort'] : 'appointment_date';
$sortDir = (isset($_GET['dir']) && strtolower($_GET['dir']) === 'desc') ? 'DESC' : 'ASC';
$allowedSortFields = ['appointment_date', 'notes', 'status_id', 'appointment_time'];
if (!in_array($sortField, $allowedSortFields)) {
    $sortField = 'appointment_date';
}
$appointments = [];
if ($searchTerm !== '') {
    $query = "SELECT * FROM appointments WHERE full_name LIKE ? AND status_id NOT IN (3,4) ORDER BY $sortField $sortDir, appointment_date DESC, appointment_time ASC";
    $stmt = $db->prepare($query);
    $stmt->execute(['%' . $searchTerm . '%']);
    $appointments = $stmt->fetchAll();
} else {
    $query = "SELECT * FROM appointments WHERE status_id NOT IN (3,4) ORDER BY $sortField $sortDir, appointment_date DESC, appointment_time ASC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $appointments = $stmt->fetchAll();
}

// Handle add new appointment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name-client'], $_POST['Tele-client'], $_POST['spec'], $_POST['datetime'])) {
    $dt = $_POST['datetime'];
    $date = $time = '';
    if (strpos($dt, 'T') !== false) {
        list($date, $time) = explode('T', $dt);
    }
    $data = [
        'full_name' => $_POST['name-client'],
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['Tele-client'],
        'appointment_date' => $date,
        'appointment_time' => $time,
        'status_id' => 1,
        'notes' => $_POST['spec']
    ];
    $appointmentModel->addAppointment($data);
    header('Location: Appointment.php?action=added');
    exit;
}

// Handle view, edit, done, cancel actions (fetch by ID)
$popupAppointment = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $popupAppointment = $appointmentModel->getAppointmentById($_GET['id']);
}

// Handle edit appointment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $dt = $_POST['datetime'];
    $date = $time = '';
    if (strpos($dt, 'T') !== false) {
        list($date, $time) = explode('T', $dt);
    }
    $data = [
        'full_name' => $_POST['name'],
        'email' => $_POST['email'],
        'phone' => $_POST['Tele-client'],
        'appointment_date' => $date,
        'appointment_time' => $time,
        'notes' => $_POST['spec']
    ];
    $appointmentModel->updateAppointment($_POST['edit_id'], $data);
    header('Location: Appointment.php?action=success');
    exit;
}

// Handle mark as done
if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'done' && is_numeric($_GET['id'])) {
    $appointmentModel->markAsDone($_GET['id']);
    header('Location: Appointment.php?action=done-success');
    exit;
}

// Handle cancel
if (isset($_GET['action'], $_GET['id'], $_GET['confirm']) && $_GET['action'] === 'cancel' && is_numeric($_GET['id']) && $_GET['confirm'] == 1) {
    $appointmentModel->cancelAppointment($_GET['id']);
    header('Location: Appointment.php?action=cancel-success');
    exit;
}

// Handle confirm
if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'confirm' && is_numeric($_GET['id'])) {
    $appointmentModel->confirmAppointment($_GET['id']);
    header('Location: Appointment.php?action=confirm-success');
    exit;
}

// Handle set pending
if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'set-pending' && is_numeric($_GET['id'])) {
    $appointmentModel->setPending($_GET['id']);
    header('Location: Appointment.php?action=pending-success');
    exit;
}

// Handle reschedule POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reschedule_id'], $_POST['reschedule_datetime'])) {
    $id = (int)$_POST['reschedule_id'];
    $dt = $_POST['reschedule_datetime'];
    $date = $time = '';
    if (strpos($dt, 'T') !== false) {
        list($date, $time) = explode('T', $dt);
    }
    // Fetch current appointment data
    $appointment = $appointmentModel->getAppointmentById($id);
    // Update only date and time, keep other fields (only supported fields)
    $data = [
        'full_name' => $appointment['full_name'],
        'email' => $appointment['email'],
        'phone' => $appointment['phone'],
        'appointment_date' => $date,
        'appointment_time' => $time,
        'notes' => $appointment['notes']
    ];
    $appointmentModel->updateAppointment($id, $data);
    // Send email and redirect as before
    $appointment = $appointmentModel->getAppointmentById($id);
    sendStatusUpdateEmail($appointment, getStatusText($appointment['status_id']), 'reschedule');
    header('Location: Appointment.php?action=view&id=' . $id . '&rescheduled=1');
    exit;
}

// Helper function to send status update or reschedule email receipt
function sendStatusUpdateEmail($appointment, $newStatusText, $type = 'status')
{
    $to = $appointment['email'];
    $fullName = htmlspecialchars($appointment['full_name']);
    $date = htmlspecialchars($appointment['appointment_date']);
    $time = htmlspecialchars($appointment['appointment_time']);
    $category = htmlspecialchars($appointment['notes']);
    $status = htmlspecialchars($newStatusText);
    $subject = ($type === 'reschedule') ? "Your Appointment Has Been Rescheduled Receipt" : "Your Appointment Status Update";
    $mainMessage = ($type === 'reschedule')
        ? "Your appointment has been <b>rescheduled</b>. Please see your new appointment details below:"
        : "Your appointment status has been updated. Please see the details below:";
    $highlight = ($type === 'reschedule')
        ? "Rescheduled: $date $time"
        : "Status: $status";
    $message = <<<EOD
    <html>
    <head>
      <meta charset="UTF-8">
      <title>$subject</title>
    </head>
    <body style="background:#f6f6f6;margin:0;padding:0;font-family:Arial,sans-serif;">
      <table width="100%" bgcolor="#f6f6f6" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td>
            <table style="max-width:600px;margin:40px auto;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.08);padding:40px 30px;" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td style="text-align:center;">
                  <img src="http://localhost/img/Header-Pic/rommel-logo-v3.svg" alt="Rommel Garcia Logo" style="width:90px;height:auto;margin-bottom:12px;">
                  <h2 style="color:#1976d2;margin-bottom:8px;">Rommel Garcia Digital Video & Photography</h2>
                  <h3 style="color:#333;margin-top:0;margin-bottom:24px;">$subject</h3>
                </td>
              </tr>
              <tr>
                <td>
                  <p style="font-size:1.1em;color:#444;margin-bottom:24px;">Hello <b>$fullName</b>,<br><br>$mainMessage</p>
                  <table width="100%" cellpadding="8" cellspacing="0" border="0" style="background:#f5faff;border-radius:8px;margin-bottom:24px;">
                    <tr>
                      <td style="color:#888;font-weight:bold;width:160px;">Name:</td>
                      <td style="color:#222;">$fullName</td>
                    </tr>
                    <tr>
                      <td style="color:#888;font-weight:bold;">Category:</td>
                      <td style="color:#222;">$category</td>
                    </tr>
                    <tr>
                      <td style="color:#888;font-weight:bold;">Date:</td>
                      <td style="color:#222;">$date</td>
                    </tr>
                    <tr>
                      <td style="color:#888;font-weight:bold;">Time:</td>
                      <td style="color:#222;">$time</td>
                    </tr>
                    <tr>
                      <td style="color:#888;font-weight:bold;">Status:</td>
                      <td style="color:#1976d2;font-weight:bold;">$status</td>
                    </tr>
                  </table>
                  <p style="color:#555;font-size:1em;margin-bottom:24px;">If you have any questions or need to reschedule, please <a href="https://www.facebook.com/rommelgarciadigitalvideoandphotography" target="_blank" style="color:#4267B2;text-decoration:underline;">contact us</a>.<br><br>Thank you for choosing Rommel Garcia Digital Video & Photography!</p>
                  <div style="text-align:center;margin-top:32px;">
                    <span style="display:inline-block;background:#1976d2;color:#fff;padding:12px 32px;border-radius:6px;font-size:1.1em;font-weight:bold;letter-spacing:1px;">$highlight</span>
                  </div>
                </td>
              </tr>
              <tr>
                <td style="text-align:center;color:#aaa;font-size:0.95em;padding-top:32px;">&copy; Rommel Garcia Digital Video & Photography</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </body>
    </html>
    EOD;
    // Email headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Rommel Garcia <no-reply@rommelgarcia.com>\r\n";
    // Log the email to a file for local testing
    file_put_contents('email_test.html', $message);
}

// At the top PHP, handle POST for status change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status_id'], $_POST['new_status'])) {
    $id = (int)$_POST['status_id'];
    $newStatus = (int)$_POST['new_status'];
    switch ($newStatus) {
        case 1:
            $appointmentModel->setPending($id);
            break;
        case 2:
            $appointmentModel->confirmAppointment($id);
            break;
        case 3:
            $appointmentModel->markAsDone($id);
            break;
        case 4:
            $appointmentModel->cancelAppointment($id);
            break;
    }
    // Fetch appointment details after update
    $appointment = $appointmentModel->getAppointmentById($id);
    $newStatusText = getStatusText($newStatus);
    sendStatusUpdateEmail($appointment, $newStatusText);
    if (isset($_POST['from_view']) && $_POST['from_view'] == '1') {
        header('Location: Appointment.php?action=view&id=' . $id . '&status_updated=1');
    } else {
        header('Location: Appointment.php');
    }
    exit;
}

function getStatusText($status_id)
{
    switch ($status_id) {
        case 1:
            return 'Pending';
        case 2:
            return 'Confirmed';
        case 3:
            return 'Completed';
        case 4:
            return 'Cancelled';
        default:
            return 'Unknown';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Record | Rommel Garcia Digital Video & Photography</title>
    <link rel="stylesheet" href="css/clientRecord.css">
    <link rel="icon" href="../img/Header-Pic/rommel-logo-v3.svg">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }


        .bg-light {
            background-color: #161a2d !important;

        }
    </style>

</head>

<body>
    <svg style="display:none;">

        <symbol id="dashboard" viewBox="0 0 24 24">
            <path
                d="M4 13h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1zm-1 7a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v4zm10 0a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v7zm1-10h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1z" />
        </symbol>


        <symbol id="calendar-btn" viewBox="0 0 448 512">
            <path
                d="M152 64H296V24C296 10.75 306.7 0 320 0C333.3 0 344 10.75 344 24V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H104V24C104 10.75 114.7 0 128 0C141.3 0 152 10.75 152 24V64zM48 448C48 456.8 55.16 464 64 464H384C392.8 464 400 456.8 400 448V192H48V448z" />
        </symbol>

        <symbol id="history" viewBox="0 0 20 21">
            <path
                d="M10.5,0 C7,0 3.9,1.9 2.3,4.8 L0,2.5 L0,9 L6.5,9 L3.7,6.2 C5,3.7 7.5,2 10.5,2 C14.6,2 18,5.4 18,9.5 C18,13.6 14.6,17 10.5,17 C7.2,17 4.5,14.9 3.4,12 L1.3,12 C2.4,16 6.1,19 10.5,19 C15.8,19 20,14.7 20,9.5 C20,4.3 15.7,0 10.5,0 L10.5,0 Z M9,5 L9,10.1 L13.7,12.9 L14.5,11.6 L10.5,9.2 L10.5,5 L9,5 L9,5 Z" />
        </symbol>

        <symbol id="bookmark" viewBox="0 0 96 96">
            <path
                d="M78-.0011H18a5.9965,5.9965,0,0,0-6,6v84a6.0015,6.0015,0,0,0,9.75,4.6875L48,73.6805,74.25,94.6864A6.0015,6.0015,0,0,0,84,89.9989v-84A5.9965,5.9965,0,0,0,78-.0011ZM72,77.5125,51.75,61.3114a6.0134,6.0134,0,0,0-7.5,0L24,77.5125V11.9989H72Z" />
        </symbol>


        <symbol id="logout" viewBox="0 0 24 24">
            <path d="M12,10c1.1,0,2-0.9,2-2V4c0-1.1-0.9-2-2-2s-2,0.9-2,2v4C10,9.1,10.9,10,12,10z" />
            <path
                d="M19.1,4.9L19.1,4.9c-0.3-0.3-0.6-0.4-1.1-0.4c-0.8,0-1.5,0.7-1.5,1.5c0,0.4,0.2,0.8,0.4,1.1l0,0c0,0,0,0,0,0c0,0,0,0,0,0c1.3,1.3,2,3,2,4.9c0,3.9-3.1,7-7,7s-7-3.1-7-7c0-1.9,0.8-3.7,2.1-4.9l0,0C7.3,6.8,7.5,6.4,7.5,6c0-0.8-0.7-1.5-1.5-1.5c-0.4,0-0.8,0.2-1.1,0.4l0,0C3.1,6.7,2,9.2,2,12c0,5.5,4.5,10,10,10s10-4.5,10-10C22,9.2,20.9,6.7,19.1,4.9z" />
        </symbol>

        <symbol id="gallery" viewBox="0 0 24 24">
            <path
                d="M24,6c0-2.2-1.8-4-4-4H4C1.8,2,0,3.8,0,6v12c0,2.2,1.8,4,4,4h16c2.2,0,4-1.8,4-4V6z M6,6c1.1,0,2,0.9,2,2   c0,1.1-0.9,2-2,2S4,9.1,4,8C4,6.9,4.9,6,6,6z M22,18c0,1.1-0.9,2-2,2H4.4c-0.9,0-1.3-1.1-0.7-1.7l3.6-3.6c0.4-0.4,1-0.4,1.4,0   l0.6,0.6c0.4,0.4,1,0.4,1.4,0l6.6-6.6c0.4-0.4,1-0.4,1.4,0l3,3c0.2,0.2,0.3,0.4,0.3,0.7V18z" />
        </symbol>
    </svg>

    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container-fluid">

            <a class="navbar-brand" href="index.php?page=dashboard">
                <img src="img/rommel-logo.png" alt="Logo" class="d-inline-block align-text-top " />

            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Appointment.php?page=Appointment">Appointment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="post.php?page=Post-image">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="calendar.php?page=Calendar">Calendar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="history.php?page=History">History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex log-col" style="gap:10px; color: #b23b3b !important;" href="logout.php"><span class="material-symbols-outlined"> logout </span>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>




    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="img/rommel-logo.png" alt="logo" />

        </div>
        <ul class="sidebar-links bt-top">
            <h4>
                <span>Main Menu</span>
                <div class="menu-separator"></div>
            </h4>
            <li>
                <a href="index.php?page=dashboard">
                    <span class="material-symbols-outlined "> dashboard </span>Dashboard</a>
            </li>

            <li>
                <a href="Appointment.php?page=Appointment" class="active"><span
                        class="material-symbols-outlined active">
                        Bookmark
                    </span>Appointment</a>
            </li>

            <li>
                <a href="post.php?page=Post-image"><span class="material-symbols-outlined">
                        Add_Photo_Alternate</span>Gallery</a>
            </li>

            <li>
                <a href="calendar.php?page=Calendar"><span class="material-symbols-outlined"> Calendar_Month
                    </span>Calendar</a>
            </li>
            <li>
                <a href="history.php?page=History"><span class="material-symbols-outlined"> History </span>History</a>
            </li>



        </ul>

        <div class="bottom-log">
            <ul class="sidebar-links log-btn">
                <li>
                    <a href="logout.php"><span class="material-symbols-outlined"> logout </span>Logout</a>
                </li>

            </ul>

        </div>
        </div>
    </aside>


    <section class="content-section">
        <section class="search-and-user">



            <div class="dash-body-top">
                <table class="table-appointment" border="0">
                    <tr>
                        <td>

                            <div class="client-front col-span">
                                <div class="d-flex for-text">
                                    <span class="nav-title " style="display: grid; place-items: center;"> <span class="material-symbols-outlined">
                                            account_circle
                                        </span> </span>
                                    <h2>Client Information </h2>

                                </div>



                                <div class="d-flex">
                                    <div class="d-grid">
                                        <p
                                            style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                                            Today's Date
                                        </p>
                                        <p class="heading-sub12" id="currentDate">

                                        </p>
                                    </div>
                                    <a href="calendar.php"> <button class="btn-label"
                                            style="display: flex;justify-content: center;align-items: center;"><img
                                                src="img/calendar.svg" width="100%"></button></a>

                                </div>
                            </div>
                            <!-- <span class="client-num dash-body">Client ID:#1121312</span> -->


                        </td>
                    </tr>

                </table>
            </div>


        </section>

        <div class="dash-body">
            <table class="table-appointment" border="0">


                <tr>
                    <td colspan="2">
                        <div class="py-3"></div>

                        <div class="row ">
                            <div class="col">
                                <div class="inputContainer">
                                    <input required class="clientInput" value="Michael Jan" type="text" readonly>
                                    <label class="inputLabel">Client Name</label>
                                    <div class="inputUnderline"></div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="inputContainer">
                                    <input required class="clientInput" value="0123123" type="number" readonly>
                                    <label class="inputLabel">Phone Number</label>
                                    <div class="inputUnderline"></div>
                                </div>
                            </div>


                        </div>
                        <div class="row py-3">
                            <div class="col">
                                <div class="inputContainer">
                                    <a href="https://mail.google.com/mail/?view=cm&to=michael@gmail.com" target="_blank"><input required="" class="clientInput" value="Michael@gmail.com" type="text" readonly>
                                        <label class="inputLabel">Email Address</label>
                                        <div class="inputUnderline"></div>
                                    </a>

                                </div>
                            </div>
                            <div class="col">
                                <div class="inputContainer">
                                    <input required="" class="clientInput" value="12123123" type="text" readonly style="border-bottom: none;
    color: gray;">
                                    <label class="inputLabel">Client ID</label>

                                </div>
                            </div>

                        </div>

                        <div class="py-3"></div>

                    </td>

                </tr>
                <tr>
                    <td colspan="4">

                        <div class="client-front justify-content-between">
                            <div class="d-flex total-clients"><span class="material-symbols-outlined">
                                    list
                                </span>
                                <p class="heading-main12">Appointment History (<span id="totalCount">0</span>)</p>


                            </div>


                            <div class="dis-form-2">
                                <form action="" method="post" class="header-search ">

                                    <input type="search" name="search" class="input-text header-searchbar"
                                        placeholder="Search Client Name " list="clientname"
                                        style="background-image: url('img/search.svg');" autocomplete="off">&nbsp;&nbsp;



                                    <input type="Submit" value="Search" class="login-btn btn-primary btn"
                                        style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">

                                </form>
                            </div>


                        </div>
                    </td>

                </tr>






            </table>
        </div>


        <div class="appointment-list-scroll-container scroll-table">
            <table id="tablepress-30" width="100%" class="  text-center sub-table main-table scrolldown table-responsive  table-striped">
                <thead class="thead-light  thead-text">
                    <tr>
                        <th class="table-headin sz-table">


                            Appointment number

                        </th>


                        <th class="table-headin">
                            <form method="get" style="display:inline;">
                                <input type="hidden" name="sort" value="notes">
                                <input type="hidden" name="dir" value="<?= ($sortField == 'notes' && $sortDir == 'ASC') ? 'desc' : 'asc' ?>">
                                Category
                                <button type="submit" style="background:none;border:none;cursor:pointer;vertical-align:middle;">
                                    <span class="material-symbols-outlined" style="font-size:1em;vertical-align:middle;">
                                        <?= $sortField == 'notes' ? ($sortDir == 'ASC' ? 'arrow_drop_up' : 'arrow_drop_down') : 'unfold_more' ?>
                                    </span>
                                </button>
                            </form>
                        </th>
                        <th class="table-headin">
                            <form method="get" style="display:inline;">
                                <input type="hidden" name="sort" value="payment">
                                <input type="hidden" name="dir" value="<?= ($sortField == 'payment' && $sortDir == 'ASC') ? 'desc' : 'asc' ?>">
                                Payment
                            </form>
                        </th>
                        <th class="table-headin">
                            <form method="get" style="display:inline;">
                                <input type="hidden" name="sort" value="appointment_date">
                                <input type="hidden" name="dir" value="<?= ($sortField == 'appointment_date' && $sortDir == 'ASC') ? 'desc' : 'asc' ?>">
                                Date
                                <button type="submit" style="background:none;border:none;cursor:pointer;vertical-align:middle;">
                                    <span class="material-symbols-outlined" style="font-size:1em;vertical-align:middle;">
                                        <?= $sortField == 'appointment_date' ? ($sortDir == 'ASC' ? 'arrow_drop_up' : 'arrow_drop_down') : 'unfold_more' ?>
                                    </span>
                                </button>
                            </form>
                        </th>
                        <!-- <th class="table-headin">
                            <form method="get" style="display:inline;">
                                <input type="hidden" name="sort" value="appointment_time">
                                <input type="hidden" name="dir" value="<?= ($sortField == 'appointment_time' && $sortDir == 'ASC') ? 'desc' : 'asc' ?>">
                                Time
                                <button type="submit" style="background:none;border:none;cursor:pointer;vertical-align:middle;">
                                    <span class="material-symbols-outlined" style="font-size:1em;vertical-align:middle;">
                                        <?= $sortField == 'appointment_time' ? ($sortDir == 'ASC' ? 'arrow_drop_up' : 'arrow_drop_down') : 'unfold_more' ?>
                                    </span>
                                </button>
                            </form>
                        </th> -->
                        <th class="table-headin">
                            <form method="get" style="display:inline;">
                                <input type="hidden" name="sort" value="status_id">
                                <input type="hidden" name="dir" value="<?= ($sortField == 'status_id' && $sortDir == 'ASC') ? 'desc' : 'asc' ?>">
                                Status
                                <button type="submit" style="background:none;border:none;cursor:pointer;vertical-align:middle;">
                                    <span class="material-symbols-outlined" style="font-size:1em;vertical-align:middle;">
                                        <?= $sortField == 'status_id' ? ($sortDir == 'ASC' ? 'arrow_drop_up' : 'arrow_drop_down') : 'unfold_more' ?>
                                    </span>
                                </button>
                            </form>
                        </th>
                        <th class="table-headin sz-table">

                            Events

                    </tr>
                </thead>
                <tbody id="client-table-body">
                    <?php if (empty($appointments)): ?>
                        <tr>
                            <td colspan="8" style="text-align:center;">No appointments found.</td>
                        </tr>
                        <?php else: foreach ($appointments as $row): ?>
                            <tr>
                                <td><?= sanitizeOutput($row['id']) ?></td>

                                <td><?= sanitizeOutput($row['notes']) ?></td>
                                <td><?= sanitizeOutput($row['payment'] ?? 'N/A') ?></td>
                                <td><?= formatDate($row['appointment_date']) ?></td>

                                <td class="status-text">
                                    <span class="status-badge status-<?= strtolower(getStatusText($row['status_id'])) ?>">
                                        <?= getStatusText($row['status_id']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="events-td">
                                        <a href="Receipt.php?page=print" class="non-style-link">
                                            <button class="btn-print btn-primary-soft btn button-icon ">
                                                <span class="material-symbols-outlined" style="font-size: 1.2em;">print</span>
                                                Print
                                            </button></a>
                                    </div>
                                </td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>

            </table>
        </div>






        <!-- <footer class="page-footer">
    
    </footer> -->
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




    <script src="js/search-filter-appointment.js">

    </script>
    <script src="js/date.js"></script>
    <script src="js/appointment.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.1/dist/bootstrap-table.min.js"></script>


</body>

</html>