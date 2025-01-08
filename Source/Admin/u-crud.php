<?php
    session_start();
    include "../../inc/connect.php";

    if(isset($_POST["u_add"])){
        $u = $_POST["rfidcard"];
        $p = $_POST["pass"];
        $r = $_POST['role'];

        // Check if the school name already exists
        $checkQuery = "SELECT * FROM `user` WHERE `username` = '$u'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) === 1) {
            // Update existing entry
            $update = mysqli_query($conn, "UPDATE `user` SET
                                            usrname = '$u',
                                            pasword = '$p'
                                            WHERE username = '$u'");
            $insert2 = mysqli_query($conn, "INSERT INTO `logs` (action) values('Updated username : $u')");
    
            if ($update) {
                $_SESSION['updated'] = "You have successfully updated username: `$u`";
                header("Location: m-user-acc.php");
            } else {
                $_SESSION['error'] = "Error Updating!";
                header("Location: m-user-acc.php");
            }
        } else {
            // Insert data into the school_profile table
            $insert = mysqli_query($conn, "INSERT INTO `user` (username, password, role) 
                                            VALUES ('$u', '$p', '$r')");
            $insert2 = mysqli_query($conn, "INSERT INTO `logs` (action) values('Added new user: $u ;role: $r')");
    
            if ($insert) {
                $_SESSION['added'] = "You have successfully added a user: `$u`";
                header("Location: m-user-acc.php");
            } else {
                $_SESSION['error'] = "Error Adding!";
                header("Location: m-user-acc.php");
            }
        }
    }
?>