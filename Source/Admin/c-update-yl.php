<?php
session_start();
include("../../Inc/connect.php");


// UPDATE GRADE LEVEL
if (isset($_POST["gr_upt"])) {
    $id = $_POST["id"];
    $grade = $_POST["gradeName"];

    // Check if the grade already exists
    $checkQuery = "SELECT * FROM `grade` WHERE `stud_grade` = '$grade' AND `grade_id` != '$id'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['error'] = "Another grade with the name '$grade' already exists!";
        header("Location: m-class.php");
    } else {
        $update = mysqli_query($conn, "UPDATE `grade` SET `stud_grade` = '$grade' WHERE `grade_id` = '$id'");
        

        if ($update) {
            $_SESSION['updated'] = "You have successfully updated '$grade'!";
            header("Location: m-class.php");
        } else {
            $_SESSION['error'] = "Error updating!";
            header("Location: m-class.php");
        }
    }


}

// UPDATE GATE SCHEDULING
if (isset($_POST["sched_update"])){
    $sid  = $_POST['id'];
    $amps = $_POST['amps'];
    $amls = $_POST['amls'];
    $am_o = $_POST['amo'];
    $pmps = $_POST['pmps'];
    $pmls = $_POST['pmls'];
    $pm_o = $_POST['pmo'];

    // Insert the section 
    $update ="UPDATE `att_sched` SET `am_ps`= '$amps', `am_ls`= '$amls',`am_logout`= '$am_o',`pm_ps`= '$pmps',`pm_ls`= '$pmls',`pm_logout`= '$pm_o'
           WHERE `id` = '$sid'";
    $updateResult = mysqli_query($conn,$update);
        if ($updateResult) {
            $_SESSION['added'] = "You have successfully Updated the Schedule";
            header("Location: m-sched-gate.php");
        } else {
            $_SESSION['error'] = "Error adding section!";
            header("Location: m-sched-gate.php");
        }
}

// UPDATE EVENT SCHEDULE
if (isset($_POST["event_update"])){
    $eid   = $_POST['id'];
    $event = $_POST['event_n'];
    $date  = $_POST['event_d'];
    $mti   = $_POST['amti'];
    $mto   = $_POST['amto'];
    $aftti = $_POST['pmti'];
    $aftto = $_POST['pmto'];
    $eveti = $_POST['eveti'];
    $eveto = $_POST['eveto'];

    // Insert the section 
    $update ="UPDATE `event_sched` SET `event_name`= '$event',`event_date`= '$date', `am_ti`= '$mti',`am_to`= '$mto',`pm_ti`= '$aftti',`pm_to`= '$aftto',`eve_ti`= '$eveti',`eve_to`= '$eveto'
           WHERE `id` = '$eid'";
    $updateResult = mysqli_query($conn,$update);
        if ($updateResult) {
            $_SESSION['added'] = "You have successfully Updated the Event Schedule";
            header("Location: a-class-sched.php");
        } else {
            $_SESSION['error'] = "Error adding section!";
            header("Location: a-class-sched.php");
        }
}
// UPDATE TEACHER INFORMATION

if (isset($_POST["teach_update"])){
    $id     = $_POST['id'];
    $fn     = $_POST['fn'];
    $mn     = $_POST['mn'];
    $ln     = $_POST['ln'];
    $gr     = $_POST['gr'];
    $bd     = $_POST['bd'];
    $num    = $_POST['num'];
    $email  = $_POST['email'];

    $updateQuery = "UPDATE teacher_info SET t_fn = ?, t_mn = ?, t_ln = ?, t_gender = ?, t_bdate = ?, t_num = ?, t_email = ? WHERE t_id = ?";
    // $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-out','$student_id','Logged $log_upt_out')");
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'sssssssi', $fn, $mn, $ln, $gr, $bd, $num, $email, $id);
    mysqli_stmt_execute($stmt);
        if ($stmt) {
            $_SESSION['added'] = "You have successfully Updated the Event Schedule";
            header("Location: m-teacher.php");
        } else {
            $_SESSION['error'] = "Error adding section!";
            header("Location: m-teacher.php");
        }
}
//UPDATING SUBJECT NAME
if (isset($_POST["sub_update"])){
    $id     = $_POST['id'];
    $sub_n     = $_POST['subname'];

    $updateQuery = "UPDATE subjects SET sub_name = ? WHERE s_id = ?";
    // $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-out','$student_id','Logged $log_upt_out')");
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'si', $sub_n, $id);
    mysqli_stmt_execute($stmt);
        if ($stmt) {
            $_SESSION['added'] = "You have successfully Updated the Event Schedule";
            header("Location: m-subject.php");
        } else {
            $_SESSION['error'] = "Error adding section!";
            header("Location: m-subject.php");
        }
}

// UPDATING ASSIGNED SUBJECT OF TEACHER
if (isset($_POST["assign_update"])){
    $id     = $_POST['as_id'];
    $tid    = $_POST['teacher'];
    $sid    = $_POST['subject'];
    $adv    = $_POST['advisory'];

    $updateQuery = "UPDATE teaching_load SET t_id = ?, s_id = ?, adv_id = ? WHERE id_tl = ?";
    // $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-out','$student_id','Logged $log_upt_out')");
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'iiii', $tid, $sid, $adv, $id);
    mysqli_stmt_execute($stmt);
        if ($stmt) {
            $_SESSION['added'] = "You have successfully Updated the Event Schedule";
            header("Location: m-teachload.php");
        } else {
            $_SESSION['error'] = "Error adding section!";
            header("Location: m-teachload.php");
        }
}
// UPDATING USER STATUS: ACTIVE OR DEACTIVATE
if(isset($_GET['userid'])){
    $get_userid = $_GET['userid'];

    // Assuming $conn is your mysqli connection
    $db = mysqli_query($conn, "SELECT * FROM user WHERE id ='$get_userid'");
    while ($row = mysqli_fetch_array($db)) {
        echo $curr_status = $row['status'];
    }
    
    if ($curr_status == "Active") {
        $sql = "UPDATE user SET status=? WHERE id=?";
        $this_status = "Deactivate";
        $q = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($q, "si", $this_status, $get_userid);
        mysqli_stmt_execute($q);
        header("location: m-user-acc.php");
    } else {
        $sql = "UPDATE user SET status=? WHERE id=?";
        $this_status = "Active";
        $q = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($q, "si", $this_status, $get_userid);
        mysqli_stmt_execute($q);
        header("location: m-user-acc.php");
    }
  
}
// UPDATING NAME OF TRACK
if (isset($_POST["track_Name"])){
    $trackId = $_POST['id'];
    $trackName    = $_POST['trackName'];


    $updateQuery = "UPDATE tracks SET track_name = ? WHERE track_id = ?;";
    // $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-out','$student_id','Logged $log_upt_out')");
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'si', $trackName, $trackId);
    mysqli_stmt_execute($stmt);
        if ($stmt) {
            $_SESSION['added'] = "You have successfully Updated the Event Schedule";
            header("Location: m-track.php");
        } else {
            $_SESSION['error'] = "Error adding section!";
            header("Location: m-track.php");
        }
}

  // UPDATING SCHOOL YEAR
if (isset($_POST["syUpdate"])){
    $syId = $_POST['id'];
    $syName    = $_POST['syName'];
    $semId  = $_POST['semId'];


    $updateQuery = "UPDATE school_year SET sy_name = ?, sem_id = ? WHERE sy_id = ?";
    // $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-out','$student_id','Logged $log_upt_out')");
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'sii', $syName, $semId, $syId);
    mysqli_stmt_execute($stmt);
        if ($stmt) {
            $_SESSION['added'] = "You have successfully Updated the Event Schedule";
            header("Location: m-school-year.php");
        } else {
            $_SESSION['error'] = "Error adding section!";
            header("Location: m-school-year.php");
        }
}
  // UPDATING STRAND
  if (isset($_POST["strand_update"])){
    $syId = $_POST['id'];
    $syName    = $_POST['strandName'];


    $updateQuery = "UPDATE strands SET strand_name = ? WHERE strand_id = ?";
    // $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-out','$student_id','Logged $log_upt_out')");
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'si', $syName, $syId);
    mysqli_stmt_execute($stmt);
        if ($stmt) {
            $_SESSION['added'] = "You have successfully Updated the Event Schedule";
            header("Location: m-strand.php");
        } else {
            $_SESSION['error'] = "Error adding section!";
            header("Location: m-strand.php");
        }
} 
  // UPDATING STRAND
  if (isset($_POST["subcat_name"])){
    $scId = $_POST['id'];
    $scName    = $_POST['subcatName'];


    $updateQuery = "UPDATE subject_category SET subcat_name = ? WHERE id = ?";
    // $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-out','$student_id','Logged $log_upt_out')");
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'si', $scName, $scId);
    mysqli_stmt_execute($stmt);
        if ($stmt) {
            $_SESSION['added'] = "You have successfully Updated the Event Schedule";
            header("Location: s-sub-cat.php");
        } else {
            $_SESSION['error'] = "Error adding section!";
            header("Location: s-sub-cat.php");
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
        // Insert data into the dynamically generated table based on school year
        $school_year_query = "SELECT * FROM `school_year` WHERE `sy_id` = ?";
        $stmt = mysqli_prepare($conn, $school_year_query);
        mysqli_stmt_bind_param($stmt, 's', $_POST['syId']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $sy_n = $row['sy_name'];

            $new_table_name = $sy_n . "_student";
                
                    // Insert data into the dynamically generated table
                    $update_studentlist = "UPDATE `$new_table_name` SET student_id = ? , fname = ? , mname = ?, lname = ?, grade = ?, section = ?, adviser = ?, dob = ?, gender = ?, contact = ?, province = ?, municipality = ?, barangay = ?, images = '$imagepath', track_id = ?, strand_id = ?, sy_enrolled = ? WHERE `sid`= ?";
                
                    $stmt = mysqli_prepare($conn, $update_studentlist);
                    mysqli_stmt_bind_param($stmt, 'sssssssssssssiiii', $student_id,$fname,$mname,$lname,$grade,$section,$adviser,$dob,$gender,$contact,$province,$municipality,$barangay,$trackId,$strandId,$syId,$sid);
                    mysqli_stmt_execute($stmt);
        } else {
            $_SESSION['error'] = "School year ID not found.";
            header("Location: m-student.php");
            exit; // Terminate script to prevent further execution
        }
        if ($updateResult) {
            

            

            $_SESSION['success'] = "Student information updated successfully!";
        } else {
            $_SESSION['error'] = "Error updating student information!";
        }

    header("Location: m-student.php");
    exit();
}

// UPDATING USER PASSWORD
if (isset($_POST["pass_reset"])){
    $uId = $_POST['id'];
    $uPass = $_POST['pass'];


    $updateQuery = "UPDATE user SET password = ? WHERE id = ?";
    // $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-out','$student_id','Logged $log_upt_out')");
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'ss', $uPass, $uId);
    mysqli_stmt_execute($stmt);
        if ($stmt) {
            $_SESSION['added'] = "You have successfully Updated the Event Schedule";
            header("Location: m-user-acc.php");
        } else {
            $_SESSION['error'] = "Error adding section!";
            header("Location: m-user-acc.php");
        }
}
// ADDING MULTIPLE SECTION AT THE SAME TIME
if(isset($_POST['submit1'])){
$a_id = $_GET['a_id'];
    // Counting No fo skillss
$count = count($_POST["section1"]);
$c1 = count($_POST["grade1"]);
//Getting post values
$section=$_POST["section1"];
$grade1 = $_POST["grade1"];
    if($count >= 1 && $c1 >= 1)
    {
        for($i=0; $i<$count && $i<$c1; $i++)
        {
            if(trim($_POST["section1"][$i] != '') && trim($_POST["grade1"][$i] != ''))
            {
                $sql= mysqli_query($conn,"INSERT INTO `section` (section_name,stud_grade) VALUES('$section[$i]','$grade1[$i]')");
            }
        }
    header("Location: m-class-edit.php?a_id=$a_id");
    echo "<script>alert('Section inserted successfully');</script>";
    }
    else
    {
    echo "<script>alert('Please enter Section name');</script>";
    }
}

// UPDATING STRAND
if (isset($_POST["sec_update"])){
    $grId   = $_POST['grade'];
    $sid    = $_POST['sId'];
    $secName = $_POST['section'];
    $updateQuery = "UPDATE section SET section_name = ? WHERE section_id = ? AND stud_grade = ?";
    // $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-out','$student_id','Logged $log_upt_out')");
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'sii', $secName, $sid, $grId);
    mysqli_stmt_execute($stmt);
        if ($stmt) {
            $_SESSION['added'] = "You have successfully Updated the Section";
            header("Location: m-class-edit.php?a_id=$grId");
        } else {
            $_SESSION['error'] = "Error adding section!";
            header("Location: m-class-edit.php?a_id=$grId");
        }
}
// UPDATING STRAND
if (isset($_POST["uptSchedSub"])){
    $csid   = $_POST['csid'];
    $inp    = $_POST['inp'];
    $inl    = $_POST['inl'];
    $clout    = $_POST['clout'];
    $updateQuery = "UPDATE class_sched SET inp = ?, inl = ?, log_out = ? WHERE cs_id = ?";
    // $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-out','$student_id','Logged $log_upt_out')");
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'sssi', $inp, $inl, $clout, $csid);
    mysqli_stmt_execute($stmt);
        if ($stmt) {
            $_SESSION['added'] = "You have successfully Updated the Schedule";
            header("Location: m-sched-class.php");
        } else {
            $_SESSION['error'] = "Updating Subject Schedule!";
            header("Location: m-sched-class.php");
        }
}

// UPDATING SCHOOL INFORMATION
if (isset($_POST["sp_update"])){
    $id = $_POST['id'];
    $sname  = $_POST['s_name'];
    $sid    = $_POST['s_id'];
    $sreg   = $_POST['sreg'];
    $sdis   = $_POST['sdis'];
    $sdiv   = $_POST['sdiv'];
    $semail = $_POST['s_email'];
    $sno    = $_POST['s_no'];
    $sfb    = $_POST['s_fb'];
    $sinfo  = $_POST['s_info'];

        // Check if a new image is uploaded
    if (!empty($_FILES['images']['name'])) {
        $image_name = $_FILES['images']['name'];
        $temp = explode(".", $image_name);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $imagepath = "../../images/admin/" . $newfilename;
        
        // Move uploaded file
        move_uploaded_file($_FILES["images"]["tmp_name"], $imagepath);
        
        // Update the student information with the new image path
        mysqli_query($conn, "UPDATE `school_profile` SET `image` = '$imagepath' WHERE id = '$id'");
    }

    $updateQuery = "UPDATE school_profile SET name = ?, info = ?, s_email = ?, s_no = ?, s_fb = ?, school_id = ?, district = ?, division = ?, region = ? WHERE id = ?";
    // $insert2 = mysqli_query($conn, "INSERT INTO `logs`(icon,user_id,action) values('fas fa-sign-out','$student_id','Logged $log_upt_out')");
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'sssssssssi', $sname, $sinfo, $semail, $sno, $sfb, $sid, $sdis, $sdiv, $sreg, $id );
    mysqli_stmt_execute($stmt);
        if ($stmt) {
            $_SESSION['added'] = "You have successfully Updated the Schedule";
            header("Location: m-school-info.php");
        } else {
            $_SESSION['error'] = "Updating Subject Schedule!";
            header("Location: m-school-info.php");
        }
}
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


// ARCHIVING STUDENT
if(isset($_POST['arc_stud'])){
    $arcId = $_POST['arcId'];
    $sId   = $_POST['sId'];

    $updateArchive = "UPDATE new_students SET arc_stat = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $updateArchive);
    mysqli_stmt_bind_param($stmt, 'ii', $arcId, $sId);
    mysqli_stmt_execute($stmt);
    
        if($stmt){
            $_SESSION['updated'] = "You have successofully Archived the Student";
            header("Location:m-student.php");
        }else{
            $_SESSION['error'] = "Unsuccessful Archiving Student";
            header("Location:m-student.php");
        }
}

// RETRIEVING STUDENT
if(isset($_POST['ret_stud'])){
    $arcId = $_POST['retId'];
    $sId   = $_POST['sId'];

    $updateArchive = "UPDATE new_students SET arc_stat = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $updateArchive);
    mysqli_stmt_bind_param($stmt, 'ii', $arcId, $sId);
    mysqli_stmt_execute($stmt);
    
        if($stmt){
            $_SESSION['updated'] = "You have successofully Archived the Student";
            header("Location:m-archive.php");
        }else{
            $_SESSION['error'] = "Unsuccessful Archiving Student";
            header("Location:m-archive.php");
        }
}
// EDITING / UPDATING ADMINISTRATIVE ROLE
if(isset($_POST['adminRoleUpt'])){
    $adminRoleId = $_POST['id'];
    $adminRoleName   = $_POST['AdminRole'];

    $updateAdminRole = "UPDATE administrativerole SET AdminRole = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $updateAdminRole);
    mysqli_stmt_bind_param($stmt, 'si', $adminRoleName, $adminRoleId);
    mysqli_stmt_execute($stmt);
    
        if($stmt){
            $_SESSION['updated'] = "You have successfully updated";
            header("Location:m-adminrole.php");
        }else{
            $_SESSION['error'] = "Unsuccessful Updating Aministrative Role";
            header("Location:m-adminrole.php");
        }
}
?>
