<?php
session_start();
include '../../inc/connect.php';

date_default_timezone_set('Asia/Manila');

// Define your allowed attendance hours
$attendanceStart = '18:00:00';
$attendanceEnd = '23:00:00';

// Get the current time
$currentTime = date('H:i:s');

// Check if the current time is within the allowed attendance hours
if ($currentTime < $attendanceStart || $currentTime > $attendanceEnd) {
    // If not, return an error message or handle it accordingly
    echo json_encode(['error' => 'The attendance will start at 7:00 PM and end at 10:00 PM.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];

    $query = "SELECT `fname`, `mname`, `lname`, `barangay`, `images` FROM `new_students` WHERE `student_id` = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $fname = $row['fname'];
        $lname = $row['lname'];
        $mname = $row['mname'];
        $barangay = $row['barangay'];
        $images = $row['images'];

        $eveningAttendanceStart = '18:00:00';
        $eveningCutOff = '19:30:00';
        $eveningCutOffEnd = '22:00:00';

        $logoutEvening = '22:01:00';
        $logoutEveningEnd = '23:00:00';

        $currentTime = date('H:i:s');
        $currentDate = date('Y-m-d');
        
        $time_in_evening = null;
        $date = null;

        if ($currentTime >= $eveningAttendanceStart && $currentTime <= $eveningCutOff) {
            $date = $currentDate;
            $time_in_evening = $currentTime;
        } elseif ($currentTime >= $eveningCutOff && $currentTime <= $eveningCutOffEnd) {
            $date = $currentDate;
            $time_in_evening = $currentTime;
        } else {
            $date = $currentDate;
            $time_in_evening = $currentTime;
        }

        $checkQuery = "SELECT * FROM `event_attendance_evening` WHERE student_id = ? AND date = ?";
        $stmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($stmt, 'ss', $student_id, $currentDate);
        mysqli_stmt_execute($stmt);
        $checkResult = mysqli_stmt_get_result($stmt);

        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            if ($currentTime < $logoutEvening) {
                echo "You cannot log out yet. Please wait until $logoutEvening.";
            } else {
                $updateQuery = "UPDATE `event_attendance_evening` SET time_out_evening = ? WHERE student_id = ? AND time_out_evening IS NULL";
                $stmt = mysqli_prepare($conn, $updateQuery);
                mysqli_stmt_bind_param($stmt, 'ss', $currentTime, $student_id);
                mysqli_stmt_execute($stmt);
            } 
        } elseif ($currentTime >= $logoutEvening || $currentTime <= $logoutEveningEnd) {
            $insertQuery = "INSERT INTO `event_attendance_evening` (student_id, images, fname, mname, lname, barangay, date, time_in_evening) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertQuery);
            mysqli_stmt_bind_param($stmt, 'ssssssss', $student_id, $images, $fname, $mname, $lname, $barangay, $date, $time_in_evening);
            mysqli_stmt_execute($stmt);
        } else {
            $insertQuery = "INSERT INTO `event_attendance_evening` (student_id, images, fname, mname, lname, barangay, date, time_in_evening) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertQuery);
            mysqli_stmt_bind_param($stmt, 'sssssss', $student_id, $images, $fname, $mname, $lname, $barangay, $date, $time_in_evening);
            mysqli_stmt_execute($stmt);
        }

        $data = array(
            'fname' => $fname,
            'lname' => $lname,
            'images' => $images,
            'date' => $date,
            'time_in_afternoon' => $time_in_evening
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://stackpat   h.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>RFID Attendance</title>
</head>
<style>
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    display: flex;
    flex-direction: column;
    height: 100vh;
    background-color: #ecf0f1;
}

header {
    background-color: #e74c3c;
    color: #fff;
    padding: 20px;
    text-align: center;
    overflow: hidden;
    box-sizing: border-box;
}

h1 {
    display: inline-block;
    animation: runningText linear infinite;
    white-space: nowrap;
    overflow: hidden;
    animation-duration: 10s;
}

@keyframes runningText {
    0% {
        transform: translateX(160%);
    }
    100% {
        transform: translateX(-160%);
    }
}

main {
    display: flex;
    flex: 1;
    overflow: hidden;
}

#rightPanel {
    background-color: rgba(52, 152, 219, 0);
    color: #fff;
    padding: 20px;
    text-align: center;
    overflow: hidden;
    box-sizing: border-box;
    width: 20%;
    order: 2;
    height: 100vh; /* Set a fixed height to avoid overlap with the fixed box */
    position: relative; /* Set position relative to contain absolutely positioned elements */
    backdrop-filter: blur(10px);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

#rightImageContainer {
    display: flex;
    flex-direction: column-reverse; /* Change from column-reverse to column */
    overflow: hidden;
    align-items: center;
}

.rightImage {
    width: 100%;
    height: 150px;
    margin-bottom: 10px;
    padding-top: 10px;
    object-fit: cover;
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
    background: url('comp.jpg') center/cover;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 100%;
    height: 100vh; /* Occupy full height of the viewport */
}

#rfidcard {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
}

.aftbtn {
    margin-top: 10px;
    background-color: blue;
    margin: 5px;
    border: none;
    outline: none;
    padding: 10px 20px;
    cursor: pointer;
    color: #fff;
    transition: all 0.5s ease-in;
    text-decoration: none;
}

#permanentBox {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    box-sizing: border-box;
    width: 50%; /* Set a fixed width for the box */
    height: 300px; /* Set a fixed height for the box */
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    text-align: center; /* Center the text inside the box */
}

#img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

#imageBox {
    width: 150px;
    height: 200px;
    overflow: hidden;
}

p {
    color: white;
    margin: 0 10px; /* Adjust the margin as needed for spacing between paragraphs */
}
#liveDateTime {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}
</style>
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
                    <p id="evening_status"></p>
                </div>

            <input type="text" id="rfidcard">
            
        </div>
    </div>

    <div id="rightPanel">
    <div id="rightImageContainer" class="slideRight"></div>
</div>

</main>

<script src="js/jquery.min.js"></script>

<script>
    $(document).ready(function(){
    var isLoggedOut = false;
    $('#rfidcard').focus();
    $('body').mousemove(function(){
        $('#rfidcard').focus();
    });

    function updateDateTime() {
        var currentDate = new Date();
        var formattedDate = currentDate.toLocaleDateString();
        var formattedTime = currentDate.toLocaleTimeString();
        $('#liveDateTime').text('Current Date and Time: ' + formattedDate + ' ' + formattedTime);
        $('#time').load('time.php');
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);

    var currentImages = [];

    $('#rfidcard').keydown(function (event) {
        if (event.which === 13 && $(this).val().length >= 10) {
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
                    console.log(data);
                    if (data) {
                        $('#img').attr('src', data.images);
                        $('#fname').text('First Name: ' + data.fname);
                        $('#lname').text('Last Name: ' + data.lname);

                        if (data.time_out_evening) {
                            $('#time_out_evening').text('Logout Time: ' + data.time_out_evening);
                            isLoggedOut = true;
                            $('#rfidcard').prop('disabled', true);
                        } else {
                            $('#time_out_evening').text('');
                        }

                        $('#rightImageContainer').addClass('slideRight');

                        if (currentImages.indexOf(data.images) === -1) {
                            currentImages.push(data.images);

                            if (currentImages.length > 3) {
                                currentImages.shift();
                            }

                            updateRightPanel();
                        }

                        setTimeout(function () {
                            $('#rightImageContainer').removeClass('slideRight');
                        }, 1000);
                    } else {
                        $('#img').attr('src', '');
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

    function updateRightPanel() {
        $('#rightImageContainer').empty();
        for (var i = currentImages.length - 1; i >= 0; i--) {
            $('#rightImageContainer').append('<img class="rightImage" src="' + currentImages[i] + '" alt="Card image cap">');
        }
    }

    function resetCardData() {
        $('#img').attr('src', '');
        updateRightPanel();
        $('#fname').text('');
        $('#lname').text('');
        $('#evening_status').text('ATTENDANCE NOT ALLOWED OUTSIDE EVENING HOURS');
    }

    setTimeout(resetCardData, 3000);

    // Check attendance end time
    var attendanceEndTime = '23:00:00'; // Replace with your actual attendance end time
    if (currentTime >= attendanceEndTime) {
        isAttendanceEndTimePassed = true;
        // Refresh the page with a delay of 1 second if the attendance end time has passed
        setTimeout(function () {
            location.reload();
        }, 1000);
    }
});
</script>
</body>
</html>
