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
</head>
<body>
    <section class="dashboard">
    <div class="top">
        <i class="fas fa-bars sidebar-toggle"></i>
            <div class="search-box">
                <i class="uil uil-search"></i>
                
            </div>
        </div>

        <div class="dash-content">
            <br>
                <div class="bread">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="m-setup.php"><i class="bx bxs-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="m-school-year.php">SCHOOL YEAR</a></li>
                    </ol>
                </div>
                <br>


            
            <div class="table-responsive">
            <div class="row well">
                <ul>
                    <li><a id="add-subject" href="#" class="btn_create1"> <i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp;ADD S.Y.</a></li>
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
                                            url:"a-auto-search-sy.php",
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
            <!-- -------------- -->
            <!-- ADDING SUBJECT -->
            <!-- -------------- -->

<div class="modal_add_student" id="modal_add_student">
            <div class="modal_content_student">
                
                    <form action="create.php" method="post" class="form-students" id="form-students" enctype="multipart/form-data">
                    <button type="button" name="cancel" id="btn_cancel" class="cancel">X</button><br>
                    <h3 class="modal_title">ADD SCHOOL YEAR</h3>
                    <hr style="height:3px;background-color:black;border:none;">
                         <!-- Subject Name -->
                        <div class="half">
                            <div class="item">
                                <label class="required" for="strandName">School Year</label>
                                <input type="text" name="syName" placeholder="Enter School Year" required>
                            </div>
                        </div>
                        
                        <!-- -------------------------------- -->
                            <div class="item">
                                <button type="submit" name="add-sy" id="btn_add" class="btn_create1">Save</button>
                            </div>

                <script src="../../assets/Js/modal-student.js"></script>
                    </form>

            </div>

            </div>

</div>
    </section>
            <!-- -------------- -->
            <!-- EDITING SCHOOL YEAR -->
            <!-- -------------- -->
    <section class="edit-form-container" id="sy_cont">
        <?php
            if(isset($_GET['e_syid'])){
            $edit_id = $_GET['e_syid'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `school_year`
                                                    WHERE sy_id = $edit_id");
            if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_array($edit_query)){
                $id = $fetch_edit['sy_id'];
                $sub_n = $fetch_edit['sy_name'];
            };
        ?>
         <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
            <div class="flex-container">
                <div class="cont1">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <label for="fname">SCHOOL YEAR</label>
                    <input type="text" class="box" required name="syName" value="<?php echo $sub_n; ?>" >
                </div>
            </div>
                    <input type="submit" value="Update" name="syUpdate" class="btn_edit1">
                    <input type="reset" value="close" id="close_sy" class="option-btn btn_cancel1">
         </form>
         <?php

         };
         echo "<script>
         
         document.querySelector('#sy_cont').style.display = 'flex';
         document.querySelector('#sy_cont').style.transition = 'transform 0.4s, top 0.4s';
         
         </script>";    
      };
   ?>


    </section>
            <!-- ---------------------------------------- -->
            <!-- POP UP MODAL FOR DELETING S.Y.-->
            <!-- ---------------------------------------- -->

            <div class="edit-form-container" id="cont_sy">
                    <?php
                        if(isset($_GET['d_syid'])){
                        $t_id = $_GET['d_syid'];  
                        $edit_query = mysqli_query($conn, "SELECT * FROM `school_year` WHERE sy_id = $t_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($fetch_edit = mysqli_fetch_array($edit_query)){
                                    $dsid   = $fetch_edit['sy_id'];
                                    $fn  = $fetch_edit['sy_name'];
                                };
                        ?>
                    <form action="delete.php"method="post" enctype="multipart/form-data">
                        <div class="flex-container">
                            <h3>Are you sure that you want to delete this S.Y.: <?php echo $fn; ?> ?</h4><br>
                            <input type="hidden" name="sy_id" value="<?php echo $dsid; ?>">
                        </div>
                                
                                <input type="submit" value="Delete" name="del_sy" class="btn_delete1">&nbsp;
                                <input type="reset" value="cancel" id="close_del_sy" class="btn_cancel1">
                    </form>
                    <?php

                    };
                    echo "<script>document.querySelector('#cont_sy').style.display = 'flex';</script>";    
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