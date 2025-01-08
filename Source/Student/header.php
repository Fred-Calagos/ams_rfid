<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Monitoring System</title>
    <link rel="icon" type="image/x-icon" href="../../inc/logo-sys.png">
        <!----======== CSS ======== -->
        <link rel="stylesheet" href="../../assets/css/style.css">
        <link rel="stylesheet" href="../../assets/css/fonts.css">
        <link rel="stylesheet" href="../../assets/css/interface.css">
        <link rel="stylesheet" href="../../assets/vendor/fontawesome/font_v6/css/all.css">
        <!----===== Iconscout CSS ===== -->
        <link href="../../assets/vendor/fontawesome/web-fonts-with-css/css/fontawesome-all.css" rel="stylesheet">
        <!-- <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel='stylesheet'>
        <script src="https://cdn.lordicon.com/lordicon.js"></script> -->
        <script src="../../assets/Js/lordicon.js"></script>

                  <!-- Vendor CSS Files -->
        <link href="../../assets/vendor/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="../../assets/vendor/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="../../assets/vendor/vendor/quill/quill.snow.css" rel="stylesheet">
        <link href="../../assets/vendor/vendor/quill/quill.bubble.css" rel="stylesheet">
        <link href="../../assets/vendor/vendor/remixicon/remixicon.css" rel="stylesheet">
        <link href="../../assets/vendor/vendor/simple-datatables/style.css" rel="stylesheet">
        <!-- jQuery UI library -->
        <script src="../../assets/Js/jquery.js" type="text/javascript"></script>
        <link rel="stylesheet" href="../../assets/vendor/jquery/jquery-ui.css">
        <script src="../../assets/vendor/jquery/jquery-ui.min.js"></script>
        <script src="../../assets/vendor/jquery/jquery.min.js"></script>
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="../../Images/Student/Dark Blue Modern Professional Technology Company Logo.png" alt="">
            </div>

            <h1 class="logo_name">RFID AMS</h1>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="stud_dash.php">
                    <i class="fa-solid fa-chalkboard"></i>
                    <span class="link-name">Dashboard</span>
                </a></li>
                <li><a href="stud_profile.php">
                    <i class="fas fa-user"></i>
                    <span class="link-name">Profile</span>
                </a></li>
                <li><a href="stud_daily_att.php">
                    <i class="fas fa-list"></i>
                    <span class="link-name">Daily Attendance</span>
                </a></li>
                <li><a href="stud_class.php">
                    <i class="fas fa-list"></i>
                    <span class="link-name">Class Attendance</span>
                </a></li>
                <li><a href="stud_event_att.php">
                    <i class="fas fa-list"></i>
                    <span class="link-name">Event Attendance</span>
                </a></li>
            
            </ul>
            
            <ul class="logout-mode">
                <li><a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="link-name">Logout</span>
                </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>

                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>
    
</body>
</html>