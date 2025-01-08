<?php
    include "header.php";
    include("../../Inc/connect.php");
    include "delete_btm.php";
    if (!isset($_SESSION["username"])) {
        ?>
            <script type="text/javascript">
                window.location="admin_dash.php";
            </script>
        <?php
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../../assets/js/jquery.js" type="text/javascript"></script>
    <script src="../../assets/js/js-script.js" type="text/javascript"></script>
    <script src="../../assets/jquery/jquery.min.js"></script>
<style>

    .upload{
        width: 110px;
        position: relative ;
        }

        .upload #upload_image{
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
                
            </div>
            
            <img src="../../images/admin/profile.jpg" alt="">
        </div>

        <div class="dash-content">
            <br>
        <div class="bread">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="m-setting.php"><i class="bx bxs-home"></i></a></li>
                <li class="breadcrumb-item active"><a href="m-teacher.php">Admin Account</a></li>
                </ol>
            </div>
            <div class="table-responsive">
            <div class="row well">
                <ul>
                    <li><a id="add_teach" class="btn_create1"><i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp; Add Admin</a></li>
                </ul>
            </div><br>
            <i class="uil uil-search"></i><input type="text" placeholder="Search here..." id="search-ins" style="float:right;padding:10px;border:none;border-bottom:2px solid blue;outline:none;">
            <div id="result"></div>
                    <script>
                        
                    $(document).ready(function(){

                        load_data();

                            function load_data(query)
                                {
                                    $.ajax({
                                            url:"a-auto-search-admin.php",
                                            method:"POST",
                                            data:{query:query},
                                            success:function(data)
                                            {
                                                $('#result').html(data);
                                            }
                                        });
                                }
                            $('#search-ins').keyup(function(){
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
    <div class="modal_add_teacher1" id="modal_add_teacher1">
        <div class="modal_content_teacher1">
            <form action="create.php" method="post" class="form-students" id="form-students" enctype="multipart/form-data">
            <button type="button" name="cancel" id="btn_cancel1" class="cancel">X</button><br>
            <h3 class="modal_title"> ADD ADMIN</h3>
            <hr style="height:3px;background-color:black;border:none;">
                <!-- Full Name -->

                <div class="half">
                <div class="item">
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
                    </div>
                    <div class="item">
                        <label class="required" for="rfid">RFID No.</label>
                        <input type="text" name="rfidcard" id="rfidcard"  required >
                            <input type="hidden" id="password5" name="pass" readonly placeholder="Generate a password"><br>
                            <input type="hidden" id="length5" value="9" hidden/>
                            <input type="hidden" id="uppercase5" checked hidden/>
                            <input type="hidden" id="lowercase5" checked hidden/>
                            <input type="hidden" id="numbers5" checked hidden/>
                    </div>
                    <div class="item">
                    <label class="required" for="rfid">Admin Role.</label>
                        <select name="adrole" id="" required>
                                    <option value=" " select hidden>SELECT ROLE</option>
                                    <?php
                                    $sql = "SELECT * FROM ad_role ORDER BY idadr asc";
                                    $allgender = mysqli_query($conn, $sql);
                                        while ($genderall = mysqli_fetch_array($allgender)) {
                                        ?>
                                            <option value="<?php echo $genderall['idadr']?>"><?php echo $genderall['admin_role']?></option>';
                                    <?php
                                        }
                                    ?>
                                </select>
                    </div>
                </div>
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
                <div class="half">

                </div>
                
                <!-- GRADE LEVEL -->

                <div class="half">

                </div>
                <!-- -------------------------------- -->
                        <button type="submit" name="add_admin" id="btn_admin" class="btn_create1">Save</button>
                        
                <script src="../../assets/js/rand_pass4.js"></script> 
                <script src="../../assets/js/rfid.js"></script>                   
                <script src="../../assets/Js/modal-student.js"></script>
                <script src="../../assets/js/bootstrap.min.js"></script>
                <script src="../../assets/js/dependent.js"></script>
            </form>
            <br><br><br>
        </div>
    </div>
</div>
    </section>
    <section class="edit-form-container" id="cont_teach">
        <?php
            if(isset($_GET['t_id'])){
            $edit_id = $_GET['t_id'];
            $name =    $_GET['t_fn'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `teacher_info` WHERE t_id = $edit_id");
            if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_array($edit_query)){
                $id = $fetch_edit['t_id'];
                $fname =   $fetch_edit['t_fn'];
                $lname  =  $fetch_edit['t_ln'];
                $mname =    $fetch_edit['t_mn'];
                $gender =   $fetch_edit['t_gender'];
                $bdate =   $fetch_edit['t_bdate'];
                $num = $fetch_edit['t_num'];
                $email = $fetch_edit['t_email'];
            };
        ?>
         <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
         <h3>Update Teacher Information</h3>
            <div class="flex-container">
                
                <div class="cont1">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <label for="fname">First Name</label>
                    <input type="text" class="box" required name="fn" value="<?php echo $fname; ?>" >
                    <label for="fname">Gender</label>
                    <input type="text" class="box" required name="gr" value="<?php echo $gender; ?>" >
                    <label for="fname">Email</label>
                    <input type="email" class="box" required name="email" value="<?php echo $email; ?>" >
                </div>
                <div class="cont1">
                    <label for="fname">Middle Name</label>
                    <input type="text" class="box" required name="mn" value="<?php echo $mname; ?>" >
                    <label for="fname">Birth Date</label>
                    <input type="date" class="box" required name="bd" value="<?php echo $bdate; ?>" >
                    
                </div>
                <div class="cont1">
                    <label for="fname">Last Name</label>
                    <input type="text" class="box" required name="ln" value="<?php echo  $lname; ?>" >
                    <label for="fname">Contact Number</label>
                    <input type="text" class="box" required name="num" value="<?php echo $num; ?>" >
                </div>
            </div>
                    <input type="submit" value="Update" name="teach_update" class="btn_edit1">
                    <input type="reset" value="cancel" id="close_teach" class="option-btn btn_cancel1">
         </form>
         <?php

         };
         echo "<script>
         
         document.querySelector('#cont_teach').style.display = 'flex';
         document.querySelector('#cont_teach').style.transition = 'transform 0.4s, top 0.4s';
         
         </script>";    
      };
   ?>

    </section>
            <!-- ---------------------------------------- -->
            <!-- POP UP MODAL FOR DELETING TEACHER INFORMATION-->
            <!-- ---------------------------------------- -->

            <div class="edit-form-container" id="teach_cont">
                    <?php
                        if(isset($_GET['id_t'])){
                        $t_id = $_GET['id_t'];  
                        $edit_query = mysqli_query($conn, "SELECT * FROM `teacher_info` WHERE t_id = $t_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($fetch_edit = mysqli_fetch_array($edit_query)){
                                    $dsid   = $fetch_edit['t_id'];
                                    $fn  = $fetch_edit['t_fn'];
                                    $ln = $fetch_edit['t_ln'];
                                };
                        ?>
                    <form action="delete.php"method="post" enctype="multipart/form-data">
                        <div class="flex-container">
                            <h3>Are you sure that you want to delete this teacher: <?php echo $fn." ".$ln; ?> ?</h4><br>
                            <input type="hidden" name="t_id" value="<?php echo $dsid; ?>">
                        </div>
                                
                                <input type="submit" value="Delete" name="delete_teach" class="del_teach btn_delete1">&nbsp;
                                <input type="reset" value="cancel" id="close-del-teach" class="btn_cancel1">
                    </form>
                    <?php

                    };
                    echo "<script>document.querySelector('#teach_cont').style.display = 'flex';</script>";    
                };
            ?>
            </div>
<?php
    include "footer.php";
?>
<!-- JS POPUP FOR EDITING AND UPDATING -->
<script src="../../assets/JS/script-popup.js"></script>
</body>
</html>