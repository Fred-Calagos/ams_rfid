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
                    <i class="fa-solid fa-print"></i>
                    <span class="text">ATTENDANCE REPORT</span>
                </div>
                <div class="content-dashboard">
                    <div class="flex-container1">
                        <!-- ------------------------------------------
                                REPORT: MAIN GATE ATTENDANCE
                        ------------------------------------------ -->

                        <div class="flex-row effect8">
                            <a href="r-gate.php">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <h3>MAIN GATE ATTENDANCE</h3>
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


                        <!-- ------------------------------------------
                                REPORT: CLASS ATTENDANCE
                        ------------------------------------------ -->

                        <div class="flex-row effect8">
                            <i class="fa-solid fa-table-list"></i>
                            <a href="s-attendance.php">
                            <h3>CLASS ATTENDANCE</h3>
                            </a>
                        </div>
                        
                        <!-- ------------------------------------------
                                REPORT: SCHOOL EVENT ATTENDANCE
                        ------------------------------------------ -->
                        
                        <div class="flex-row effect8">
                            <a href="r-event.php">
                            <i class="fa-regular fa-address-book"></i>
                            <h3>EVENT ATTENDANCE</h3>
                            <?php
                                $select_rows = mysqli_query($conn, "SELECT * FROM `teaching_load`") or die('query failed');
                                $row_count = mysqli_num_rows($select_rows);
                            ?>
                            <span style="font-size:20px;"><?php echo $row_count; ?></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="title">
                    <i class="fa-solid fa-print"></i>
                    <span class="text">LOG REPORT</span>
                </div>
                <div class="content-dashboard">
                    <div class="flex-container1">
                        <!-- ------------------------------------------
                                REPORT: ATTENDANCE LOG REPORTS
                        ------------------------------------------ -->
                        
                        <div class="flex-row effect8">
                            <a href="r-att-logs.php">
                            <i class="fa-regular fa-address-book"></i>
                            <h3>GATE LOG REPORT</h3>
                            <?php
                                $select_rows = mysqli_query($conn, "SELECT * FROM `teaching_load`") or die('query failed');
                                $row_count = mysqli_num_rows($select_rows);
                            ?>

                            <span style="font-size:20px;"><?php echo $row_count; ?></span>
                            </a>
                        </div>
                        <!-- ------------------------------------------
                                REPORT: CLASS LOG REPORT SECTION
                        ------------------------------------------ -->
                        <div class="flex-row effect8">
                                <a href="r-evt-logs.php">
                                <i class="fa-solid fa-book-bookmark"></i>
                                <h3>CLASS LOG REPORT</h3>
                                </a>
                            </div>
                        <!-- ------------------------------------------
                                REPORT: EVENT LOG REPORT SECTION
                        ------------------------------------------ -->
                            <div class="flex-row effect8">
                                <a href="r-evt-logs.php">
                                <i class="fa-solid fa-book-bookmark"></i>
                                <h3>EVENT LOG REPORT</h3>
                                </a>
                            </div>
                            
                    </div>
                </div>
                <div class="title">
                    <i class="fa-solid fa-print"></i>
                    <span class="text">INFORMATION REPORT</span>
                </div>
                <div class="content-dashboard">
                    <div class="flex-container1">
                        <!-- ------------------------------------------
                                REPORT: STUDENT LIST REPORT
                        ------------------------------------------ -->
                        <div class="flex-row effect8">
                                <a href="r-evt-logs.php">
                                <i class="fa-solid fa-book-bookmark"></i>
                                <h3>STUDENT INFORMATION</h3>
                                </a>
                            </div>
                        <!-- ------------------------------------------
                                REPORT: TEACHER INFORMATION
                        ------------------------------------------ -->
                            <div class="flex-row effect8">
                                <a href="r-evt-logs.php">
                                <i class="fa-solid fa-book-bookmark"></i>
                                <h3>TEACHER INFORMATION</h3>
                                </a>
                            </div>
                        <!-- ------------------------------------------
                                REPORT: RFID INFORMATION
                        ------------------------------------------ -->
                            <div class="flex-row effect8">
                                <a href="r-evt-logs.php">
                                <i class="fa-solid fa-book-bookmark"></i>
                                <h3>RFID CARD INFORMATION</h3>
                                </a>
                            </div>
                        <!-- ------------------------------------------
                                REPORT: ENROLLED STUDENT BY SCHOOL YEAR
                        ------------------------------------------ -->
                        <div class="flex-row effect8">
                                <a href="r-enrolledStud-sy.php">
                                <h3>ENROLLED STUDENT BY SCHOOL YEAR </h3>
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