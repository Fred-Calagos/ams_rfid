<?php
session_start();
include "header.php";
include "../../Inc/connect.php";

// Redirect if user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit();
}

// Fetch student information from the database
$username = $_SESSION['username'];

// Fetch student information from the database
$query = "SELECT * FROM new_students WHERE student_id = '$username'";
$result = mysqli_query($conn, $query);

if (!$result) {
    // Handle query execution error
    echo "Error executing query: " . mysqli_error($conn);
} else {
    $student = mysqli_fetch_assoc($result);

    // Check if search date is set
    if (isset($_POST['date']) && !empty($_POST['date'])) {
        $search_date = $_POST['date'];
        $attendance_query = "SELECT * FROM `attendance_gate` WHERE `student_id` = '$username' AND DATE(`att_date`) = '$search_date' ORDER BY `att_date` DESC";
    } else {
        // Fetch attendance record for the logged-in student
        $attendance_query = "SELECT * FROM `attendance_gate` WHERE `student_id` = '$username' ORDER BY `att_date` DESC";
    }

    $attendance_result = mysqli_query($conn, $attendance_query);

    // Check if any attendance records were found
    if (!$attendance_result) {
        // Handle query execution error
        echo "Error executing attendance query: " . mysqli_error($conn);
    } else {
        // Display table structure
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body>
        <div class="dashboard">
            <div class="top">
                <i class="fas fa-bars sidebar-toggle"></i>
            </div>
            <div class="dash-content">
                <div class="overview">
                    <div class="title">
                        <i class="fas fa-user"></i>
                        <span class="text">DAILY ATTENDANCE RECORD</span>
                    </div>
                </div>

                <!-------------------ATTENDANCE TABLE ------------------------ -->

                
                <div class="table-responsive">

                        <form action="" method="post">
                        <button type="submit" style="float:right;margin:0 10px;padding:10px;" class="btn_edit1">Search</button>
                        <input type="date" id="search-date" name="date" style="float:right;padding:10px;border:none;border-bottom:2px solid blue;outline:none;">
                        </form>
                            
                            <br><br><br>
                    <div class="scroll" style="overflow-x:auto;">
                    
                    <table class="table-container">
                    <thead>
                        <tr>
                            <th rowspan="2">No.</th>
                            <th rowspan="2">RFID No.</th>
                            <th rowspan="2">Name</th>
                            <th rowspan="2">Date</th>
                            <th rowspan="2">Status</th>
                            <th colspan="5">Morning</th>
                            <th colspan="5">Afternoon</th>
                        </tr>
                        <tr>
                            <th>TIME IN</th>
                            <th>LOG OUT</th>
                            <th>Login Count</th>
                            <th>Logout Count</th>
                            <th>AM Status</th>
                            <th>TIME IN</th>
                            <th>LOG OUT</th>
                            <th>Login Count</th>
                            <th>LogoutCount</th>
                            <th>PM Status</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php
                        $n = 0;
                        // Check if any attendance records were found
                        if (mysqli_num_rows($attendance_result) > 0) {
                            while ($row = mysqli_fetch_assoc($attendance_result)) {
                                $n++;
                                // Format the date
                                $formatted_date = date("F j, Y", strtotime($row['att_date']));
                                echo "<tr>
                                <td>{$n}</td>
                                <td>{$row['student_id']}</td>
                                <td>{$student['fname']} {$student['mname']} {$student['lname']}</td>
                                <td>{$formatted_date}</td>
                                <td>{$row['log_status']}</td>
                                <td>{$row['amti']}</td>
                                <td>{$row['amto']}</td>
                                <td>{$row['am_log_in']}</td>
                                <td>{$row['am_log_out']}</td>
                                <td>{$row['am_status']}</td>
                                <td>{$row['pmti']}</td>
                                <td>{$row['pmto']}</td>
                                <td>{$row['pm_log_in']}</td>
                                <td>{$row['pm_log_out']}</td>
                                <td>{$row['pm_status']}</td>
                            </tr>";
                            }
                        } else {
                            // No attendance records found
                            echo "<tr><td colspan='15'>No attendance records were found.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    </div>
                </div>
        </div>
    </div>
    <?php
            include "footer.php";
    }
}
?>
</body>
</html>
