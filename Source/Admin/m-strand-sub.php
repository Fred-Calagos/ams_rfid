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
                    <li class="breadcrumb-item"><a href="m-setup.php"><i class="bi bi-house-door"></i></a></li>
                    <li class="breadcrumb-item active"><a href="m-track.php">TRACK</a></li>
                    <li class="breadcrumb-item active"><a href="m-strand.php">STRAND</a></li>
                    <li class="breadcrumb-item active"><a href="m-strand.php">STRAND SUBJECTS</a></li>
                    </ol>
                </div>
                <br>

            <div class="table-responsive">
            <div class="row well">
            <form action="create.php" method="post" enctype="multipart/form-data">
                <h3>CREATE STRAND SUBJECT</h3>
                <br>
                <ul>
                    <li>
                    <label for="adviser">Track</label>
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
                    </li>
                    <li>
                    <label class="required" for="strand">Strand</label>
                                    <select name="strand" id="strand">
                                        <option >Select Strand</option>
                                    </select>
                    </li>
                    <li>
                    <label class="required" for="strand-sub">Strand Subject</label>
                    <input type="text" name="subname" class="subtext">
                    </li>
                </ul>
                <br>
                <input type="submit" value="Create" name="sub_create" class="btn_create1" style="float:right">
               
            </form>
                
            </div><br>
            </div>
            
            <div class="table-responsive">
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
</div>
    </section>
            <!-- -------------- -->
            <!-- EDITING SUBJECT -->
            <!-- -------------- -->
    <section class="edit-form-container" id="track_cont">
        <?php
            if(isset($_GET['e_subid'])){
            $edit_id = $_GET['e_subid'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `subjects` WHERE s_id = $edit_id");
            if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_array($edit_query)){
                $id = $fetch_edit['s_id'];
                $sub_n =   $fetch_edit['sub_name'];
            };
        ?>
         <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
            <div class="flex-container">
                <div class="cont1">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <label for="fname">First Name</label>
                    <input type="text" class="box" required name="subname" value="<?php echo $sub_n; ?>" >
                </div>
            </div>
                    <input type="submit" value="Update" name="sub_update" class="btn_edit1">
                    <input type="reset" value="x" id="close_subj" class="option-btn btn_cancel1">
         </form>
         <?php

         };
         echo "<script>
         
         document.querySelector('#cont_subn').style.display = 'flex';
         document.querySelector('#cont_subn').style.transition = 'transform 0.4s, top 0.4s';
         
         </script>";    
      };
   ?>


    </section>
            <!-- ---------------------------------------- -->
            <!-- POP UP MODAL FOR DELETING SUBJECTS-->
            <!-- ---------------------------------------- -->

            <div class="edit-form-container" id="cont_track">
                    <?php
                        if(isset($_GET['d_subid'])){
                        $t_id = $_GET['d_subid'];  
                        $edit_query = mysqli_query($conn, "SELECT * FROM `subjects` WHERE s_id = $t_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($fetch_edit = mysqli_fetch_array($edit_query)){
                                    $dsid   = $fetch_edit['s_id'];
                                    $fn  = $fetch_edit['sub_name'];
                                };
                        ?>
                    <form action="delete.php"method="post" enctype="multipart/form-data">
                        <div class="flex-container">
                            <h3>Are you sure that you want to delete this Subject: <?php echo $fn; ?> ?</h4><br>
                            <input type="hidden" name="s_id" value="<?php echo $dsid; ?>">
                        </div>
                                
                                <input type="submit" value="Delete" name="delete_subject" class="del_teach btn_delete1">&nbsp;
                                <input type="reset" value="cancel" id="close-del-subj" class="btn_cancel1">
                    </form>
                    <?php

                    };
                    echo "<script>document.querySelector('#cont_track').style.display = 'flex';</script>";    
                };
            ?>
            </div>
<?php
    include "footer.php";
?>
<!-- JS POPUP FOR EDITING AND UPDATING -->
<script src="../../assets/js/dependent.js"></script>
<script src="../../assets/JS/script-popup.js"></script>
</body>
</html>