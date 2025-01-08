<?php

    include "header.php";
    include("../../Inc/connect.php");
    include "delete_btm.php";

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
</head>
<body>
    <section class="dashboard">
            <div class="top">
            <i class="fas fa-bars sidebar-toggle"></i>
                <div class="search-box">
                    <i class="uil uil-search"></i>
                    <input type="text" placeholder="Search here...">
                </div>
                
                
            </div>

            <div class="dash-content">
              <div class="table-responsive">
              <div class="bread">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="m-student.php"><i class="bx bxs-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="m-class.php">UPDATE STUDENT INFORMATION</a></li>
                    </ol>
                </div>

              </div>
              <div class="table-responsive">  
              <table class="table-container">
                <tr>
                  <td colspan="4"><h2>Update Student Information</h2></td>
                </tr>
                <tr>
                <td rowspan="5">
                      <div class="upload">
                          <img src="noprofil.jpg" id="upload_image" width = 150 height = 150 alt="">
                          <div class="round">
                              <input type="file" id="upload_input" accept=".jpg, .jpeg, .png">
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
                    <td>
                      <input type="text" name="fname" placeholder="Enter First Name" required oninput="lettersOnly(this)">
                    </td>
                    <td> <input type="text" name="mname" placeholder="Enter Surname" required  oninput="lettersOnly(this)"></td>
                    <td><input type="text" name="lname" placeholder="Enter Last Name" required  oninput="lettersOnly(this)"></td>
                  </tr>
                  <tr>
                    <td>Province</td>
                    <td>Municipality</td>
                    <td>Barangay</td>
                  </tr>
                  <tr>
                    <td>
                      <select name="province" onchange="getMunicipalities(this.value);">
                          <option >Select Province</option>
                          <?php
                          $query = mysqli_query($conn, "SELECT * FROM refprovince ORDER BY provDesc ASC");
                          while ($row = mysqli_fetch_array($query)) {
                          ?>
                          <option style="text-align-last:left;" value="<?php echo htmlentities($row['provDesc']); ?>"><?php echo $row['provDesc']; ?></option>
                          <?php
                          }
                          ?>
                      </select>  
                    </td>
                    <td>
                      <select name="municipality" id="municipality" onchange="getBarangays(this.value);">
                          <option >Select Municipality</option>
                      </select>
                    </td>
                    <td>
                      <select name="barangay" id="barangay">
                          <option >Select Barangay</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4">Class Information</td>
                  </tr>
                  <tr>
                    <td>RFID No.</td>
                    <td>School Year</td>
                    <td>Grade</td>
                    <td>Section</td>
                  </tr>
                  <tr>
                    <td>
                         <input type="text" name="rfidcard" id="rfidcard" placeholder="Scan RFID CARD" required>
                    </td>
                    <td>
                    <select name="sy" id="" required>
                          <option value="" selected disabled hidden>SELECT S.Y.</option>
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
                      <td><input type="text" name="grade" id="grade" readonly></td>
                      <td><input type="text" name="section" id="section" readonly></td>
                  </tr>
                  <tr>
                    <td colspan="4">
                      <h5>For Senior High</h5>
                    </td>
                  </tr>
                  <tr>

                    <td colspan="2">
                    <label for="track">Track</label>
                    <select name="track" onchange="getStrand(this.value);">
                        <option selected disabled hidden>Select Track</option>
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
                                    <select name="strand" id="strand">
                                        <option >Select Strand</option>
                                    </select>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4">
                    <h5>Other Information</h5>
                    </td>
                  </tr>
                  
                  <tr>
                    <td colspan="2">
                    <label class="required" for="contact">Contact</label>
                      <input type="text" name="contact" placeholder="Enter Contact" required >
                    </td>
                    <td>
                    <label class="required" for="dob">Birth Date</label>
                                <input type="date" name="dob" placeholder="Enter Age" required >
                    </td>
                    <td >
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
                    </td>
                  </tr>
              </table>
              </div>
        </div>
    </section>
    <script src="../../assets/js/dependent.js"></script>
    <?php
        include "footer.php"; 
    ?>
</body>
</html>