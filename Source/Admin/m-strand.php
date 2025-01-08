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
            <BR><div class="bread">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="m-setup.php"><i class="bx bxs-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="m-track.php">TRACK</a></li>
                    <li class="breadcrumb-item active"><a href="#">STRAND</a></li>
                </div>
                <BR>            
            <div class="table-responsive">
            <div class="row well">
                <ul>
                    <li><a id="add-subject" href="#" class="btn_view1"> <i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp;ADD STRAND</a></li>
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
                                            url:"a-auto-search-strand.php",
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
            <script src="../../assets/js/rfid.js"></script>
                
                    <form action="create.php" method="post" class="form-students" id="form-students" enctype="multipart/form-data">
                    <button type="button" name="cancel" id="btn_cancel" class="cancel">X</button><br>
                    <h3 class="modal_title">ADDING STRAND</h3>
                    <hr style="height:3px;background-color:black;border:none;">
                         <!-- Subject Name -->
                        <div class="half">
                            <div class="item">
                                <label class="required" for="trackName">Select Track</label>
                                <select name="track" id="" required>
                                    <option value="" selected hidden disabled>SELECT TRACK</option>
                                    <?php
                                    $sql = "SELECT * FROM tracks ORDER BY track_name asc";
                                    $allgender = mysqli_query($conn, $sql);
                                        while ($genderall = mysqli_fetch_array($allgender)) {
                                        ?>
                                            <option value="<?php echo $genderall['track_id']?>"><?php echo $genderall['track_name']?></option>';
                                    <?php
                                        }
                                    ?>
                                </select>
                                <label class="required" for="strandName">Add Strand</label>
                                <input type="text" name="strandName" placeholder="Enter Strand" required oninput="lettersOnly(this)">
                            </div>
                        </div>
                        
                        <!-- -------------------------------- -->
                            <div class="item">
                                <button type="submit" name="add-strand" id="btn_add" class="btn_create1">Save</button>
                                <br><br><br>
                            </div>

                <script src="../../assets/Js/modal-student.js"></script>
                <script src="../../assets/js/bootstrap.min.js"></script>
                <script src="../../assets/js/dependent.js"></script>
                    </form>

            </div>

            </div>

</div>
    </section>
            <!-- -------------- -->
            <!--EDITING STRAND NAME -->
            <!-- -------------- -->
    <section class="edit-form-container" id="strand_cont">
        <?php
            if(isset($_GET['e_stid'])){
            $edit_id = $_GET['e_stid'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `strands` WHERE strand_id = $edit_id");
            if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_array($edit_query)){
                $id = $fetch_edit['strand_id'];
                $sub_n =   $fetch_edit['strand_name'];
            };
        ?>
         <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
            <div class="flex-container">
                <div class="cont1">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <label for="strand">Edit Strand</label>
                    <input type="text" required name="strandName" value="<?php echo $sub_n; ?>" >
                </div>
            </div>
                    <input type="submit" value="Update" name="strand_update" class="btn_edit1">
                    <input type="reset" value="x" id="close_strand" class="option-btn btn_cancel1">
         </form>
         <?php

         };
         echo "<script>
         
         document.querySelector('#strand_cont').style.display = 'flex';
         document.querySelector('#strand_cont').style.transition = 'transform 0.4s, top 0.4s';
         
         </script>";    
      };
   ?>


    </section>
            <!-- ---------------------------------------- -->
            <!-- POP UP MODAL FOR DELETING SUBJECTS-->
            <!-- ---------------------------------------- -->

            <div class="edit-form-container" id="cont_strand">
                    <?php
                        if(isset($_GET['d_stid'])){
                        $t_id = $_GET['d_stid'];  
                        $edit_query = mysqli_query($conn, "SELECT * FROM `strands` WHERE strand_id = $t_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($fetch_edit = mysqli_fetch_array($edit_query)){
                                    $dsid   = $fetch_edit['strand_id'];
                                    $fn  = $fetch_edit['strand_name'];
                                };
                        ?>
                    <form action="delete.php"method="post" enctype="multipart/form-data">
                        <div class="flex-container">
                            <h4>Are you sure that you want to delete this Strand: <?php echo $fn; ?> ?</h4><br>
                            <input type="hidden" name="st_id" value="<?php echo $dsid; ?>">
                        </div>
                                <br>
                                <input type="submit" value="Delete" name="delete_strand" class="del_teach btn_delete1">&nbsp;
                                <input type="reset" value="cancel" id="close_del_strand" class="btn_cancel1">
                    </form>
                    <?php

                    };
                    echo "<script>document.querySelector('#cont_strand').style.display = 'flex';</script>";    
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