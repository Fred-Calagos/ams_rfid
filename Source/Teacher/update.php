<?php 
session_start();
include("../../Inc/connect.php");
    // UPDATING CLASS
if (isset($_POST["cl_upt"])){

    $id = $_POST['id'];
    $ti = $_POST['ti'];
    $to = $_POST['to'];
    $as = $_POST['at'];
    $updateQuery = "UPDATE attendance_class SET time_in  = ?, time_out = ?, attendance_status = ? WHERE ca_id = ?";
    // $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-out','$student_id','Logged $log_upt_out')");
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'sssi', $ti, $to, $as, $id);
    mysqli_stmt_execute($stmt);
        if ($stmt) {
            $_SESSION['added'] = "You have successfully Updated the Attendance";
            header("Location: a-attendance-class.php");
        } else {
            $_SESSION['error'] = "Unable to Update Attendance!";
            header("Location: a-attendance-class.php");
        }
}
if(isset($_POST['chpass'])){
    $uname = $_POST['username'];
    $upass = $_POST['password'];

    $update = "UPDATE user SET password = ? WHERE username = ?";

    $stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($stmt, 'ss', $upass, $uname);
    mysqli_stmt_execute($stmt);

    if($stmt){
        $_SESSION['updated'] = "You have successfully updated your password";
        header("Location: t-profile.php");
    } else {
        $_SESSION['error'] = "Unable to Update password!";
        header("Location: t-profile.php");
    }
}

// UPDATING GATE ATTENDANCE 
if (isset($_POST["gt_upt"])){

    $id = $_POST['id'];
    $amti    = $_POST['amti'];
    $amto    = $_POST['amto'];
    $am_stat = $_POST['am_stat'];
    $pmti    = $_POST['pmti'];
    $pmto    = $_POST['pmto'];
    $pm_stat = $_POST['pm_stat'];
    $updateQuery = "UPDATE attendance_gate SET amti=?, amto=?, am_status = ?, pmti= ?, pmto=?, pm_status=? WHERE gid = ?";
    // $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-out','$student_id','Logged $log_upt_out')");
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'ssssssi', $amti,$amto,$am_stat,$pmti, $pmto,$pm_stat, $id);
    mysqli_stmt_execute($stmt);
        if ($stmt) {
            $_SESSION['added'] = "You have successfully Updated the Attendance";
            header("Location: a-attendance.php");
        } else {
            $_SESSION['error'] = "Unable to Update Attendance!";
            header("Location: a-attendance.php");
        }
}

  // UPDATING STUDENT

  if (isset($_POST["updateStud"])) {
    // Retrieve data from the form
    $sid = $_POST['studId'];
    $student_id = $_POST['rfidcard'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];

    $province = $_POST['province'];
    $municipality = $_POST['municipality'];
    $barangay = $_POST['barangay'];

    $syId = $_POST['syId'];
    $trackId =$_POST['trackId'];
    $strandId = $_POST['strandId'];
    $grade = $_POST['grade'];
    $section = $_POST['section'];
    $adviser = $_POST['adviser'];

    $contact = $_POST['contact'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    // Check if a new image is uploaded
    if (!empty($_FILES['images']['name'])) {
        $image_name = $_FILES['images']['name'];
        $temp = explode(".", $image_name);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $imagepath = "../../images/admin/" . $newfilename;
        
        // Move uploaded file
        move_uploaded_file($_FILES["images"]["tmp_name"], $imagepath);
        
        // Update the student information with the new image path
        mysqli_query($conn, "UPDATE `new_students` SET images = '$imagepath' WHERE id = '$sid'");
    }

    // Update the student information without changing the image path
    $updateQuery = "UPDATE `new_students` SET 
                    fname = '$fname', 
                    mname = '$mname', 
                    lname = '$lname', 
                    province = '$province', 
                    municipality = '$municipality', 
                    barangay = '$barangay', 
                    grade = '$grade', 
                    section = '$section', 
                    adviser = '$adviser', 
                    contact = '$contact', 
                    dob = '$dob',
                    sy_enrolled = '$syId',
                    track_id = '$trackId',
                    strand_id = '$strandId',
                    gender = '$gender',
                    student_id = '$student_id'
                    WHERE id = '$sid'";

    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        $_SESSION['success'] = "Student information updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating student information!";
    }

    header("Location: s-student-adv.php");
    exit();
}
?>