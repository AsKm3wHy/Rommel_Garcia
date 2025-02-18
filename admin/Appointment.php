<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Dashboard</title>
  <link rel="stylesheet" href="css/appointment.css">
  <link rel="icon" href="img/Header-Pic/rommel-logo-v3.svg">
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

    <symbol id="gallery" viewBox="0 0 24 24">
      <path d="M24,6c0-2.2-1.8-4-4-4H4C1.8,2,0,3.8,0,6v12c0,2.2,1.8,4,4,4h16c2.2,0,4-1.8,4-4V6z M6,6c1.1,0,2,0.9,2,2   c0,1.1-0.9,2-2,2S4,9.1,4,8C4,6.9,4.9,6,6,6z M22,18c0,1.1-0.9,2-2,2H4.4c-0.9,0-1.3-1.1-0.7-1.7l3.6-3.6c0.4-0.4,1-0.4,1.4,0   l0.6,0.6c0.4,0.4,1,0.4,1.4,0l6.6-6.6c0.4-0.4,1-0.4,1.4,0l3,3c0.2,0.2,0.3,0.4,0.3,0.7V18z" />
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
          <a href="post.php">
            <svg>
              <use xlink:href="#gallery"></use>
            </svg>
            <span>Gallery</span>
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
        <table class="table-appointment" border="0">
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
              <p class="heading-sub12" id="currentDate">

              </p>
            </td>
            <td width="4%">
              <a href="calendar.php"> <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="img/calendar.svg" width="100%"></button></a>

            </td>


          </tr>

        </table>
      </div>


    </section>

    <div class="dash-body">
      <table class="table-appointment" border="0">


        <tr>
          <td colspan="2">
            <p class="heading-main12">Add New Client</p>
          </td>
          <td colspan="2">
            <a href="?action=add&id=none" class="non-style-link"><button class="login-btn btn-primary btn button-icon add-btn-table" style="display: flex;justify-content: center;align-items: center;margin-left:75px;background-image: url('img/icon/add.svg');">Add New</font></button>
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

                        <input name="status" type="text" value="Pending..." readonly style="text-align: center;" />
                      </td>


                      <td>
                        <div class="events-td">
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
                        <input name="status" type="text" value="Pending..." readonly style="text-align: center;" />
                      </td>

                      <td>
                        <div class="events-td">
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
                        <input name="status" type="text" value="Pending..." readonly style="text-align: center;" />
                      </td>

                      <td>
                        <div class="events-td">
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
                        <br><br><br><br>
                            <h2> Successfully Completed!</h2>
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
      } elseif ($action == 'cancel') {

        echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="Appointment.php">&times;</a>
                        <div class="content">
                            You want to Cancel this record<br>().
                            
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
                                <form action="" method="POST" class="add-new-form">
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="text" name="name" class="input-text" placeholder="Client Name" ><br>
                                </td>
                                
                            </tr>
                           
                          
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Phone: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="tel" name="Tele" class="input-text" placeholder="Phone Number" ><br>
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
                                            <input type="datetime-local" id="datetime" class="input-text" name="datetime" ><br>
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
                                        <input type="email" name="email" class="input-text" placeholder="Email Address" value="" ><br>
                                        </td>
                                    </tr>
                            
                
                            <tr>
                                <td colspan="2">
                                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                
                                    <a href="?action=added&id=123" class="non-style-link"> <input type="submit" value="Add" class="login-btn btn-primary btn"></a>
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
      } elseif ($action == 'added') {
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
  <script src="js/date.js"></script>


</body>

</html>