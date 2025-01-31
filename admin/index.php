<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="css/style.css">

  <style type="text/css">


  </style>
</head>

<body>
  <svg style="display:none;">




    <symbol id="dashboard" viewBox="0 0 24 24">
      <path d="M4 13h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1zm-1 7a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v4zm10 0a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v7zm1-10h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1z" />
    </symbol>


    <symbol id="calendar-btn" viewBox="0 0 448 512">
      <path d="M152 64H296V24C296 10.75 306.7 0 320 0C333.3 0 344 10.75 344 24V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H104V24C104 10.75 114.7 0 128 0C141.3 0 152 10.75 152 24V64zM48 448C48 456.8 55.16 464 64 464H384C392.8 464 400 456.8 400 448V192H48V448z" />
    </symbol>

    <symbol id="history" viewBox="0 0 20 21">
      <path d="M10.5,0 C7,0 3.9,1.9 2.3,4.8 L0,2.5 L0,9 L6.5,9 L3.7,6.2 C5,3.7 7.5,2 10.5,2 C14.6,2 18,5.4 18,9.5 C18,13.6 14.6,17 10.5,17 C7.2,17 4.5,14.9 3.4,12 L1.3,12 C2.4,16 6.1,19 10.5,19 C15.8,19 20,14.7 20,9.5 C20,4.3 15.7,0 10.5,0 L10.5,0 Z M9,5 L9,10.1 L13.7,12.9 L14.5,11.6 L10.5,9.2 L10.5,5 L9,5 L9,5 Z" />
    </symbol>

    <symbol id="bookmark" viewBox="0 0 96 96">
      <path d="M78-.0011H18a5.9965,5.9965,0,0,0-6,6v84a6.0015,6.0015,0,0,0,9.75,4.6875L48,73.6805,74.25,94.6864A6.0015,6.0015,0,0,0,84,89.9989v-84A5.9965,5.9965,0,0,0,78-.0011ZM72,77.5125,51.75,61.3114a6.0134,6.0134,0,0,0-7.5,0L24,77.5125V11.9989H72Z" />
    </symbol>


    <symbol id="logout" viewBox="0 0 24 24">
      <path d="M12,10c1.1,0,2-0.9,2-2V4c0-1.1-0.9-2-2-2s-2,0.9-2,2v4C10,9.1,10.9,10,12,10z" />
      <path d="M19.1,4.9L19.1,4.9c-0.3-0.3-0.6-0.4-1.1-0.4c-0.8,0-1.5,0.7-1.5,1.5c0,0.4,0.2,0.8,0.4,1.1l0,0c0,0,0,0,0,0c0,0,0,0,0,0c1.3,1.3,2,3,2,4.9c0,3.9-3.1,7-7,7s-7-3.1-7-7c0-1.9,0.8-3.7,2.1-4.9l0,0C7.3,6.8,7.5,6.4,7.5,6c0-0.8-0.7-1.5-1.5-1.5c-0.4,0-0.8,0.2-1.1,0.4l0,0C3.1,6.7,2,9.2,2,12c0,5.5,4.5,10,10,10s10-4.5,10-10C22,9.2,20.9,6.7,19.1,4.9z" />
    </symbol>
  </svg>



  <header class="page-header">
    <nav>
      <a href="dashboard.php" aria-label="forecastr logo" class="logo">

        <img src="img/rommel-logo-v3.svg" alt="logo" width="150">
      </a>



      <ul class="admin-menu">
        <li class="menu-heading">
          <h3>Admin</h3>
        </li>
        <li>
          <a href="index.php" class="active">
            <svg>
              <use xlink:href="#dashboard"></use>
            </svg>
            <span>Dashboard</span>
          </a>
        </li>

        <li>
          <a href="appointment.php">
            <svg>
              <use xlink:href="#bookmark"></use>
            </svg>
            <span>Appointment</span>
          </a>
        </li>
        <li>
          <a href="calendar.php">
            <svg>
              <use xlink:href="#calendar-btn"></use>
            </svg>
            <span>Calendar</span>
          </a>
        </li>
        <li>
          <a href="history.php">
            <svg>
              <use xlink:href="#history"></use>
            </svg>
            <span>History</span>
          </a>
        </li>


        <li>
          <!-- <div class="switch">
          <input type="checkbox" id="mode" checked>
          <label for="mode">
            <span></span>
            <span>Dark</span>
          </label>
        </div> -->
          <!--  <button class="collapse-btn" aria-expanded="true" aria-label="collapse menu">
          <svg aria-hidden="true">
            <use xlink:href="#collapse"></use>
          </svg>
          <span>Collapse</span>
        </button> -->
          <button class="logout-btn" aria-expanded="true" aria-label="collapse menu">
            <svg aria-hidden="true">
              <use xlink:href="#logout"></use>
            </svg>
            <span>Logout</span>
          </button>
        </li>

      </ul>

    </nav>

  </header>
  <section class="page-content">
    <section class="search-and-user">

      <span class="nav-title">Dashboard</span>
      <div class="admin-profile">

        <div class="row-date">
          <div class="column-date">
            <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
              Today's Date
            </p>
            <p class="heading-sub12">
              2025-6-3
            </p>
          </div>
          <div class="column-button">
            <a href="calendar.php"> <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="img/calendar.svg" width="100%"></button></a>

          </div>
        </div>

      </div>
    </section>
    <center>
      <table class="filter-container" style="border: none;" border="0">
        <tr>
          <td colspan="4">
            <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Status</p>
          </td>
        </tr>
        <tr>
          <td style="width: 25%;">
            <a href="appointment.php">
              <div class="dashboard-items">
                <div>
                  <div class="h1-dashboard"> 12
                  </div><br>
                  <div class="h3-dashboard">
                    Appointment &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </div>
                </div>
                <div class="btn-icon-back dashboard-icons" style="background-image: url('img/icon/Appointment.svg');"></div>
              </div>
            </a>

          </td>
          <td style="width: 25%;">
            <a href="appointment.php">
              <div class="dashboard-items">
                <div>
                  <div class="h1-dashboard">
                    43
                  </div><br>
                  <div class="h3-dashboard">
                    New Appointment &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </div>
                </div>
                <div class="btn-icon-back dashboard-icons" style="background-image: url('img/icon/New-Appointment.svg');"></div>
              </div>
            </a>

          </td>
          <td style="width: 25%;">
            <a href="appointment.php">
              <div class="dashboard-items">
                <div>
                  <div class="h1-dashboard">
                    13
                  </div><br>
                  <div class="h3-dashboard">
                    Today Sessions &nbsp;&nbsp;
                  </div>
                </div>
                <div class="btn-icon-back dashboard-icons" style="background-image: url('img/icon/Today-Sessions.svg');"></div>
              </div>
            </a>

          </td>
          <td style="width: 25%;">
            <a href="appointment.php">
              <div class="dashboard-items">
                <div>
                  <div class="h1-dashboard">
                    76
                  </div><br>
                  <div class="h3-dashboard">
                    Upcomming Sessions
                  </div>
                </div>
                <div class="btn-icon-back dashboard-icons" style="background-image: url('img/icon/Upcomming-Sessions.svg');"></div>
              </div>
            </a>

          </td>

        </tr>
      </table>
    </center>

    <table width="100%" border="0" class="dashbord-tables">
      <tr>
        <td>
          <p style="padding:10px;padding-left:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);">
            Today’s Appointment Schedule
          </p>
          <p style="padding-bottom:19px;padding-left:50px;font-size:15px;font-weight:500;color:#212529e3;line-height: 20px;">
            Here's Quick access to Upcoming Appointments until 7 days<br>
            More details available in @Appointment section.
          </p>

        </td>
        <td>
          <p style="text-align:right;padding:10px;padding-right:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);">
            Upcoming Appointments Next Week
          </p>
          <p style="padding-bottom:19px;text-align:right;padding-right:50px;font-size:15px;font-weight:500;color:#212529e3;line-height: 20px;">
            Here's Quick access to Upcoming Appointments that Scheduled next week 7 days<br>
            Add,Remove and Many features available in @Schedule section.
          </p>


        </td>
      </tr>
      <tr>
        <td width="50%">

          <div class="group-search">
            <svg class="icon-search" aria-hidden="true" viewBox="0 0 24 24">
              <g>
                <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
              </g>
            </svg>
            <input placeholder="Search for client names..." id="search-bar" type="text" class="input-search-name">
          </div>
          <center>

            <div class="abc scroll">

              <table width="85%" class="sub-table scrolldown" border="0">
                <thead>
                  <tr>
                    <th class="table-headin">

                      Appointment number

                    </th>
                    <th class="table-headin">
                      Client name
                    </th>
                    <th class="table-headin">


                      Category

                    </th>
                    <th class="table-headin">


                      Time

                    </th>
                  </tr>
                </thead>
                <tbody id="appointment-table-body">



                  <tr>
                    <td class="data-app-num">
                      291
                    </td>
                    <td class="data-cla-name"> &nbsp; Russel Requina </td>
                    <td class="data-cat"> &nbsp; Duo </td>
                    <td class="data-time">
                      6:30pm
                    </td>
                  </tr>

                  <tr>
                    <td class="data-app-num">
                      291
                    </td>
                    <td class="data-cla-name"> &nbsp; josh Dizon </td>
                    <td class="data-cat"> &nbsp; Duo </td>
                    <td class="data-time">
                      6:30pm
                    </td>
                  </tr>
                  <tr>
                    <td class="data-app-num">
                      291
                    </td>
                    <td class="data-cla-name"> &nbsp; Ron Rivera </td>
                    <td class="data-cat"> &nbsp; Duo </td>
                    <td class="data-time">
                      6:30pm
                    </td>
                  </tr>



                </tbody>

              </table>
            </div>
          </center>


        </td>
        <td width="50%" style="padding: 0;">
          <div class="group-search">
            <svg class="icon-search" aria-hidden="true" viewBox="0 0 24 24">
              <g>
                <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
              </g>
            </svg>
            <input placeholder="Search for client names..." id="search-bar-two" type="text" class="input-search-name">
          </div>
          <center>
            <div class="abc scroll">
              <table width="85%" class="sub-table scrolldown" border="0">
                <thead>
                  <tr>
                    <th class="table-headin">


                      Category

                    </th>

                    <th class="table-headin">
                      Client name
                    </th>
                    <th class="table-headin">

                      Sheduled Date

                    </th>
                    <th class="table-headin">

                      Time

                    </th>

                  </tr>
                </thead>
                <tbody id="appointment-two-table-body">
                  <tr>
                    <td class="data-up-next-week">group</td>
                    <td class="data-two-cla-name"> &nbsp; Josh Dizon </td>
                    <td class="data-date"> &nbsp; 1/24/25 </td>
                    <td class="data-time"> &nbsp; 8:30pm </td>

                  </tr>



                </tbody>

              </table>
            </div>
          </center>
        </td>
      </tr>
      <tr>
        <td>
          <center>
            <a href="Appointment.php" class="non-style-link"><button class="btn-primary btn" style="width:85%">Show all Appointments</button></a>
          </center>
        </td>
        <td>
          <center>
            <a href="Appointment.php" class="non-style-link"><button class="btn-primary btn" style="width:85%">Show all Sessions</button></a>
          </center>
        </td>
      </tr>
    </table>


    <!-- <section class="grid">
    <article></article>
    <article></article>
    <article></article>
    <article></article>
 
  
  </section> -->
    <!-- <footer class="page-footer">
     
    </footer> -->
  </section>
  <script>

  </script>

  <script src="js/dashboard.js"></script>


</body>

</html>