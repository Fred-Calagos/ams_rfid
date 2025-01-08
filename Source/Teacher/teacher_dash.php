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
            <div class="overview">
                <div class="title">
                    <i class="ri-bar-chart-box-fill"></i>
                    <span class="text">CHARTS</span>
                </div>
                <div class="title">
                    <i class="fas fa-dashboard"></i>
                    <span class="text">DASHBOARD</span>
                </div>
                <div class="content-dashboard">
                    <div class="flex-container1">
                        <div class="flex-row effect8">
                            <a href="m-student.php">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <h1>NUMBER OF STUDENTS</h1>
                            <?php
            
                                    $select_rows = mysqli_query($conn, "SELECT * FROM `new_students`") or die('query failed');
                                    $row_count = mysqli_num_rows($select_rows);

                                    ?>

                                    <span style="font-size:20px;"><?php echo $row_count; ?></span>
                                <?php

                                if(isset($message)){
                                foreach($message as $message){
                                    echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
                                };
                                };

                            ?>
                            </a>
                        </div>
                        <div class="flex-row effect8">
                        <i class="fa-solid fa-table-list"></i>
                        <a href="a-attendance.php">
                            <h1>ATTENDANCE</h1>
                            <?php
            
                                    $select_rows = mysqli_query($conn, "SELECT * FROM `attendance_gate`") or die('query failed');
                                    $row_count = mysqli_num_rows($select_rows);

                                    ?>

                                    <span style="font-size:20px;"><?php echo $row_count; ?></span>

                                <?php

                                if(isset($message)){
                                foreach($message as $message){
                                    echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
                                };
                                };

                            ?>
                            </a>
                        </div>
                        <div class="flex-row effect8">
                        <a href="logs.php">
                        <i class="fa-regular fa-address-book"></i>
                            <h1>ACTIVITY LOGS</h1>
                        <?php
                            $select_rows = mysqli_query($conn, "SELECT * FROM `logs`") or die('query failed');
                            $row_count = mysqli_num_rows($select_rows);
                        ?>

                        

                            <span style="font-size:20px;"><?php echo $row_count; ?></span>
                            </a>
                        </div>
                        <div class="flex-row effect8">
                        <a href="r-report.php">
                        <i class="fa-solid fa-book-bookmark"></i>
                            <h1>REPORT</h1>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
        include "footer.php";
    ?>
</body>
</html>