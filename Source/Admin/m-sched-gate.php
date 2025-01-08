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



        <!-- BUTTON FOR GATE ATTENDANCE -->

        <div class="dash-content">
            <div class="table-responsive">
            <div class="bread">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="m-schedule.php"><i class="bx bxs-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="m-sched-gate.php">Gate Schedule</a></li>
                </ul>
            </div>
            </div>
        <div class="table-responsive">
            <div class="row well">
                <ul>
                    <li><a href="a-att-pg1.php" class="btn_edit1" target="_blank">Attendance Portal</a></li>
                    <li><a id="add_time" class="btn_create1">Add Time Schedule</a></li>
                </ul>
            </div>
        <!-- TABLE FOR REGULAR CLASS ATTENDANCE -->

        <h1 style="text-align:center">GATE ATTENDANCE SCHEDULE</h1><BR>
            <i class="uil uil-search"></i><input type="text" placeholder="Search here..." id="search-ins" style="float:right;padding:10px;border:none;border-bottom:2px solid blue;outline:none;">
            <div id="result"></div>
                    <script>
                        
                    $(document).ready(function(){

                        load_data();

                            function load_data(query)
                                {
                                    $.ajax({
                                            url:"a-auto-search-sched.php",
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

        <!-- BUTTON FOR EVENT ATTENDANCE -->
        <div class="dash-content">
        <!-- TABLE FOR EVENT ATTENDANCE -->
        <!-- --------------------------------------- -->
        <!-- POP UP MODAL FOR UPDATING GATE SCHEDULE -->
        <!-- --------------------------------------- -->

                <section class="edit-form-container1">
                <?php
                    if(isset($_GET['sid'])){
                    $edit_id = $_GET['sid'];
                    $edit_query = mysqli_query($conn, "SELECT * FROM `att_sched` WHERE id = $edit_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($row = mysqli_fetch_array($edit_query)){
                                    $dsid   = $row['id'];
                                    $amps   = $row['am_ps'];
                                    $amls   = $row['am_ls'];
                                    $amo    = $row['am_logout'];
                                    $pmps   = $row['pm_ps'];
                                    $pmls   = $row['pm_ls'];
                                    $pmo    = $row['pm_logout'];
                                };
                ?>
                <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
                    <h1>UPDATE SCHEDULE</h1>
                    <div class="flex-container">
                        <div class="cont1">
                            <input type="hidden" name="id" value="<?php echo $dsid; ?>">
                            <label for="">AM PRESENT START</label>
                            <input type="time" class="box" required name="amps" step="1" value="<?php echo $amps; ?>" >
                            <label for="">AM LATE START</label>
                            <input type="time" class="box" required name="amls" step="1"  value="<?php echo $amls; ?>" >
                            <label for="">AM LOGOUT</label>
                            <input type="time" class="box" required name="amo"  step="1"  value="<?php echo $amo; ?>" >
                        </div> 
                        <div class="cont2">
                            <label for="">PM PRESENT START</label>
                            <input type="time" class="box" required name="pmps" step="1"  value="<?php echo $pmps; ?>" >
                            <label for="">PM LATE START</label>
                            <input type="time" class="box" required name="pmls" step="1"  value="<?php echo $pmls;  ?>" >
                            <label for="">PM LOGOUT</label>
                            <input type="time" class="box" required name="pmo"  step="1"  value="<?php echo $pmo; ?>" >
                        </div>
                    </div>
                            <input type="submit" value="Update" name="sched_update" class="btn_edit1">
                            <input type="reset" value="cancel" id="close-upts" class="btn_cancel1">
                </form>
                <?php

                };
                echo "<script>document.querySelector('.edit-form-container1').style.display = 'flex';</script>";    
            };
        ?>
            </section>
            <!-- --------------------------------------- -->
            <!-- POP UP MODAL FOR DELETING GATE SCHEDULE -->
            <!-- --------------------------------------- -->

            <div class="edit-form-container" id="del_cont">
                    <?php
                        if(isset($_GET['did'])){
                        $sched_id = $_GET['did'];  
                        $edit_query = mysqli_query($conn, "SELECT * FROM `att_sched` WHERE id = $sched_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($fetch_edit = mysqli_fetch_array($edit_query)){
                                    $dsid   = $fetch_edit['id'];
                                };
                        ?>
                    <form action="delete.php"method="post" enctype="multipart/form-data">
                        <div class="flex-container">
                            <h1>Are you sure that you want to delete the Schedule?</h1><br>
                            <input type="hidden" name="id" value="<?php echo $dsid; ?>">
                        </div>  
                                <input type="submit" value="Delete" name="delete_sched" class="btn_delete1">
                                <input type="reset" value="cancel" id="close-del" class="btn_cancel1">
                    </form>
                    <?php

                    };
                    echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";    
                };
            ?>
            </div>

    </section>



<!-- Modal Time -->
<div class="modal_time" id="modal_time">

    <div class="modal_time_content">
   
        <form action="create.php" method="post" class="frm_time">
            <button type="button" name="cancel" id="btn_cancel_t">x</button>
            <Br>
            <h3>Gate Schedule</h3>
            <hr style="border: 2px solid black; width:100%; margin: 3% 0;">
            <h4>MORNING</h4>
            <div class="half">
                <div class="item">
                <label for="">On Time Start</label>
                <input type="time" name="ps" id="ps" step="1">
                </div>
                <div class="item">
                    <label for="">Late Start</label>
                    <input type="time" name="ls" id="ls" step="1">
                </div>
                <div class="item">
                    <label for="">Morning Log-Out</label>
                    <input type="time" name="am_o" id="am_o" step="1">
                </div>
            </div>
            <h4>AFTERNOON</h4>
            <div class="half">
                <div class="item">
                    <label for="">Present Start</label>
                    <input type="time" name="psa" id="psa" step="1">
                </div>
                <div class="item">
                    <label for="">Start</label>
                    <input type="time" name="lsa" id="lsa" step="1">
                </div>
                <div class="item">
                    <label for="">Log-Out</label>
                    <input type="time" name="pm_o" id="pm_o" step="1">
                </div>
            </div>
            <button type="submit" name="add_time" id="btn_time" class="btn_create1">Save</button>
        </form>
        <script src="../../assets/js/modal_time.js"></script>
    </div>
</div>
<?php 
    include("footer.php");
?>
<script src="../../assets/JS/script-popup.js"></script>
</body>
</html>