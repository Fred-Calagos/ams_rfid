<?php
//fetch.php
include("../../Inc/connect.php");
$output = '';
$pagi = '';
$n = 0;


    if(isset($_POST["query"]))
        {
        $search = mysqli_real_escape_string($conn, $_POST["query"]);
        $query = "SELECT * FROM `teacher_info` 
        WHERE t_fn LIKE '%".$search."%'
        OR t_mn LIKE '%".$search."%'
        OR t_ln LIKE '%".$search."%'
        ";
        }
    else
    {
    $query = "SELECT * FROM `teacher_info` ORDER BY t_id desc";
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
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Birth Date</th>
                    <th>Gender</th>
                    <th>Contact Number</th>
                    <th>Email</th>
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
            <td>'.$row['t_fn'].'</td>
            <td>'.$row['t_mn'].'</td>
            <td>'.$row['t_ln'].'</td>
            <td>'.$row['t_bdate'].'</td>
            <td>'.$row['t_gender'].'</td>
            <td>'.$row['t_num'].'</td>
            <td>'.$row['t_email'].'</td>
            <td>
                <a href="m-teacher.php?t_id='.$row['t_id'].'&t_fn='.$row['t_fn'].'"><i class="fas fa-edit btn_edit1"></i></a>
                <a href="m-teacher.php?id_t='.$row['t_id'].'"><i class="fas fa-trash btn_delete1"></a></a></td>
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
