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
    <script src="../../assets/jquery/jquery.min.js"></script>   
    <script src="bootstrap/autocomplete.js" type="text/javascript"></script>
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
#stud_id{
    display: none;
    position: absolute;
    width: 100%;
    border: 1px solid #eaeaea;
    background: #ffffff;
    padding: 10px;
    list-style: none;
    cursor: pointer;
    text-align: left;
    top: calc(35% + 10px);
    z-index: 3;
}
#stud_id li:hover{
    z-index: 2;
    background: #efefef;
    padding: 10px;
}
#stud_id li{
    padding: 10px;
    z-index: 2;
}
</style>
</head>
<body>
<script src="../../assets/js/rfid.js"></script>
    <section class="dashboard">
        <div class="top">
        <i class="fas fa-bars sidebar-toggle"></i>

        </div>  
        <div class="dash-content">
        <div class="bread">
                <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="m-setup.php"><i class="bx bxs-home"></i></a></li>
                <li class="breadcrumb-item active"><a href="m-teachload.php">TEACHING LOAD</a></li>
                </ul>
            </div>
            <!-- TABLE FOR STUDENTS -->
            <!--                    -->
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?=$_GET['error']?>
                </div>
            <?php } ?>
            <div class="table-responsive">
                <div class="row well">
                    <ul>
                        <li><a id="add-student-modal" href="#" class="btn_create1"> <i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp;STUDENT ACCOUNT</a></li>
                        <li><a id="add_teach" href="#" class="btn_create1"> <i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp;TEACHER ACCOUNT</a></li>
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
                                            url:"a-as-uacc.php",
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
    </section>

    <div class="modal_add_student" id="modal_add_student">
                <div class="modal_content_teacher">
                        <form action="create.php" method="post" class="form-students" id="form-students" enctype="multipart/form-data">
                        <button type="button" name="cancel" id="btn_cancel" class="cancel btn_cancel1">x</button><br><br><br>
                        <h2 class="modal_title"> ADD STUDENT</h2>
                        <hr style="height:3px;background-color:black;border:none;">

                            <!-- USER ACCOUNT FOR TEACHER -->

                            <div class="half">
                                <div class="item">
                                    <label class="required" for="email">USERNAME</label>
                                    <input type="text" name="rfidcard" id="rfidcard" placeholder="Scan RFID CARD" >
                                    <input type="hidden" name="role" id="role" value="2" >
                                    
                                </div>
                            </div>
                            <!-- Full Name -->
                            <div class="half">
                                <div class="item">
                                    <label class="required" for="fname">PASSWORD</label>
                                    <input type="text" id="password" name="pass" readonly placeholder="Generate a password"><br>
                                </div>
                                
                                <input type="hidden" id="length" value="9" hidden/>
                                    <input type="hidden" id="uppercase" checked hidden/>
                                    <input type="hidden" id="lowercase" checked hidden/>
                                    <input type="hidden" id="numbers" checked hidden/>
                                    <input type="hidden" id="symbols" checked hidden/>
                            </div>
                            <div class="half">
                            <div class="item">
        
                                    <input type="submit" name="u_add" value="Add" id="btn_add_st" class="btn_create1" >
                                </div>
                            </div>

                            <script src="../../assets/js/rand_pass.js"></script>
                            <!-- -------------------------------- -->
                        </form>
                </div>
            </div>

            <div class="modal_add_teacher1" id="modal_add_teacher1">
                <div class="modal_content_teacher">
                        <form action="create.php" method="post" class="form-students" id="form-students" enctype="multipart/form-data">
                        <button type="button" name="cancel" id="btn_cancel1" class="cancel btn_cancel1">x</button><br><br><br>
                        <h2 class="modal_title"> ADD TEACHER</h2>
                        <hr style="height:3px;background-color:black;border:none;">

                            <!-- USER ACCOUNT FOR TEACHER -->

                            <div class="half">
                                <div class="item">
                                    <label class="required" for="email">USERNAME</label>
                                    <input type="text" name="rfidcard" id="rfidcard" placeholder="Scan RFID CARD" >
                                    <input type="hidden" name="role" id="role" value="3" >
                                    
                                </div>
                            </div>
                            <!-- Full Name -->
                            <div class="half">
                                <div class="item">
                                    <label class="required" for="fname">PASSWORD</label>
                                    <input type="text" id="password" name="pass" readonly placeholder="Generate a password"><br>
                                </div>
                                <input type="hidden" id="length" value="9" hidden/>
                                    <input type="hidden" id="uppercase" checked hidden/>
                                    <input type="hidden" id="lowercase" checked hidden/>
                                    <input type="hidden" id="numbers" checked hidden/>
                                    <input type="hidden" id="symbols" checked hidden/>
                            </div>
                            <div class="half">
                            <div class="item">
        
                                    <input type="submit" name="ut_add" value="Add" id="btn_add1" class="btn_create1" >
                                </div>
                            </div>
                            <!-- -------------------------------- -->
                        </form>
                </div>
            </div>
                <script src="../../assets/js/modal-student.js"></script>
                <script src="../../assets/js/bootstrap.min.js"></script>
                <script src="../../assets/js/dependent.js"></script>
            <!--                    -->

    <!-- PASSWORD RESET MODAL -->
        <section class="edit-form-container" id="cont_usered">
            <?php
                if(isset($_GET['u_ed'])){
                $edit_id = $_GET['u_ed'];
                $edit_query = mysqli_query($conn, "SELECT * FROM `user` WHERE id = $edit_id");  
                if(mysqli_num_rows($edit_query) > 0){
                while($fetch_edit = mysqli_fetch_array($edit_query)){
                    $id = $fetch_edit['id'];
                    $pass_r = $fetch_edit['password'];
                    $username = $fetch_edit['username'];
                };
            ?>
            <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
                <div class="flex-container">
                    <div class="cont1">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <h3 >RESET PASSWORD</h3><br>
                        <label for="username">Username</label>
                        <input type="text" value="<?php echo $username?>" class="box" readonly>
                        <label for="password">Password</label>
                        <input type="text" id="password4" name="pass" class="box" placeholder="Generate a password" value="<?php echo $pass_r;?>">
                        <a id="generate_reset" class="btn_edit1">Generate Password</a><br><br>
                        <input type="hidden" id="length4" value="9" hidden/>
                        <input type="hidden" id="uppercase4" checked hidden/>
                        <input type="hidden" id="lowercase4" checked hidden/>
                        <input type="hidden" id="numbers4" checked hidden/>
                        <input type="hidden" id="symbols4" checked hidden/>
                    </div>
                </div>
                        <input type="submit" value="update" name="pass_reset" class="btn_edit1">
                        <input type="reset" value="close" id="close_pass_r" class="option-btn btn_cancel1">
                        <script src="../../assets/js/rand_pass3.js"></script>
            </form>
            <?php

            };
            echo "<script>
            
            document.querySelector('#cont_usered').style.display = 'flex';
            document.querySelector('#cont_usered').style.transition = 'transform 0.4s, top 0.4s';
            
            </script>";    
        };
        
    ?>
    
        </section>
            <!-- ---------------------------------------- -->
            <!-- POP UP MODAL FOR DELETING USER-->
            <!-- ---------------------------------------- -->

            <div class="edit-form-container" id="user_cont">
                    <?php
                        if(isset($_GET['u_del'])){
                        $t_id = $_GET['u_del'];  
                        $edit_query = mysqli_query($conn, "SELECT * FROM `user` WHERE id = $t_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($fetch_edit = mysqli_fetch_array($edit_query)){
                                    $dsid   = $fetch_edit['id'];
                                    $fn  = $fetch_edit['username'];
                                    $ln = $fetch_edit['password'];
                                };
                        ?>
                    <form action="delete.php"method="post" enctype="multipart/form-data">
                        <div class="flex-container">
                            <h3>Are you sure that you want to delete this Account: <?php echo $fn?> ?</h4><br>
                            <input type="hidden" name="uId" value="<?php echo $dsid; ?>"><br>
                        </div>
                                
                                <input type="submit" value="Delete" name="delete_user" class="del_teach btn_delete1">&nbsp;
                                <input type="reset" value="cancel" id="close_del_user" class="btn_cancel1">
                    </form>
                    <?php

                    };
                    echo "<script>document.querySelector('#user_cont').style.display = 'flex';</script>";    
                };
            ?>
            </div>
    

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
<!-- JS POPUP FOR EDITING AND UPDATING -->
<script src="../../assets/JS/script-popup.js"></script>
</body>
</html>