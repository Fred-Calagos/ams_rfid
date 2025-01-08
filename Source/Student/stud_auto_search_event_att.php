<?php
session_start();
include "../../Inc/connect.php";


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$output = '';

if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit();
}

$username = $_SESSION['username'];
$search = isset($_POST["query"]) ? mysqli_real_escape_string($conn, $_POST["query"]) : '';

$query = "SELECT attendance_event.*, new_students.fname, new_students.mname, new_students.lname, event_sched.event_name, event_sched.event_date 
            FROM `attendance_event` 
            INNER JOIN `new_students` ON attendance_event.stud_rfid = new_students.student_id
            INNER JOIN `event_sched` ON attendance_event.eid = event_sched.id
            WHERE (stud_rfid LIKE '%$search%' OR event_name LIKE '%$search%' OR fname LIKE '%$search%') AND new_students.student_id = '$username'";

$result = mysqli_query($conn, $query);

$output .= '
<br><br>
<div class="scroll" style="overflow-x:auto;">
    <table class="table-container">
        <thead>
            <tr>
                <th rowspan="2">Event Name</th>
                <th rowspan="2">Date</th>
                <th rowspan="2">RFID No.</th>
                <th rowspan="2">Name</th>
                <th rowspan="2">Log Status</th>
                <th colspan="4">Morning</th>
                <th colspan="4">Afternoon</th>
                <th colspan="4">Evening</th>
            </tr>
            <tr>
                <th>TIME IN</th>
                <th>LOG OUT</th>
                <th>Login Count</th>
                <th>LogoutCount</th>
                <th>TIME IN</th>
                <th>LOG OUT</th>
                <th>Login Count</th>
                <th>LogoutCount</th>
                <th>TIME IN</th>
                <th>LOG OUT</th>
                <th>Login Count</th>
                <th>LogoutCount</th>
            </tr>
        </thead>
';

if (mysqli_num_rows($result) > 0) {
    while ($row_morning = mysqli_fetch_array($result)) {
        // Format date
        $formatted_date = date("F j, Y", strtotime($row_morning['event_date']));

        $output .= '
        <tr>
            <td>' . $row_morning['event_name'] . '</td>
            <td>' . $formatted_date . '</td>
            <td>' . $row_morning['stud_rfid'] . '</td>
            <td>' . $row_morning['fname'] . ' ' . $row_morning['mname'] . ' ' . $row_morning['lname'] . '</td>
            <td>' . $row_morning['l_status'] . '</td>
            <td>' . $row_morning['mti'] . '</td>
            <td>' . $row_morning['mto'] . '</td>
            <td>' . $row_morning['m_log_in'] . '</td>
            <td>' . $row_morning['m_log_out'] . '</td>
            <td>' . $row_morning['aftti'] . '</td>
            <td>' . $row_morning['aftto'] . '</td>
            <td>' . $row_morning['aft_log_in'] . '</td>
            <td>' . $row_morning['aft_log_out'] . '</td>
            <td>' . $row_morning['eveti'] . '</td>
            <td>' . $row_morning['eveto'] . '</td>
            <td>' . $row_morning['eve_log_in'] . '</td>
            <td>' . $row_morning['eve_log_out'] . '</td>
        </tr>
        ';
    }
} else {
    $output .= '<tr><td colspan="17">No attendance records were found.</td></tr>';
}

$output .= '
    </table>
</div>
';

echo $output;
?>
</body>
</html>
