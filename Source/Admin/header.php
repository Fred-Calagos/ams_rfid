<?php
    // Assuming you have established your database connection
    // and stored it in a variable named $conn

    session_start();
    include "../../Inc/connect.php";

    // Check if the user is logged in
    if (!isset($_SESSION["username"])) {
        header("Location: ../../index.php");
        exit(); // Terminate script execution
    }

    // Check if the logged-in user is assigned an advisory
    $username = $_SESSION["username"];

    // Query to check if the username is assigned an advisory
    $query = "SELECT * FROM admin WHERE rfid_admin = ? AND authority = 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // If there's an error in the query execution, output the error
    if (!$result) {
        die("Query execution failed: " . $conn->error);
    }

    // If the user is not assigned an advisory, hide the link
    if ($result->num_rows == 0) {
        echo '<style>.adviserInput { display: none; }</style>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Monitoring System</title>
    <link rel="icon" class="icon" type="image/x-icon" href="../../inc/logo-sys2.png">

        <!----======== CSS ======== -->
        <link rel="stylesheet" href="../../assets/css/style.css">
        <link rel="stylesheet" href="../../assets/css/fonts.css">
        <link rel="stylesheet" href="../../assets/css/interface.css">
        <link rel="stylesheet" href="../../assets/css/attendance_reportFooter.css">
        <!-- <link rel="stylesheet" href="../../assets/css/bootstap.min.css"> -->
        <link rel="stylesheet" href="../../assets/vendor/fontawesome/font_v6/css/all.css">
        <!----===== Iconscout CSS ===== -->
        <link href="../../assets/vendor/fontawesome/web-fonts-with-css/css/fontawesome-all.css" rel="stylesheet">


          <!-- Vendor CSS Files -->
        <link href="../../assets/vendor/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="../../assets/vendor/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="../../assets/vendor/vendor/quill/quill.snow.css" rel="stylesheet">
        <link href="../../assets/vendor/vendor/quill/quill.bubble.css" rel="stylesheet">
        <link href="../../assets/vendor/vendor/remixicon/remixicon.css" rel="stylesheet">
        <link href="../../assets/vendor/vendor/simple-datatables/style.css" rel="stylesheet">

        <!-- JAVASCRIPT -->
        
        <!-- jQuery UI library -->
        <!-- <script src="../../assets/Js/bootstrap.min.js" type="text/javascript"></script> -->
        <script src="../../assets/Js/jquery.js" type="text/javascript"></script>
        <link rel="stylesheet" href="jquery-ui.css">
        <script src="jquery-ui.min.js"></script>


        <style>
            .icon {
                width: 32px;
                height: 32px;
                border-radius: 100px;
}
        </style>
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="../../inc/logo-sys2.png" alt="">
            </div>

            <h1 class="logo_name">RFID AMS</h1>
        </div>

        <div class="menu-items" >
            <ul class="nav-links" id="leftCol">
                <li><a href="admin_dash.php">
                    <i class="fa-solid fa-chalkboard"></i>
                    <span class="link-name">Dashboard</span>
                </a></li>

                <li><span class="link-title">ATTENDANCE</span></li>

                <li><a href="m-schedule.php">
                    <i class="fas fa-clock"></i>
                    <span class="link-name">Schedule</span>
                </a></li>

                <li><a href="a-attendance.php">
                    <i class="fas fa-list"></i>
                    <span class="link-name">Gate Attendance</span>
                </a></li>
                <li><a href="a-attendance-class.php">
                    <i class="fas fa-list"></i>
                    <span class="link-name">Class Attendance</span>
                </a></li>
                <li><a href="a-attendance-event.php">
                    <i class="fas fa-list"></i>
                    <span class="link-name">Event Attendance</span>
                </a></li>


                <li><span class="link-title">INPUTS</span></li>
                <li>
                    <div class="iocn-link">
                    <a href="#">
                        <i class='fas fa-book'></i>
                        <span class="link-name ">Manage</span>
                    </a>
                    <i class='fas fa-arrow-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a href="m-setup.php">Setup</a></li>
                        <li><a href="m-instructor.php">Create Adviser</a></li>
                        <li><a href="m-teacher.php">Create Teacher</a></li>
                        <li><a href="m-rfid.php">RFID Num</a></li>
                        <li><a href="m-student.php">Students</a></li>
                        <li><a href="m-school-info.php">School Info</a></li>
                    </ul>
                </li>
                <li class="adviserInput"><span class="link-title">END USER </span></li>
                <li class="adviserInput"><a href="m-user-acc.php">
                    <i class="bx bxs-user-account"></i>
                    <span class="link-name">User Account</span>
                </a></li>
                <li><span class="link-title">REPORTS AND LOGS</span></li>
                <li><a href="m-report.php">
                    <i class="fas fa-file"></i>
                    <span class="link-name">Reports</span>
                </a></li>
                <li><a href="logs.php">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span class="link-name">Activity Logs</span>
                </a></li>
                <li class="adviserInput"><span class="link-title">SETTING</span></li>
                <li class="adviserInput"><a href="m-setting.php">
                    <i class="fas fa-gear"></i>
                    <span class="link-name">setting</span>
                </a></li>
                
            </ul>
            
            <ul class="logout-mode">
                <li><a href="logout.php">
                    <i class="ri-logout-circle-line"></i>
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