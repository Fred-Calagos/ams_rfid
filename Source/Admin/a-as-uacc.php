<?php
        session_start();
        include("../../Inc/connect.php");
        include "delete_btm.php";
        if (!isset($_SESSION["username"])) {
            ?>
                <script type="text/javascript">
                    window.location="../../index.php";
                </script>
            <?php
        }
?>
<?php
//fetch.php
$output = '';
$pagi = '';

    if(isset($_POST["query"]))
        {
        $search = mysqli_real_escape_string($conn, $_POST["query"]);
        $query = "SELECT user.*, role.role as rol, concat(teach.t_ln, ', ',teach.t_fn, ' ',teach.t_mn) as teach_n,
        concat(stud.lname,', ',stud.fname,' ',stud.lname) as stud_n FROM `user`
        LEFT JOIN `role` ON user.role = role.role_id
        LEFT JOIN teacher_info as teach ON user.username = teach.t_rfid
        LEFT JOIN new_students as stud ON user.username = stud.student_id
        WHERE username LIKE '%".$search."%' 
        OR role.role LIKE '%".$search."%'
        OR teach.t_ln LIKE '%".$search."%'
        OR teach.t_fn LIKE '%".$search."%'
        OR teach.t_mn LIKE '%".$search."%'
        OR stud.fname LIKE '%".$search."%'
        OR stud.lname LIKE '%".$search."%'
        OR stud.mname LIKE '%".$search."%'

        ";
        }
    else
    {
    $query = "SELECT user.*, role.role as rol, concat(teach.t_ln, ', ',teach.t_fn, ' ',teach.t_mn) as teach_n,
                concat(stud.lname,', ',stud.fname,' ',stud.lname) as stud_n, CONCAT(admin_lname,', ',admin_fname,' ',admin_mname) AS adName FROM `user`
                LEFT JOIN `role` ON user.role = role.role_id
                LEFT JOIN teacher_info as teach ON user.username = teach.t_rfid
                LEFT JOIN new_students as stud ON user.username = stud.student_id
                LEFT JOIN `admin` AS ad ON user.username = ad.rfid_admin
                ORDER BY date_created DESC";
    }
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0)
        {
            $output .= '
            <div class="table-responsivess" >
            <form action="check-delete.php" method="post" name="data_table">
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
                    <th>No.</th>
                    <th>End User</th>
                    <th>RFID No.</th>
                    <th>Password</th>
                    <th>Account Status</th>  
                    <th>Role</th> 
                    <th>Action</th>
                </tr>
            </thead>
            ';
            $n=0;
        while($row_morning = mysqli_fetch_array($result))
        {
            $n++;
            $output .= '
            <tr>
                <td>'.$n.''.".".'</td>';
                if ($row_morning['role'] == '3') {
                    $output .= '<td>'.$row_morning['teach_n'].'</td>';
                } elseif($row_morning['role'] == '2') {
                    $output .= '<td>'.$row_morning['stud_n'].'</td>';
                }elseif($row_morning['role'] == '1') {
                    $output .= '<td>'.$row_morning['adName'].'</td>';
                }
                $output.='
                <td>'.$row_morning['username'].'</td>
                <td>'.$row_morning['password'].'</td>';

                // UPDATE USER ACCOUNT STATUS
               if ($row_morning['status'] == 'Active') {
                    $output .= '<td><a href="c-update-yl.php?userid='.$row_morning['id'].'" class="btn btn_active">'.$row_morning['status'].'</a></td>';
                } else {
                    $output .= '<td><a href="c-update-yl.php?userid='.$row_morning['id'].'" class="btn btn_inactive">'.$row_morning['status'].'</a></td>';
                }
                $output .= '<td>'.$row_morning['rol'].'</td>
                <td><a href="m-user-acc.php?u_ed='.$row_morning['id'].'"><i class="fas fa-edit btn_edit1"></i></a>
                    <a href="m-user-acc.php?u_del='.$row_morning['id'].'" onclick= return confirm("Are you sure you want to delete '.$row_morning['username'].'?")><i class="fas fa-trash btn_delete1"></i></a>
                </td>
            </tr>
            </form>
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
