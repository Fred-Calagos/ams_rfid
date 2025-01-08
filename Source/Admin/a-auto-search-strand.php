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
        SELECT sr.*, tr.track_name AS tr_n FROM `strands` as sr
        LEFT JOIN tracks AS tr ON sr.track_id = tr.track_id
        WHERE strand_name LIKE '%".$search."%'
        ";
        }
    else
    {
    $query = "SELECT sr.strand_id, sr.strand_name as sr_n, tr.track_name AS tr_n FROM `strands` as sr
             LEFT JOIN tracks AS tr ON sr.track_id = tr.track_id ORDER BY tr_n asc";
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
                    <th>TRACK</th>
                    <th>STRAND</th>
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
                    <td>'.$row['tr_n'].'</td>
                    <td>'.$row['sr_n'].'</td>
                    <td>
                        <a href="m-strand.php?e_stid='.$row["strand_id"].'"><i class="fas fa-edit btn_edit1"></i></a>
                        <a href="m-strand.php?d_stid='.$row['strand_id'].'"><i class="fas fa-trash btn_delete1"></a></a></td>
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
