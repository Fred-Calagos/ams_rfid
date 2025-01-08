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
                    <li class="breadcrumb-item active"><a href="m-sched-event.php">Event Schedule</a></li>
                </ul>
            </div>
        </div>
        <!-- TABLE FOR EVENT ATTENDANCE -->


        <div class="table-responsive">
        <div class="row well">
                <ul>
                    <li><a id="add_event" class="btn_create1"><i class="fas fa-circle-plus"></i> Event Schedule</a></li>
                </ul>
            </div>
        <h1 style="text-align:center">EVENT SCHEDULE</h1><BR>
            <i class="uil uil-search"></i><input type="text" placeholder="Search here..." id="search-eve" style="float:right;padding:10px;border:none;border-bottom:2px solid blue;outline:none;">
            <div id="result1"></div>
                    <script>
                        
                    $(document).ready(function(){

                        load_data();

                            function load_data(query)
                                {
                                    $.ajax({
                                            url:"a-auto-search-att-event-sched.php",
                                            method:"POST",
                                            data:{query:query},
                                            success:function(data)
                                            {
                                                $('#result1').html(data);
                                            }
                                        });
                                }
                            $('#search-eve').keyup(function(){
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
        <!-- -------------------------------------- -->
        <!-- POP UP MODAL FOR UPDATING EVENT SCHEDULE -->
        <!-- ---------------------------------------- -->

        <section class="edit-form-container" id="edit-form-container2">
                <?php
                    if(isset($_GET['event_id'])){
                    $edit_id = $_GET['event_id'];
                    $edit_query = mysqli_query($conn, "SELECT * FROM `event_sched` WHERE id = $edit_id LIMIT 1");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($row = mysqli_fetch_array($edit_query)){
                                    $dsid   = $row['id'];
                                    $event  = $row['event_name']; 
                                    $date   = $row['event_date'];
                                    $mti    = $row['am_ti'];
                                    $mto    = $row['am_to']; 
                                    $aftti  = $row['pm_ti'];
                                    $aftto  = $row['pm_to'];
                                    $eveti  = $row['eve_ti'];
                                    $eveto  = $row['eve_to'];
                                };
                ?>
                <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
                    <h1>UPDATE SCHEDULE</h1>
                    <div class="flex-container">
                        <div class="cont1">
                            <input type="hidden" name="id" value="<?php echo $dsid; ?>">
                            <label for="">EVENT NAME</label>
                            <input type="text" class="box" required name="event_n" step="1" value="<?php echo $event; ?>" >
                            <label for="">EVENT DATE</label>
                            <input type="date" class="box" required name="event_d" step="1"  value="<?php echo $date; ?>" >
                        </div> 
                        <div class="cont1">
                            <h4>MORNING</h4>
                            <label for="">TIME IN</label>
                            <input type="time" class="box" required name="amti" step="1"  value="<?php echo $mti; ?>" >
                            <label for="">TIME OUT</label>
                            <input type="time" class="box" required name="amto" step="1"  value="<?php echo $mto; ?>" >
                        </div>
                        <div class="cont1">
                            <h4>AFTERNOON</h4>
                            <label for="">TIME IN</label>
                            <input type="time" class="box" required name="pmti" step="1"  value="<?php echo $aftti; ?>" >
                            <label for="">TIME OUT</label>
                            <input type="time" class="box" required name="pmto" step="1"  value="<?php echo $aftto; ?>" >
                        </div>
                        <div class="cont1">
                        <h4>EVENING</h4>
                            <label for="">TIME IN</label>
                            <input type="time" class="box" required name="eveti" step="1"  value="<?php echo $eveti; ?>" >
                            <label for="">TIME OUT</label>
                            <input type="time" class="box" required name="eveto" step="1"  value="<?php echo $eveto; ?>" >
                        </div>
                            
                        
                    </div>
                            <input type="submit" value="Update" name="event_update" class="btn_edit1">
                            <input type="reset" value="cancel" id="close-upt-e" class="option-btn btn_cancel1">
                </form>
                <?php

                };
                echo "<script>document.querySelector('#edit-form-container2').style.display = 'flex';</script>";    
            };
        ?>
            </section>
            <!-- ---------------------------------------- -->
            <!-- POP UP MODAL FOR DELETING EVENT SCHEDULE -->
            <!-- ---------------------------------------- -->

            <div class="edit-form-container" id="edit-form-container3">
                    <?php
                        if(isset($_GET['eve_del_id'])){
                        $sched_id = $_GET['eve_del_id'];  
                        $edit_query = mysqli_query($conn, "SELECT * FROM `event_sched` WHERE id = $sched_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($fetch_edit = mysqli_fetch_array($edit_query)){
                                    $dsid   = $fetch_edit['id'];
                                    $event  = $fetch_edit['event_name'];
                                };
                        ?>
                    <form action="delete.php"method="post" enctype="multipart/form-data">
                        <div class="flex-container">
                            <h1>Are you sure that you want to delete this event: <i> <?php echo $event; ?> </i>?</h1><br>
                            <input type="hidden" name="eid" value="<?php echo $dsid; ?>">
                        </div>
                                
                                <input type="submit" value="Delete" name="delete_event_sched" class="btn_delete1">
                                <input type="reset" value="cancel" id="close-del-e" class="option-btn btn_cancel1">
                    </form>
                    <?php

                    };
                    echo "<script>document.querySelector('#edit-form-container3').style.display = 'flex';</script>";    
                };
            ?>
            </div>    

    </section>


<!-- Modal Time -->
<div class="modal_event" id="modal_event">

                    <div class="modal_event_content">
    
                        <form action="create.php" method="post" class="frm_time">
                            <br>
                            <button type="button" name="cancel" class="btn_cancel1" id="btn_cancel_e">x</button>
                            <br>
                            <h4>EVENT SCHEDULE</h4>
                            <hr style="border: 2px solid black; width:100%; margin: 3% 0;">
                            <div class="half">
                                <div class="item">
                                <label for="">Event Name</label>
                                <input type="text" name="event" id="event" placeholder="Event Name">
                                </div>
                                <div class="item">
                                <label for="">Event Date</label>
                                <input type="date" name="date" id="date" placeholder="Event Date">
                                </div>

                            </div>
                            <div class="half">
                                                                
                                <div class="item">
                                    <h4>MORNING</h4>
                                        <label for="">Start</label>
                                        <input type="time" name="mti" id="mti" step="1">
                                        <label for="">End</label>
                                        <input type="time" name="mto" id="mto" step="1"><br>
                                </div>
                                <div class="item">
                                    <h4>AFTERNOON</h4>
                                        <label for="">Start</label>
                                        <input type="time" name="aftti" id="aftti" step="1">
                                        <label for="">End</label>
                                        <input type="time" name="aftto" id="aftto" step="1"><br>
                                </div>
                                <div class="item">
                                    <h4>EVENING</h4>
                                        <label for="">Start</label>
                                        <input type="time" name="eveti" id="eveti" step="1">
                                        <label for="">End</label>
                                        <input type="time" name="eveto" id="eveto" step="1">
                                </div>
                            </div>
                            <button type="submit" name="add_event" class="btn_create1" id="btn_event">Save</button>
                            <br><br><br>
                                  
                        </form>
                        <script src="../../assets/js/modal_event.js"></script>
                    </div>
                </div>

<?php 
    include("footer.php");
?>
<script src="../../assets/JS/script-popup.js"></script>
</body>
</html>