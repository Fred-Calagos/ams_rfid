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
            <br>
            <div class="bread">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="m-setup.php"><i class="bx bxs-home"></i></a></li>
                <li class="breadcrumb-item active"><a href="m-instructor.php">Adviser Information</a></li>
                </ol>
            </div>
            <div class="table-responsive">
            <div class="row well">
                <ul>
                    <li><a href="generate.php" class="btn_create1"><i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp; Add Adviser</a></li>
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
                                            url:"a-auto-search-instructor.php",
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
            <!-- --------------------------------- -->
            <!-- POP UP MODAL FOR UPDATING ADVISER -->
            <!-- --------------------------------- -->                                

        <section class="edit-form-container" id="adv_edit">
        <?php
            if(isset($_GET['id_adv'])){
            $edit_id = $_GET['id_adv'];
            $name =    $_GET['name'];
            $edit_query = mysqli_query($conn, "SELECT t.*, ti.t_fn, ti.t_mn, ti.t_ln, gr.stud_grade AS grName, sc.section_name AS scName FROM `teacher` as t
                                                LEFT JOIN teacher_info AS ti ON t.t_id = ti.t_id 
                                                LEFT JOIN grade AS gr ON t.grade = gr.grade_id
                                                LEFT JOIN section AS sc ON sc.section_id = t.section 
                                                WHERE id = $edit_id");
            if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_array($edit_query)){
                $id = $fetch_edit['id'];
                $t_id = $fetch_edit['t_id'];
                $fname =   $fetch_edit['t_fn'];
                $lname  =  $fetch_edit['t_ln'];
                $mname =    $fetch_edit['t_mn'];
                $grade =   $fetch_edit['grade'];
                $section =   $fetch_edit['section'];
                $grName = $fetch_edit['grName'];
                $scName = $fetch_edit['scName'];
            };
        ?>
         <form action="i-ins-update.php" method="post" enctype="multipart/form-data">
            <div class="flex-container">
                <div class="cont1">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <label for="">Adviser Name</label>
                    <select name="adv_name" class="box" id="" required>
                        <option value="<?php echo $t_id ?>" selected hidden ><?php echo $lname.",".$fname." ".$mname?></option>
                        <?php
                        $sql = "SELECT * FROM teacher_info ORDER BY t_id asc";
                        $allgender = mysqli_query($conn, $sql);
                            while ($genderall = mysqli_fetch_array($allgender)) {
                            ?>
                                <option value="<?php echo $genderall['t_id']?>"><?php echo $genderall['t_ln'].",".$genderall['t_fn']." ".$genderall['t_mn']?></option>';
                        <?php
                            }
                        ?>
                    </select>
                    <label for="">Grade</label>
                    <select name="gr" onchange="getGrade(this.value);" class="form-control">
                            <option value="<?php echo $grade ?>" selected hidden ><?php echo $grName?></option>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM grade ORDER BY stud_grade ASC");
                            while ($row = mysqli_fetch_array($query)) {
                                ?>
                                <option value="<?php echo htmlentities($row['grade_id']); ?>"><?php echo $row['stud_grade']; ?></option>
                                <?php
                            }
                            ?>
                    </select>
                    <label for="">Section</label>
                    <select name="sc" id="section" class="form-control">
                        <option value="<?php echo $section ?>" selected hidden ><?php echo $scName?></option>
                    </select>
                    <br>
                </div>
            </div>
            <br>
                    <input type="submit" value="Update" name="ins_update" class="btn_edit1">
                    <input type="reset" value="cancel" id="close-ins" class="option-btn btn_cancel1">
         </form>
         <?php

         };
         echo "<script>document.querySelector('#adv_edit').style.display = 'flex';</script>";    
      };
   ?>
        </section>

            <!-- --------------------------------- -->
            <!-- POP UP MODAL FOR DELETING ADVISER -->
            <!-- --------------------------------- --> 

            <div class="edit-form-container" id="adv_del_cont">
                    <?php
                        if(isset($_GET['adv_id'])){
                        $t_id = $_GET['adv_id'];  
                        $edit_query = mysqli_query($conn, "SELECT teacher.*, teacher_info.t_fn, teacher_info.t_mn, teacher_info.t_ln FROM `teacher`
                                                            INNER JOIN teacher_info ON teacher.t_id = teacher_info.t_id WHERE id = $t_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($fetch_edit = mysqli_fetch_array($edit_query)){
                                    $dsid   = $fetch_edit['id'];
                                    $fn  = $fetch_edit['t_fn'];
                                    $ln = $fetch_edit['t_ln'];
                                };
                        ?>
                    <form action="delete.php"method="post" enctype="multipart/form-data">
                        <div class="flex-container">
                            <h3>Are you sure that you want to delete this Adviser: <?php echo $fn." ".$ln; ?> ?</h4><br>
                            <input type="hidden" name="adv_id" value="<?php echo $dsid; ?>">
                        </div>
                                
                                <input type="submit" value="Delete" name="del_adv" class="del_teach btn_delete1">&nbsp;
                                <input type="reset" value="cancel" id="close-del-adv" class="btn_cancel1">
                    </form>
                    <?php

                    };
                    echo "<script>document.querySelector('#adv_del_cont').style.display = 'flex';</script>";    
                };
            ?>
            </div>
    </section>

<?php
    include "footer.php";
?>
<script>
    function edit_records() {
        // Your existing edit_records function
        var selectedRecords = $('input[name="chk[]"]:checked').map(function(){
            return this.value;
        }).get();

        if (selectedRecords.length === 0) {
            alert('At least one checkbox must be selected to proceed!');
            return;
        }

        // Redirect to the edit page with selected record IDs
        window.location.href = 'mul_edit.php?idp=' + selectedRecords.join(',');
    }

</script>
<script src="../../assets/JS/script-popup.js"></script>
</body>
</html>