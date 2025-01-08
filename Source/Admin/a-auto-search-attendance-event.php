<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/interface.css">
</head>
<body>
<?php
//fetch.php
include("../../Inc/connect.php");
$output = '';
$pagi = '';

    if(isset($_POST["query"]))
        {
        $search = mysqli_real_escape_string($conn, $_POST["query"]);
        $query = "SELECT attendance_event.*, new_students.fname, new_students.mname, new_students.lname, event_sched.event_name, event_sched.event_date FROM `attendance_event` 
        INNER JOIN `new_students` ON attendance_event.stud_rfid = new_students.student_id
        INNER JOIN `event_sched` ON attendance_event.eid = event_sched.id
        WHERE stud_rfid LIKE '%".$search."%'
        OR event_name LIKE '%".$search."%'
        OR fname LIKE '%".$search."%'
        OR mname LIKE '%".$search."%'
        OR lname LIKE '%".$search."%'
        ";
        }
    else
    {
    $query = "SELECT attendance_event.*, new_students.fname, new_students.mname, new_students.lname, event_sched.event_name, event_sched.event_date FROM `attendance_event` 
                INNER JOIN `new_students` ON attendance_event.stud_rfid = new_students.student_id
                INNER JOIN `event_sched` ON attendance_event.eid = event_sched.id
                ORDER BY id DESC";
    }
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0)
        {
            $output .= '
            <div class="table-responsivess" >
                <section class="header">
                
                    <div class="items-controller">
                        <h5>Show</h5>
                        <select name="" id="itemperpage">
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="08">08</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                        </select>
                        <span>Per Page</span>
                        
                    </div><br>
                    
                    <div class="scroll" style="overflow-x:auto;">
                    
            <table class="table-container">
                <thead>
                <tr>
                    <th rowspan="2">Event Name</th>
                    <th rowspan="2">Date</th>
                    <th rowspan="2">RFID No.</th>
                    <th rowspan="2">Name</th>
                    <th rowspan="2">Log Status</th>
                    <th colspan = "4">Morning</th>
                    <th colspan = "4">Afternoon</th>
                    <th colspan = "4">Evening</th>
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
            $n = 0;
        while($row_morning = mysqli_fetch_array($result))
        {
            
            $output .= '
            <tr>
                <td>'.$row_morning['event_name'].'</td>
                <td>'.$row_morning['event_date'].'</td>
                <td>'.$row_morning['stud_rfid'].'</td>
                <td>'.$row_morning['fname'].' '.$row_morning['mname'].' '.$row_morning['lname'].'</td>
                <td>'.$row_morning['l_status'].'</td>
                <td>'.$row_morning['mti'].'</td>
                <td>'.$row_morning['mto'].'</td>
                <td>'.$row_morning['m_log_in'].'</td>
                <td>'.$row_morning['m_log_out'].'</td>
                <td>'.$row_morning['aftti'].'</td>
                <td>'.$row_morning['aftto'].'</td>
                <td>'.$row_morning['aft_log_in'].'</td>
                <td>'.$row_morning['aft_log_out'].'</td>
                <td>'.$row_morning['eveti'].'</td>
                <td>'.$row_morning['eveto'].'</td>
                <td>'.$row_morning['eve_log_in'].'</td>
                <td>'.$row_morning['eve_log_out'].'</td>
                
            </tr>
            ';
        }
        $output .= '
            </table>
                </div> 
                <div class="bottom-field">      
                    <ul class="pagination">
                        <li class="prev\"><a href="#" id="prev">&#139;</a></li>
                            <!-- page number here -->
                        <li class="next"><a href="#" id="next">&#155;</a></li>
                    </ul>
                
            </div>
        </div>
        <script src="../../assets/js/main.js"></script>
        
    ';

            echo $output;
        }
    else
        {
                echo 'Data Not Found';
        }

    ?>

</body>
</html>
