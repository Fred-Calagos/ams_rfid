<?php
    include "header.php";
    include("../../Inc/connect.php");
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
        </div>
        <div class="dash-content">
            <div class="table-responsive">
                <form action="create.php" method="post" enctype="multipart/form-data">

                    <table class="table-container">
                            <tr>
                                <td rowspan="2">
                                <div class="upload">
                                    <img src="" id="upload_image" width = 120 height = 120 alt="">
                                    <div class="round">
                                        <input type="file" id="upload_input" name="s_logo" accept=".jpg, .jpeg, .png">
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
                                <td colspan="3">
                                    <label for="">SCHOOL NAME</label>
                                    <input placeholder="school name" type="text" class="puts" name="s_name" tabindex="1" required autofocus>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">SCHOOL ID</label>
                                    <input placeholder="Enter School ID" class="puts" type="text" name="s_num" tabindex="2" required>
                                </td>
                                <td>
                                    <label for="">REGION</label>
                                    <input placeholder="Enter Region" class="puts" name="s_fb"type="url"tabindex="3" required>
                                </td>  
                                <td>
                                    <label for="">DISTRICT</label>
                                    <input placeholder="Your Phone Number" class="puts" type="tel" name="s_no" tabindex="4" required>
                                </td>
                                <td>
                                    <label for="">DIVISION</label>
                                    <input placeholder="Enter Division" class="puts" name="s_fb" type="url" tabindex="5" required>
                                </td>
                                
                            </tr>
                            <tr>
                                <td>
                                    <label for="">SCHOOL EMAIL</label>
                                    <input placeholder="Your Email Address" class="puts" type="email" name="s_email" tabindex="6" required>
                                </td>
                                <td>
                                    <label for="">SCHOOL PHONE No.</label>
                                    <input placeholder="Your Phone Number" class="puts" type="tel" name="s_no" tabindex="7" required>
                                </td>
                                <td colspan="2">
                                    <label for="">SCHOOL FACEBOOK PAGE</label>
                                    <input placeholder="Your Facebook Page starts with https://" class="puts" name="s_fb"type="url" pattern="https://.*" tabindex="8" required>
                                </td>  
                            </tr>
                            <tr>
                                       
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <label for="">SCHOOL INFO</label>
                                    <textarea placeholder="Type your Message Here...." name="s_info" rows="5" class="puts" cols="50" maxlength="20000" tabindex="9" required></textarea><br>
                                </td>
                            </tr>
                        
                    </table>
                    <br>
                    <input type="submit" value="submit" class="btn_create1" name="s-info" style="float:right">
                    <br><br>
                </form>
            </div>

        </div>
        <div class="table-responsive">
        <table class="table-container">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>School Logo</th>
                    <th>School Name</th>
                    <th>Email</th>
                    <th>Phone no.</th>
                    <th>Facebook Link</th>
                    <th>ACTION</th>

                </tr>
            </thead>
            <tbody>
                <?php   

                    $n = 0;
                    $query=mysqli_query($conn,"SELECT * FROM `school_profile` order by id ASC LIMIT 1");
                    while($row=mysqli_fetch_array($query))
                        {
                            $n++;
                    ?>
                    <tr>
                        <td><?php echo $n; echo '.';?></td>
                        <td><img src="<?php echo $row['image'];?>" height="30px" width="30px" alt="" srcset=""></td>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['s_email'];?></td>
                        <td><?php echo $row['s_no'];?></td>
                        <td><?php echo $row['s_fb'];?></td>
                        <td><a href="m-school-info.php?sis-info=<?php echo $row['id']?>"><i class="fas fa-edit btn_edit1"></i></a>
                    </tr>

                <?php
                    }
                ?>
            </tbody>
        </table>
        </div>

    </section>
                <!-- -------------- -->
            <!-- UPDATING SUBJECT -->
            <!-- -------------- -->
        <section class="edit-form-container" id="sis_cont">
        <?php
            if(isset($_GET['sis-info'])){
            $edit_id = $_GET['sis-info'];
            $edit_query = mysqli_query($conn, "SELECT * FROM school_profile WHERE id = $edit_id");
            if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_array($edit_query)){
                $id         = $fetch_edit['id'];
                $name       = $fetch_edit['name'];
                $image      = $fetch_edit['image'];
                $info       = $fetch_edit['info'];
                $s_email    = $fetch_edit['s_email'];
                $s_no       = $fetch_edit['s_no'];
                $s_fb       = $fetch_edit['s_fb'];
                $sid        = $fetch_edit['school_id'];
                $sreg       = $fetch_edit['region'];
                $sdis       = $fetch_edit['district'];
                $sdiv       = $fetch_edit['division'];

            };
        ?>
         <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
                    

                <table class="table-container">
                    <tr>
                        <td colspan="4">
                        <h1>UPDATE SUBJECT</h1>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">
                        <div class="upload">
                        <img src="<?php echo $image?>" id="upload_image1" width ="100" height ="100" alt="">
                        <div class="round">
                            <input type="file" id="upload_input1" name="images" accept=".jpg, .jpeg, .png">
                            <i class = "fa fa-camera" style = "color: #fff;"></i>
                        </div>

                            <script>
                                const uploadInput1 = document.getElementById('upload_input1');
                                const uploadImage1 = document.getElementById('upload_image1');
                                uploadInput1.addEventListener('change', function(event){
                                    const file1 = event.target.files[0];
                                    uploadImage1.src = URL.createObjectURL(file1);;
                                });
                            </script>
                    </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="">SCHOOL NAME</label>
                            <input  type="hidden" class="puts" value="<?php echo $id?>" name="id">
                            <input placeholder="school name" type="text" class="puts" value="<?php echo $name?>" name="s_name" tabindex="1" required autofocus>
                        </td>
                        <td>
                            <label for="">SCHOOL ID</label>
                            <input placeholder="school id" type="text" class="puts" value="<?php echo $sid?>" name="s_id" tabindex="2" required autofocus>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="">REGION</label>
                            <input placeholder="Enter Region" class="puts" type="text" name="sreg" value="<?php echo $sreg?>" tabindex="3" required>
                        </td>
                        <td>
                            <label for="">DIVISION</label>
                            <input placeholder="Enter Division" class="puts" type="text" value="<?php echo $sdiv?>" name="sdiv" tabindex="4" required>
                        </td>
                        <td>
                            <label for="">DISTRICT</label>
                            <input placeholder="Enter district" class="puts" name="sdis" type="text" value="<?php echo $sdis?>" tabindex="5" required>
                        </td>  
                    </tr>
                    <tr>

                        <td>
                            <label for="">SCHOOL PHONE No.</label>
                            <input placeholder="Your Phone Number" class="puts" type="tel" name="s_no" value="<?php echo $s_no?>" tabindex="2" required>
                        </td>
                        <td>
                            <label for="">SCHOOL EMAIL</label>
                            <input placeholder="Your Email Address" class="puts" type="email" value="<?php echo $s_email?>" name="s_email" tabindex="3" required>
                        </td>
                        <td>
                            <label for="">SCHOOL FACEBOOK PAGE</label>
                            <input placeholder="Your Facebook Page starts with https://" class="puts" name="s_fb"type="url" value="<?php echo $s_fb?>" pattern="https://.*" tabindex="4" required>
                        </td>  
                    </tr>
                    <tr>
                        <td colspan="3">
                            <label for="">SCHOOL INFO</label>
                            <textarea name="s_info" rows="5" class="puts" cols="50" maxlength="20000" required><?php echo $info?></textarea><br>
                        </td>
                    </tr>
                </table>
                <BR>
                    <input type="submit" value="Update" name="sp_update" class="btn_edit1">
                    <input type="reset" value="close" id="close_sis" class="option-btn btn_cancel1">
         </form>
         <?php

         };
         echo "<script>
         
         document.querySelector('#sis_cont').style.display = 'flex';
         document.querySelector('#sis_cont').style.transition = 'transform 0.4s, top 0.4s';
         
         </script>";    
      };
   ?>


    </section>
    <?php
        include "footer.php";
    ?>
    <!-- JS POPUP FOR EDITING AND UPDATING -->
<script src="../../assets/JS/script-popup.js"></script>
</body>
</html>