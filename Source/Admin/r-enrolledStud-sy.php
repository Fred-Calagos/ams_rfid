<?php

    include "header.php";
    include "../../Inc/connect.php";
    if (!isset($_SESSION["username"])) {
        ?>
            <script type="text/javascript">
                window.location="../../index.php";
            </script>
        <?php
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <section class="dashboard">
        <div class="top">
            <i class="fas fa-bars sidebar-toggle"></i>
        </div>
        <div class="dash-content">
        <div class="table-responsive">
            <div class="row well">
                <form action="" method="POST">
                    <ul>
                        <li>
                        <select name="sy" >
                            <option value="" selected disabled hidden>Select S.Y.</option>
                            <?php
                                $query = mysqli_query($conn, "SELECT * FROM `school_year` ORDER BY sy_id ASC");
                                while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                    <option value="<?php echo $row['sy_name']; ?>"><?php echo $row['sy_name']; ?></option>
                                    <?php
                                }
                                ?>
                        </select>
                        </li>
                        <li><input type="submit" name="submit" value="Submit" class="btn_create1"></li>
                    </ul>
                </form>

                <?php
                if(isset($_POST['submit'])) {
                    $sy_n = $_POST['sy'];
                    $new_table_name = $sy_n . "_student";
                    $fetchsyrecord = mysqli_query($conn,"SELECT st.*, CONCAT(t_ln,', ',t_fn,' ',t_ln) as advName, tr.track_name AS trName, sr.strand_name AS srName, sy.sy_name AS syName, gr.stud_grade AS gname, sc.section_name AS sname,
                                                prov.provDesc AS provName, mun.citymunDesc AS munName, brgy.brgyDesc AS brgyName FROM `$new_table_name` AS st
                                                LEFT JOIN teacher_info AS adv ON st.adviser = adv.t_id
                                                LEFT JOIN grade AS gr ON st.grade = gr.grade_id
                                                LEFT JOIN section AS sc ON st.section = sc.section_id
                                                LEFT JOIN tracks AS tr ON st.track_id = tr.track_id
                                                LEFT JOIN strands AS sr ON st.strand_id = sr.strand_id
                                                LEFT JOIN school_year AS sy ON st.sy_enrolled = sy.sy_id
                                                LEFT JOIN refprovince AS prov ON st.province = prov.provCode
                                                LEFT JOIN refcitymun AS mun ON st.municipality = mun.citymunCode
                                                LEFT JOIN refbrgy AS brgy ON st.barangay = brgy.brgyCode    
                                                ");
                    ?>
                        <div class="scroll" style="overflow-x:auto;">
                            <div class="printable">
                                <table class="table-container" id="tbl_cont">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Student ID</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Grade</th>
                                        <th>Section</th>
                                        <th>Adviser</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Contact</th>
                                        <th>Province</th>
                                        <th>Municipality</th>
                                        <th>Barangay</th>
                                        <th>Track ID</th>
                                        <th>Strand ID</th>
                                        <th>SY Enrolled</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                        <?php 
                                        $n=0;
                                            while($row = mysqli_fetch_assoc($fetchsyrecord)) {
                                                $n++;
                                                ?>
                                                <tr>
                                                    <td><?php echo $n?></td>
                                                    <td><?php echo $row['student_id']?></td>
                                                    <td><?php echo $row['fname']?></td>
                                                    <td><?php echo $row['mname']?></td>
                                                    <td><?php echo $row['lname']?></td>
                                                    <td><?php echo $row['gname']?></td>
                                                    <td><?php echo $row['sname']?></td>
                                                    <td><?php echo $row['advName']?></td>
                                                    <td><?php echo $row['dob']?></td>
                                                    <td><?php echo $row['gender']?></td>
                                                    <td><?php echo $row['contact']?></td>
                                                    <td><?php echo $row['provName']?></td>
                                                    <td><?php echo $row['munName']?></td>
                                                    <td><?php echo $row['brgyName']?></td>
                                                    <td><?php echo $row['trName']?></td>
                                                    <td><?php echo $row['srName']?></td>
                                                    <td><?php echo $row['syName']?></td>
                                                <?php
                                            }
                                        ?>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                        </div>
                </div>
                    <?php
                }else{
                    $fetchrecord = mysqli_query($conn,"SELECT * FROM new_students");
                }
                ?>

                
            


        </div>
    </section>
    <?php
        include "footer.php";
    ?>
</body>
</html>