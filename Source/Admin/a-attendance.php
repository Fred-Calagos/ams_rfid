<?php 
    include("header.php");
    include("../../inc/connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <section class="dashboard">
        <div class="top">
        <i class="fas fa-bars sidebar-toggle"></i>
        </div>
        <script src="../../assets/js/jquery.js" type="text/javascript"></script>
    <script src="../../assets/js/js-script.js" type="text/javascript"></script>
    <script src="../../assets/jquery/jquery.min.js"></script>


        <div class="dash-content">
                <!-------------------ATTENDANCE TABLE ------------------------ -->
                <div class="table-responsive">
                    <div class="row well">
                        <ul>
                            <li><a href="a-att-pg1.php" target="_blank" class="btn_create1">Attendance Portal</a></li>
                        </ul>
                    </div>
            <i class="uil uil-search"></i><input type="text" placeholder="Search here..." id="search-ins" style="float:right;padding:10px;border:none;border-bottom:2px solid blue;outline:none;">
            
            <div id="result"></div>
                    <script>
                        
                    $(document).ready(function(){

                        load_data();

                            function load_data(query)
                                {
                                    $.ajax({
                                            url:"a-auto-search-attendance.php",
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
            <!--EDITING STRAND NAME -->
            <!-- -------------- -->
            <section class="edit-form-container" id="att_g">
        <?php
            if(isset($_GET['gid'])){
            $edit_id = $_GET['gid'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `attendance_gate` WHERE gid = $edit_id");
            if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_array($edit_query)){
                $id = $fetch_edit['gid'];
                $amti = $fetch_edit['amti'];
                $amto = $fetch_edit['amto'];
                $am_stat = $fetch_edit['am_status'];
                $pmti = $fetch_edit['pmti'];
                $pmto = $fetch_edit['pmto'];
                $pm_stat = $fetch_edit['pm_status'];
            };
        ?>
         <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
            <div class="flex-container">
                <div class="cont1">
                    <h3>Edit Attendance</h3>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <h4>Morning</h4>
                    <input type="time" class="box" step="1" required name="amti" value="<?php echo $amti; ?>">
                    <input type="time" class="box" step="1" required name="amto" value="<?php echo $amto; ?>">
                    <select name="am_stat" class="box">
                        <option value="<?php echo $am_stat?>" selected hidden><?php echo $am_stat?></option>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM att_status ORDER BY att_name ASC");
                        while ($row = mysqli_fetch_array($query)) {
                            ?>
                            <option value="<?php echo htmlentities($row['att_name']); ?>"><?php echo $row['att_name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <h4>Afternoon</h4>
                    <input type="time" class="box" step="1" required name="pmti" value="<?php echo $pmti; ?>">
                    <input type="time" class="box" step="1" required name="pmto" value="<?php echo $pmto; ?>">
                    <select name="pm_stat" class="box">
                        <option value="<?php echo $pm_stat?>" selected hidden><?php echo $pm_stat?></option>
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
                    <input type="submit" value="Update" name="gt_upt" class="btn_edit1">
                    <input type="reset" value="x" id="close_attg" class="option-btn btn_cancel1">
         </form>
         <?php

         };
         echo "<script>
         
         document.querySelector('#att_g').style.display = 'flex';
         document.querySelector('#att_g').style.transition = 'transform 0.4s, top 0.4s';
         
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