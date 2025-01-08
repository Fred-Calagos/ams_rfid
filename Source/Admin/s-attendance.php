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
            <div class="bread">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="m-report.php"><i class="bx bxs-home"></i></a></li>
                </ul>
            </div>
            <div class="overview">
                <div class="title">
                    <i class="fa-solid fa-print"></i>
                    <span class="text"> CLASS ATTENDANCE REPORTS</span>
                </div>
                <div class="content-dashboard">
                    <div class="flex-container1">
                        <!-- ------------------------------------------
                                REPORT: MAIN GATE ATTENDANCE
                        ------------------------------------------ -->

                        <div class="flex-row effect8">
                            <a href="s-att-jh.php">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <h3>JUNIOR HIGH SCHOOL</h3>
                            </a>
                        </div>


                        <!-- ------------------------------------------
                                REPORT: CLASS ATTENDANCE
                        ------------------------------------------ -->

                        <div class="flex-row effect8">
                        <i class="fa-solid fa-table-list"></i>
                        <a href="s-att-sh.php">
                            <h3>SENIOR HIGH SCHOOL</h3>
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