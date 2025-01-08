<?php

    include "header.php";
    include("../../Inc/connect.php");
    $sid = $_GET['e_id'];
    
    $query = mysqli_query($conn, "SELECT st.*, tr.track_name AS trackName, sr.strand_name AS strandName, sy.sy_name AS syName, CONCAT(t_ln,', ',t_fn,' ',t_mn) AS tfName, prov.provDesc AS provName, mun.citymunDesc AS munName, brgy.brgyDesc AS brgyName, gr.stud_grade AS grName, sc.section_name AS scName from `new_students` AS st
    LEFT JOIN refprovince AS prov ON st.province = prov.provCode
    LEFT JOIN refcitymun AS mun ON st.municipality = mun.citymunCode
    LEFT JOIN refbrgy AS brgy ON st.barangay = brgy.brgyCode
    LEFT JOIN tracks AS tr ON st.track_id = tr.track_id 
    LEFT JOIN strands AS sr ON st.strand_id = sr.strand_id
    LEFT JOIN school_year AS sy ON st.sy_enrolled = sy.sy_id
    LEFT JOIN teacher_info as ti ON st.adviser = ti.t_id
    LEFT JOIN grade AS gr ON st.grade = gr.grade_id
    LEFT JOIN section AS sc ON st.section = sc.section_id
    where st.id = '$sid'");
    while($row=mysqli_fetch_array($query)){
        $sid1 = $row['id'];
        $id = $row['student_id'];
        $fname =$row['fname'];
        $mname = $row['mname'];
        $lname = $row['lname'];
        $prob = $row['province'];
        $mun = $row['municipality'];
        $brgy = $row['barangay'];
        $provName = $row['provName'];
        $munName = $row['munName'];
        $brgyName = $row['brgyName'];
        
        $grade = $row['grade'];
        $section = $row['section'];
        $grName = $row['grName'];
        $scName = $row['scName'];
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
              <div class="bread">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="s-student-adv.php"><i class="bx bxs-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="#">UPDATE STUDENT INFORMATION</a></li>
                    </ol>
                </div>

              </div>
              <div class="table-responsive">
              <form action="update.php" method="post" enctype="multipart/form-data">
                <table class="table-container">
                <tr>
                  <td colspan="4"><h2>Update Student Information</h2></td>
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
                  <input type="hidden" name="studId" class="puts" placeholder="Enter First Name" required value="<?php echo $sid1?>" oninput="lettersOnly(this)">
                    <td>
                      <input type="text" name="fname" class="puts" placeholder="Enter First Name" required value="<?php echo $fname?>" oninput="lettersOnly(this)">
                    </td>
                    <td> <input type="text" name="mname" class="puts" placeholder="Enter Surname" required value="<?php echo $mname?>" oninput="lettersOnly(this)"></td>
                    <td><input type="text" name="lname" class="puts" placeholder="Enter Last Name" required value="<?php echo $lname?>" oninput="lettersOnly(this)"></td>
                  </tr>
                  <tr>
                    <td>Province</td>
                    <td>Municipality</td>
                    <td>Barangay</td>
                  </tr>
                  <tr>
                    <td>
                      <select name="province" onchange="getMunicipalities(this.value);">
                          <option value="<?php echo $prob?>"><?php echo $provName?></option>
                          <?php
                          $query = mysqli_query($conn, "SELECT * FROM refprovince ORDER BY provDesc ASC");
                          while ($row = mysqli_fetch_array($query)) {
                          ?>
                          <option style="text-align-last:left;" value="<?php echo htmlentities($row['provCode']); ?>"><?php echo $row['provDesc']; ?></option>
                          <?php
                          }
                          ?>
                      </select>  
                    </td>
                    <td>
                      <select name="municipality" id="municipality" onchange="getBarangays(this.value);">
                          <option value="<?php echo $mun?>"><?php echo $munName ?></option>
                      </select>
                    </td>
                    <td>
                      <select name="barangay" id="barangay">
                          <option value="<?php echo $brgy?>"><?php echo $brgyName?></option>
                      </select>
                    </td>
                  </tr>
                  <tr  >
                    <td rowspan="2">Class Information</td>
                    <td>School Year</td>
                    <td  colspan="2">
                        <label for="">RFID No.</label>
                    </td>
                    
                    
                  </tr>
                  <tr>
                  <td>
                    <select name="syId" id="" required>
                          <option value="<?php echo $syId?>"><?php echo $sy?></option>
                          <?php
                          $sql = "SELECT * FROM school_year ORDER BY sy_id asc";
                          $data = mysqli_query($conn, $sql);
                              while ($row = mysqli_fetch_array($data)) {
                              ?>
                                  <option value="<?php echo $row['sy_id']?>"><?php echo $row['sy_name']?></option>';
                          <?php
                              }
                          ?>
                      </select>
                    </td>
                    <td  colspan="2">
                         <input type="text" name="rfidcard" class="puts" id="rfidcard" placeholder="Scan RFID CARD" value="<?php echo $id?>"required>
                    </td>
                  </tr>
                  <tr>
                    
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
                    <select name="trackId" onchange="getStrand(this.value);">
                        <option value="<?php echo $trackId?>"><?php echo $track?></option>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM tracks ORDER BY track_name ASC");
                        while ($row = mysqli_fetch_array($query)) {
                        ?>
                        <option style="text-align-last:left;" value="<?php echo htmlentities($row['track_id']); ?>"><?php echo $row['track_name']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    </td>
                    <td colspan="2">
                    <label class="required" for="strand">Strand</label>
                        <select name="strandId" id="strand">
                            <option value="<?php echo $strandId?>"><?php echo $strand?></option>
                        </select>
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
                    <label class="required" for="contact">Contact</label>
                      <input type="text" name="contact" class="puts" placeholder="Enter Contact" value="<?php echo $contact?>" required >
                    </td>
                    <td>
                    <label class="required" for="dob">Birth Date</label>
                                <input type="date" name="dob" class="puts" placeholder="Enter Age"  value="<?php echo $dob?>" required >
                    </td>
                    <td >
                      <label class="required" for="gender">GENDER</label>
                      <select name="gender" placeholder="Please select Gender" id=""  required>
                          <option value="<?php echo $gender?>"><?php echo $gender?></option>
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
                    </td>
                  </tr>
                  
              </table>
              <br>
              <input type="submit" value="Update" name="updateStud" class="btn_edit1" style="float:right">
              <br>              <br>
              <script src="../../assets/js/dependent.js"></script>
                </form> 
              
              </div>
        </div>
    </section>

    <?php
        include "footer.php"; 
    ?>
</body>
</html>