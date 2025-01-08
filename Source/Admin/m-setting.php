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
                    <i class="fas fa-dashboard"></i>
                    <span class="text">SETUP</span>
                </div>
                <div class="content-dashboard">
                    <div class="flex-container1">
                        <!-- ----------------- -->
                        <!--    SCHOOL YEAR    -->
                        <!-- ----------------- -->

                        <div class="flex-row effect8">
                                <a href="m-admin.php">
                                <i class="fa-solid fa-user"></i>
                                <h1>ADMIN ACCOUNT</h1>
                                <?php
                
                                        $select_rows = mysqli_query($conn, "SELECT * FROM `admin`") or die('query failed');
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

                        <!-- ----------------- -->
                        <!--    ARCHIVE         -->
                        <!-- ----------------- -->

                        <div class="flex-row effect8">
                                <a href="m-archive.php">
                                <i class="fa-solid fa-archive"></i>
                                <h1>ARCHIVED STUDENT</h1>
                                </a>
                        </div>
                        <!-- ----------------------- -->
                        <!--    SCHOOL PRINCIPAL     -->
                        <!-- ----------------------- -->

                        <div class="flex-row effect8">
                                <a href="m-archive.php">
                                <i class="fa-solid fa-archive"></i>
                                <h1>SCHOOL PRINCIPAL INFO</h1>
                                </a>
                        </div>
                        <!-- ----------------------- -->
                        <!--    Administrative Role  -->
                        <!-- ----------------------- -->

                        <div class="flex-row effect8">
                                <a href="m-adminrole.php">
                                <i class="fa-solid fa-archive"></i>
                                <h1>Administrative Role</h1>
                                </a>
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