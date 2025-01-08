<?php
    include "header.php";
    include("../../Inc/connect.php");
    if (!isset($_SESSION["username"])) {
        ?>
            <script type="text/javascript">
                window.location="../../index.php";
            </script>
        <?php
    }
    $username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../../assets/js/jquery.js" type="text/javascript"></script>
    <script src="../../assets/js/js-script.js" type="text/javascript"></script>
    <script src="../../assets/jquery/jquery.min.js"></script>
</head>
<body>
    <section class="dashboard">
    <div class="top">
        <i class="fas fa-bars sidebar-toggle"></i>
            <div class="search-box">
                <i class="uil uil-search"></i>
                
            </div>
    </div>
    <!-- CONCAT(adv.t_ln,', ',adv.t_fn,' ',adv.t_mn) AS adv_name, -->
    <div class="dash-content">
        <?php
                
                    $query = "SELECT tl.*, ti.t_rfid AS trfid, CONCAT(sub.sub_name,' | ',sub.sub_desc) AS subname, CONCAT(adv.t_ln,', ',adv.t_fn,' ',adv.t_mn) AS advName, gr.stud_grade AS gname, sc.section_name AS scname FROM teaching_load AS tl
                    LEFT JOIN subjects AS sub ON tl.s_id = sub.s_id
                    LEFT JOIN teacher_info AS ti ON tl.t_id = ti.t_id
                    LEFT JOIN teacher_info AS adv ON tl.adv_id = adv.t_id
                    LEFT JOIN teacher AS cadv ON tl.adv_id =cadv.t_id
                    LEFT JOIN grade AS gr ON cadv.grade = gr.grade_id
                    LEFT JOIN section AS sc ON cadv.section = sc.section_id
                    WHERE ti.t_rfid = ? AND tl.t_id = ti.t_id" ; // Added condition to check for the specific date or if no record exists for the student
                    
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, 's', $username);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);


        ?>

        <div class="table-responsive">
            <table class="table-container">
                
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Subject Name</th>
                            <th>Advisory</th>
                            <th>Grade</th>
                            <th>Section</th>
                        </tr>
                    </thead>
                
                
                    <tbody>
                    <tr>
                        <?php
                        $n= 0;
                            while ($row = mysqli_fetch_array($result)) {
                                $tlid        = $row['id_tl'];
                                $subjects    = $row['subname'];
                                $advName     = $row['advName'];
                                $grade       = $row['gname'];
                                $section     = $row['scname'];
                                $sId         = $row['s_id'];
                                $n++;
                                ?>
                                <td><?php echo $n?></td>
                                <td><?php echo $subjects?></td>
                                <td><?php echo $advName?></td>
                                <td><?php echo $grade?></td>
                                <td><?php echo $section?></td>
                                </tr>
                        <?php
                            }
                        ?>

                    </tbody>
                
            </table>
        </div>
            
    </div>
    </section>
            <!-- ---------------------------------------- -->
            <!-- POP UP MODAL FOR DELETING TEACHER INFORMATION-->
            <!-- ---------------------------------------- -->
<?php
    include "footer.php";
?>
<!-- JS POPUP FOR EDITING AND UPDATING -->
<script src="../../assets/JS/script-popup.js"></script>
</body>
</html>