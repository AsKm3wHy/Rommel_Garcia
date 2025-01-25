<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Dashboard</title>
  <link rel="stylesheet" href="css/appointment.css">
  <!-- <link rel="stylesheet" href="css/animations.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/admin.css"> -->

  <style>
    .popup {
      animation: transitionIn-Y-bottom 0.5s;
    }

    .sub-table {
      animation: transitionIn-Y-bottom 0.5s;
    }
  </style>

</head>

<body>
  <svg style="display:none;">


    <symbol id="down" viewBox="0 0 16 16">
      <polygon points="3.81 4.38 8 8.57 12.19 4.38 13.71 5.91 8 11.62 2.29 5.91 3.81 4.38" />
    </symbol>
    <symbol id="users" viewBox="0 0 16 16">
      <path d="M8,0a8,8,0,1,0,8,8A8,8,0,0,0,8,0ZM8,15a7,7,0,0,1-5.19-2.32,2.71,2.71,0,0,1,1.7-1,13.11,13.11,0,0,0,1.29-.28,2.32,2.32,0,0,0,.94-.34,1.17,1.17,0,0,0-.27-.7h0A3.61,3.61,0,0,1,5.15,7.49,3.18,3.18,0,0,1,8,4.07a3.18,3.18,0,0,1,2.86,3.42,3.6,3.6,0,0,1-1.32,2.88h0a1.13,1.13,0,0,0-.27.69,2.68,2.68,0,0,0,.93.31,10.81,10.81,0,0,0,1.28.23,2.63,2.63,0,0,1,1.78,1A7,7,0,0,1,8,15Z" />
    </symbol>


    <symbol id="calendar" viewBox="0 0 24 24">
      <path d="M3 9H21M12 18V12M15 15.001L9 15M7 3V5M17 3V5M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z" stroke="#242e42" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </symbol>

    <symbol id="calendar-btn" viewBox="0 0 448 512">
      <path d="M152 64H296V24C296 10.75 306.7 0 320 0C333.3 0 344 10.75 344 24V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H104V24C104 10.75 114.7 0 128 0C141.3 0 152 10.75 152 24V64zM48 448C48 456.8 55.16 464 64 464H384C392.8 464 400 456.8 400 448V192H48V448z" />
    </symbol>


    <!--  <symbol id="collection" viewBox="0 0 16 16">
    <rect width="7" height="7" />
    <rect y="9" width="7" height="7" />
    <rect x="9" width="7" height="7" />
    <rect x="9" y="9" width="7" height="7" />
  </symbol> -->
    <!-- <symbol id="charts" viewBox="0 0 16 16">
    <polygon points="0.64 7.38 -0.02 6.63 2.55 4.38 4.57 5.93 9.25 0.78 12.97 4.37 15.37 2.31 16.02 3.07 12.94 5.72 9.29 2.21 4.69 7.29 2.59 5.67 0.64 7.38" />
    <rect y="9" width="2" height="7" />
    <rect x="12" y="8" width="2" height="8" />
    <rect x="8" y="6" width="2" height="10" />
    <rect x="4" y="11" width="2" height="5" />
  </symbol> -->
    <!--  <symbol id="comments" viewBox="0 0 16 16">
    <path d="M0,16.13V2H15V13H5.24ZM1,3V14.37L5,12h9V3Z" />
    <rect x="3" y="5" width="9" height="1" />
    <rect x="3" y="7" width="7" height="1" />
    <rect x="3" y="9" width="5" height="1" />
  </symbol> -->
    <symbol id="pages" viewBox="0 0 16 16">
      <rect x="4" width="12" height="12" transform="translate(20 12) rotate(-180)" />
      <polygon points="2 14 2 2 0 2 0 14 0 16 2 16 14 16 14 14 2 14" />
    </symbol>
    <!--  <symbol id="appearance" viewBox="0 0 16 16">
    <path d="M3,0V7A2,2,0,0,0,5,9H6v5a2,2,0,0,0,4,0V9h1a2,2,0,0,0,2-2V0Zm9,7a1,1,0,0,1-1,1H9v6a1,1,0,0,1-2,0V8H5A1,1,0,0,1,4,7V6h8ZM4,5V1H6V4H7V1H9V4h1V1h2V5Z" />
  </symbol> -->
    <symbol id="trends" viewBox="0 0 16 16">
      <polygon points="0.64 11.85 -0.02 11.1 2.55 8.85 4.57 10.4 9.25 5.25 12.97 8.84 15.37 6.79 16.02 7.54 12.94 10.2 9.29 6.68 4.69 11.76 2.59 10.14 0.64 11.85" />
    </symbol>
    <symbol id="settings" viewBox="0 0 16 16">
      <rect x="9.78" y="5.34" width="1" height="7.97" />
      <polygon points="7.79 6.07 10.28 1.75 12.77 6.07 7.79 6.07" />
      <rect x="4.16" y="1.75" width="1" height="7.97" />
      <polygon points="7.15 8.99 4.66 13.31 2.16 8.99 7.15 8.99" />
      <rect x="1.28" width="1" height="4.97" />
      <polygon points="3.28 4.53 1.78 7.13 0.28 4.53 3.28 4.53" />
      <rect x="12.84" y="11.03" width="1" height="4.97" />
      <polygon points="11.85 11.47 13.34 8.88 14.84 11.47 11.85 11.47" />
    </symbol>

    <symbol id="options" viewBox="0 0 16 16">
      <path d="M8,11a3,3,0,1,1,3-3A3,3,0,0,1,8,11ZM8,6a2,2,0,1,0,2,2A2,2,0,0,0,8,6Z" />
      <path d="M8.5,16h-1A1.5,1.5,0,0,1,6,14.5v-.85a5.91,5.91,0,0,1-.58-.24l-.6.6A1.54,1.54,0,0,1,2.7,14L2,13.3a1.5,1.5,0,0,1,0-2.12l.6-.6A5.91,5.91,0,0,1,2.35,10H1.5A1.5,1.5,0,0,1,0,8.5v-1A1.5,1.5,0,0,1,1.5,6h.85a5.91,5.91,0,0,1,.24-.58L2,4.82A1.5,1.5,0,0,1,2,2.7L2.7,2A1.54,1.54,0,0,1,4.82,2l.6.6A5.91,5.91,0,0,1,6,2.35V1.5A1.5,1.5,0,0,1,7.5,0h1A1.5,1.5,0,0,1,10,1.5v.85a5.91,5.91,0,0,1,.58.24l.6-.6A1.54,1.54,0,0,1,13.3,2L14,2.7a1.5,1.5,0,0,1,0,2.12l-.6.6a5.91,5.91,0,0,1,.24.58h.85A1.5,1.5,0,0,1,16,7.5v1A1.5,1.5,0,0,1,14.5,10h-.85a5.91,5.91,0,0,1-.24.58l.6.6a1.5,1.5,0,0,1,0,2.12L13.3,14a1.54,1.54,0,0,1-2.12,0l-.6-.6a5.91,5.91,0,0,1-.58.24v.85A1.5,1.5,0,0,1,8.5,16ZM5.23,12.18l.33.18a4.94,4.94,0,0,0,1.07.44l.36.1V14.5a.5.5,0,0,0,.5.5h1a.5.5,0,0,0,.5-.5V12.91l.36-.1a4.94,4.94,0,0,0,1.07-.44l.33-.18,1.12,1.12a.51.51,0,0,0,.71,0l.71-.71a.5.5,0,0,0,0-.71l-1.12-1.12.18-.33a4.94,4.94,0,0,0,.44-1.07l.1-.36H14.5a.5.5,0,0,0,.5-.5v-1a.5.5,0,0,0-.5-.5H12.91l-.1-.36a4.94,4.94,0,0,0-.44-1.07l-.18-.33L13.3,4.11a.5.5,0,0,0,0-.71L12.6,2.7a.51.51,0,0,0-.71,0L10.77,3.82l-.33-.18a4.94,4.94,0,0,0-1.07-.44L9,3.09V1.5A.5.5,0,0,0,8.5,1h-1a.5.5,0,0,0-.5.5V3.09l-.36.1a4.94,4.94,0,0,0-1.07.44l-.33.18L4.11,2.7a.51.51,0,0,0-.71,0L2.7,3.4a.5.5,0,0,0,0,.71L3.82,5.23l-.18.33a4.94,4.94,0,0,0-.44,1.07L3.09,7H1.5a.5.5,0,0,0-.5.5v1a.5.5,0,0,0,.5.5H3.09l.1.36a4.94,4.94,0,0,0,.44,1.07l.18.33L2.7,11.89a.5.5,0,0,0,0,.71l.71.71a.51.51,0,0,0,.71,0Z" />
    </symbol>
    <symbol id="collapse" viewBox="0 0 16 16">
      <polygon points="11.62 3.81 7.43 8 11.62 12.19 10.09 13.71 4.38 8 10.09 2.29 11.62 3.81" />
    </symbol>
    <symbol id="logout" viewBox="0 0 24 24">
      <path d="M12,10c1.1,0,2-0.9,2-2V4c0-1.1-0.9-2-2-2s-2,0.9-2,2v4C10,9.1,10.9,10,12,10z" />
      <path d="M19.1,4.9L19.1,4.9c-0.3-0.3-0.6-0.4-1.1-0.4c-0.8,0-1.5,0.7-1.5,1.5c0,0.4,0.2,0.8,0.4,1.1l0,0c0,0,0,0,0,0c0,0,0,0,0,0c1.3,1.3,2,3,2,4.9c0,3.9-3.1,7-7,7s-7-3.1-7-7c0-1.9,0.8-3.7,2.1-4.9l0,0C7.3,6.8,7.5,6.4,7.5,6c0-0.8-0.7-1.5-1.5-1.5c-0.4,0-0.8,0.2-1.1,0.4l0,0C3.1,6.7,2,9.2,2,12c0,5.5,4.5,10,10,10s10-4.5,10-10C22,9.2,20.9,6.7,19.1,4.9z" />
    </symbol>

    <symbol id="bookmark" viewBox="0 0 96 96">
      <path d="M78-.0011H18a5.9965,5.9965,0,0,0-6,6v84a6.0015,6.0015,0,0,0,9.75,4.6875L48,73.6805,74.25,94.6864A6.0015,6.0015,0,0,0,84,89.9989v-84A5.9965,5.9965,0,0,0,78-.0011ZM72,77.5125,51.75,61.3114a6.0134,6.0134,0,0,0-7.5,0L24,77.5125V11.9989H72Z" />
    </symbol>

    <symbol id="search" viewBox="0 0 16 16">
      <path d="M6.57,1A5.57,5.57,0,1,1,1,6.57,5.57,5.57,0,0,1,6.57,1m0-1a6.57,6.57,0,1,0,6.57,6.57A6.57,6.57,0,0,0,6.57,0Z" />
      <rect x="11.84" y="9.87" width="2" height="5.93" transform="translate(-5.32 12.84) rotate(-45)" />
    </symbol>

    <symbol id="Walk-in" viewBox="0 0 24 24">
      <circle cx="13" cy="4" r="2" />
      <path d="M13.978 12.27c.245.368.611.647 1.031.787l2.675.892.633-1.896-2.675-.892-1.663-2.495a2.016 2.016 0 0 0-.769-.679l-1.434-.717a1.989 1.989 0 0 0-1.378-.149l-3.193.797a2.002 2.002 0 0 0-1.306 1.046l-1.794 3.589 1.789.895 1.794-3.589 2.223-.556-1.804 8.346-3.674 2.527 1.133 1.648 3.675-2.528c.421-.29.713-.725.82-1.225l.517-2.388 2.517 1.888.925 4.625 1.961-.393-.925-4.627a2 2 0 0 0-.762-1.206l-2.171-1.628.647-3.885 1.208 1.813z" />
    </symbol>

    <symbol id="history" viewBox="0 0 20 21">
      <path d="M10.5,0 C7,0 3.9,1.9 2.3,4.8 L0,2.5 L0,9 L6.5,9 L3.7,6.2 C5,3.7 7.5,2 10.5,2 C14.6,2 18,5.4 18,9.5 C18,13.6 14.6,17 10.5,17 C7.2,17 4.5,14.9 3.4,12 L1.3,12 C2.4,16 6.1,19 10.5,19 C15.8,19 20,14.7 20,9.5 C20,4.3 15.7,0 10.5,0 L10.5,0 Z M9,5 L9,10.1 L13.7,12.9 L14.5,11.6 L10.5,9.2 L10.5,5 L9,5 L9,5 Z" />
    </symbol>
    <symbol id="dashboard" viewBox="0 0 24 24">
      <path d="M4 13h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1zm-1 7a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v4zm10 0a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v7zm1-10h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1z" />
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
          <a href="index.php">
            <svg>
              <use xlink:href="#dashboard"></use>
            </svg>
            <span>Dashboard</span>
          </a>
        </li>

        <li>
          <a href="appointment.php" class="active">
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

      <!-- <span class="nav-title">Appointment Manager </span>

      <form action="" method="post" class="header-search">

        <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Client name or Email" list="Clientname" style=" background-image: url('img/search.svg');">&nbsp;&nbsp;


        <input type="Submit" value="Search" class="login-btn btn-primary btn " style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">

      </form>

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
            <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="img/calendar.svg" width="100%"></button>
          </div>
        </div>

      </div> -->


      <div class="dash-body" style="padding-right: 0px;">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
          <tr>
            <td width="13%">
              <a href="index.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px; ">
                  <font class="tn-in-text">Back</font>
                </button></a>
            </td>

            <td>

              <form action="" method="post" class="header-search">

                <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Client Name " list="clientname" style="background-image: url('img/search.svg');" autocomplete="off">&nbsp;&nbsp;



                <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">

              </form>

            </td>
            <td width="15%">
              <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                Today's Date
              </p>
              <p class="heading-sub12">
                2025-6-3
              </p>
            </td>
            <td width="4%">
              <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="img/calendar.svg" width="100%"></button>
            </td>


          </tr>

        </table>
      </div>


    </section>

    <div class="dash-body">
      <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">


        <tr>
          <td colspan="2">
            <p class="heading-main12">Add New Client</p>
          </td>
          <td colspan="2">
            <a href="?action=add&id=none&error=0" class="non-style-link"><button class="login-btn btn-primary btn button-icon add-btn-table" style="display: flex;justify-content: center;align-items: center;margin-left:75px;background-image: url('img/icon/add.svg');">Add New</font></button>
            </a>
          </td>
        </tr>
        <tr>
          <td colspan="4">
            <p class="heading-main12">All Client (0)</p>
          </td>

        </tr>


        <tr>
          <td colspan="4">
            <center>
              <div class="abc scroll">
                <table width="93%" class="sub-table scrolldown" border="0">
                  <thead>
                    <tr>
                      <th class="table-headin">


                        Appointment number

                      </th>
                      <th class="table-headin">


                        Client Name

                      </th>
                      <th class="table-headin">
                        Email
                      </th>
                      <th class="table-headin">

                        Category

                      </th>
                      <th class="table-headin">

                        Date

                      </th>
                      <th class="table-headin">

                        Time

                      </th>
                      <th class="table-headin">

                        Status

                      </th>
                      <th class="table-headin">

                        Events

                    </tr>
                  </thead>
                  <tbody id="client-table-body">

                    <!--                            <tr>
                                    <td colspan="4">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="doctors.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Doctors &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr> -->
                    <tr>
                      <td>123</td>
                      <td>
                        Michael Jan Natividad
                      </td>
                      <td>
                        michaeljannatividadgmail.com
                      </td>
                      <td>
                        Group
                      </td>
                      <td>
                        1/23/25
                      </td>
                      <td>
                        11:00 AM
                      </td>
                      <td>

                        <input name="status" type="text" value="Pending..." readonly style="text-align: center;" />
                      </td>


                      <td>
                        <div style="display:flex;justify-content: center;">
                          <a href="?action=edit&id=#&error=0" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-edit" style=" background-image: url(' img/icon/edit-iceblue.svg')">
                              <font class="tn-in-text">Edit</font>
                            </button></a>
                          &nbsp;&nbsp;&nbsp;
                          <a href="?action=view&id=#" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-view" style="background-image: url(' img/icon/view-iceblue.svg')">
                              <font class="tn-in-text">View</font>
                            </button></a>
                          &nbsp;&nbsp;&nbsp;

                          <a href="?action=done&id=#&name=" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-done" style="background-image: url(' img/icon/done_iceblue.svg')">
                              <font class="tn-in-text">Done</font>
                            </button></a>


                          &nbsp;&nbsp;&nbsp;


                          <a href="?action=cancel&id=#" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-cancel" style="background-image: url(' img/icon/cancel-iceblue.svg')">
                              <font class="tn-in-text">Cancel</font>
                            </button></a>

                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td> &nbsp;asddasd</td>
                      <td>
                        asdasdad
                      </td>
                      <td>
                        asdasd
                      </td>
                      <td>
                        asdasdad
                      </td>
                      <td>
                        1/23/25
                      </td>
                      <td>
                        11:00 AM
                      </td>
                      <td>
                        <input name="status" type="text" value="Pending..." readonly style="text-align: center;" />
                      </td>

                      <td>
                        <div style="display:flex;justify-content: center;">
                          <a href="?action=edit&id=&error=0" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-edit" style=" background-image: url(' img/icon/edit-iceblue.svg')">
                              <font class="tn-in-text">Edit</font>
                            </button></a>
                          &nbsp;&nbsp;&nbsp;
                          <a href="?action=view&id=#" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-view" style="background-image: url(' img/icon/view-iceblue.svg')">
                              <font class="tn-in-text">View</font>
                            </button></a>
                          &nbsp;&nbsp;&nbsp;
                          <a href="?action=done&id=#&name=" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-done" style="background-image: url(' img/icon/done_iceblue.svg')">
                              <font class="tn-in-text">Done</font>
                            </button></a>


                          &nbsp;&nbsp;&nbsp;


                          <a href="?action=cancel&id=#" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-cancel" style="background-image: url(' img/icon/cancel-iceblue.svg')">
                              <font class="tn-in-text">Cancel</font>
                            </button></a>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td> &nbsp;asddasd</td>
                      <td>
                        asdasdad
                      </td>
                      <td>
                        asdasd
                      </td>
                      <td>
                        asdasdad
                      </td>
                      <td>
                        1/23/25
                      </td>
                      <td>
                        11:00 AM
                      </td>
                      <td>
                        <input name="status" type="text" value="Pending..." readonly style="text-align: center;" />
                      </td>

                      <td>
                        <div style="display:flex;justify-content: center;">
                          <a href="?action=edit&id=#&error=0" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-edit" style=" background-image: url(' img/icon/edit-iceblue.svg')">
                              <font class="tn-in-text">Edit</font>
                            </button></a>
                          &nbsp;&nbsp;&nbsp;
                          <a href="?action=view&id=#" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-view" style="background-image: url(' img/icon/view-iceblue.svg')">
                              <font class="tn-in-text">View</font>
                            </button></a>
                          &nbsp;&nbsp;&nbsp;
                          <a href="?action=done&id=#&name=" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-done" style="background-image: url(' img/icon/done_iceblue.svg')">
                              <font class="tn-in-text">Done</font>
                            </button></a>


                          &nbsp;&nbsp;&nbsp;


                          <a href="?action=cancel&id=#" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-cancel" style="background-image: url(' img/icon/cancel-iceblue.svg')">
                              <font class="tn-in-text">Cancel</font>
                            </button></a>
                        </div>
                      </td>
                    </tr>


                  </tbody>

                </table>
              </div>
            </center>
          </td>
        </tr>



      </table>
    </div>


    <?php
    if ($_GET) {
      $action = $_GET["action"];
      if ($action == 'done') {

        echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="Appointment.php">&times;</a>
                        <div class="content">
                            You want to delete this record<br>().
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="Appointment.php?id=" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="Appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            ';
      } elseif ($action == 'view') {

        echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2></h2>
                        <a class="close" href=" Appointment.php">&times;</a>
                        
                        <div style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                  josh <br><br>
                                </td>
                                
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Email: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                @gmail.com <br><br>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Telephone: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                               12312312<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Category: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2"> Duo
                            <br><br>
                            </td>
                            </tr>

                             <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Specialties: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2"> 1/2/25 12:00 PM
                            <br><br>
                            </td>
                            </tr>

                             <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Payment Method: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2"> Gcash
                            <br><br>
                            </td>
                            </tr>



                            <tr>
                                <td colspan="2">
                                    <a href="Appointment.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                
                                    
                                </td>
                
                            </tr>
                           

                        </table>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';
      } elseif ($action == 'add') {
        $error_1 = $_GET["error"];
        if ($error_1 != '4') {
          echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                    
                        <a class="close" href="Appointment.php">&times;</a> 
                        <div style="display: flex;justify-content: center;">
                        <div class="abc-popup">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                                <td class="label-td" colspan="2"></td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Client.</p><br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                <form action="add-new.php" method="POST" class="add-new-form">
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="text" name="name" class="input-text" placeholder="Client Name" required><br>
                                </td>
                                
                            </tr>
                           
                          
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Phone: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="tel" name="Tele" class="input-text" placeholder="Phone Number" required><br>
                                </td>
                            </tr>
                               <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="spec" class="form-label">Choose category: (Current )</label>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <select name="spec" id="" class="box">
                                            <option value="Trion">Trion</option>
                                            <option value="Duo">Duo</option>
                                            <option value="Solo">Solo</option>
                                            <option value="Quad">Quad</option>
                                            <option value="Deluxe">Deluxe</option>
                                            <option value="Group">Group</option>
                                            <option value="Graduate">Graduate</option>
                                            <option value="Package2">Package 2</option>
                                            <option value="Package3">Package 3</option>
                                            <option value="Package4">Package 4</option>
                                            <option value="Unopackage">Uno Package</option>
                                            <option value="Dospackage">Dos Package</option>
                                            <option value="Trespackage">Tres Package</option>
                                            <option value="Cuatropackage">Cuantro Package</option>
                                            <option value="Cincopackage">Cinco Package</option>
                                            <option value="Seispackage">Seis Package</option>
                                            

                                                   </select><br><br>
                                        </td>
                                    </tr>

                                     <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="date" class="form-label"> Date: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="datetime-local" id="datetime" class="input-text" name="datetime" required><br>
                                        </td>
                                    </tr>
                                   
                                   <tr>
                                        <td class="label-td" colspan="2">
                                            <form action="#" method="POST" class="add-new-form">
                                            <label for="Email" class="form-label">Email: </label>
                                            <input type="hidden" value="" name="id00">
                                            <input type="hidden" name="oldemail" value="" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                        <input type="email" name="email" class="input-text" placeholder="Email Address" value="" required><br>
                                        </td>
                                    </tr>
                            
                
                            <tr>
                                <td colspan="2">
                                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                
                                    <input type="submit" value="Add" class="login-btn btn-primary btn">
                                </td>
                
                            </tr>
                           
                            </form>
                            </tr>
                        </table>
                        </div>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';
        } else {
          echo '
                    <div id="popup1" class="overlay">
                            <div class="popup">
                            <center>
                            <br><br><br><br>
                                <h2>New Record Added Successfully!</h2>
                                <a class="close" href="Appointment.php">&times;</a>
                                <div class="content">
                                    
                                    
                                </div>
                                <div style="display: flex;justify-content: center;">
                                
                                <a href="Appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>

                                </div>
                                <br><br>
                            </center>
                    </div>
                    </div>
        ';
        }



        // /////////////////////////////////  END ADD   /////////////////////////
      } elseif ($action == 'edit') {

        echo '
                    <div id="popup1" class="overlay">
                            <div class="popup">
                            <center>
                            
                                <a class="close" href="Appointment.php">&times;</a> 
                                <div style="display: flex;justify-content: center;">
                                <div class="abc-popup">
                                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <tr>
                                        <td class="label-td" colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Edit Client Details.</p>
                                        Client ID :  (Auto Generated)<br><br>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        
                                        <td class="label-td" colspan="2">
                                            <label for="name" class="form-label">Name: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="name" class="input-text" placeholder="Client Name" value="" required><br>
                                        </td>
                                        
                                    </tr>
                                    
                                   
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="Tele" class="form-label">Phone: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="tel" name="Tele" class="input-text" placeholder="Telephone Number" value="" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="spec" class="form-label">Choose category: (Current )</label>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <select name="spec" id="" class="box">
                                            <option value="Trion">Trion</option>
                                            <option value="Duo">Duo</option>
                                            <option value="Solo">Solo</option>
                                            <option value="Quad">Quad</option>
                                            <option value="Deluxe">Deluxe</option>
                                            <option value="Group">Group</option>
                                            <option value="Graduate">Graduate</option>
                                            <option value="Package2">Package 2</option>
                                            <option value="Package3">Package 3</option>
                                            <option value="Package4">Package 4</option>
                                            <option value="Unopackage">Uno Package</option>
                                            <option value="Dospackage">Dos Package</option>
                                            <option value="Trespackage">Tres Package</option>
                                            <option value="Cuatropackage">Cuantro Package</option>
                                            <option value="Cincopackage">Cinco Package</option>
                                            <option value="Seispackage">Seis Package</option>
                                            

                                                   </select><br><br>
                                        </td>
                                    </tr>

                                     <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="date" class="form-label"> Appointment Date: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="datetime-local" id="datetime" class="input-text" name="datetime" required><br>
                                        </td>
                                    </tr>
                                   
                                   <tr>
                                        <td class="label-td" colspan="2">
                                            <form action="#" method="POST" class="add-new-form">
                                            <label for="Email" class="form-label">Email: </label>
                                            <input type="hidden" value="" name="id00">
                                            <input type="hidden" name="oldemail" value="" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                        <input type="email" name="email" class="input-text" placeholder="Email Address" value="" required><br>
                                        </td>
                                    </tr>
                                    
                        
                                    <tr>
                                        <td colspan="2">
                                            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                            <input type="submit" value="Save" class="login-btn btn-primary btn">
                                        </td>
                        
                                    </tr>
                                
                                    </form>
                                    </tr>
                                </table>
                                </div>
                                </div>
                            </center>
                            <br><br>
                    </div>
                    </div>
                    ';
      } else {
        echo '
                <div id="popup1" class="overlay">
                        <div class="popup">
                        <center>
                        <br><br><br><br>
                            <h2>Edit Successfully!</h2>
                            <a class="close" href="Appointment.php">&times;</a>
                            <div class="content">
                                
                                
                            </div>
                            <div style="display: flex;justify-content: center;">
                            
                            <a href="Appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>

                            </div>
                            <br><br>
                        </center>
                </div>
                </div>
    ';
      };
    };


    ?>




    <!-- <footer class="page-footer">
    
    </footer> -->
  </section>


  <script src="js/search-filter-appointment.js"></script>


</body>

</html>