<?php

    include "header.php";
    include("../../Inc/connect.php");
    include "delete_btm.php";
    if (!isset($_SESSION["username"])) {
        ?>
            <script type="text/javascript">
                window.location="../../index.php";
            </script>
        <?php
    }

    $id_s =$_GET["id"];
    
    $query = mysqli_query($conn, "select * from `new_students` where `student_id` = '$id_s'");
    while($row=mysqli_fetch_array($query)){
        $id = $row['student_id'];
        $fname =$row['fname'];
        $mname = $row['mname'];
        $lname = $row['lname'];
        $prob = $row['province'];
        $mun = $row['municipality'];
        $brgy = $row['barangay'];
        $grade = $row['grade'];
        $section = $row['section'];
        $adviser = $row['adviser'];
        $contact = $row['contact'];
        $dob = $row['dob'];
        $gender = $row['gender'];
        $img = $row['images'];

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<section class="dashboard">
        <div class="top">
            <i class="fas fa-bars sidebar-toggle"></i>
            <span>EDIT STUDENT</span>
        </div>
        <div class="dash-content">

        
            <!-- =================================== SELECT AND UPLOAD BUTTON FOR PROFILE ======================== -->
        <div class="item-container">

            <form action="stud-update.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="student_id" value="<?php echo $id; ?>">
                <div class="half">
                        <div class="item">
                            <div class="photo">

                                <?php
                                    $res = mysqli_query($conn, "select * from `new_students` where `student_id` ='$id'");
                                        while ($row = mysqli_fetch_array($res))
                                        {
                                            ?><img src="<?php echo $row["images"]; ?> " height="200" width="200" style="text-align:center;border-radius:50%;border:2px solid black" alt="something wrong"></a> <?php
                                        }
                                ?>

                            </div>
                        </div>
                        <div class="item">
                        <label for="images">Image:</label>
                        <input type="file" name="images" accept="image/png, image/gif, image/jpeg" class="modal-mt" id="image">
                        </div>
                </div>
                
                <div class="half">

                        <div class="item">
                        <label for="fname">First Name:</label>
                        <input type="text" name="fname" value="<?php echo $fname; ?>" required><br>
                        </div>

                    <div class="item">
                    <label for="mname">Middle Name:</label>
                    <input type="text" name="mname" value="<?php echo $mname; ?>"><br>
                    </div>

                    <div class="item">
                    <label for="lname">Last Name:</label>
                    <input type="text" name="lname" value="<?php echo $lname; ?>" required><br>
                    </div>

                </div>

                <div class="half">
                    <div class="item">
                    <label for="grade">Grade:</label>
                    <input type="text" name="grade" value="<?php echo $grade; ?>" required><br>
                    </div>

                    <div class="item">
                    <label for="section">Section:</label>
                    <input type="text" name="section" value="<?php echo $section; ?>"><br>
                    </div>

                    <div class="item">
                    <label for="adviser">Adviser:</label>
                    <input type="text" name="adviser" value="<?php echo $adviser; ?>"><br>
                    </div>
                </div>
                <div class="half">
                    <div class="item">
                    <label for="province">Province:</label>
                    <input type="text" name="province" value="<?php echo $prob; ?>"><br>
                    </div>

                    <div class="item">
                    <label for="municipality">Municipality:</label>
                    <input type="text" name="municipality" value="<?php echo $mun; ?>"><br>
                    </div>

                    <div class="item">
                    <label for="barangay">Barangay:</label>
                    <input type="text" name="barangay" value="<?php echo $brgy; ?>"><br>
                    </div>
                </div>
                <div class="half">
                    <div class="item">
                    <label for="contact">Contact:</label>
                    <input type="tel" name="contact" value="<?php echo $contact; ?>"><br>
                    </div>

                    <div class="item">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" name="dob" value="<?php echo $dob; ?>" required><br>
                    </div>
                    
                    <div class="item">
                    <label for="gender">Gender:</label>
                    <select name="gender" required>
                        <option value="Male" <?php echo ($gender === 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo ($gender === 'Female') ? 'selected' : ''; ?>>Female</option>
                    </select><br>
                    </div>
                </div>
                <input type="submit" name="submit" value="Update">
            </form>
        </div>
        </div>
    </tbody>
</table>
    </section>

<?php
    include("footer.php");
?>
</body>
</html>