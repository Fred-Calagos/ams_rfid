<?php 
    
    include("header.php");
    include("../../Inc/connect.php");
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
                    <input type="text" name="search-attendance" id="search-attendance" placeholder="Search here...">
            </div>
        </div>

        <!-- BUTTON FOR EVENT ATTENDANCE -->
        <div class="dash-content">

        <div class="table-responsive">
        <div class="bread">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="m-schedule.php"><i class="bx bxs-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="m-teachload.php">Teaching Load</a></li>
                    <li class="breadcrumb-item active"><a href="m-sched-class.php">Class Schedule</a></li>
                </ul>
            </div>
        </div>
        <!-- TABLE FOR EVENT ATTENDANCE -->


        <div class="table-responsive">
        <h1 style="text-align:center">CLASS SCHEDULE</h1><br>
            <i class="uil uil-search"></i><input type="text" placeholder="Search here..." id="search" style="float:right;padding:10px;border:none;border-bottom:2px solid blue;outline:none;">
            <div id="result1"></div>
                    <script>
                        
                    $(document).ready(function(){

                        load_data();

                            function load_data(query)
                                {
                                    $.ajax({
                                            url:"a-auto-search-sched-class.php",
                                            method:"POST",
                                            data:{query:query},
                                            success:function(data)
                                            {
                                                $('#result1').html(data);
                                            }
                                        });
                                }
                            $('#search').keyup(function(){
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

            <!-- -------------- -->
            <!-- EDTITING sSUBJECT SCHED -->
            <!-- -------------- -->
            <section class="edit-form-container" id="esched_cont">
                <?php
                    if(isset($_GET['csid'])){
                    $edit_id = $_GET['csid'];
                    $edit_query = mysqli_query($conn, "SELECT * FROM `class_sched` as cs
                                                                    LEFT JOIN 

                                                                    WHERE cs_id = $edit_id");
                    if(mysqli_num_rows($edit_query) > 0){
                    while($fetch_edit = mysqli_fetch_array($edit_query)){
                        $id = $fetch_edit['cs_id'];
                        $idtl = $fetch_edit['id_tl'];
                        $inp = $fetch_edit['inp'];
                        $inl = $fetch_edit['inl'];
                        $inout = $fetch_edit['log_out'];
                    };
                ?>
            <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
                <table class="table-container">
                    <tr>
                        <td colspan="3" style="text-align:center">
                        <h1>Edit Subject Schedule</h1>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label for="teacher_name">Teacher Name: </label>
                        </td>
                    </tr>
                    <tr>
                        
                        <td>
                            <input type="hidden" name="csid" class="puts" value="<?php echo $id; ?>">
                            <label for="">Present</label>
                            <input type="time" name="inp" class="puts" step="1" value="<?php echo $inp?>">
                        </td>
                        <td>
                            <label for="">Late</label>
                            <input type="time" name="inl" class="puts" step="1" value="<?php echo $inl?>">
                        </td>
                        <td>
                            <label for="">OUT</label>
                            <input type="time" name="clout" class="puts"step="1" value="<?php echo $inout?>">
                        </td>
                    </tr>
                </table>
                <br>
                        <input type="submit" value="Update" name="uptSchedSub" class="btn_edit1">
                        <input type="reset" value="close" id="close_esched" class="option-btn btn_cancel1">
            </form>
         <?php

         };
         echo "<script>
         
         document.querySelector('#esched_cont').style.display = 'flex';
         document.querySelector('#esched_cont').style.transition = 'transform 0.4s, top 0.4s';
         
         </script>";    
      };
   ?>


    </section>
            <!-- ---------------------------------------- -->
            <!-- POP UP MODAL FOR DELETING SCHED -->
            <!-- ---------------------------------------- -->

            <div class="edit-form-container" id="dsched_cont">
                    <?php
                        if(isset($_GET['did'])){
                        $tr_id = $_GET['did'];  
                        $edit_query = mysqli_query($conn, "SELECT * FROM `class_sched` WHERE cs_id = $tr_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($fetch_edit = mysqli_fetch_array($edit_query)){
                                    $dsid   = $fetch_edit['cs_id'];
                                };
                        ?>
                    <form action="delete.php"method="post" enctype="multipart/form-data">
                        <div class="flex-container">
                            <h3>Are you sure that you want to delete this Schedule?</h4><br>
                            <input type="hidden" name="sc_id" value="<?php echo $dsid; ?>">
                        </div>
                                
                                <input type="submit" value="Delete" name="del_csched" class="del_teach btn_delete1">&nbsp;
                                <input type="reset" value="cancel" id="close_del_csched" class="btn_cancel1">
                    </form>
                    <?php

                    };
                    echo "<script>document.querySelector('#dsched_cont').style.display = 'flex';</script>";    
                };
            ?>
            </div>
<?php 
    include("footer.php");
?>
<script src="../../assets/JS/script-popup.js"></script>
</body>
</html>