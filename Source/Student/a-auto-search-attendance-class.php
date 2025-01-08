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
        $query = "SELECT 
        ag.student_id, ag.cl_date AS clDate, CONCAT( t.t_ln,', ',t.t_fn,' ',t.t_mn) AS tName,
        CONCAT(ns.lname,', ', ns.fname, ' ', ns.mname) AS full_name,
        gr.stud_grade AS grName, sc.section_name AS secName, sy.sy_name AS syName
        FROM attendance_class AS ag
        LEFT JOIN teaching_load AS tl ON ag.id_tl = tl.id_tl
        LEFT JOIN teacher_info AS t ON tl.t_id = t.t_id
        LEFT JOIN teacher AS advId ON t.t_id = advId.t_id
        LEFT JOIN grade AS gr ON advId.grade = gr.grade_id
        LEFT JOIN section AS sc ON advId.section = sc.section_id
        LEFT JOIN new_students AS ns ON ag.student_id = ns.student_id
        LEFT JOIN school_year AS sy ON ns.sy_enrolled = sy.sy_id
        WHERE student_id LIKE '%".$search."%'s
        OR event_name LIKE '%".$search."%'
        OR fname LIKE '%".$search."%'
        OR mname LIKE '%".$search."%'
        OR lname LIKE '%".$search."%'
        ";
        }
    else
    {
    $query = "SELECT ag.*, ag.cl_date AS clDate, CONCAT(t.t_ln,', ',t.t_fn,' ',t.t_mn) AS tName, CONCAT(ns.lname,', ', ns.fname, ' ', ns.mname) AS full_name, gr.stud_grade AS grName, sc.section_name AS secName, sy.sy_name AS syName
    FROM attendance_class AS ag
    LEFT JOIN teaching_load AS tl ON ag.id_tl = tl.id_tl
    LEFT JOIN teacher_info AS t ON tl.t_id = t.t_id
    LEFT JOIN teacher AS advId ON t.t_id = advId.t_id
    LEFT JOIN grade AS gr ON advId.grade = gr.grade_id
    LEFT JOIN section AS sc ON advId.section = sc.section_id
    LEFT JOIN new_students AS ns ON ag.student_id = ns.student_id
    LEFT JOIN school_year AS sy ON ns.sy_enrolled = sy.sy_id
    ";
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
                        </select>
                        <span>Per Page</span>
                        
                    </div><br>
                    
                    <div class="scroll" style="overflow-x:auto;">
                    
            <table class="table-container">
                <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Student</th>
                    <th rowspan="2">Date</th>
                    <th rowspan="2">Teacher</th>
                    <th colspan="4">Attendance</th>
                    <th rowspan="2">Status</th>
                    <th rowspan="2">Action</th>
                </tr>
                <tr>
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
            $n++;
            $output .= '
            <tr>
                <td>'.$n.'</td>
                <td>'.$row_morning['full_name'].'</td>
                <td>'.$row_morning['clDate'].'</td>
                <td>'.$row_morning['tName'].'</td>
                <td>'.$row_morning['time_in'].'</td>
                <td>'.$row_morning['time_out'].'</td>
                <td>'.$row_morning['in_count'].'</td>
                <td>'.$row_morning['out_count'].'</td>
                <td>'.$row_morning['attendance_status'].'</td>
                <td><a href="a-attendance-class.php?clid='.$row_morning["ca_id"].'"><i class="fas fa-edit btn_edit1"></i></a></td>
                
            </tr>
            ';
        }
        $output .= '
            </table>
        
                <div class="bottom-field">      
                    <ul class="pagination">
                        <li class="prev\"><a href="#" id="prev">&#139;</a></li>
                            <!-- page number here -->
                        <li class="next"><a href="#" id="next">&#155;</a></li>
                    </ul>
                </div> 
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
