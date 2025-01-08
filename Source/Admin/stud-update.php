<?php
session_start();
include "../../inc/connect.php";

if (isset($_POST["submit"])) {
    // Retrieve data from the form
    $student_id = $_POST['student_id'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $province = $_POST['province'];
    $municipality = $_POST['municipality'];
    $barangay = $_POST['barangay'];
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
        mysqli_query($conn, "UPDATE `new_students` SET images = '$imagepath' WHERE student_id = '$student_id'");
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
                    gender = '$gender'
                    WHERE student_id = '$student_id'";

    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        $_SESSION['success'] = "Student information updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating student information!";
    }

    header("Location: m-student.php");
    exit();
} else {
    // Redirect if the form is not submitted
    header("Location:m-student.php");
    exit();
}
?>
