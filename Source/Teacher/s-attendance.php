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
    
// Query to check if the username is assigned an advisory
$query = "SELECT *FROM teacher_info AS ti
          LEFT JOIN teacher AS adv ON ti.t_id = adv.t_id
            WHERE t_rfid = ? AND adv.t_id IS NOT NULL";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// If the user is not assigned an advisory, hide the link
if ($result->num_rows == 0) {
    echo '<style>.adviserInput { display: none; }</style>';
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
                    <span class="text">ATTENDANCE REPORTS</span>
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

                        <div class="flex-row effect8 adviserInput">
                        <i class="fa-solid fa-table-list"></i>
                        <a href="r-gate.php">
                            <h3>GATE ATTENDANCE</h3>
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