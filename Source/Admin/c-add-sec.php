<?php
include "../../inc/connect.php";

    if(isset($_POST["add-sec"])){
        $grade = $_POST["grade_name"];
        $section = $_POST["section"];

        $insert = mysqli_query($conn, "INSERT INTO  `section` (section_name,stud_grade) VALUES ('$section','$grade')");

        if($insert)
        {
        
        $_SESSION['added'] = "You have successfully added a book: `$grade`";
        header("Location:m-class-edit.php");

        }
        else
        { 
        $_SESSION['error'] = "Error Adding! ";
        header("Location:m-class-edit.php");
        }
    }
?>