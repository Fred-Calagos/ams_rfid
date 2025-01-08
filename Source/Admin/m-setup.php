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
                                <a href="m-school-year.php">
                                <i class="bi bi-calendar-week-fill"></i>    
                                <h1>SCHOOL YEAR</h1>
                                <?php
                
                                        $select_rows = mysqli_query($conn, "SELECT * FROM `school_year`") or die('query failed');
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
                        <!-- GRADE AND SECTION -->
                        <!-- ----------------- -->

                            <div class="flex-row effect8">
                                <a href="m-class.php">
                                <i class="ri-ball-pen-fill"></i>
                                <h1>GRADE AND SECTION</h1>
                                <?php
                
                                        $select_rows = mysqli_query($conn, "SELECT * FROM `grade`") or die('query failed');
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
                        <!--      TEACHER      -->
                        <!-- ----------------- -->

                            <div class="flex-row effect8">
                                <a href="m-teacher.php">
                                <i class="bx bxs-user-rectangle"></i>
                                <h1>TEACHER</h1>
                                <?php
                
                                        $select_rows = mysqli_query($conn, "SELECT * FROM `teacher_info`") or die('query failed');
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
                        <!--      ADVISER      -->
                        <!-- ----------------- -->

                            <div class="flex-row effect8">
                                <a href="m-instructor.php">
                                <i class="bx bxs-user-rectangle"></i>
                                <h1>ADVISER</h1>
                                <?php
                
                                        $select_rows = mysqli_query($conn, "SELECT * FROM `teacher`") or die('query failed');
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
                        <!-- --------------------------- -->
                        <!--      GENERAL sUBJECTS      -->
                        <!-- --------------------------- -->
                        <div class="flex-row effect8">
                            <a href="m-track.php">
                            <i class="bx bxs-notepad"></i>
                            <h1>TRACK AND STRAND</h1>
                            <?php
            
                                    $select_rows = mysqli_query($conn, "SELECT * FROM `grade`") or die('query failed');
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
                        <i class="bx bxs-book-add"></i>
                        <a href="m-subject.php">
                            <h1>SUBJECT</h1>
                            <?php
            
                                    $select_rows = mysqli_query($conn, "SELECT * FROM `subjects`") or die('query failed');
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
                        <a href="m-teachload.php">
                        <i class="fa-regular fa-address-book"></i>
                            <h1>TEACHING LOAD</h1>
                        <?php
                            $select_rows = mysqli_query($conn, "SELECT * FROM `teaching_load`") or die('query failed');
                            $row_count = mysqli_num_rows($select_rows);
                        ?>

                            <span style="font-size:20px;"><?php echo $row_count; ?></span>
                            </a>
                        </div>

                        <!-- --------------------------- -->
                        <!--      Administrative Staff      -->
                        <!-- --------------------------- -->
                        <div class="flex-row effect8">
                        <a href="m-sp.php">
                        <i class="fa-regular fa-address-book"></i>
                            <h3>ADMINISTRATION OFFICE</h3>
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