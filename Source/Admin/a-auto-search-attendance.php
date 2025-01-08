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
        $query = "SELECT ag.*, CONCAT(ns.lname,', ',ns.fname,' ',ns.mname) AS studfname FROM `attendance_gate` AS ag
        LEFT JOIN new_students AS ns ON ag.student_id = ns.student_id
        WHERE ag.student_id LIKE '%".$search."%'
        OR ag.att_date LIKE '%".$search."%'
        OR CONCAT(ns.lname,', ',ns.fname,' ',ns.mname) LIKE '%".$search."%'

        ";
        }
    else    
    {
    $query = "SELECT ag.*, CONCAT(ns.lname,', ',ns.fname,' ',ns.mname) AS studfname FROM `attendance_gate` AS ag
    LEFT JOIN new_students AS ns ON ag.student_id = ns.student_id
    ORDER BY att_date DESC";
    }
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0)
        {
            $output .= '
                <section class="header">
                
                    <div class="items-controller">
                        <h5>Show</h5>
                        <select name="" id="itemperpage">
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="08">08</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                        </select>
                        <span>Per Page</span>
                        
                    </div><br>
                    
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
                    <th rowspan="2">Action</th>

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
            ';
            $n = 0;
        while($row_morning = mysqli_fetch_array($result))
        {
            $n++;
            $output .= '
            <tr>
                <td>'.$n.'</td>
                <td>'.$row_morning['student_id'].'</td>
                <td>'.$row_morning['studfname'].'</td>
                <td>'.$row_morning['att_date'].'</td>
                <td>'.$row_morning['log_status'].'</td>
                <td>'.$row_morning['amti'].'</td>
                <td>'.$row_morning['amto'].'</td>
                <td>'.$row_morning['am_log_in'].'</td>
                <td>'.$row_morning['am_log_out'].'</td>
                <td>'.$row_morning['am_status'].'</td>
                <td>'.$row_morning['pmti'].'</td>
                <td>'.$row_morning['pmto'].'</td>
                <td>'.$row_morning['pm_log_in'].'</td>
                <td>'.$row_morning['pm_log_out'].'</td>
                <td>'.$row_morning['pm_status'].'</td>
                <td><a href="a-attendance.php?gid='.$row_morning["gid"].'"><i class="fas fa-edit btn_edit1"></i></a></td>
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
