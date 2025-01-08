<?php
session_start();
include "header.php";
include "../../Inc/connect.php";

// Redirect if user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit();
}

// Fetch student information from the database
$username = $_SESSION['username'];
    
    $query = mysqli_query($conn, "SELECT st.*, tr.track_name AS trackName, sr.strand_name AS strandName, sy.sy_name AS syName, gr.stud_grade AS gname, sc.section_name AS sname,
    CONCAT(t_ln,', ',t_fn,' ',t_mn) AS tfName, prov.provDesc AS provName, mun.citymunDesc AS munName, brgy.brgyDesc AS brgyName from `new_students` AS st
    LEFT JOIN tracks AS tr ON st.track_id = tr.track_id 
    LEFT JOIN strands AS sr ON st.strand_id = sr.strand_id
    LEFT JOIN school_year AS sy ON st.sy_enrolled = sy.sy_id
    LEFT JOIN teacher_info as ti ON st.adviser = ti.t_id
    LEFT JOIN refprovince AS prov ON st.province = prov.provCode
    LEFT JOIN refcitymun AS mun ON st.municipality = mun.citymunCode
    LEFT JOIN refbrgy AS brgy ON st.barangay = brgy.brgyCode
    LEFT JOIN grade AS gr ON st.grade = gr.grade_id
    LEFT JOIN section AS sc ON st.section = sc.section_id
    where `student_id` = '$username'");
    while($row=mysqli_fetch_array($query)){
        $sid = $row['id'];
        $id = $row['student_id'];
        $fname =$row['fname'];
        $mname = $row['mname'];
        $lname = $row['lname'];
        $prob = $row['provName'];
        $mun = $row['munName'];
        $brgy = $row['brgyName'];
        
        $grade = $row['gname'];
        $section = $row['sname'];
        $adviser = $row['tfName'];
        $contact = $row['contact'];

        $syId = $row['sy_enrolled'];
        $trackId = $row['track_id'];
        $strandId = $row['strand_id'];
        $adviserId = $row['adviser'];

        $sy = $row['syName'];
        $track   = $row['trackName'];
        $strand  = $row['strandName'];

        $dob = $row['dob'];
        $gender = $row['gender'];
        $contact = $row['contact'];
        $img = $row['images'];

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>

    .upload{
        width: 100px;
        position: relative;
        }

        .upload img{
        border-radius: 50%;
        border: 6px solid #eaeaea;
        object-fit: cover;
        }

        .upload .round{
        position: absolute;
        bottom: 0;
        right: 0;
        background: #00B4FF;
        width: 32px;
        height: 32px;
        line-height: 33px;
        text-align: center;
        border-radius: 50%;
        overflow: hidden;
        }

        .upload .round input[type = "file"]{
        position: absolute;
        transform: scale(2);
        opacity: 0;
        }

</style>
<script>
    function GetProDetails(str){
        if(str.length == 0){
            document.getElementById("grade").value = "";
            document.getElementById("section").value = "";
            return;
        }
        else{

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
            
                if (this.readyState == 4 && this.status == 200){
                    
                    var myObj = JSON.parse(this.responseText);
                    document.getElementById("grade").value = myObj[0];
                    document.getElementById("section").value = myObj[1];
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
                <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
                <table class="table-container">
                <tr>
                  <td colspan="4"><h2>Student Information</h2></td>
                </tr>
                <tr>
                <td rowspan="5">
                <div class="upload">
                          <img src="<?php echo $img?>" id="upload_image" width = 120 height = 120 alt="">
                          <div class="round">
                              <input type="file" id="upload_input" name="images" accept=".jpg, .jpeg, .png">
                              <i class = "fa fa-camera" style = "color: #fff;"></i>
                          </div>

                            <script>
                                const uploadInput = document.getElementById('upload_input');
                                const uploadImage = document.getElementById('upload_image');
                                uploadInput.addEventListener('change', function(event){
                                    const file = event.target.files[0];
                                    uploadImage.src = URL.createObjectURL(file);;
                                });
                            </script>
                      </div>
                    </td>
                </tr>
                  <tr>
                    <td>First Name</td>
                    <td>Middle Name</td>
                    <td>Last Name</td>
                  </tr>
                  <tr>
                  <input type="hidden" name="studId" class="puts" placeholder="Enter First Name" readonly value="<?php echo $sid?>" oninput="lettersOnly(this)">
                    <td>
                      <input type="text" name="fname" class="puts" placeholder="Enter First Name" readonly value="<?php echo $fname?>" oninput="lettersOnly(this)">
                    </td>
                    <td> <input type="text" name="mname" class="puts" placeholder="Enter Surname" readonly value="<?php echo $mname?>" oninput="lettersOnly(this)"></td>
                    <td><input type="text" name="lname" class="puts" placeholder="Enter Last Name" readonly value="<?php echo $lname?>" oninput="lettersOnly(this)"></td>
                  </tr>
                  <tr>
                    <td>Province</td>
                    <td>Municipality</td>
                    <td>Barangay</td>
                  </tr>
                  <tr>
                    <td>
                      <input type="text" class="puts" name="grade" value="<?php echo $prob?>" id="grade" readonly> 
                    </td>
                    <td>
                      <input type="text" class="puts" name="grade" value="<?php echo $mun?>" id="grade" readonly>
                    </td>
                    <td>
                      <input type="text" class="puts" name="grade" value="<?php echo $brgy?>" id="grade" readonly>
                    </td>
                  </tr>
                  <tr  >
                    <td  colspan="2" rowspan="3">Class Information</td>
                    <td  colspan="2">
                        <label for="">RFID No.</label>
                    </td>
                    
                    
                  </tr>
                  <tr>
                    <td  colspan="2">
                         <input type="text" name="rfidcard" class="puts" id="rfidcard" placeholder="Scan RFID CARD" value="<?php echo $id?>"readonly>
                    </td>
                  </tr>
                  <tr>
                  </tr>
                  <tr>
                    <td>School Year</td>
                    <td>Adviser</td>
                    <td>Grade</td>
                    <td>Section</td>
                  </tr>
                  <tr>

                    <td>
                      <input type="text" class="puts" name="grade" value="<?php echo $sy?>" id="grade" readonly>
                    </td>
                    <td>
                        <input type="text" class="puts" name="grade" value="<?php echo $adviser?>" id="grade" readonly>
                    </td>
                      <td><input type="text" class="puts" name="grade" value="<?php echo $grade?>" id="grade" readonly></td>
                      <td><input type="text" class="puts" name="section" id="section"  value="<?php echo $section?>" readonly></td>
                  </tr>
                  <tr>

                  </tr>
                  <tr>
                    <td colspan="4">
                      <h5>For Senior High</h5>
                    </td>
                  </tr>
                  <tr>
                              
                    <td colspan="2">
                    <label for="track">Track</label>
                    <input type="text" class="puts" name="section" id="section"  value="<?php echo $track?>" readonly>
                    </td>
                    <td colspan="2">
                    <label class="readonly" for="strand">Strand</label>
                        <input type="text" class="puts" name="section" id="section"  value="<?php echo $strand?>" readonly>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                    <h5>Other Information</h5>
                    </td>
                    <td colspan="2">
                    <h5>Other Information</h5>
                    </td>
                  </tr>
                  
                  <tr>
                    <td colspan="2">
                    <label class="readonly" for="contact">Contact</label>
                      <input type="text" name="contact" class="puts" placeholder="Enter Contact" value="<?php echo $contact?>" readonly >
                    </td>
                    <td>
                    <label class="readonly" for="dob">Birth Date</label>
                                <input type="date" name="dob" class="puts" placeholder="Enter Age"  value="<?php echo $dob?>" readonly >
                    </td>
                    <td >
                      <label class="readonly" for="gender">GENDER</label>
                      <input type="text" name="contact" class="puts" placeholder="Enter Contact" value="<?php echo $gender?>" readonly >
                    </td>
                  </tr>
                  
              </table>
                </form> 
              
              </div>
        </div>
    </section>

    <?php
        include "footer.php"; 
    ?>
</body>
</html>