<?php
//fetch.php
include("../../Inc/connect.php");
$output = '';
$pagi = '';
$n = '';


    if(isset($_POST["query"]))
        {
        $search = mysqli_real_escape_string($conn, $_POST["query"]);
        $query = "
        SELECT * FROM `event_sched` 
        WHERE event_name LIKE '%".$search."%'
        ";
        }
    else
    {
    $query = "SELECT * FROM `event_sched` ORDER BY id desc";
    }

    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0)
        {

            $output .= '
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
            <table class="table-container">
            <thead>
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">EVENT NAME</th>
                    <th rowspan="2">EVENT DATE</th>
                    <th colspan="2">MORNING</th>
                    <th colspan="2">AFTERNOON</th>
                    <th colspan="2">EVENING</th>
                    <th rowspan="2">Action</th>
                </tr>
                <tr>
                    <th>TIME IN</th>
                    <th>TIME OUT</th>
                    <th>TIME IN</th>
                    <th>TIME OUT</th>
                    <th>TIME IN</th>
                    <th>TIME OUT</th>
                </tr>
            </thead>
            ';

        while($row = mysqli_fetch_array($result))
        {
            $n++;
            $output .= '
                <tr>
                    <td>'.$n.'</td>
                    <td>'.$row['event_name'].'</td>
                    <td>'.$row['event_date'].'</td>
                    <td>'.$row['am_ti'].'</td>
                    <td>'.$row['am_to'].'</td>
                    <td>'.$row['pm_ti'].'</td>
                    <td>'.$row['pm_to'].'</td>  
                    <td>'.$row['eve_ti'].'</td>
                    <td>'.$row['eve_to'].'</td>
                    <td>
                        <a href="a-class-sched.php?event_id='.$row["id"].'"><i class="fas fa-edit btn_edit1"></i></a>
                        <a href="a-att-pg-event.php?view_id='.$row["id"].'&date='.$row['event_date'].'" target="_blank"><i class="fas fa-eye btn_view1"></i></a>
                        <a href="a-class-sched.php?eve_del_id='.$row['id'].'"><i class="fas fa-trash btn_delete1"></a></a></td>
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
