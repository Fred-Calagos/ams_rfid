<?php
    session_start();
    include '../../inc/connect.php';
    $id = $_GET["stud_id"];
        mysqli_query($conn, "delete from `grade` where `stud_grade` ='$id'");
        mysqli_query($conn, "delete from `section` where `stud_grade`='$id'");

        ?>
        <script type="text/javascript">
            window.location="m-class.php";
        </script>
        <?php
?>