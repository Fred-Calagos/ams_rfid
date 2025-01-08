<?php
//fetch.php
include("../../Inc/connect.php");
$output = '';
$pagi = '';
$n = 0;


    if(isset($_POST["query"]))
        {
        $search = mysqli_real_escape_string($conn, $_POST["query"]);
        $query = "SELECT ad.*, at.admin_role AS adr FROM `admin` AS ad
        LEFT JOIN ad_role AS at ON ad.authority = at.idadr
        WHERE admin_fname LIKE '%".$search."%'
        OR admin_lname LIKE '%".$search."%'
        OR admin_mname LIKE '%".$search."%'
        ";
        }
    else
    {
    $query = "SELECT ad.*, at.admin_role AS adr FROM `admin` AS ad
            LEFT JOIN ad_role AS at ON ad.authority = at.idadr
            ORDER BY admin_lname desc";
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
                    <th>Profile</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>RFID</th>
                    <th>Authority</th>
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
            <td><img src='.$row['profile'].' class="img_tbl" alt="Admin Image"></td>
            <td>'.$row['admin_fname'].'</td>
            <td>'.$row['admin_mname'].'</td>
            <td>'.$row['admin_lname'].'</td>
            <td>'.$row['rfid_admin'].'</td>
            <td>'.$row['adr'].'</td>
            <td>
                <a href="m-teacher.php?t_id='.$row['idad'].'&t_fn='.$row['admin_fname'].'"><i class="fas fa-edit btn_edit1"></i></a>
                <a href="m-teacher.php?id_t='.$row['idad'].'"><i class="fas fa-trash btn_delete1"></a></a></td>
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
