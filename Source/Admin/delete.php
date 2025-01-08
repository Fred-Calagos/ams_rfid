<?php
    session_start();
    include '../../inc/connect.php';

    // DELETE GATE SCHEDULE
    if(isset($_POST["delete_sched"])){
        $id = $_POST["id"];
        mysqli_query($conn, "delete from `att_sched` where `id` ='$id'");

        ?>
        <script type="text/javascript">
            window.location="a-class-sched.php";
        </script>
        <?php

    }
    // DELETE EVENT SCHEDULE
    if(isset($_POST["delete_event_sched"])){
        $id = $_POST["eid"];
        mysqli_query($conn, "delete from `event_sched` where `id` ='$id'");

        ?>
        <script type="text/javascript">
            window.location="a-class-sched.php";
        </script>
        <?php

    }
    // DELETE TEACHER INFORMATION
    if(isset($_POST["delete_teach"])){
        $id = $_POST["t_id"];
        mysqli_query($conn, "delete from `teacher_info` where `t_id` ='$id'");

        ?>
        <script type="text/javascript">
            window.location="m-teacher.php";
        </script>
        <?php

    }
    // DELETE ADVISER
    if(isset($_POST["del_adv"])){
        $id = $_POST["adv_id"];
        mysqli_query($conn, "delete from `teacher` where `id` ='$id'");

        ?>
        <script type="text/javascript">
            window.location="m-instructor.php";
        </script>
        <?php

    }
    // DELETE SUBJECT
    if(isset($_POST["s_id"])){
        $id = $_POST["s_id"];
        mysqli_query($conn, "delete from `subjects` where `s_id` ='$id'");

        ?>
        <script type="text/javascript">
            window.location="m-subject.php";
        </script>
        <?php

    }
    // DELETE ASSIGNED SUBJECT
    if(isset($_POST["d_tl"])){
        $id = $_POST["s_tl"];
        mysqli_query($conn, "DELETE FROM `teaching_load` where `id_tl` ='$id'");

        ?>
        <script type="text/javascript">
            window.location="m-teachload.php";
        </script>
        <?php

    }
    // DELETE TRACKS
    if(isset($_POST["del_track"])){
        $id = $_POST["tr_id"];
        mysqli_query($conn, "DELETE FROM `tracks` where `track_id` ='$id'");
        mysqli_query($conn, "DELETE FROM `strands` where `track_id` ='$id'");
    
        ?>
        <script type="text/javascript">
            window.location="m-track.php";
        </script>
        <?php
    
    }
        // DELETE S.Y
        if(isset($_POST["del_sy"])){
            $id = $_POST["sy_id"];
            mysqli_query($conn, "DELETE FROM `school_year` where `sy_id` ='$id'");
        
            ?>
            <script type="text/javascript">
                window.location="m-school-year.php";
            </script>
            <?php
        
        }
// DELETE STRAND
if(isset($_POST["delete_strand"])){
    $id = $_POST["st_id"];
    mysqli_query($conn, "DELETE FROM `strands` where `strand_id` ='$id'");

    ?>
    <script type="text/javascript">
        window.location="m-strand.php";
    </script>
    <?php

}
// DELETE SUBJECT CATEGORY
if(isset($_POST["del_subcat"])){
    $id = $_POST["sc_id"];
    mysqli_query($conn, "DELETE FROM `subject_category` WHERE `id` ='$id'");

    ?>
    <script type="text/javascript">
        window.location="s-sub-cat.php";
    </script>
    <?php

}
// DELETE USER ACCOUNT
if(isset($_POST["delete_user"])){
    $id = $_POST["uId"];
    mysqli_query($conn, "DELETE FROM `user` WHERE `id` ='$id'");

    ?>
    <script type="text/javascript">
        window.location="m-user-acc.php";
    </script>
    <?php

}

// DELETE STUDENT
if(isset($_POST["delete_stud"])){
    $id = $_POST["sId"];
    mysqli_query($conn, "DELETE FROM `new_students` WHERE `id` ='$id'");

    ?>
    <script type="text/javascript">
        window.location="m-student.php";
    </script>
    <?php

}
// DELETE SECTION
if(isset($_POST["del_sec"])){
    $sid = $_POST["sid"];
    $grId = $_POST['grade'];
    mysqli_query($conn, "DELETE FROM `section` WHERE `section_id` ='$sid'");

    // Redirect to the same page with the a_id parameter
    header("Location: m-class-edit.php?a_id=$grId");
    exit; // Make sure to exit after setting the header to prevent further execution
}
// DELETE CLASS SCHEDULE
if(isset($_POST["del_csched"])){
    $sid = $_POST["sc_id"];
    mysqli_query($conn, "DELETE FROM `class_sched` WHERE `cs_id` ='$sid'");

    // Redirect to the same page with the a_id parameter
    header("Location: m-sched-class.php");
    exit; // Make sure to exit after setting the header to prevent further execution
}
// DELETE CLASS SCHEDULE
if(isset($_POST["del_csub"])){
    $sid = $_POST["d_tl"];
    mysqli_query($conn, "DELETE FROM `teaching_load` WHERE `id_tl` ='$sid'");

    // Redirect to the same page with the a_id parameter
    header("Location: m-teachload.php");
    exit; // Make sure to exit after setting the header to prevent further execution
}

// DELETE CLASS GRADE
if(isset($_POST["delete_grade"])){
    $id = $_POST["gr_id"];
    mysqli_query($conn, "DELETE FROM `grade` WHERE `grade_id` ='$id'");
        mysqli_query($conn, "DELETE FROM `section` WHERE `stud_grade`='$id'");

    // Redirect to the same page with the a_id parameter
    header("Location: m-class.php");
    exit; // Make sure to exit after setting the header to prevent further execution
}

?>