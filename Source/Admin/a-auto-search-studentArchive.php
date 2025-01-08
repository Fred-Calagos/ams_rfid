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
        $query = "SELECT st.*, CONCAT(t_ln,', ',t_fn,' ',t_ln) as advName, tr.track_name AS trName, sr.strand_name AS srName, sy.sy_name AS syName, gr.stud_grade AS gname, sc.section_name AS sname,
        prov.provDesc AS provName, mun.citymunDesc AS munName, brgy.brgyDesc AS brgyName FROM `new_students` as st
        LEFT JOIN teacher_info AS adv ON st.adviser = adv.t_id
        LEFT JOIN tracks AS tr ON st.track_id = tr.track_id
        LEFT JOIN strands AS sr ON st.strand_id = sr.strand_id
        LEFT JOIN school_year AS sy ON st.sy_enrolled = sy.sy_id
        LEFT JOIN grade AS gr ON st.grade = gr.grade_id
        LEFT JOIN section AS sc ON st.section = sc.section_id
        LEFT JOIN refprovince AS prov ON st.province = prov.provCode
        LEFT JOIN refcitymun AS mun ON st.municipality = mun.citymunCode
        LEFT JOIN refbrgy AS brgy ON st.barangay = brgy.brgyCode
        WHERE arc_stat = 0 AND student_id LIKE '%".$search."%'
        OR fname LIKE '%".$search."%'
        OR mname LIKE '%".$search."%'
        OR lname LIKE '%".$search."%'
        OR barangay LIKE '%".$search."%'
        ";
        }
    else
    {
    $query = "SELECT st.*, CONCAT(t_ln,', ',t_fn,' ',t_ln) as advName, tr.track_name AS trName, sr.strand_name AS srName, sy.sy_name AS syName, gr.stud_grade AS gname, sc.section_name AS sname,
    prov.provDesc AS provName, mun.citymunDesc AS munName, brgy.brgyDesc AS brgyName FROM `new_students` as st
    LEFT JOIN teacher_info AS adv ON st.adviser = adv.t_id
    LEFT JOIN tracks AS tr ON st.track_id = tr.track_id
    LEFT JOIN strands AS sr ON st.strand_id = sr.strand_id
    LEFT JOIN school_year AS sy ON st.sy_enrolled = sy.sy_id
    LEFT JOIN grade AS gr ON st.grade = gr.grade_id
    LEFT JOIN section AS sc ON st.section = sc.section_id
    LEFT JOIN refprovince AS prov ON st.province = prov.provCode
    LEFT JOIN refcitymun AS mun ON st.municipality = mun.citymunCode
    LEFT JOIN refbrgy AS brgy ON st.barangay = brgy.brgyCode
    WHERE arc_stat = 0
    ORDER BY fname ASC";
    }
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0)
        {
            $output .= '

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
                    <th>Profile</th>
                    <th>RFID No.</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Adviser</th>
                    <th>Grade</th>
                    <th>Section</th>
                    <th>Track</th>
                    <th>Strand</th>
                    <th>School Year</th>
                    <th>Province</th>
                    <th>Municipality</th>
                    <th>Barangay</th>
                   
                    
                    <th>Action</th>
                </tr>
            </thead>
            ';
            $n=0;
        while($row_morning = mysqli_fetch_array($result))
        {
            $trName = isset($row_morning['trName']) ? $row_morning['trName'] : '';
            $srName = isset($row_morning['srName']) ? $row_morning['srName'] : '';
            $syName = isset($row_morning['syName']) ? $row_morning['syName'] : '';
            $n++;
            $output .= '
            <tr>
                <td>'.$n.''.".".'</td>
                <td> <img src='.$row_morning['images'].' class="img_tbl" alt="StudentImage"></td>
                <td>'.$row_morning['student_id'].'</td>
                <td>'.$row_morning['fname'].'</td>
                <td>'.$row_morning['mname'].'</td>
                <td>'.$row_morning['lname'].'</td>
                <td>'.$row_morning['advName'].'</td>
                <td>'.$row_morning['gname'].'</td>
                <td>'.$row_morning['sname'].'</td>
                <td>'.$trName.'</td> 
                <td>'.$srName.'</td>
                <td>'.$syName.'</td>
                <td>'.$row_morning['provName'].'</td>
                <td>'.$row_morning['munName'].'</td>
                <td>'.$row_morning['brgyName'].'</td>
                <td>
                    <a href="m-archive.php?retId='.$row_morning['id'].'"><i class="fas fa-archive btn_create1"></i></a>
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
        <script src="../../assets/js/main.js"></script>
    ';

            echo $output;
        }
    else
        {
                echo 'Data Not Found';
        }

    ?>
