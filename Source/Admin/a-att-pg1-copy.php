<?php
session_start();
include '../../inc/connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the server's time zone
date_default_timezone_set('Asia/Manila'); // Replace 'Asia/Manila' with your desired time zone


// $current_Time = strtotime('13:45:00');
// $current_Date = strtotime('2024-03-29');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $query1=mysqli_query($conn,"SELECT * FROM att_sched order by id ASC");
    while($row1=mysqli_fetch_array($query1))
        {
            $am_ps = $row1['am_ps'];
            $am_ls = $row1['am_ls'];
            $amout = $row1['am_logout'];
            $pm_ps = $row1['pm_ps'];
            $pm_ls = $row1['pm_ls'];
            $pmout = $row1['pm_logout'];

        }

    // Query your database to retrieve the data based on the student_id value
    $query = "SELECT fname, mname, lname, barangay, images FROM new_students WHERE student_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $fname = $row['fname'];
        $lname = $row['lname'];
        $mname = $row['mname'];
        $address = $row['barangay'];
        $images = $row['images'];

        $amps   =$am_ps;
        $amls   =$am_ls;
        $am_out =$amout;
        $pmps   =$pm_ps;
        $pmls   =$pm_ls;
        $pm_out =$pmout;
        $currentTime = date('H:i:s');
        $currentDate = date('Y-m-d');
        // $currentTime = date('H:i:s', $current_Time);
        // $currentDate = date('Y-m-d', $current_Date);

        $new_login_count = 1;

        // Determine the login time and status for afternoon attendance 
        if ($currentTime >= $amps && $currentTime < $amls) {
            $login_date= $currentDate;
            $login_time = $currentTime;
            $record_status = "Present";
            $new_login_count;
            $log_status = "IN";
            $log_upt_in = "IN";
            $log_upt_out = "OUT";
            $current_logout = 0;
        } elseif ($currentTime >= $amls && $currentTime < $am_out) {
            $login_date= $currentDate;
            $login_time = $currentTime;
            $record_status = "Late";
            $new_login_count;
            $log_status = "IN";
            $log_upt_in = "IN";
            $log_upt_out = "OUT";
            $current_logout = 0;
            $not_logged = null;
        } elseif ($currentTime >= $am_out && $currentTime < $pmps) {
            $login_date= $currentDate;  
            $login_time = $currentTime; 
            $record_status = "Absent";
            $new_login_count;
            $log_status = "IN";
            $log_upt_in = "IN";
            $log_upt_out = "OUT";
            $current_logout = 0;
            $not_logged = null;
        } elseif ($currentTime >= $pmps && $currentTime < $pmls) {
            $login_date = $currentDate;
            $login_time = $currentTime;
            $record_status = "Present";
            $no_am = "Absent";
            $new_login_count;
            $log_status = "IN";
            $log_upt_in = "IN";
            $log_upt_out = "OUT";
            $current_logout = 0;
            $not_logged = null;
        } elseif ($currentTime >= $pmls && $currentTime < $pm_out) {
            $login_date= $currentDate;
            $login_time = $currentTime;
            $record_status = "Late";
            $aft_rec_stat = "Present";
            $no_am = "Absent";
            $new_login_count;
            $log_status = "IN";
            $log_upt_in = "IN";
            $log_upt_out = "OUT";
            $current_logout = 0;
            $not_logged = null;
        } elseif ($currentTime >= $pm_out) {
            $login_date = $currentDate;
            $login_time = $currentTime;
            $no_am = "Absent";
            $new_login_count;
            $log_status = "IN";
            $log_upt_in = "IN";
            $log_upt_out = "OUT";
            $current_logout = 0;
            $not_logged = null;
        }
            // Check if the student is already logged in or logged out for afternoon attendance
            $checkQuery = "SELECT * FROM attendance_gate WHERE student_id = ? and att_date = ?";
            $stmt = mysqli_prepare($conn, $checkQuery);
            mysqli_stmt_bind_param($stmt, 'ss', $student_id, $currentDate);
            mysqli_stmt_execute($stmt);
            $checkResult = mysqli_stmt_get_result($stmt);

            if ($checkResult && mysqli_num_rows($checkResult) > 0) {
                $row2 = mysqli_fetch_assoc($checkResult);
                $mti1    = $row2['amti'];
                $mto1    = $row2['amto'];
                $m_in    = $row2['am_log_in'];
                $m_out   = $row2['am_log_out'];
                $am_stat = $row2['am_status'];
                $aftti1  = $row2['pmti']; 
                $aftto1  = $row2['pmto'];
                $aft_in  = $row2['pm_log_in'];
                $aft_out = $row2['pm_log_out'];
                $pm_stat = $row2['pm_status'];
                $l_status = $row2['log_status'];


                // MORNING LOGS

                    // UPDATE student log for m log in and l status if the l status is EQUAL TO OUT
                if (($currentTime >= $amls && $currentTime < $am_out  && $l_status == "OUT") || ($currentTime >= $amps && $currentTime < $amls  && $l_status == "OUT")) {
                    // The student is already logged out for MORNING attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_gate` SET am_log_in = $m_in + 1, log_status = ? WHERE student_id = ? AND att_date = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'sss',$log_upt_in, $student_id, $currentDate);
                    mysqli_stmt_execute($stmt);

                    // UPDATE student log for m log in and l status if the l status is EQUAL TO IN
                } elseif (($currentTime >= $amls && $currentTime < $am_out && $l_status == "IN") || ($currentTime >= $amps && $currentTime < $amls && $l_status == "IN")) {
                    // The student is already logged out for MORNING attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_gate` SET am_log_out = $m_out + 1, log_status = ? WHERE student_id = ? AND att_date = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'sss',$log_upt_out, $student_id, $currentDate);
                    mysqli_stmt_execute($stmt);

                    /*  UPDATE student log if the currentTime is already >= time_out but less that pm  attendance start
                        this will update the time out of student in the morning if the amto is empty            */

                } elseif (($currentTime >= $am_out && $currentTime < $pmps) && $l_status == "IN" && empty($mto1)) {
                    // The student is already logged IN for MORNING attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_gate` SET am_log_out = $m_out + 1, amto = ?, log_status = ? WHERE student_id = ? AND att_date = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'ssss', $login_time, $log_upt_out, $student_id, $currentDate);
                    mysqli_stmt_execute($stmt);
                } elseif (($currentTime >= $am_out && $currentTime < $pmps) && $l_status == "OUT" && empty($mto1)) {
                    // The student is already logged IN for MORNING attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_gate` SET am_log_out = $m_in + 1, log_status = ? WHERE student_id = ? AND att_date = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'sss', $log_upt_in, $student_id, $currentDate);
                    mysqli_stmt_execute($stmt);
                }

                    // AFTERNOON LOGS

                    /*  if the student is already log out in the morning and the status is out, the studetn can also time time for the afternoon attendance.
                    For the reason of that some student will it their lunch in their classroom and we do not want to input a delay to for efficient attendance */

                    // BETWEEN AM OUT AND AFTERNOON TIME IN

                if (($currentTime >= $am_out && $currentTime < $pmps) && $l_status == "OUT" && !empty($mto1) && empty($pm_stat)) {
                    
                    $updateQuery = "UPDATE `attendance_gate` SET pmti = ?, pm_status = 'Present' , pm_log_in = ? , pm_log_out = ?, log_status = ? WHERE student_id = ? AND att_date = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'siisss',$login_time,$new_login_count, $current_logout, $log_upt_in, $student_id, $currentDate);
                    mysqli_stmt_execute($stmt);

                }elseif ((($currentTime >= $pmps && $currentTime < $pmls) && $l_status == "OUT" && empty($pm_stat)) || 
                        (($currentTime >= $pmls && $currentTime < $pm_out) && $l_status == "OUT" && empty($pm_stat))) {
                    
                    $updateQuery = "UPDATE `attendance_gate` SET pmti = ?, pm_status = ? , pm_log_in = ? , pm_log_out = ?, log_status = ? WHERE student_id = ? AND att_date = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'ssiisss',$login_time, $record_status, $new_login_count, $current_logout, $log_upt_in, $student_id, $currentDate);
                    mysqli_stmt_execute($stmt);

                    // UPDATE student log for m log in and l status if the l status is EQUAL TO IN
                } elseif    ((($currentTime >= $am_out && $currentTime < $pmps) && $l_status == "IN" &&!empty($pm_stat)) || 
                            (($currentTime >= $pmps && $currentTime < $pmls) && $l_status == "IN" &&  !empty($pm_stat)) ||
                            (($currentTime >= $pmls && $currentTime < $pm_out) && $l_status == "IN" && !empty($pm_stat))) {
                    
                    $updateQuery = "UPDATE `attendance_gate` SET pm_log_out = $aft_out + 1 , log_status = ? WHERE student_id = ? AND att_date = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'sss',$log_upt_out, $student_id, $currentDate);
                    mysqli_stmt_execute($stmt);

                    // UPDATE student log for m log in and l status if the l status is EQUAL TO IN
                } elseif  ((($currentTime >= $am_out && $currentTime < $pmps) && $l_status == "OUT" && !empty($pm_stat)) ||
                            (($currentTime >= $pmps && $currentTime < $pmls) && $l_status == "OUT" && !empty($pm_stat)) ||
                            (($currentTime >= $pmls && $currentTime < $pm_out) && $l_status == "OUT" && !empty($pm_stat))) {
                    
                    $updateQuery = "UPDATE `attendance_gate` SET pm_log_in = $aft_in + 1 , log_status = ? WHERE student_id = ? AND att_date = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'sss',$log_upt_in, $student_id, $currentDate);
                    mysqli_stmt_execute($stmt);

                    // UPDATE student log for m log in and l status if the l status is EQUAL TO IN
                }  elseif ($currentTime >= $pm_out && $l_status == "IN") {
                    // The student is already logged IN for MORNING attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_gate` SET pm_log_out = $aft_out + 1, pmto = ?, log_status = ? WHERE student_id = ? AND att_date = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'ssss', $login_time, $log_upt_out, $student_id, $currentDate);
                    mysqli_stmt_execute($stmt);
                } elseif ($currentTime >= $pm_out && $l_status == "OUT") {
                    // The student is already logged IN for MORNING attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_gate` SET pm_log_in = $aft_in + 1, log_status = ? WHERE student_id = ? AND att_date = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'sss', $log_upt_out, $student_id, $currentDate);
                    mysqli_stmt_execute($stmt);
                }

                // STUDENT MORNING TIME IN ON TIME OR LATE
            } elseif (($currentTime >= $amps && $currentTime < $amls) || ($currentTime >= $amls && $currentTime < $am_out)) {
                // The student is not logged in for afternoon attendance, so insert a new record
                $insertQuery = "INSERT INTO `attendance_gate` (student_id,att_date, log_status, amti,am_log_in,am_log_out,am_status) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_status')");
                $stmt = mysqli_prepare($conn, $insertQuery);
                mysqli_stmt_bind_param($stmt, 'sssssss', $student_id, $login_date, $log_status, $login_time, $new_login_count, $current_logout, $record_status);
                mysqli_stmt_execute($stmt);


                /*STUDENT LOG IN DURING LOG OUT TIME OF MORNING :: MORNING STATUS WILL BE ABSENT, 
                SO IT AUTOMATICALLY TIME IN FOR THE AFTERNOON :: AFTERNOON STATUS WILL BE PRESENT*/

                // STUDENT AFTERNOON TIME IN DURING ON TIME OR LATE
            } elseif (($currentTime >= $am_out && $currentTime < $pmps) || ($currentTime >= $pmps && $currentTime < $pmls) || ($currentTime >= $pmls && $currentTime < $pm_out) ) {
                // The student is not logged in for afternoon attendance, so insert a new record
                $insertQuery = "INSERT INTO `attendance_gate` (student_id,att_date, log_status, amti,amto,am_log_in,am_log_out,am_status,pmti,pm_log_in,pm_log_out,pm_status) VALUES (?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?)";
                $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_status')");
                $stmt = mysqli_prepare($conn, $insertQuery);
                mysqli_stmt_bind_param($stmt, 'sssssssssiis', $student_id, $login_date, $log_status, $not_logged,  $not_logged,  $not_logged,  $not_logged, $no_am, $login_time, $new_login_count, $current_logout, $record_status);
                mysqli_stmt_execute($stmt);
            } elseif (($currentTime >= $am_out && $currentTime < $pmls) || ($currentTime >= $pmls && $currentTime < $pm_out) ) {
                // The student is not logged in for afternoon attendance, so insert a new record
                $insertQuery = "INSERT INTO `attendance_gate` (student_id,att_date, log_status, amti,amto,am_log_in,am_log_out,am_status,pmti,pm_log_in,pm_log_out,pm_status) VALUES (?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?)";
                $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_status')");
                $stmt = mysqli_prepare($conn, $insertQuery);
                mysqli_stmt_bind_param($stmt, 'sssssssssiis', $student_id, $login_date, $log_status, $not_logged,  $not_logged,  $not_logged,  $not_logged, $no_am, $login_time, $new_login_count, $current_logout, $record_status);
                mysqli_stmt_execute($stmt);
            } elseif ($currentTime >= $pm_out) {
                // The student is not logged in for afternoon attendance, so insert a new record
                $insertQuery = "INSERT INTO `attendance_gate` (student_id,att_date, log_status, amti,amto,am_log_in,am_log_out,am_status,pmti,pm_log_in,pm_log_out,pm_status) VALUES (?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?)";
                $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_status')");
                $stmt = mysqli_prepare($conn, $insertQuery);
                mysqli_stmt_bind_param($stmt, 'ssssssssssss', $student_id, $login_date, $log_status, $not_logged,  $not_logged,  $not_logged,  $not_logged, $no_am, $not_logged, $not_logged, $not_logged, $no_am);
                mysqli_stmt_execute($stmt);
            }
        $data = array(
            'fname' => $fname,
            'lname' => $lname,
            'images' => $images,
            'att_date' => $login_date, // Pass the login/logout time to the client
            'log_status' => isset($row2['log_status']) ? ($l_status == 'IN' ? $log_upt_out : $log_upt_in) : $log_status // Pass the attendance status to the client
        );
        echo json_encode($data);
    } else {
        echo json_encode(null);
    }
    exit();
}
?>
<?php 
    // Automatically record student if they did not log in 
    $day_out_time = strtotime('17:10:00');
    $dateDaily = date('Y-m-d');
    // Check if the current time is after 8:10 PM
    if (time() > $day_out_time) {
        $A_status = "Absent";
        $not_log = null;
        
        // Query students who are present in new_students but absent in attendance_gate for the specific date
        $query = "SELECT ns.student_id 
                FROM new_students ns 
                LEFT JOIN attendance_gate ag 
                ON ns.student_id = ag.student_id AND ag.att_date = ?
                WHERE ag.student_id IS NULL"; // Added condition to check for the specific date or if no record exists for the student
                
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $dateDaily);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        // Insert records for absent students
        if($result && mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)) {
                $student_id = $row['student_id'];
                $insertQuery = "INSERT INTO attendance_gate (student_id, att_date, log_status, amti, amto, am_log_in, am_log_out, am_status, pmti, pmto, pm_log_in, pm_log_out, pm_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $insertQuery);
                mysqli_stmt_bind_param($stmt, 'sssssssssssss', $student_id, $dateDaily, $not_log, $not_log, $not_log, $not_log, $not_log, $A_status, $not_log, $not_log, $not_log, $not_log, $A_status);
                mysqli_stmt_execute($stmt);
            }
        }
    
    }

    // Close database connection
    mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="../../assets/vendor/jquery/jquery.min.js"></script>        
    <link rel="stylesheet" href="../../assets/css/portal.css">
    <link rel="stylesheet" href="../../assets/css/clock.css">
    
    <title>GATE Attendance</title>

    <script src="">

    </script>
</head>

<body>
<header>
    <h1>-Welcome To Canipaan National High School-</h1>
</header>
    
<main>
<div id="MyClockDisplay" class="clock" onload="showTime()"></div>
    <div id="card">
    
        <div id="card-body">
            <div id="permanentBox">
                <div id="imageBox">
                    <img class="card-img-top" alt="Card image cap" id="img">
                </div>
            </div>

            <div id="info-box">
                    <p id="fname"></p>
                    <p id="lname"></p>
                    <p id="status"></p>
                </div>
                <div class="default">
                    <h1 id="default_message"></h1>
                </div>
            <input type="text" id="rfidcard">
        </div>
    </div>

    <div id="rightPanel">
    <div id="rightImageContainer" class="slideRight"></div>
</div>

</main>
    <script src="../../assets/Js/clock.js" type="text/javascript"></script>
    <script src="../../assets/jquery/jquery.min.js"></script>
    
    <script>
        $(document).ready(function(){

            var isLoggedOut = false;
            
            $('#rfidcard').focus();
            $('body').mousemove(function(){
                $('#rfidcard').focus();
            });

            // Function to update the real-time date and time
            function updateDateTime() {
                $('#time').load('time.php'); // Fetch the real-time date and time from time.php and update the 'time' paragraph
            }

            // Call the updateDateTime function initially and every 1 second (1000 milliseconds)
            updateDateTime(); // Call the function initially to show the real-time date and time
            setInterval(updateDateTime, 1000);

            var currentImages = [];

            $('#rfidcard').keydown(function (event) {
                if (event.which === 13 && $(this).val().length >= 10) { // Check for Enter key (keyCode 13)
                    if (isLoggedOut) {
                        console.log("Already logged out. Cannot tap again.");
                        return;
                    }

                    var student_id = $(this).val();

                    $.ajax({
                        url: window.location.href,
                        type: 'POST',
                        data: { student_id: student_id },
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                $('#img').attr('src', data.images);
                                $('#fname').text('First Name: ' + data.fname);
                                $('#lname').text('Last Name: ' +data.lname);
                                $('#status').text('Log Status: ' +data.log_status);
                                

                                // Trigger animation when card data is loaded
                                $('#rightImageContainer').addClass('slideRight');

                                // Update the right panel
                                if (currentImages.indexOf(data.images) === -1) {
                                // Add the new image to the array
                                currentImages.push(data.images);

                                // Limit the number of images to 3
                                if (currentImages.length > 2) {
                                // Remove the oldest image
                                currentImages.shift();
                                }

                                updateRightPanel();
                                }

                                // Reset animation class after a delay (adjust the delay as needed)
                                setTimeout(function () {
                                $('#rightImageContainer').removeClass('slideRight');
                                }, 1000); // 1 second delay
                            
                            } else {
                                $('#img').attr('src', '');  // Clear the image source
                                $('#fname').text('Unknown');
                                $('#lname').text('Unknown');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log('AJAX Error:', textStatus, errorThrown);
                        }
                    });
                    $(this).val('');
                }
        });
    // Modify the updateDateTime function to update the live time and date
    function updateDateTime() {
    // Get the current date and time
    var currentDate = new Date();
    var formattedDate = currentDate.toLocaleDateString();
    var formattedTime = currentDate.toLocaleTimeString();

        // Display the live time and date
        $('#liveDateTime').text('Current Date and Time: ' + formattedDate + ' ' + formattedTime);

        // Load the real-time date and time from time.php
        $('#time').load('time.php');
    }

    // Call the updateDateTime function initially and every 1 second (1000 milliseconds)
    updateDateTime(); // Call the function initially to show the real-time date and time
    setInterval(updateDateTime, 1000); // Refresh the live time and date every second


        // Function to update the right panel
        // Function to update the right panel
    function updateRightPanel() {
    $('#rightImageContainer').empty();
    for (var i = currentImages.length - 1; i >= 0; i--) {
        $('#rightImageContainer').append('<img class="rightImage" src="' + currentImages[i] + '" alt="Card image cap">');
    }
}

        // Automatically reset the card data to default after 3 seconds
        function resetCardData() {
            // Check if data is empty, if so, do not reset
            if (!$.isEmptyObject(data)) {
                $('#img').attr('src', '');  // Clear the image source
                updateRightPanel();
                $('#fname').text('');
                $('#lname').text('');
                $('#status').text('');
                $('#default_message').text('TAP YOUR RFID');

                // Show 'Loading...' for morning status
                console.log('Reset');
            }
        }
        // Call the resetCardData function after 3 seconds
        setTimeout(resetCardData, 3000); // 3 seconds
    });

    // Reload the page every 5 seconds (5000 milliseconds)
        setInterval(function(){
            location.reload();
        }, 5000);

    </script>
</body>
</html>