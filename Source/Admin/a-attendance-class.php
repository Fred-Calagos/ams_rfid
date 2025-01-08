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

    function updateGSStatus($id, $sc) {
        global $conn;
        $updateQuery = "UPDATE `teacher` SET grade = '$sc' WHERE id = '$id'";
        $conn->query($updateQuery);
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
            
            <img src="../../images/admin/profile.jpg" alt="">
        </div>

        <div class="dash-content">
            
            <div class="table-responsive">
            <i class="uil uil-search"></i><input type="text" placeholder="Search here..." id="search-event" style="float:right;padding:10px;border:none;border-bottom:2px solid blue;outline:none;">
            <div id="result"></div>
                    <script>
                        
                    $(document).ready(function(){

                        load_data();

                            function load_data(query)
                                {
                                    $.ajax({
                                            url:"a-auto-search-attendance-class.php",
                                            method:"POST",
                                            data:{query:query},
                                            success:function(data)
                                            {
                                                $('#result').html(data);
                                            }
                                        });
                                }
                            $('#search-event').keyup(function(){
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
            <!--EDITING STRAND NAME -->
            <!-- -------------- -->
    <section class="edit-form-container" id="att_c">
        <?php
            if(isset($_GET['clid'])){
            $edit_id = $_GET['clid'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `attendance_class` WHERE ca_id = $edit_id");
            if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_array($edit_query)){
                $id = $fetch_edit['ca_id'];
                $ti = $fetch_edit['time_in'];
                $tout = $fetch_edit['time_out'];
                $as = $fetch_edit['attendance_status'];
            };
        ?>
         <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
            <div class="flex-container">
                <div class="cont1">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <label for="fname">Edit Attendance</label>
                    <input type="time" class="box" step="1" required name="ti" value="<?php echo $ti; ?>" >
                    <input type="time" class="box" step="1" required name="to" value="<?php echo $tout; ?>" >
                    <select name="at" onchange="getGrade(this.value);" class="form-control">
                        <option value="<?php echo $as?>" selected hidden><?php echo $as?></option>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM att_status ORDER BY att_name ASC");
                        while ($row = mysqli_fetch_array($query)) {
                            ?>
                            <option value="<?php echo htmlentities($row['att_name']); ?>"><?php echo $row['att_name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <br><br>
                </div>
                
            </div>
                    <input type="submit" value="Update" name="cl_upt" class="btn_edit1">
                    <input type="reset" value="x" id="close_attc" class="option-btn btn_cancel1">
         </form>
         <?php

         };
         echo "<script>
         
         document.querySelector('#att_c').style.display = 'flex';
         document.querySelector('#att_c').style.transition = 'transform 0.4s, top 0.4s';
         
         </script>";    
      };
   ?>


    </section>
        <?php 
    include("footer.php");
?>
<script src="../../assets/JS/script-popup.js"></script>
</body>
</html>