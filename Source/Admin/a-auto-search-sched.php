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
        SELECT * FROM `att_sched` 
        WHERE am_ps LIKE '%".$search."%'
        OR am_ls LIKE '%".$search."%'
        OR pm_ps LIKE '%".$search."%'
        OR pm_ls LIKE '%".$search."%'
        ";
        }
    else
    {
    $query = "SELECT * FROM `att_sched` ORDER BY id desc";
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
                    <th colspan="3">MORNING</th>
                    <th colspan="3">AFTERNOON</th>
                    <th rowspan="2">ACTION</th>
                </tr>
                <tr>
                    <th>ON TIME START</th>
                    <th>LATE START</th>
                    <th>AM LOG OUT</th>
                    <th>ON TIME START</th>
                    <th>LATE START</th>
                    <th>PM LOG OUT</th>
                </tr>
            </thead>
            ';

        while($row = mysqli_fetch_array($result))
        {
            $n++;
            $output .= '
                <tr>
                    <td>'.$n.'</td>
                    <td>'.$row['am_ps'].'</td>
                    <td>'.$row['am_ls'].'</td>
                    <td>'.$row['am_logout'].'</td>
                    <td>'.$row['pm_ps'].'</td>
                    <td>'.$row['pm_ls'].'</td>
                    <td>'.$row['pm_logout'].'</td>
                    <td>
                        <a href="a-class-sched.php?sid='.$row["id"].'"><i class="fas fa-edit btn_edit1"></i></a>
                        <a href="a-class-sched.php?did='.$row['id'].'"><i class="fas fa-trash btn_delete1"></a></a></td>
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
