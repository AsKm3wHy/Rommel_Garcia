<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
require_once 'config/database.php';
require_once 'models/Appointment.php';

$database = new Database();
$db = $database->getConnection();
$appointmentModel = new Appointment($db);

// Handle search, sort, and fetch appointments (only completed/cancelled)
$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';
$sortField = isset($_GET['sort']) ? $_GET['sort'] : 'appointment_date';
$sortDir = (isset($_GET['dir']) && strtolower($_GET['dir']) === 'desc') ? 'DESC' : 'ASC';
$allowedSortFields = ['appointment_date', 'notes', 'status_id', 'appointment_time'];
if (!in_array($sortField, $allowedSortFields)) {
    $sortField = 'appointment_date';
}
$appointments = [];
if ($searchTerm !== '') {
    $query = "SELECT * FROM appointments WHERE full_name LIKE ? AND status_id IN (3,4) ORDER BY $sortField $sortDir, appointment_date DESC, appointment_time ASC";
    $stmt = $db->prepare($query);
    $stmt->execute(['%' . $searchTerm . '%']);
    $appointments = $stmt->fetchAll();
} else {
    $query = "SELECT * FROM appointments WHERE status_id IN (3,4) ORDER BY $sortField $sortDir, appointment_date DESC, appointment_time ASC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $appointments = $stmt->fetchAll();
}

// Handle view/edit modal logic
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
    // If status is being changed to Pending or Confirmed, and date is in the past, set to tomorrow
    $newStatus = null;
    if (isset($_POST['new_status'])) {
        $newStatus = (int)$_POST['new_status'];
    }
    $today = date('Y-m-d');
    if (($newStatus === 1 || $newStatus === 2) && $date <= $today) {
        $date = date('Y-m-d', strtotime('+1 day'));
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
    header('Location: history.php?action=success');
    exit;
}

// Handle status update from modal
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
    if (isset($_POST['from_view']) && $_POST['from_view'] == '1') {
        header('Location: history.php?action=view&id=' . $id . '&status_updated=1');
    } else {
        header('Location: history.php');
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
function sanitizeOutput($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
function formatDate($date)
{
    return date('n/j/y', strtotime($date));
}
function formatDateTime($time)
{
    return date('g:i A', strtotime($time));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History | Rommel Garcia Digital Video & Photography</title>
    <link rel="stylesheet" href="css/history.css">
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
        <!-- SVG symbols as in Appointment.php -->
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
            <li><a href="index.php?page=dashboard"><span class="material-symbols-outlined"> dashboard </span>Dashboard</a></li>
            <li><a href="Appointment.php?page=Appointment"><span class="material-symbols-outlined">Bookmark</span>Appointment</a></li>
            <li><a href="post.php?page=Post-image"><span class="material-symbols-outlined">Add_Photo_Alternate</span>Gallery</a></li>
            <li><a href="calendar.php?page=Calendar"><span class="material-symbols-outlined">Calendar_Month</span>Calendar</a></li>
            <li><a href="history.php?page=History" class="active"><span class="material-symbols-outlined active">History</span>History</a></li>

        </ul>
        <div class="bottom-log">
            <ul class="sidebar-links log-btn">
                <li><a href="logout.php"><span class="material-symbols-outlined"> logout </span>Logout</a></li>
            </ul>
        </div>
    </aside>
    <section class="content-section">


        <div class="dash-body-top ">
            <table class="table-appointment" border="0">
                <tr>
                    <td class="top-header-table">


                        <div class="d-flex for-text"><span class="nav-title " style="display: grid; place-items: center;"> <span class="material-symbols-outlined">
                                    History
                                </span> </span>
                            <h2>History Manager</h2>
                        </div>
                    </td>

                    <td>


                    </td>
                    <td width="15%">
                        <p
                            style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" id="currentDate">

                        </p>
                    </td>
                    <td width="4%">
                        <a href="calendar.php"> <button class="btn-label"
                                style="display: flex;justify-content: center;align-items: center;"><img
                                    src="img/calendar.svg" width="100%"></button></a>

                    </td>


                </tr>

            </table>
        </div>


        <div class="dash-body py-4">
            <table class=" table-appointment" border="0">
                <tr>
                    <td class="top-header-table">
                        <p class="heading-main12">All Client History (0)</p>
                    </td>
                    <td>
                        <form action="" method="post" class="header-search">
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Client Name " list="clientname" style="background-image: url('img/search.svg');" autocomplete="off">&nbsp;&nbsp;
                            <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        </form>
                    </td>

                </tr>
            </table>
        </div>
        <div class="appointment-list-scroll-container scroll-table">
            <table id="tablepress-30" width="100%" class="sub-table main-table scrolldown text-center " border="0">
                <thead>
                    <tr>
                        <th class="table-headin sz-table">Appointment number</th>
                        <th class="table-headin">Client Name</th>
                        <th class="table-headin">Category</th>
                        <th class="table-headin">Payment</th>
                        <th class="table-headin">Date</th>
                        <th class="table-headin">Time</th>
                        <th class="table-headin">Status</th>
                        <th class="table-headin sz-table">Events</th>
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
                                <td><?= sanitizeOutput($row['full_name']) ?></td>
                                <td><?= sanitizeOutput($row['notes']) ?></td>
                                <td><?= sanitizeOutput($row['payment'] ?? 'N/A') ?></td>
                                <td><?= formatDate($row['appointment_date']) ?></td>
                                <td><?= formatDateTime($row['appointment_time']) ?></td>
                                <td class="status-text">
                                    <span class="status-badge status-<?= strtolower(getStatusText($row['status_id'])) ?>">
                                        <?= getStatusText($row['status_id']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="events-td">
                                        <a href="?action=edit&id=<?= $row['id'] ?>&error=0" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-edit" style=" background-image: url(' img/icon/edit-iceblue.svg')">
                                                <font class="tn-in-text">Edit</font>
                                            </button></a>

                                        <a href="?action=view&id=<?= $row['id'] ?>" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-view" style="background-image: url(' img/icon/view-iceblue.svg')">
                                                <font class="tn-in-text">View</font>
                                            </button></a>
                                    </div>
                                </td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>


    </section>

    <?php
    if (isset($_GET["action"])) {
        $action = $_GET["action"];
        if ($action == 'view' && $popupAppointment) {
            $statusText = getStatusText($popupAppointment['status_id']);
            $statusClass = strtolower($statusText);
            $showSuccess = (isset($_GET['status_updated']) && $_GET['status_updated'] == '1');
            echo '<div id="popup1" class="overlay" style="z-index: 1000;">
    <div class="popup" style="max-width: 540px; border-radius: 18px; box-shadow: 0 8px 32px rgba(0,0,0,0.18); padding: 0; overflow: visible; background: #f8fafc;">
        <a class="close" href="history.php" style="font-size: 2.5rem; top: 18px; right: 24px; color: #333; text-shadow: 0 2px 8px #fff; font-weight: bold; position: absolute;">&times;</a>
        <div class="abc-popup" style="padding: 0;">
            <div style="padding: 32px 32px 0 32px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span class="material-symbols-outlined" style="font-size: 2.1em; color: #1976d2;">event</span>
                        <h2 style="margin: 0; font-size: 1.6rem; font-weight: 700; letter-spacing: 0.5px;">Manage Appointment</h2>
                    </div>
                    <span class="status-badge status-' . $statusClass . '" style="font-size: 1rem; padding: 0.4em 1.2em; display: flex; align-items: center; gap: 6px;">
                        <span class="material-symbols-outlined" style="font-size: 1.1em;">verified</span> ' . $statusText . '
                    </span>
                </div>
                <hr style="margin-bottom: 18px;">
                <div style="margin-bottom: 24px;">
                    <h3 style="margin: 0 0 12px 0; font-size: 1.15em; color: #1976d2; letter-spacing: 0.5px;">Appointment Details</h3>
                    <div class="details-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px 32px; background: #f5faff; border-radius: 10px; padding: 18px 12px; font-size: 1.05em;">
                        <div><span style="font-weight: 600; color: #444;">Client Name:</span><br><span class="data-bold">' . htmlspecialchars($popupAppointment['full_name']) . '</span></div>
                        <div><span style="font-weight: 600; color: #444;">Phone:</span><br><span class="data-bold">' . htmlspecialchars($popupAppointment['phone']) . '</span></div>
                        <div><span style="font-weight: 600; color: #444;">Email:</span><br><span class="data-bold">' . htmlspecialchars($popupAppointment['email']) . '</span></div>
                        <div><span style="font-weight: 600; color: #444;">Category:</span><br><span class="data-bold">' . htmlspecialchars($popupAppointment['notes']) . '</span></div>
                        <div><span style="font-weight: 600; color: #444;">Date:</span><br><span class="data-bold">' . htmlspecialchars($popupAppointment['appointment_date']) . '</span></div>
                        <div><span style="font-weight: 600; color: #444;">Time:</span><br><span class="data-bold">' . date('g:i A', strtotime($popupAppointment['appointment_time'])) . '</span></div>
                        <div><span style="font-weight: 600; color: #444;">Payment:</span><br><span class="data-bold">' . htmlspecialchars($popupAppointment['payment'] ?? 'N/A') . '</span></div>
                    </div>
                </div>
                <div style="margin: 0 -32px 0 -32px;"><hr></div>
                <div style="margin: 32px 0 0 0;">
                    <div style="background: #f5faff; border-radius: 10px; padding: 22px 18px 18px 18px; box-shadow: 0 2px 8px rgba(25, 118, 210, 0.06);">
                        <h3 style="margin: 0 0 12px 0; font-size: 1.08em; color: #1976d2; letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px;"><span class="material-symbols-outlined" style="font-size: 1.2em;">edit_square</span>Update Appointment Status</h3>
                        ' . ($showSuccess ? '<div style="background: #e8f5e9; color: #2e7d32; border-radius: 5px; padding: 8px 12px; margin-bottom: 12px; font-weight: 500; display: flex; align-items: center; gap: 6px;"><span class="material-symbols-outlined" style="font-size: 1.2em;">check_circle</span> Status updated successfully!</div>' : '') . '
                        <form method="post" action="" style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px; width: 100%;">
                            <input type="hidden" name="status_id" value="' . htmlspecialchars($popupAppointment['id']) . '">
                            <input type="hidden" name="from_view" value="1">
                            <label for="view-status-dropdown" style="font-weight: 500;">Status:</label>
                            <div style="display: flex; align-items: center; gap: 8px; width: 100%;">
                                <span class="material-symbols-outlined" style="font-size: 1.3em; color: #1976d2;">arrow_drop_down_circle</span>
                                <select id="view-status-dropdown" name="new_status" class="status-dropdown status-' . strtolower($statusText) . '" style="min-width: 160px; flex: 1; font-size: 1.05em;">
                                    <option value="1" ' . ($popupAppointment['status_id'] == 1 ? 'selected' : '') . '>Pending</option>
                                    <option value="2" ' . ($popupAppointment['status_id'] == 2 ? 'selected' : '') . '>Confirmed</option>
                                    <option value="3" ' . ($popupAppointment['status_id'] == 3 ? 'selected' : '') . '>Completed</option>
                                    <option value="4" ' . ($popupAppointment['status_id'] == 4 ? 'selected' : '') . '>Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="btn-primary btn" style="margin-top: 12px; background: #1976d2; color: #fff; font-weight: 600; display: flex; align-items: center; gap: 6px; font-size: 1.05em;">
                                <span class="material-symbols-outlined" style="font-size: 1.2em;">check</span> Update Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
        } elseif ($action == 'edit' && $popupAppointment) {
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                        <a class="close" href="history.php">&times;</a> 
                        <div style="display: flex;justify-content: center;">
                        <div class="abc-popup">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <form action="#" method="POST" class="add-new-form">
                            <input type="hidden" name="edit_id" value="' . htmlspecialchars($popupAppointment['id']) . '">
                        <tr>
                                <td class="label-td" colspan="2"></td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Edit Client Details.</p>
                                    Client ID : ' . htmlspecialchars($popupAppointment['id']) . ' (Auto Generated)<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                        <input type="text" name="name" class="input-text" placeholder="Client Name" value="' . htmlspecialchars($popupAppointment['full_name']) . '" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Phone: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                       <input type="tel" name="Tele-client" class="input-text" placeholder="Phone Number" id="phoneInput" value="' . htmlspecialchars($popupAppointment['phone']) . '"><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                        <label for="spec" class="form-label">Choose category: (Current ' . htmlspecialchars($popupAppointment['notes']) . ')</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <select name="spec" id="" class="box">';
            $categories = [
                "SOLO",
                "DUO",
                "TRIO",
                "QUAD",
                "DELUXE",
                "GROUP",
                "GRADUATE",
                "GRADUATE Package 1",
                "GRADUATE Package 2",
                "GRADUATE Package 3",
                "GRADUATE Package 4",
                "UNO",
                "DOS",
                "TRES",
                "CUATRO",
                "CINCO",
                "SEIS"
            ];
            foreach ($categories as $cat) {
                $selected = (strtolower($popupAppointment['notes']) == strtolower($cat)) ? 'selected' : '';
                echo '<option value="' . htmlspecialchars($cat) . '" ' . $selected . '>' . htmlspecialchars($cat) . '</option>';
            }
            echo '</select><br><br>
                                </td>
                            </tr>
                             <tr>
                                <td class="label-td" colspan="2">
                                    <label for="date" class="form-label"> Appointment Date: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                        <input type="datetime-local" id="datetime" class="input-text" name="datetime" value="' . htmlspecialchars($popupAppointment['appointment_date']) . 'T' . htmlspecialchars(substr($popupAppointment['appointment_time'], 0, 5)) . '" required><br>
                                </td>
                            </tr>
                           <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Email: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="email" name="email" class="input-text" placeholder="Email Address" value="' . htmlspecialchars($popupAppointment['email']) . '" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="submit" value="Save" class="login-btn btn-primary btn">
                                </td>
                            </tr>
                            </form>
                        </table>
                        </div>
                        </div>
                    <br><br>
            </div>
            </div>';
        } elseif ($action == 'success') {
            echo '<div id="popup1" class="overlay"><div class="popup"><center><br><br><br><br><h2>Edit Successfully!</h2><a class="close" href="history.php">&times;</a><div class="content"></div><div style="display: flex;justify-content: center;"><a href="history.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a></div><br><br></center></div></div>';
        }
    }
    ?>


    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/search-filter-appointment.js"></script>
    <script src="js/date.js"></script>
    <script src="js/appointment.js"></script>
</body>

</html>