<?php
//fetch.php
include("../../Inc/connect.php");
$output = '';
$pagi = '';
$n = '';


    if(isset($_POST["query"]))
        {
        $search = mysqli_real_escape_string($conn, $_POST["query"]);
        $query = "SELECT cs.*, s.sub_name as sname, CONCAT(t.t_ln,', ',t.t_fn,' ',t.t_ln) AS tflname, CONCAT(adv.t_ln,', ',adv.t_fn,' ',adv.t_ln) AS advflname  FROM `class_sched` AS cs
        LEFT JOIN teaching_load AS tl ON cs.id_tl = tl.id_tl
        LEFT JOIN teacher_info AS t ON tl.t_id = t.t_id
        LEFT JOIN teacher_info AS adv ON tl.adv_id = adv.t_id
        LEFT JOIN subjects AS s ON tl.s_id = s.s_id
        WHERE CONCAT(t.t_ln,', ',t.t_fn,' ',t.t_ln) LIKE '%".$search."%'
        OR CONCAT(adv.t_ln,', ',adv.t_fn,' ',adv.t_ln) LIKE '%".$search."%'
        OR s.sub_name LIKE '%".$search."%'
        ";
        }
    else
    {
    $query = "SELECT cs.*, s.sub_name as sname, CONCAT(t.t_ln,', ',t.t_fn,' ',t.t_ln) AS tflname, CONCAT(adv.t_ln,', ',adv.t_fn,' ',adv.t_ln) AS advflname  FROM `class_sched` AS cs
    LEFT JOIN teaching_load AS tl ON cs.id_tl = tl.id_tl
    LEFT JOIN teacher_info AS t ON tl.t_id = t.t_id
    LEFT JOIN teacher_info AS adv ON tl.adv_id = adv.t_id
    LEFT JOIN subjects AS s ON tl.s_id = s.s_id ORDER BY cs_id desc";
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
                                    <option value="08" selected>08</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                            </select>
                        <h5>Per Page</h5>
                        <br><br>
                    </div>
            <div class="scroll" style="overflow-x:auto;">
            <table class="table-container"  >
            
            <thead>
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">Subject Teacher</th>
                    <th rowspan="2">Subject</th>
                    <th rowspan="2">Advisory</th>
                    <th colspan="3">Class Schedule</th>
                    <th rowspan="2">ACTION</th>
                </tr>
                <tr>
                    <th>Present Start</th>
                    <th>Late Start</th>
                    <th>Log Out</th>
                </tr>
            </thead>
            ';

        while($row = mysqli_fetch_array($result))
        {
            $n++;
            $output .= '
                <tr>
                    <td>'.$n.'</td>
                    <td>'.$row['tflname'].'</td>
                    <td>'.$row['sname'].'</td>
                    <td>'.$row['advflname'].'</td>
                    <td>'.$row['inp'].'</td>
                    <td>'.$row['inl'].'</td>
                    <td>'.$row['log_out'].'</td>
                    <td>
                        <a href="m-sched-class.php?csid='.$row["cs_id"].'"><i class="fas fa-edit btn_edit1"></i></a>
                        <a href="m-sched-class.php?did='.$row['cs_id'].'"><i class="fas fa-trash btn_delete1"></a></a></td>
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
        <script src="../../assets/JS/main.js"></script>
    ';

            echo $output;
        }
    else
        {
                echo 'Data Not Found';
        }
        
    ?>
