<?php
include "header.php";
include "../../Inc/connect.php";

// Redirect if user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit();
}

// Fetch student information from the database
$username = $_SESSION['username'];
    
    $query = mysqli_query($conn, "SELECT ti.*, ua.username AS uname, ua.password AS pass FROM teacher_info AS ti
                  LEFT JOIN user AS ua ON ti.t_rfid = ua.username
                  where `t_rfid` = '$username'");
    while($row=mysqli_fetch_array($query)){
        $fname  = $row['t_fn'];
        $mname  = $row['t_mn'];
        $lname  = $row['t_ln'];
        $gender = $row['t_gender'];
        $bdate  = $row['t_bdate'];
        $num    = $row['t_num'];
        $email  = $row['t_email'];
        $rfid   = $row['t_rfid'];
        $uname = $row['uname'];
        $upass = $row['pass'];
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
                <form action="update.php" method="post" enctype="multipart/form-data">
                <table class="table-container">
                <tr>
                  <td colspan="4"><h2>Personal Information</h2></td>
                </tr>
                  <tr>
                    <td>First Name</td>
                    <td>Middle Name</td>
                    <td>Last Name</td>
                  </tr>
                  <tr>
                    <td>
                      <input type="text" name="fname" class="puts" placeholder="Enter First Name" readonly value="<?php echo $fname?>" oninput="lettersOnly(this)">
                    </td>
                    <td> <input type="text" name="mname" class="puts" placeholder="Enter Surname" readonly value="<?php echo $mname?>" oninput="lettersOnly(this)"></td>
                    <td><input type="text" name="lname" class="puts" placeholder="Enter Last Name" readonly value="<?php echo $lname?>" oninput="lettersOnly(this)"></td>
                  </tr>
                  <tr>
                    <td>RFID</td>
                    <td>Email</td>
                    <td>Contact Number</td>
                  </tr>
                  <tr>
                    <td>
                      <input type="text" class="puts" name="grade" value="<?php echo $rfid?>" id="grade" readonly> 
                    </td>
                    <td>
                      <input type="text" class="puts" name="grade" value="<?php echo $email?>" id="grade" readonly>
                    </td>
                    <td>
                      <input type="text" class="puts" name="grade" value="<?php echo $num?>" id="grade" readonly>
                    </td>
                  </tr>
                  <tr>
                  <td  colspan="4">Birth Information</td>
                  </tr>
                  <tr>
                    
                    <td  colspan="2">
                        <label for="">Gender</label>
                        <input type="text" name="rfidcard" class="puts" id="rfidcard" placeholder="Scan RFID CARD" value="<?php echo $gender?>"readonly>
                    </td>
                    <td  colspan="2">
                        <label for="">Birth Date</label>
                         <input type="text" name="rfidcard" class="puts" id="rfidcard" placeholder="Scan RFID CARD" value="<?php echo $bdate?>"readonly>
                    </td>
                  </tr>
                  <tr>
                  <td  colspan="4">Accont</td>
                  </tr>
                  <tr>
                    <td coslpan="2">
                        <label for="">Username</label>
                        <input type="text" name="username" class="puts" value="<?php echo $uname?>">
                    </td>
                    <td coslpan="2">
                        <label for="">Pasword</label>
                        <input type="text" name="password" class="puts" value="<?php echo $upass?>">
                    </td>
                    <td>
                        <label for=""><i class="fa-solid fa-button"></i></label>
                        <input type="submit" value="Change Password" name="chpass" class="btn_create1">
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