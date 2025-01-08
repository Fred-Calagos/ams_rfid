<?php
    include "../../inc/connect.php";

        // ADDING STUDENT INFORMATION

        if (isset($_POST["add-student"])) {
            $rfid           = $_POST['rfidcard']; //used as student username
            $fname          = $_POST['fname'];
            $mname          = $_POST['mname'];
            $lname          = $_POST['lname'];
            $grade          = $_POST['grade'];
            $section        = $_POST['section'];
            $adviser        = $_POST['adviser'];
            $dob            = $_POST['dob'];
            $gender         = $_POST['gender'];
            $contact        = $_POST['contact'];
            $province       = $_POST['province'];
            $municipality   = $_POST['municipality'];
            $barangay       = $_POST['barangay'];
            $pass           = $_POST['pass']; // the random generated password
            $sy             = $_POST['sy'];
            $track          = $_POST['track'];
            $strand         = $_POST['strand'];

            $filename       = $_FILES['images']['name'];
            $temp           = explode(".", $filename);
            $newfilename    = round(microtime(true)) . '.' . end($temp);
            $tmpName        = $_FILES['images']['tmp_name'];
            $imagePath      = '../../Images/'.$filename;
            move_uploaded_file($_FILES["images"]["tmp_name"],$imagePath);

            $insert= mysqli_query($conn, "INSERT INTO `new_students` (student_id,fname,mname,lname,grade,section,adviser,dob,gender,contact,province,municipality,barangay,images, track_id, strand_id, sy_enrolled, arc_stat) 
                                            VALUES ('$rfid','$fname','$mname','$lname','$grade','$section','$adviser','$dob','$gender','$contact','$province','$municipality','$barangay','$imagePath','$track','$strand','$sy', 1)");
            $student_id = mysqli_insert_id($conn);
            $insert2 = mysqli_query($conn, "INSERT INTO `logs`(action) values('Added user $rfid')");
            // Check if the username already exists
            $user_check_query = "SELECT * FROM `user` WHERE `username` = '$rfid'";
            $user_check_result = mysqli_query($conn, $user_check_query);

            if (mysqli_num_rows($user_check_result) == 0) {
                // Username doesn't exist, insert the new user
                $insert_user_query = "INSERT INTO `user` (username, password, role, status) VALUES ('$rfid', '$pass', '2', 'Active')";
                $insert_user_result = mysqli_query($conn, $insert_user_query);

                if (!$insert_user_result) {
                    $_SESSION['error'] = "Error Adding User!";
                    header("Location: m-student.php");
                    exit; // Terminate script
                }
            }

// Continue with the rest of your code...

            
            if (!$insert) {
                $_SESSION['error'] = "Error Adding!";
                header("Location: m-student.php");
                exit; // Terminate script to prevent further execution
            }
            
            
            // Insert data into the dynamically generated table based on school year
            $school_year_query = "SELECT * FROM `school_year` WHERE `sy_id` = ?";
            $stmt = mysqli_prepare($conn, $school_year_query);
            mysqli_stmt_bind_param($stmt, 's', $_POST['sy']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $sy_n = $row['sy_name'];
            
                // Construct the new table name
                $new_table_name = $sy_n . "_student";
            
                // Insert data into the dynamically generated table
                $insert_query = "INSERT INTO `$new_table_name` (sid,student_id, fname, mname, lname, grade, section, adviser, dob, gender, contact, province, municipality, barangay, images, track_id, strand_id, sy_enrolled) 
                                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            
                $stmt = mysqli_prepare($conn, $insert_query);
                mysqli_stmt_bind_param($stmt, 'issssssssssssssiii', $student_id,$rfid,$fname,$mname,$lname,$grade,$section,$adviser,$dob,$gender,$contact,$province,$municipality,$barangay,$imagePath,$track,$strand,$sy);
                mysqli_stmt_execute($stmt);
            } else {
                $_SESSION['error'] = "School year ID not found.";
                header("Location: m-student.php");
                exit; // Terminate script to prevent further execution
            }

        
            // Update RFID status to "Active" if it was previously "Vacant"
            $updateRfidQuery = "UPDATE `rfid` SET rfid_status = 'Active' WHERE rfid_no = '$rfid' AND rfid_status = 'Vacant'";
            $conn->query($updateRfidQuery);
        
            $_SESSION['added'] = "You have successfully added a student: $fname";
            header("Location: m-student.php");
            exit; // Terminate script to prevent further execution
    }

    // ADDING DATE SCHEDULE

    if(isset($_POST["add_time"])){
        
            $ps   =  $_POST['ps'];
            $pe   =  $_POST['pe'];
            $ls   =  $_POST['ls'];
            $le   =  $_POST['le'];
            $psa   =  $_POST['psa'];
            $pea   =  $_POST['pea'];
            $lsa   =  $_POST['lsa'];
            $lea   =  $_POST['lea'];
            $amo   = $_POST['am_o'];
            $pmo   = $_POST['pm_o'];

            $insert ="INSERT INTO `att_sched`(am_ps, am_pe, am_ls, am_le, am_logout, pm_ps, pm_pe, pm_ls, pm_le, pm_logout) VALUES (?,?,?,?,?,?,?,?,?,?)";
            $stmt = mysqli_prepare($conn, $insert);
            mysqli_stmt_bind_param($stmt, 'ssssssssss', $ps ,$pe ,$ls ,$le ,$psa,$pea,$lsa,$lea,$amo,$pmo);
            mysqli_stmt_execute($stmt);

            if($stmt)
            {

            
            $_SESSION['added'] = "You have successfully added a book: `$fname`";
            header("Location:a-class-sched.php");

            }
            else
            { 
                $_SESSION['error'] = "Error Adding! ";
            header("Location:a-class-sched.php");
            }
    }

    // ADDING EVENT SCHEDULE
    if(isset($_POST["add_event"])){
        $event  = $_POST['event'];
        $date   = $_POST['date'];
        $mti    = $_POST['mti'];
        $mto    = $_POST['mto'];
        $aftti  = $_POST['aftti'];
        $aftto  = $_POST['aftto'];
        $eveti  = $_POST['eveti'];
        $eveto  = $_POST['eveto'];

        $insert ="INSERT INTO `event_sched`(event_name, event_date, am_ti,am_to,pm_ti,pm_to,eve_ti, eve_to) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $insert);
        mysqli_stmt_bind_param($stmt, 'ssssssss', $event, $date, $mti,$mto,$aftti, $aftto, $eveti, $eveto );
        mysqli_stmt_execute($stmt);

        if($stmt)
        {

        
        $_SESSION['added'] = "You have successfully added an Event: `$event`";
        header("Location:a-class-sched.php");

        }
        else
        { 
            $_SESSION['error'] = "Error Adding! ";
        header("Location:a-class-sched.php");
        }
    }

    // ADDING TEACHER
    if(isset($_POST["add_teach"])){
        $fn     = $_POST['fname'];
        $mn     = $_POST['mname'];
        $ln     = $_POST['lname'];
        $gndr   = $_POST['gender'];
        $num    = $_POST['contact'];
        $bdate  = $_POST['bdate'];
        $email  = $_POST['email'];
        $rfid   = $_POST['rfidcard'];
        $pass   = $_POST['pass'];

        $insert ="INSERT INTO `teacher_info`(t_fn,t_mn,t_ln,t_gender,t_bdate,t_num,t_email,t_rfid) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $insert);
        mysqli_stmt_bind_param($stmt, 'ssssssss', $fn, $mn, $ln,$gndr,$bdate,$num, $email,$rfid);
        mysqli_stmt_execute($stmt);

        if($stmt)
        {
            $select = mysqli_query($conn,"SELECT * FROM teacher_info WHERE t_email = '$email'");
            $update = mysqli_query($conn,"INSERT INTO user (username,password,status,role) VALUES('$rfid','$pass','Active','3')");
        
        $_SESSION['added'] = "You have successfully added an Event: `$fn $mn $ln`";
        header("Location:m-teacher.php");

        }
        else
        { 
            $_SESSION['error'] = "Error Adding! ";
        header("Location:m-teacher.php");
        }
    }

        // ADDING ADMIN
        if(isset($_POST["add_admin"])){
            $fn     = $_POST['fname'];
            $mn     = $_POST['mname'];
            $ln     = $_POST['lname'];
            $rfid   = $_POST['rfidcard'];
            $pass   = $_POST['pass'];
            $role   = $_POST['adrole'];
            $filename       = $_FILES['images']['name'];
            $temp           = explode(".", $filename);
            $newfilename    = round(microtime(true)) . '.' . end($temp);
            $tmpName        = $_FILES['images']['tmp_name'];
            $imagePath      = '../../Images/'.$filename;
            move_uploaded_file($_FILES["images"]["tmp_name"],$imagePath);
    
            $insert ="INSERT INTO `admin`(admin_fname,admin_mname,admin_lname,profile,authority,rfid_admin) VALUES (?,?,?,?,?,?)";
            $stmt = mysqli_prepare($conn, $insert);
            mysqli_stmt_bind_param($stmt, 'ssssis', $fn, $mn, $ln,$imagePath,$role,$rfid);
            mysqli_stmt_execute($stmt);
    
            if($stmt)
            {
                $update = mysqli_query($conn,"INSERT INTO user (username,password,status,role) VALUES('$rfid','$pass','Active','1')");
            
            $_SESSION['added'] = "You have successfully added an Event: `$fn $mn $ln`";
            header("Location:m-admin.php");
    
            }
            else
            { 
                $_SESSION['error'] = "Error Adding! ";
            header("Location:m-admin.php");
            }
        }

    // ADDING SUBJECT

    if(isset($_POST["add-subject"])){
        $sub_n  = $_POST['subTitle'];
        $subcatId  = $_POST['subcat'];
        $subDesc  = $_POST['subDesc'];
        $strand  = $_POST['strand'];
        $grade  = $_POST['grade'];
        $track  = $_POST['track'];

        $insert ="INSERT INTO `subjects`(sub_name,sub_desc,strand_id,subcat_id,grade_id, track_id) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $insert);
        mysqli_stmt_bind_param($stmt, 'ssiiii', $sub_n, $subDesc, $strand, $subcatId, $grade, $track);
        mysqli_stmt_execute($stmt);

        if($stmt)
        {

        
        $_SESSION['added'] = "You have successfully added a Subject: `$sub_n`";
        header("Location:m-subject.php");

        }
        else
        { 
            $_SESSION['error'] = "Error Adding! ";
        header("Location:m-subject.php");
        }
    }

        // ADDING STUDENT ACCOUNT

    if(isset($_POST["u_add"])){
        $u = $_POST["rfidcard"];
        $p = $_POST["pass"];
        $r = $_POST['role'];

        // Check if the school name already exists
        $checkQuery = "SELECT * FROM `user` WHERE `username` = '$u'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
                header("Location:m-user-acc.php?error=This Account already Exist");
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

    if(isset($_POST["ut_add"])){
        $u = $_POST["rfidcard"];
        $p = $_POST["pass"];
        $r = $_POST['role'];

        // Check if the school name already exists
        $checkQuery = "SELECT * FROM `user` WHERE `username` = '$u'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
                $_SESSION['error'] = "Error Updating!";
                header("Location: m-user-acc.php");
            
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
        // ADDING TEACHING LOAD

        if(isset($_POST["add_teachload"])){
            $teacher  = $_POST['teacher'];
            $subject  = $_POST['subject'];
            $advisory  = $_POST['advisory'];
    
            $insert ="INSERT INTO `teaching_load`(t_id,s_id,adv_id) VALUES (?,?,?)";
            $stmt = mysqli_prepare($conn, $insert);
            mysqli_stmt_bind_param($stmt, 'iii', $teacher, $subject, $advisory);
            mysqli_stmt_execute($stmt);
    
            if($stmt)
            {
    
            
            $_SESSION['added'] = "You have successfully Assign a Subject";
            header("Location:m-teachload.php");
    
            }
            else
            { 
                $_SESSION['error'] = "Error Adding! ";
            header("Location:m-teachload.php");
            }
        }

            // ADDING TRACK

    if(isset($_POST["add-track"])){
        $tr_n  = $_POST['trackName'];

        $insert ="INSERT INTO `tracks`(track_name) VALUES (?)";
        $stmt = mysqli_prepare($conn, $insert);
        mysqli_stmt_bind_param($stmt, 's', $tr_n);
        mysqli_stmt_execute($stmt);

        if($stmt)
        {

        
        $_SESSION['added'] = "You have successfully added a New Track: `$tr_n`";
        header("Location:m-track.php");

        }
        else
        { 
            $_SESSION['error'] = "Error Adding! ";
        header("Location:m-track.php");
        }
    }

// ADDING SCHOOL YEAR

    if(isset($_POST["add-sy"])){
        $sy_n  = $_POST['syName'];
        $insert ="INSERT INTO `school_year`(sy_name) VALUES (?)";
        $stmt = mysqli_prepare($conn, $insert);
        mysqli_stmt_bind_param($stmt, 's', $sy_n);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
    
        // Once sy_name is inserted successfully, create a new table
        $new_table_name = str_replace(' ', '_', $sy_n) . "_student"; // Generate a table name based on sy_name
        $sql = "CREATE TABLE `$new_table_name` (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `student_id` varchar(45) NOT NULL,
            `fname` varchar(100) NOT NULL,
            `mname` varchar(100) NOT NULL,
            `lname` varchar(100) NOT NULL,
            `province` varchar(100) NOT NULL,
            `municipality` varchar(100) NOT NULL,
            `barangay` varchar(100) NOT NULL,
            `grade` varchar(100) NOT NULL,
            `section` varchar(100) NOT NULL,
            `adviser` int NOT NULL,
            `contact` varchar(12) NOT NULL,
            `dob` varchar(20) NOT NULL,
            `gender` varchar(20) NOT NULL,
            `images` varchar(5000) DEFAULT NULL,
            `enroll_status` varchar(100) DEFAULT NULL,
            `track_id` INT(6) DEFAULT NULL,
            `strand_id` INT(6) DEFAULT NULL,
            `sy_enrolled` INT(6) DEFAULT NULL,
            `sid` INT(10) DEFAULT NULL,
            UNIQUE KEY `fullname_bod` (`fname`,`lname`,`dob`)
        )";

        echo "SQL Query: " . $sql; // Debugging - Echo out the SQL query

        if ($conn->query($sql) === TRUE) {
            $_SESSION['added'] = "You have successfully added a New Track: $sy_n";
            header("Location: m-school-year.php");
        } else {
            $_SESSION['error'] = "Error creating table: " . $conn->error;
            header("Location: m-school-year.php");
        }

        $_SESSION['added'] = "You have successfully added a New Track: `$sy_n`";
        header("Location:m-school-year.php");
    
        }
        else
        { 
            $_SESSION['error'] = "Error Adding! ";
        header("Location:m-school-year.php");
        }
    }

// ADDING STRAND ON TRACK
if(isset($_POST["add-strand"])){
    $tr_id  = $_POST['track'];
    $st_n   = $_POST['strandName'];

    $insert ="INSERT INTO `strands`(strand_name, track_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $insert);
    mysqli_stmt_bind_param($stmt, 'si', $st_n, $tr_id);
    mysqli_stmt_execute($stmt);

    if($stmt)
    {

    
    $_SESSION['added'] = "You have successfully added a New Strand: `$st_n`";
    header("Location:m-strand.php");

    }
    else
    { 
        $_SESSION['error'] = "Error Adding! ";
    header("Location:m-strand.php");
    }
}
// ADDING SUBJECT CATEGORY
if(isset($_POST["add-subcat"])){
    $st_n   = $_POST['subCat'];

    $insert ="INSERT INTO `subject_category`(subcat_name) VALUES (?)";
    $stmt = mysqli_prepare($conn, $insert);
    mysqli_stmt_bind_param($stmt, 's', $st_n,);
    mysqli_stmt_execute($stmt);

    if($stmt)
    {

    
    $_SESSION['added'] = "You have successfully added a New Strand: `$st_n`";
    header("Location:s-sub-cat.php");

    }
    else
    { 
        $_SESSION['error'] = "Error Adding! ";
    header("Location:s-sub-cat.php");
    }
}
// ADDING SCHOOL INFORMATION
if (isset($_POST["s-info"])) {
    $s_name   = $_POST['s_name'];
    $s_email  = $_POST['s_email'];
    $s_no     = $_POST['s_no'];
    $s_fb     = $_POST['s_fb'];
    $s_info   = $_POST['s_info'];

    $filename    = $_FILES['s_logo']['name'];
    $temp        = explode(".", $filename);
    $newfilename = round(microtime(true)) . '.' . end($temp);
    $tmpName     = $_FILES['s_logo']['tmp_name'];
    $imagePath   = '../../Images/Admin/' . $filename;

    // Check if the school name already exists
    $checkQuery = "SELECT * FROM `school_profile` WHERE `id` = id ";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {

            $_SESSION['error'] = "Update the Existing School Information";
            header("Location: m-school-info.php");
    } else {
        // Move uploaded file
        move_uploaded_file($_FILES["s_logo"]["tmp_name"], $imagePath);

        // Insert data into the school_profile table
        $insert = mysqli_query($conn, "INSERT INTO `school_profile` (name, image, info, s_email, s_no, s_fb) 
                                        VALUES ('$s_name', '$imagePath', '$s_info', '$s_email', '$s_no', '$s_fb')");
        $insert2 = mysqli_query($conn, "INSERT INTO `logs` (action) values('Added School name: $s_name')");

        if ($insert) {
            $_SESSION['added'] = "You have successfully added a school: `$s_name`";
            header("Location: m-school-info.php");
        } else {
            $_SESSION['error'] = "Error Adding!";
            header("Location: m-school-info.php");
        }
    }
}
// ADDING SUBJECT CATEGORY
if(isset($_POST["add_sched_sub"])){
    $idtl   = $_POST['idtl'];
    $inp    = $_POST['inp'];
    $inl    = $_POST['inl'];
    $clout  = $_POST['clout'];
    
    // Check if the combination already exists in the class_sched table
    $check_query = "SELECT COUNT(*) AS count FROM class_sched WHERE id_tl = ? AND inp = ? AND inl = ? AND log_out = ?";
    $stmt_check = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt_check, 'isss', $idtl, $inp, $inl, $clout);
    mysqli_stmt_execute($stmt_check);
    $result = mysqli_stmt_get_result($stmt_check);
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];
    
    if ($count > 0) {
        $_SESSION['error'] = "Error Adding! Combination already exists.";
        header("Location:m-teachload.php");
        exit; // Stop further execution
    }
    
    // If the combination doesn't exist, proceed with insertion
    $insert ="INSERT INTO `class_sched`(id_tl,inp,inl,log_out) VALUES (?,?,?,?)";
    $stmt = mysqli_prepare($conn, $insert);
    mysqli_stmt_bind_param($stmt, 'isss', $idtl, $inp, $inl, $clout);
    mysqli_stmt_execute($stmt);
    
    if($stmt) {
        $_SESSION['added'] = "You have successfully added a new record.";
        header("Location:m-teachload.php");
    } else { 
        $_SESSION['error'] = "Error Adding! ";
        header("Location:m-teachload.php");
    }
    
}
// adding year level
if(isset($_POST["add-year"])){
    $grade = $_POST["grade"];
    $hsCat = $_POST["hsCat"];

    $insert = mysqli_query($conn, "INSERT INTO  `grade` (stud_grade,hs_id) VALUES ('$grade', '$hsCat')");

    if($insert)
    {
    
    $_SESSION['added'] = "You have successfully added a new Grade: `$grade`";
    header("Location:m-class.php");

    }
    else
    { 
    $_SESSION['error'] = "Error Adding! ";
    header("Location:m-class.php");
    }
}


// ADDING ADMINSTRATIVE ROLE
if(isset($_POST["addAdminRole"])){
    $AdminRole = $_POST["AdminRole"];
    $insert = mysqli_query($conn, "INSERT INTO  `administrativerole` (AdminRole) VALUES ('$AdminRole')");

    if($insert)
    {
    
    $_SESSION['added'] = "You have successfully added a new Administrative Role: `$AdminRole`";
    header("Location:m-adminrole.php");

    }
    else
    { 
    $_SESSION['error'] = "Error Adding! ";
    header("Location:m-adminrole.php");
    }
}
?>
