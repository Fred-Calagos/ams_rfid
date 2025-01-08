<?php
session_start();
include '../../inc/connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the server's time zone
// date_default_timezone_set('Asia/Manila'); // Replace 'Asia/Manila' with your desired time zone
// // date_default_timezone_set('America/Denver');
$currentDateTime = strtotime('13:45:00');
$timestamp = strtotime('2024-03-29');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $event_id = $_GET['view_id'];
    $query1=mysqli_query($conn,"SELECT * FROM event_sched WHERE id = '$event_id' order by id ASC");
    while($row1=mysqli_fetch_array($query1))
        {
            $eid   = $row1['id'];
            $event = $row1['event_name'];
            $date  = $row1['event_date'];
            $mti   = $row1['am_ti'];
            $mto   = $row1['am_to'];
            $aftti = $row1['pm_ti'];
            $aftto = $row1['pm_to'];
            $eveti = $row1['eve_ti'];
            $eveto = $row1['eve_to'];

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

        $mor_ti = $mti;
        $mor_to = $mto;
        $aft_ti = $aftti;
        $aft_to = $aftto;
        $eve_ti = $eveti;
        $eve_to = $eveto;

        // $currentTime = date('H:i:s');
        // $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s', $currentDateTime);
        $currentDate = date('Y-m-d', $timestamp);
        // AFTERNOON
        $login_time_afternoon = null;
        $login_date_afternoon = null;
        $logout_time_afternoon = null;
        $new_login_count = 1;

        // Determine the login time and status for afternoon attendance 
        if ($currentTime >= $mor_ti && $currentTime < $mor_to) {
            $login_date= $currentDate;
            $login_time = $currentTime;
            $new_login_count;
            $log_status = "IN";
            $log_upt_in = "IN";
            $log_upt_out = "OUT";
            $current_logout = 0;
        } elseif ($currentTime >= $mor_to && $currentTime < $aft_ti) {
            $login_date= $currentDate;
            $login_time = $currentTime;
            $new_login_count;
            $log_status = "IN";
            $log_upt_in = "IN";
            $log_upt_out = "OUT";
            $current_logout = 0;
            $not_logged = "-";
        }elseif ($currentTime >= $aft_ti && $currentTime < $aft_to) {
            $login_date = $currentDate;
            $login_time = $currentTime;
            $new_login_count;
            $log_status = "IN";
            $log_upt_in = "IN";
            $log_upt_out = "OUT";
            $current_logout = 0;
            $not_logged = "-";
        }elseif ($currentTime >= $aft_to && $currentTime < $eve_ti) {
            $login_date= $currentDate;
            $login_time = $currentTime;
            $new_login_count;
            $log_status = "IN";
            $log_upt_in = "IN";
            $log_upt_out = "OUT";
            $current_logout = 0;
            $not_logged = "-";
        }elseif ($currentTime >= $eve_ti && $currentTime < $eve_to) {
            $login_date = $currentDate;
            $login_time = $currentTime;
            $new_login_count;
            $log_status = "IN";
            $log_upt_in = "IN";
            $log_upt_out = "OUT";
            $current_logout = 0;
            $not_logged = "-";
        }elseif ($currentTime >= $eve_to) {
            $login_date = $currentDate;
            $login_time = $currentTime;
            $new_login_count;
            $log_status = "IN";
            $log_upt_in = "IN";
            $log_upt_out = "OUT";
            $current_logout = 0;
            $not_logged = "-";
        }

            // Check if the student is already logged in or logged out for afternoon attendance
            $checkQuery = "SELECT * FROM attendance_event WHERE stud_rfid = ? and eid = ?";
            $stmt = mysqli_prepare($conn, $checkQuery);
            mysqli_stmt_bind_param($stmt, 'ss', $student_id, $eid);
            mysqli_stmt_execute($stmt);
            $checkResult = mysqli_stmt_get_result($stmt);
        
            if ($checkResult && mysqli_num_rows($checkResult) > 0) {
                $row2 = mysqli_fetch_assoc($checkResult);
                $mti1    = $row2['mti'];
                $mto1    = $row2['mto'];
                $aftti1  = $row2['aftti']; 
                $aftto1  = $row2['aftto'];
                $eveti1  = $row2['eveti'];
                $eveto1  = $row2['eveto'];
                $m_in    = $row2['m_log_in'];
                $m_out   = $row2['m_log_out'];
                $aft_in  = $row2['aft_log_in'];
                $aft_out = $row2['aft_log_out'];
                $eve_in  = $row2['eve_log_in'];
                $eve_out = $row2['eve_log_out']; 
                $l_status = $row2['l_status'];

                // MORNING LOGS

                if ($currentTime >= $mor_ti && $currentTime < $mor_to && $l_status == "OUT") {
                    // The student is already logged in for afternoon attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_event` SET m_log_in = $m_in + 1, l_status = ? WHERE stud_rfid = ? AND eid = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'sss',$log_upt_in, $student_id, $eid);
                    mysqli_stmt_execute($stmt);
                } elseif($currentTime >= $mor_ti && $currentTime < $mor_to && $l_status == "IN"){
                    // The student is already logged in for afternoon attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_event` SET m_log_out = $m_out + 1, l_status = ? WHERE stud_rfid = ? AND eid = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'sss',$log_upt_out, $student_id, $eid);
                    mysqli_stmt_execute($stmt);
                } elseif($currentTime >= $mor_to && $currentTime < $aft_to && ($l_status == "IN" || $l_status ="OUT") && empty($mto1)){
                    // The student is already logged in for afternoon attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_event` SET m_log_out = $m_out + 1, mto = ?, l_status = ? WHERE stud_rfid = ? AND eid = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'ssss',$login_time, $log_upt_out, $student_id, $eid);
                    mysqli_stmt_execute($stmt);
                }

                // AFTERNOON LOGS



                if ((($currentTime >= $mor_to || $currentTime >= $aft_ti) && $currentTime < $aft_to) && (!empty($mti1) && !empty($mto1)) && empty($aftti1) && $l_status == "OUT") {

                    // The student is already logged in for afternoon attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_event` SET aft_log_in = $aft_in + 1, aftti = ?, l_status = ? WHERE stud_rfid = ? AND eid = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'ssss',  $login_time,$log_upt_in,$student_id, $eid);
                    mysqli_stmt_execute($stmt);
                }elseif((($currentTime >= $mor_to || $currentTime >= $aft_ti) && $currentTime < $aft_to) && (!empty($mti1) && !empty($mto1)) && !empty($aftti1) && $l_status == "IN") {

                    // The student is already logged in for afternoon attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_event` SET aft_log_out = $aft_out + 1, l_status = ? WHERE stud_rfid = ? AND eid = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'sss', $log_upt_out,$student_id, $eid);
                    mysqli_stmt_execute($stmt);
                }elseif((($currentTime >= $mor_to || $currentTime >= $aft_ti) && $currentTime < $aft_to) && (!empty($mti1) || !empty($mto1)) && !empty($aftti1) && $l_status == "OUT") {

                    // The student is already logged in for afternoon attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_event` SET aft_log_in = $aft_in + 1, l_status = ? WHERE stud_rfid = ? AND eid = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'sss',  $log_upt_in,$student_id, $eid);
                    mysqli_stmt_execute($stmt);
                } elseif($currentTime >= $aft_to && $currentTime < $eve_to && ($l_status == "IN" || $l_status ="OUT") && empty($aftto1)){
                    // The student is already logged in for afternoon attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_event` SET aft_log_out = $aft_out + 1, aftto = ?, l_status = ? WHERE stud_rfid = ? AND eid = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'ssss',$login_time, $log_upt_out, $student_id, $eid);
                    mysqli_stmt_execute($stmt);
                }

                // EVENING LOGS

                if ((($currentTime >= $aft_to || $currentTime >= $eve_ti) && $currentTime < $eve_to) && (!empty($aftti1) && !empty($aftto1)) && empty($eveti1) && $l_status == "OUT") {

                    // The student is already logged in for afternoon attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_event` SET eve_log_in = $eve_in + 1, eveti = ?, l_status = ? WHERE stud_rfid = ? AND eid = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'ssss',  $login_time,$log_upt_in,$student_id, $eid);
                    mysqli_stmt_execute($stmt);
                }elseif((($currentTime >= $aft_to || $currentTime >= $eve_ti) && $currentTime < $eve_to) && (!empty($aftti1) && !empty($aftto1)) && !empty($eveti1) && $l_status == "IN") {

                    // The student is already logged in for afternoon attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_event` SET eve_log_out = $eve_out + 1, l_status = ? WHERE stud_rfid = ? AND eid = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'sss', $log_upt_out,$student_id, $eid);
                    mysqli_stmt_execute($stmt);
                }elseif((($currentTime >= $aft_to || $currentTime >= $eve_ti) && $currentTime < $eve_to) && (!empty($aftti1) && !empty($aftto1)) && !empty($eveti1) && $l_status == "OUT") {

                    // The student is already logged in for afternoon attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_event` SET eve_log_in = $eve_in + 1, l_status = ? WHERE stud_rfid = ? AND eid = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'sss',  $log_upt_in,$student_id, $eid);
                    mysqli_stmt_execute($stmt);
                }  elseif($currentTime >= $eve_to && ($l_status == "IN" || $l_status ="OUT") && empty($eveto1)){
                    // The student is already logged in for afternoon attendance, so update the login count
                    $updateQuery = "UPDATE `attendance_event` SET eve_log_out = $eve_out + 1, eveto = ?, l_status = ? WHERE stud_rfid = ? AND eid = ?";
                    $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_upt_out')");
                    $stmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($stmt, 'ssss',$login_time, $log_upt_out, $student_id, $eid);
                    mysqli_stmt_execute($stmt);
                }


            
                // NEW ADDED ATTENDANCE

            } elseif ($currentTime >= $mor_ti && $currentTime < $mor_to) {
                // The student is not logged in for afternoon attendance, so insert a new record
                $insertQuery = "INSERT INTO `attendance_event` (eid,stud_rfid, mti, m_log_in, m_log_out,l_status) VALUES (?, ?, ?, ?, ?, ?)";
                $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_status')");
                $stmt = mysqli_prepare($conn, $insertQuery);
                mysqli_stmt_bind_param($stmt, 'ssssss', $eid, $student_id, $login_time, $new_login_count, $current_logout, $log_status);
                mysqli_stmt_execute($stmt);
            } elseif (($currentTime >=  $mor_to || $currentTime >= $aft_ti) && $currentTime < $aft_to) {
                // The student is not logged in for afternoon attendance, so insert a new record
                $insertQuery = "INSERT INTO `attendance_event` (eid,stud_rfid, mti, mto, m_log_in, m_log_out, aftti, aft_log_in, aft_log_out,l_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_status')");
                $stmt = mysqli_prepare($conn, $insertQuery);
                mysqli_stmt_bind_param($stmt, 'ssssssssss', $eid, $student_id, $not_logged, $not_logged, $not_logged, $not_logged,$login_time, $new_login_count, $current_logout, $log_status);
                mysqli_stmt_execute($stmt);
            } elseif (($currentTime >= $aft_to || $currentTime >= $eve_ti) && $currentTime < $eve_to) {
                // The student is not logged in for afternoon attendance, so insert a new record
                $insertQuery = "INSERT INTO `attendance_event` (eid,stud_rfid, mti, mto, m_log_in, m_log_out, aftti,aftto, aft_log_in, aft_log_out, eveti, eve_log_in, eve_log_out, l_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-in','$student_id','Logged $log_status')");
                $stmt = mysqli_prepare($conn, $insertQuery);
                mysqli_stmt_bind_param($stmt, 'ssssssssssssss', $eid, $student_id, $not_logged, $not_logged, $not_logged, $not_logged,$not_logged, $not_logged, $not_logged, $not_logged, $login_time, $new_login_count, $current_logout, $log_status);
                mysqli_stmt_execute($stmt);
            } 


        $data = array(
            'fname' => $fname,
            'lname' => $lname,
            'images' => $images,
            // 'att_date' => $login_date_afternoon, // Pass the login/logout time to the client
            // 'mti' => $login_time, // Pass the  login time to the client
            'l_status' => isset($row2['l_status']) ? ($l_status == 'IN' ? $log_upt_out : $log_upt_in) : $log_status // Pass the attendance status to the client
        );
        echo json_encode($data);
    } else {
        echo json_encode(null);
    }
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="../../assets/vendor/jquery/jquery.min.js"></script>


    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>EVENT Attendance</title>
    <style>
        
body {
    margin: 0;
    padding: 0;
    font-family: 'Roboto', sans-serif;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background: linear-gradient(to right, #2c3e50, #3498db);
    color: #fff;
}

header {
    background-color: maroon;
    padding: 20px;
    text-align: center;
    box-sizing: border-box;
}

h1 {
    font-size: 2em;
    margin: 0;
}

main {
    display: flex;
    flex: 1;
    overflow: hidden;
}

#rightPanel {
    background-color: burlywood;
    color: #fff;
    padding: 20px;
    text-align: center;
    box-sizing: border-box;
    width: 20%;
    order: 2;
    position: relative;
    backdrop-filter: blur(10px);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

#rightImageContainer {
    display: flex;
    flex-direction: column;
    width: 100%;
    overflow: hidden;
    align-items: center;
    flex-shrink: 0; /* Prevent the container from shrinking */
}

.rightImage {
    width: 200px;
    height: 200px; /* Auto height to maintain aspect ratio */
    max-height: 300px; /* Set maximum height as needed */
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    margin-bottom: 15px;
}


#card {
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    box-sizing: border-box;
    flex: 1;
}

#card-body {
    /* background: url('comp.jpg') center/cover; */
    background-color: #000080;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 10px;
    background-color: rgba(255, 255, 255, 0.9);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    text-align: left;
    width: 100%;
    height: 100%;
}

#rfidcard {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
}

.aftbtn {
    margin-top: 10px;
    background-color: #e74c3c;
    margin: 5px;
    border: none;
    outline: none;
    padding: 10px 20px;
    cursor: pointer;
    color: #fff;
    transition: all 0.5s ease-in-out;
    text-decoration: none;
    border-radius: 4px;
}

#permanentBox {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    box-sizing: border-box;
    width: 0%;
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    margin-bottom: 20px;
    text-align: center;
}

#img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
}

#imageBox {
    width: 300px; /* Increased width for the center image */
    height: 300px; /* Increased height for the center image */
    overflow: hidden;
    border-radius: 50%;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

#info-box {
    padding: 15px;
    margin: 20px;
    max-width: 500px; /* Adjust width as needed */
}

#fname, #lname, #status {
    margin: 10px 0;
    color:#000080;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    font-size: large;
} 
#status {
    color: #39FF14;

}


#liveDateTime {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}
    </style>
</head>

<body>
<header>
    <div id="liveDateTime" class="text-white"></div>
    <h1>-Welcome To Canipaan National High School-</h1>
</header>
    
<main>
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

            <input type="text" id="rfidcard">
        </div>
    </div>

    <div id="rightPanel">
    <div id="rightImageContainer" class="slideRight"></div>
</div>

</main>

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
                                $('#status').text('Log Status: ' +data.l_status);
                                
                                // if (data.logout_time_afternoon) {
                                //     $('#logout_time_afternoon').text('Logout Time: ' + data.logout_time_afternoon);
                                //     isLoggedOut = true; // Set logout status to true
                                //     $('#rfidcard').prop('disabled', true); // Disable RFID input field
                                // } else {
                                //     $('#logout_time_afternoon'); // Clear the value if logout time is not set
                                // }

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
            $('#img').attr('src', '');  // Clear the image source
            updateRightPanel();
            $('#fname');
            $('#lname');
            $('#afternoon_status'); // Show 'Loading...' for morning status
        }
        // Call the resetCardData function after 3 seconds
        setTimeout(resetCardData, 3000); // 3 seconds
    });
    </script>
</body>
</html>