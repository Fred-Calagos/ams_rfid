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
            
            <img src="../../images/admin/profile.jpg" alt="">
        </div>


        <div class="dash-content">
            <br>
        <div class="bread">
                <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="m-setup.php"><i class="bx bxs-home"></i></a></li>
                <li class="breadcrumb-item active"><a href="m-teachload.php">TEACHING LOAD</a></li>
                </ul>
            </div>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?=$_GET['error']?>
                </div>
            <?php } ?>
            <div class="table-responsive">
            <div class="row well">
                <ul>
                    <li><a id="add-subject" class="btn_create1"><i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp; Assign Subject</a></li>
                    <li><a id="" class="btn_edit1" href="m-sched-class.php"><i class="fa fas fa-arrow-alt-circle-right" aria-hidden="true"></i> &nbsp; Class Schedule</a></li>
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
                                            url:"a-as-teachload.php",
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
    <div class="modal_add_teacher1" id="modal_add_student">
        <div class="modal_content_student">
            <form action="create.php" method="post" class="form-students" id="form-students" enctype="multipart/form-data">
            <button type="button" name="cancel" id="btn_cancel" class="cancel">X</button><br>
            <h3 class="modal_title"> ADD TEACHER</h3>
            <hr style="height:3px;background-color:black;border:none;">
                <div class="half">
                    <div class="item">
                        <label class="required" for="teacher">Teacher</label>
                        <select name="teacher" id="teacher" required>
                                <option value="" selected disabled hidden >--Select Teacher--</option>
                                <?php
                                $sql = "SELECT * FROM teacher_info ORDER BY t_ln asc";
                                $teacher = mysqli_query($conn, $sql);
                                    while ($teach = mysqli_fetch_array($teacher)) {
                                        $n++;
                                    ?>
                                        <option value="<?php echo $teach['t_id']?>"><?php echo $teach['t_ln'].", ".$teach['t_fn'] ." ".$teach['t_mn']?></option>';
                                <?php
                                    }
                                ?>
                            </select>
                        <label class="required" for="subject">Subject</label>
                        <select name="subject" id="subject" required>
                                <option value="" selected disabled hidden >--Select Subject--</option>
                                <?php
                                $sql = "SELECT * FROM subjects ORDER BY sub_name asc";
                                $subj = mysqli_query($conn, $sql);
                                    while ($subject = mysqli_fetch_array($subj)) {
                                    ?>
                                        <option value="<?php echo $subject['s_id']?>"><?php echo $subject['sub_name']?> | <?php echo $subject['sub_desc']?></option>';
                                <?php
                                    }
                                ?>
                            </select>
                        <label class="required" for="advisory">Advisory</label>
                        <select name="advisory" placeholder="Please select Gender" id="" required>
                                <option value="" selected disabled hidden >--Advisory--</option>
                                <?php
                                $sql = "SELECT teacher.*, teacher_info.t_fn AS t_fn, teacher_info.t_mn AS t_mn, teacher_info.t_ln AS t_ln FROM teacher
                                INNER JOIN teacher_info ON teacher.t_id = teacher_info.t_id ORDER BY t_ln asc";
                                $adviser = mysqli_query($conn, $sql);
                                    while ($adv = mysqli_fetch_array($adviser)) {
                                    ?>
                                        <option value="<?php echo $adv['t_id']?>"><?php echo $adv['t_ln'] ." ". $adv['t_fn']." ". $adv['t_mn']?></option>';
                                <?php
                                    }
                                ?>
                            </select>
                    </div>
                </div>
                <!-- -------------------------------- -->
                    <div class="item">
                        <button type="submit" name="add_teachload" id="btn_add" class="btn_create1">Save</button><br><br><br>
                    </div>

                <script src="../../assets/Js/modal-student.js"></script>
                <script src="../../assets/js/bootstrap.min.js"></script>
                <script src="../../assets/js/dependent.js"></script>
            </form>
        </div>
    </div>
</div>
    </section>
    <section class="edit-form-container" id="eassign_sub">
        <?php
            if(isset($_GET['tl_id'])){
            $edit_id = $_GET['tl_id'];
            $edit_query = mysqli_query($conn, "SELECT teaching_load.*, teacher.t_fn as fn, teacher.t_ln as ln, teacher.t_mn as mn,
            adviser.t_ln as advln, adviser.t_fn as advfn, adviser.t_mn as advmn, 
            subjects.sub_name as sn
            FROM `teaching_load` 
            INNER JOIN teacher_info as teacher ON teaching_load.t_id = teacher.t_id
            INNER JOIN subjects ON teaching_load.s_id = subjects.s_id
            INNER JOIN teacher_info as adviser ON teaching_load.adv_id = adviser.t_id
            WHERE id_tl = $edit_id
            ");
            if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_array($edit_query)){
                $id  = $fetch_edit['id_tl'];
                $tid = $fetch_edit['t_id'];
                $tfn = $fetch_edit['fn'];
                $tln = $fetch_edit['ln'];
                $tmn = $fetch_edit['mn'];
                $afn = $fetch_edit['advfn'];
                $aln = $fetch_edit['advln'];
                $amn = $fetch_edit['advmn'];
                $sid = $fetch_edit['s_id'];
                $sn  = $fetch_edit['sn'];
                $adv = $fetch_edit['adv_id'];
            };
        ?>
         <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
            <div class="flex-container">
                <div class="cont1">
                    <h1>EDIT TEACHING LOAD</h1>
                    <input type="hidden" name="as_id" value="<?php echo $id; ?>">
                        <label class="required" for="teacher">Teacher</label>
                        <select name="teacher" id="teacher" required>
                                <option value="<?php echo $tid?>"selected hidden><?php echo $tln .", ".$tfn." ".$tmn?></option>
                                <?php
                                $sql = "SELECT * FROM teacher_info ORDER BY t_ln asc";
                                $teacher = mysqli_query($conn, $sql);
                                    while ($teach = mysqli_fetch_array($teacher)) {
                                    ?>
                                        <option value="<?php echo $teach['t_id']?>"><?php echo $teach['t_ln'].", ".$teach['t_fn'] ." ".$teach['t_mn']?></option>';
                                <?php
                                    }
                                ?>
                            </select>
                        <label class="required" for="subject">Subject</label>
                        <select name="subject" id="subject" required>
                                <option value="<?php echo $sid?>" selected hidden><?php echo $sn?></option>
                                <?php
                                $sql = "SELECT * FROM subjects ORDER BY sub_name asc";
                                $subj = mysqli_query($conn, $sql);
                                    while ($subject = mysqli_fetch_array($subj)) {
                                    ?>
                                        <option value="<?php echo $subject['s_id']?>"><?php echo $subject['sub_name']?></option>';
                                <?php
                                    }
                                ?>
                            </select>
                        <label class="required" for="advisory">Advisory</label>
                        <select name="advisory" placeholder="Please select Gender" id="" required>
                                <option value="<?php echo $adv?>" selected hidden><?php echo  $aln.", ".$afn." ".$amn?></option>
                                <?php
                                $sql = "SELECT teacher.*, teacher_info.t_fn AS t_fn, teacher_info.t_mn AS t_mn, teacher_info.t_ln AS t_ln FROM teacher
                                INNER JOIN teacher_info ON teacher.t_id = teacher_info.t_id ORDER BY t_ln asc";
                                $adviser = mysqli_query($conn, $sql);
                                    while ($adv = mysqli_fetch_array($adviser)) {
                                    ?>
                                        <option value="<?php echo $adv['t_id']?>"><?php echo $adv['t_ln'] ." ". $adv['t_fn']." ". $adv['t_mn']?></option>';
                                <?php
                                    }
                                ?>
                            </select>
                </div>
            </div>
                    <input type="submit" value="Update" name="assign_update" class="btn_edit1">
                    <input type="reset" value="cancel" id="close_assign" class="option-btn btn_cancel1">
         </form>
         <?php

         };
         echo "<script>
         
         document.querySelector('#eassign_sub').style.display = 'flex';
         document.querySelector('#eassign_sub').style.transition = 'transform 0.4s, top 0.4s';
         
         </script>";    
      };
   ?>

    </section>
            <!-- ---------------------------------------- -->
            <!-- POP UP MODAL FOR DELETING TEACHER INFORMATION-->
            <!-- ---------------------------------------- -->

            <div class="edit-form-container" id="del_assign_sub">
                    <?php
                        if(isset($_GET['d_tl'])){
                        $t_id = $_GET['d_tl'];  
                        $edit_query = mysqli_query($conn, "SELECT * FROM `teaching_load` WHERE id_tl = $t_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($fetch_edit = mysqli_fetch_array($edit_query)){
                                    $dsid   = $fetch_edit['id_tl'];
                                };
                        ?>
                    <form action="delete.php"method="post" enctype="multipart/form-data">
                        <div class="flex-container">
                            <h4>Are you sure that you want to delete this?</h4><br>
                            <input type="hidden" name="d_tl" value="<?php echo $dsid; ?>">
                        </div>
                                
                                <input type="submit" value="Delete" name="del_csub" class="del_teach btn_delete1">&nbsp;
                                <input type="reset" value="cancel" id="close-del-assign" class="btn_cancel1">
                    </form>
                    <?php

                    };
                    echo "<script>document.querySelector('#del_assign_sub').style.display = 'flex';</script>";    
                };
            ?>
            </div>
            <!-- ---------------------------------------- -->
            <!-- POP UP MODAL FOR ADDING SUBJECT SCHED-->
            <!-- ---------------------------------------- -->
    <section class="edit-form-container" id="sched_cont">
        <?php
            if(isset($_GET['a_id'])){
            $edit_id = $_GET['a_id'];
            $edit_query = mysqli_query($conn, "SELECT * FROM teaching_load
            WHERE id_tl = $edit_id
            ");
            if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_array($edit_query)){
                $id  = $fetch_edit['id_tl'];
            };
        ?>
         <form action="create.php" method="post" enctype="multipart/form-data">
            <table class="table-container">
                <tr>
                    <td colspan="3" style="text-align:center">
                    <h1>ADD SCHEDULE</h1>
                    </td>
                </tr>
                <tr>
                    <td>
                    <input type="hidden" name="idtl" class="puts" value="<?php echo $id; ?>">
                    <label for="">Present</label>
                    <input type="time" name="inp" class="puts" step="1">
                    </td>
                    <td>
                    <label for="">Late</label>
                    <input type="time" name="inl" class="puts" step="1">
                    </td>
                    <td>
                    <label for="">OUT</label>
                    <input type="time" name="clout" class="puts"step="1">
                    </td>
                </tr>
            </table>
            <br>
                    <input type="submit" value="Add" name="add_sched_sub" class="btn_edit1">
                    <input type="reset" value="cancel" id="close_add_sched" class="option-btn btn_cancel1">
         </form>
         <?php

         };
         echo "<script>
         
         document.querySelector('#sched_cont').style.display = 'flex';
         document.querySelector('#sched_cont').style.transition = 'transform 0.4s, top 0.4s';
         
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