<?php
session_start();
include "../../inc/connect.php";

if(isset($_POST["ins_update"])){
    $id_ins = $_POST['id'];
    $t_id   = $_POST['adv_name'];
    $ins_gr = $_POST['gr'];
    $ins_sc = $_POST['sc'];


    $update = "UPDATE `teacher` SET 
        t_id =     '$t_id',
        grade =     '$ins_gr',
        section =   '$ins_sc'
        where id = '$id_ins'";
 $updateResult = mysqli_query($conn,$update);

    if ($updateResult) {
        $_SESSION['success'] = "TEacher information updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating teacher information!";
    }

    header("Location: m-instructor.php");
    exit();
} else {
 // Redirect if the form is not submitted
 header("Location: m-instructor.php");
 exit();
}

?>