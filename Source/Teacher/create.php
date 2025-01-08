<?php
    include "../../inc/connect.php";

        if(isset($_POST["btn_subSched"])){
            $ps  = $_POST['ps'];
            $ls  = $_POST['ls'];
            $out  = $_POST['out'];
    
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

            $insert= mysqli_query($conn, "INSERT INTO `new_students` (student_id,fname,mname,lname,grade,section,adviser,dob,gender,contact,province,municipality,barangay,images, track_id, strand_id, sy_enrolled) 
                                            VALUES ('$rfid','$fname','$mname','$lname','$grade','$section','$adviser','$dob','$gender','$contact','$province','$municipality','$barangay','$imagePath','$track','$strand','$sy')");
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
                    header("Location: s-student-adv.php");
                    exit; // Terminate script
                }
            }

// Continue with the rest of your code...

            
            if (!$insert) {
                $_SESSION['error'] = "Error Adding!";
                header("Location: s-attendance-adv.php");
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
                $insert_query = "INSERT INTO `$new_table_name` (student_id, fname, mname, lname, grade, section, adviser, dob, gender, contact, province, municipality, barangay, images, track_id, strand_id, sy_enrolled) 
                                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            
                $stmt = mysqli_prepare($conn, $insert_query);
                mysqli_stmt_bind_param($stmt, 'ssssssssssssssiii', $rfid,$fname,$mname,$lname,$grade,$section,$adviser,$dob,$gender,$contact,$province,$municipality,$barangay,$imagePath,$track,$strand,$sy);
                mysqli_stmt_execute($stmt);
            } else {
                $_SESSION['error'] = "School year ID not found.";
                header("Location: s-attendance-adv.php");
                exit; // Terminate script to prevent further execution
            }

        
            // Update RFID status to "Active" if it was previously "Vacant"
            $updateRfidQuery = "UPDATE `rfid` SET rfid_status = 'Active' WHERE rfid_no = '$rfid' AND rfid_status = 'Vacant'";
            $conn->query($updateRfidQuery);
        
            $_SESSION['added'] = "You have successfully added a student: $fname";
            header("Location: s-attendance-adv.php");
            exit; // Terminate script to prevent further execution
    }

    ?>
