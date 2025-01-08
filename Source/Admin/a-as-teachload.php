<?php
//fetch.php
include("../../Inc/connect.php");
$output = '';
$pagi = '';
$n = 0;


    if(isset($_POST["query"]))
        {
        $search = mysqli_real_escape_string($conn, $_POST["query"]);
        $query = "SELECT teaching_load.*, adviser.t_ln as ln,adviser.t_fn as fn,adviser.t_mn as mn, concat(teach.t_ln, ', ',teach.t_fn, ' ',teach.t_mn) as teach_n, subjects.sub_name as sn, sem.semName as semName FROM teaching_load
        INNER JOIN subjects ON teaching_load.s_id = subjects.s_id
        INNER JOIN teacher_info as adviser ON teaching_load.adv_id = adviser.t_id
        INNER JOIN teacher_info as teach ON teaching_load.t_id = teach.t_id
        INNER JOIN semester as sem ON teaching_load.sem_id = sem.sem_id
        WHERE sub_name LIKE '%".$search."%'
        OR adviser.t_ln LIKE '%".$search."%'
        OR adviser.t_fn LIKE '%".$search."%'
        OR adviser.t_mn LIKE '%".$search."%'
        OR teach.t_ln LIKE '%".$search."%'
        OR teach.t_fn LIKE '%".$search."%'
        OR teach.t_mn LIKE '%".$search."%'
        ORDER BY t_id asc";
        }
    else
    {
    $query = "SELECT teaching_load.*, adviser.t_ln as ln,adviser.t_fn as fn,adviser.t_mn as mn, concat(teach.t_ln, ', ',teach.t_fn, ' ',teach.t_mn) as teach_n,subjects.sub_name as sn, sem.semName as semName FROM teaching_load
    INNER JOIN subjects ON teaching_load.s_id = subjects.s_id
    INNER JOIN teacher_info as adviser ON teaching_load.adv_id = adviser.t_id
    INNER JOIN teacher_info as teach ON teaching_load.t_id = teach.t_id
     INNER JOIN semester as sem ON teaching_load.sem_id = sem.sem_id
    ORDER BY t_id asc";
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
                    <th>#</th>
                    <th>Teacher </th>
                    <th>Subject Load</th>
                    <th>Advisory</th>
                    <th>Semester</th>
                    <th>Action</th>
                </tr>
            </thead>
            ';

        while($row = mysqli_fetch_array($result))
        {
            $n++;
            $output .= '
            <tr>
            <td>'.$n.'</td>
            <td>'.$row['teach_n'].'</td>
            <td>'.$row['sn'].'</td>
            <td>'.$row['ln'].', '.$row['fn'].' '.$row['mn'].' </td>
            <td>'.$row['semName'].'</td>
            <td>
                <a href="m-teachload.php?tl_id='.$row['id_tl'].'"><i class="fas fa-edit btn_edit1"></i></a>
                <a href="m-teachload.php?a_id='.$row['id_tl'].'"><i class="fas fa-plus btn_create1"></i></a>
                <a href="m-teachload.php?a_id='.$row['id_tl'].'"><i class="fas fa-eye btn_create1"></i></a>
                <a href="m-teachload.php?d_tl='.$row['id_tl'].'"><i class="fas fa-trash btn_delete1"></a></a></td>
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
