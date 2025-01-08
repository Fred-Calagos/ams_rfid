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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDENT LIST</title>
    <script src="../../assets/js/jquery.js" type="text/javascript"></script>
    <script src="../../assets/js/js-script.js" type="text/javascript"></script>
    <script src="../../assets/jquery/jquery.min.js"></script>
<style>
    .disable-background {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    z-index: 1;
    backdrop-filter: blur(10px); /* Apply blur effect */
}

.modal_add_student {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 2; /* Ensure the modal appears above the blur background */
    /* Add other styles as needed */
}
</style>
<script>
// $(function() {
//     $( "#adviser").autocomplete({
//     source: 'stud-complete.php',
//     });
// });

function GetProDetails(str){
if(str.length == 0){
    document.getElementById("grade").value = "";
    document.getElementById("section").value = "";
    document.getElementById("gradeName").value = "";
    document.getElementById("sectionName").value = "";
    return;
}
else{

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200){
            
            var myObj = JSON.parse(this.responseText);
            document.getElementById("grade").value = myObj[0];
            document.getElementById("section").value = myObj[1];
            document.getElementById("gradeName").value = myObj[2];
            document.getElementById("sectionName").value = myObj[3];
        }
    };
    xmlhttp.open("GET", "stud-fill.php?adv=" + str, true);
    xmlhttp.send();

}
}
</script>
</head>
<body>
    <section class="dashboard">
        <div class="top">
        <i class="fas fa-bars sidebar-toggle"></i>

        </div>  
        <div class="dash-content">
        <div class="table-responsive">
            <div class="row well">
                <ul>
                    <li><a id="add-student-modal" class="btn_create1" href="#"> <i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp;ADD STUDENTS</a></li>
                </ul>
            </div><br>
            <i class="uil uil-search"></i><input type="text" placeholder="Search here..." id="search-stud" style="float:right;padding:10px;border:none;border-bottom:2px solid blue;outline:none;">
            <div id="result"></div>
                    <script>
                        
                    $(document).ready(function(){

                        load_data();

                            function load_data(query)
                                {
                                    $.ajax({
                                            url:"a-as-stud.php",
                                            method:"POST",
                                            data:{query:query},
                                            success:function(data)
                                            {
                                                $('#result').html(data);
                                            }
                                        });
                                }
                            $('#search-stud').keyup(function(){
                                var search = $(this).val();
                                    if(search != '')
                                        {
                                            load_data(search);
                                        }
                                        else
                                        {
                                            load_data();
                                        }
                                    });
                                });
                </script>
            </div>
            <div class="modal_add_student" id="modal_add_student">
            <div class="modal_content_student">
            
                
                    <form action="create.php" method="post" class="form-students" id="form-students" enctype="multipart/form-data">
                    <button type="button" name="cancel" id="btn_cancel" class="cancel">X</button><br>
                    <h3 class="modal_title"> ADD STUDENT</h3>
                    <hr style="border: 2px solid black; width:100%;">
                        <!-- Student ID -->

                        <div class="half">
                            <div class="item">
                                <label class="required" for="student_id">Student Profile</label>
                                <input type="file" name="images" accept=".jpg, .jpeg, .png" required>
                            </div>
                            <div class="item">
                                <label class="required" for="rfid">RFID No.</label>
                                <input type="text" name="rfidcard" id="rfidcard" placeholder="Scan RFID CARD" required>
                                <input type="hidden" id="password3" name="pass" readonly>
                                <input type="hidden" id="length3" value="9" hidden/>
                                <input type="hidden" id="uppercase3" checked hidden/>
                                <input type="hidden" id="lowercase3" checked hidden/>
                                <input type="hidden" id="numbers3" checked hidden/>
                                <input type="hidden" id="symbols3" checked hidden/>
                            </div>
                            <div class="item">
                                <label class="required" for="sy">School Year</label>
                                <select name="sy" id="" required>
                                    <option value="" selected disabled hidden>SELECT S.Y.</option>
                                    <?php
                                    $sql = "SELECT * FROM school_year ORDER BY sy_name asc";
                                    $data = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_array($data)) {
                                        ?>
                                            <option value="<?php echo $row['sy_id']?>"><?php echo $row['sy_name']?></option>';
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <!-- Full Name -->
                        <div class="half">
                            <div class="item">
                                <label class="required" for="fname">First Name</label>
                                <input type="text" name="fname" placeholder="Enter First Name" required oninput="lettersOnly(this)">
                            </div>
                            <div class="item">
                                <label class="required" for="mname">Middle Name</label>
                                <input type="text" name="mname" placeholder="Enter Surname" required  oninput="lettersOnly(this)">
                            </div>
                            <div class="item">
                                <label class="required" for="lname">Last Name</label>
                                <input type="text" name="lname" placeholder="Enter Last Name" required  oninput="lettersOnly(this)">
                            </div>
                        </div>
                        
                        <!-- GRADE LEVEL -->

                        <div class="half">

                            <div class="item">
                                <label class="required" for="adviser">Adviser</label>
                                <select name="adviser" id="" required onchange="GetProDetails(this.value)">
                                    <option value="" selected disabled hidden >--Select Adviser--</option>
                                    <?php
                                    $sql = "SELECT teacher.*, concat(teach.t_ln, ', ',teach.t_fn, ' ',teach.t_mn) as teach_n FROM teacher
                                            INNER JOIN teacher_info AS teach ON teacher.t_id = teach.t_id ORDER BY teach.t_ln asc";
                                    $allteach = mysqli_query($conn, $sql);
                                        while ($teach = mysqli_fetch_array($allteach)) {
                                            $adv = $teach['teach_n'];
                                        ?>
                                            <option value="<?php echo $teach['t_id']?>"><?php echo $adv?></option>';
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="item">
                                <label class="required" for="grade">Grade</label>
                                <input type="hidden" name="grade" id="grade" readonly>
                                <input type="text" name="gradeName" id="gradeName" readonly>
                            </div>

                            <div class="item">
                                <label class="required" for="section">Section</label>
                                <input type="hidden" name="section" id="section" readonly>
                                <input type="text" name="sectionName" id="sectionName" readonly>
                            </div>
                        </div>
                        <!-- ENROLLMENT SECTION -->
                        
                        <div class="half">
                                <div class="item">
                                    <h5>For Senior High</h5>
                                    <label for="adviser">Track</label>
                                        <select name="track" onchange="getStrand(this.value);">
                                            <option value="">Select Track</option>
                                            <?php
                                            $query = mysqli_query($conn, "SELECT * FROM tracks ORDER BY track_name ASC");
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <option style="text-align-last:left;" value="<?php echo htmlentities($row['track_id']); ?>"><?php echo $row['track_name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    <label class="required" for="strand">Strand</label>
                                    <select name="strand" id="strand">
                                        <option value="">Select Strand</option>
                                    </select>
                                </div>
                        <!-- Gender / Sex Identity -->
                            <div class="item">
                                <h5>Other Information</h5>
                                <label class="required" for="contact">Contact</label>
                                <input type="text" name="contact" placeholder="Enter Contact" required >
                                <label class="required" for="dob">Birth Date</label>
                                <input type="date" name="dob" placeholder="Enter Age" required >
                                <label class="required" for="gender">GENDER</label>
                                <select name="gender" placeholder="Please select Gender" id="" required>
                                    <option value=" ">SELECT GENDER</option>
                                    <?php
                                    $sql = "SELECT * FROM gender ORDER BY gender_id asc";
                                    $allgender = mysqli_query($conn, $sql);
                                        while ($genderall = mysqli_fetch_array($allgender)) {
                                        ?>
                                            <option value="<?php echo $genderall['gender']?>"><?php echo $genderall['gender']?></option>';
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        
                        <!-- Place or Location -->
                            <div class="item">
                            <h5>Address</h5>
                                <label class="required" for="province">Province</label>
                                <select name="province" onchange="getMunicipalities(this.value);">
                                    <option >Select Province</option>
                                    <?php
                                    $query = mysqli_query($conn, "SELECT * FROM refprovince ORDER BY provDesc ASC");
                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                    <option style="text-align-last:left;" value="<?php echo htmlentities($row['provCode']); ?>"><?php echo $row['provDesc']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label class="required" for="municipality">Municipality</label>
                                    <select name="municipality" id="municipality" onchange="getBarangays(this.value);">
                                        <option >Select Municipality</option>
                                    </select>
                                <label class="required" for="barangay">Barangay</label>
                                    <select name="barangay" id="barangay">
                                        <option >Select Barangay</option>
                                    </select>
                            </div>

                        </div>
                                <button type="submit" name="add-student" id="btn_add" class="btn_create1">Save</button>
                        <!-- -------------------------------- -->

                <script src="../../assets/js/rfid.js"></script>
                <script src="../../assets/js/rand_pass2.js"></script>
                <script src="../../assets/Js/modal-student.js"></script>
                <script src="../../assets/js/bootstrap.min.js"></script>
                <script src="../../assets/js/dependent.js"></script>
                    </form>

            </div>

            </div>
            <!--                    -->
            <!-- TABLE FOR STUDENTS -->
            <!--                    -->


        </div>
    </section>
            <!-- ---------------------------------------- -->
            <!-- POP UP MODAL FOR DELETING SUBJECTS-->
            <!-- ---------------------------------------- -->

            <div class="edit-form-container" id="stud_cont">
                    <?php
                        if(isset($_GET['d_id'])){
                        $t_id = $_GET['d_id'];  
                        $edit_query = mysqli_query($conn, "SELECT * FROM `new_students` WHERE id = $t_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($fetch_edit = mysqli_fetch_array($edit_query)){
                                    $dsid   = $fetch_edit['id'];
                                    $fn  = $fetch_edit['fname'];
                                    $mn  = $fetch_edit['mname'];
                                    $ln  = $fetch_edit['lname'];
                                };
                        ?>
                    <form action="delete.php"method="post" enctype="multipart/form-data">
                        <div class="flex-container">
                            <h4>Are you sure that you want to delete this Student: <?php echo $fn.' '.$mn.' '.$ln; ?> ?</h4><br>
                            <input type="hidden" name="sId" value="<?php echo $dsid; ?>">
                        </div>
                                <br>
                                <input type="submit" value="Delete" name="delete_stud" class="del_teach btn_delete1">&nbsp;
                                <input type="reset" value="cancel" id="close_del_stud" class="btn_cancel1">
                    </form>
                    <?php

                    };
                    echo "<script>document.querySelector('#stud_cont').style.display = 'flex';</script>";    
                };
            ?>
            </div>

            <!-- ---------------------------------------- -->
            <!-- POP UP MODAL FOR ARCHIVING STUDENTS-->
            <!-- ---------------------------------------- -->

            <div class="edit-form-container" id="stud_arc">
                    <?php
                        if(isset($_GET['arc_id'])){
                        $t_id = $_GET['arc_id'];  
                        $edit_query = mysqli_query($conn, "SELECT * FROM `new_students` WHERE id = $t_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($fetch_edit = mysqli_fetch_array($edit_query)){
                                    $dsid   = $fetch_edit['id'];
                                    $fn  = $fetch_edit['fname'];
                                    $mn  = $fetch_edit['mname'];
                                    $ln  = $fetch_edit['lname'];
                                };
                        ?>
                    <form action="c-update-yl.php"method="post" enctype="multipart/form-data">
                        <div class="flex-container">
                            <h4>Are you sure that you want to Archived this Student: <?php echo $fn.' '.$mn.' '.$ln; ?> ?</h4><br>
                            <input type="hidden" name="sId" value="<?php echo $dsid; ?>">
                            <input type="hidden" name="arcId" value="0">
                        </div>
                                <br>
                                <input type="submit" value="Archive" name="arc_stud" class="btn_delete1">&nbsp;
                                <input type="reset" value="cancel" id="close_arc_stud" class="btn_cancel1">
                    </form>
                    <?php

                    };
                    echo "<script>document.querySelector('#stud_arc').style.display = 'flex';</script>";    
                };
            ?>
            </div>
    </section>
    <?php
        include "footer.php";
    ?>
    
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('add-student-modal').addEventListener('click', function () {
        // Show the modal and background disable
        document.getElementById('modal_add_student').style.display = 'block';
    });

    document.getElementById('btn_cancel').addEventListener('click', function () {
        // Hide the modal and background disable
        document.getElementById('modal_add_student').style.display = 'none';
    });
});
 </script>
<!-- JS POPUP FOR EDITING AND UPDATING -->
<script src="../../assets/JS/script-popup.js"></script>
</body>
</html>