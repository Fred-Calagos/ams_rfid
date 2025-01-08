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

    <div class="dash-content">
        <div class="table-responsive">
            <h3>Class Schedule</h3>
            <div class="scroll" style="overflow-x:auto;">
            <table class="table-container">
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Subject</th>
                    <th rowspan="2">Advisory</th>
                    <th colspan="3">Schedule</th>
                    <th rowspan="2">Action</th>
                </tr>
                <tr>
                    <th>On time Start</th>
                    <th>Late Start</th>
                    <th>End of Class</th>
                    
                </tr>
                <tr>
                <?php
                    $n = 0;
                    $res = mysqli_query($conn, "SELECT tl.*, ti.t_rfid AS trfid, sub.sub_name AS sname, CONCAT(adv.t_ln,', ',adv.t_fn,' ',adv.t_mn) AS advName, tl.adv_id AS advid, cs.cs_id AS csid, cs.inp AS inp, cs.inl AS inl, cs.log_out AS log_out FROM teaching_load AS tl
                    LEFT JOIN subjects AS sub ON tl.s_id = sub.s_id
                    LEFT JOIN teacher_info AS ti ON tl.t_id = ti.t_id
                    LEFT JOIN teacher_info AS adv ON tl.adv_id = adv.t_id
                    LEFT JOIN class_sched AS cs ON tl.id_tl = cs.id_tl
                    WHERE ti.t_id = tl.t_id AND ti.t_rfid = '$username' and cs.id_tl = tl.id_tl;");
                    while ($row = mysqli_fetch_array($res)) {
                        $n++;
                        ?>
                            <tr>
                                <td><?php echo $n?></td>
                                <td><?php echo $row['sname']?></td>
                                <td><?php echo $row['advName']?></td>
                                <td><?php echo $row['inp']?></td>
                                <td><?php echo $row['inl']?></td>
                                <td><?php echo $row['log_out']?></td>

                                <td>
                                    <a target="_blank" href="a-att-pg-class.php?tlid=<?php echo $row["id_tl"];?>&csid=<?php echo $row['csid']?>&advid=<?php echo $row['advid']?>"><i class="fas fa-plus btn_create1"></i></a>
                                </td>
                            </tr>
                            <?php       

                    }
                    ?>
                </tr>
            </table>
            </div>
        </div>
    </div>
    </section>
<?php
    include "footer.php";
?>
<!-- JS POPUP FOR EDITING AND UPDATING -->
<script src="../../assets/JS/script-popup.js"></script>
</body>
</html>