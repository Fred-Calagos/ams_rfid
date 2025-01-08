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
                    <li class="breadcrumb-item active"><a href="#">SUBJECT</a></li>
                    </ol>
                </div>
                <BR>
            
            <div class="table-responsive">
            <div class="row well">
            <form action="create.php" method="post" enctype="multipart/form-data">
                <h3>CREATE SUBJECT</h3>
                <br>
                <ul>
                    <li>
                    <label for="adviser">Subject Category</label>
                    <select name="subcat" placeholder="Please select Gender" id="" required>
                        <option value="" selected disabled hidden>SELECT SUBJECT CATEGORY</option>
                        <?php
                        $sql = "SELECT * FROM subject_category ORDER BY subcat_name asc";
                        $data = mysqli_query($conn, $sql);
                            while ($dataAll = mysqli_fetch_array($data)) {
                            ?>
                                <option value="<?php echo $dataAll['id']?>"><?php echo $dataAll['subcat_name']?></option>';
                        <?php
                            }
                        ?>
                    </select>
                    </li>
                    <li>
                        <label class="required" for="strand-sub">Subject Title</label>
                        <input type="text" name="subTitle" class="subtext">
                    </li>
                    <li>
                        <label class="required" for="strand-sub">Subject Description</label>
                        <input type="text" name="subDesc" class="subtext">
                    </li>
                    <li>
                    <label for="grade">Offered to</label>
                    <select name="grade" id="" required>
                        <option value="" selected disabled hidden>SELECT GRADE</option>
                        <?php
                        $sql = "SELECT * FROM grade ORDER BY CAST(SUBSTRING(stud_grade, 7) AS UNSIGNED) ASC;";
                        $data = mysqli_query($conn, $sql);
                            while ($dataAll = mysqli_fetch_array($data)) {
                            ?>
                                <option value="<?php echo $dataAll['grade_id']?>"><?php echo $dataAll['stud_grade']?></option>';
                        <?php
                            }
                        ?>
                    </select>
                    </li>
                </ul>
                <br>
                <ul>
                    <h5>For Specialized Subject ONLY*</h5>
                    <br>
                    <li>
                        <label class="required" for="track">Track</label>
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
                </ul>
                <br>
                <input type="submit" value="Add" name="add-subject" class="btn_create1" style="float:right">
               
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
                                            url:"a-auto-search-subject.php",
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
                    <h3 class="modal_title"> ADD STUDENT</h3>
                    <hr style="height:3px;background-color:black;border:none;">
                         <!-- Subject Name -->
                        <div class="half">
                            <div class="item">
                                <label class="required" for="subname">Subject Name</label>
                                <input type="text" name="subname" placeholder="Enter Subject Name" required oninput="lettersOnly(this)">
                            </div>
                        </div>
                        
                        <!-- -------------------------------- -->
                            <div class="item">
                                <button type="submit" name="add-subject" id="btn_add">Save</button>
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
            <!-- UPDATING SUBJECT -->
            <!-- -------------- -->
    <section class="edit-form-container" id="cont_subn">
        <?php
            if(isset($_GET['e_subid'])){
            $edit_id = $_GET['e_subid'];
            $edit_query = mysqli_query($conn, "SELECT sub.*,  sc.subcat_name AS scname, st.strand_name AS strandName, tr.track_name as trName, gr.stud_grade AS gradeName FROM `subjects` AS sub 
            LEFT JOIN subject_category AS sc ON sub.subcat_id  = sc.id
            LEFT JOIN strands AS st ON sub.strand_id = st.strand_id
            LEFT JOIN tracks AS tr ON sub.track_id = tr.track_id
            LEFT JOIN grade AS gr ON sub.grade_id = gr.grade_id
            WHERE sub.s_id = $edit_id");
            if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_array($edit_query)){
                $id         = $fetch_edit['s_id'];
                $sub_n      = $fetch_edit['sub_name'];
                $subDesc    = $fetch_edit['sub_desc'];
                $subCat     = $fetch_edit['subcat_id'];
                $subCatName = $fetch_edit['scname'];
                $strand     = $fetch_edit['strand_id'];
                $strandName = $fetch_edit['strandName'];
                $track      = $fetch_edit['track_id'];
                $trackName  = $fetch_edit['trName'];
                $grade      = $fetch_edit['grade_id'];
                $gradeName  = $fetch_edit['gradeName'];

            };
        ?>
         <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
            <div class="flex-container">
            
                <div class="cont1">
                <h1>UPDATE SUBJECT</h1>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <label for="subName">Subject Name</label>
                    <input type="text" name="subname" value="<?php echo $sub_n; ?>" >
                    <label for="subDesc">Subject Description</label>
                    <input type="text" name="subDesc" value="<?php echo $subDesc; ?>">
                    <label for="">Subject Category</label>
                    <select name="subcat" class="select" required>
                        <option value="<?php echo $subCat; ?>"><?php echo $subCatName; ?></option>
                        <?php
                        $sql = "SELECT * FROM subject_category ORDER BY subcat_name asc";
                        $data = mysqli_query($conn, $sql);
                            while ($dataAll = mysqli_fetch_array($data)) {
                            ?>
                                <option value="<?php echo $dataAll['id']?>"><?php echo $dataAll['subcat_name']?></option>';
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="cont1">
                    <br><br>
                <label for="grade">Offered to</label>
                
                    <select name="grade" id="" class="select" required>
                        <option value="<?php echo $grade?>"><?php echo $gradeName?></option>
                        <?php
                        $sql = "SELECT * FROM grade ORDER BY stud_grade asc";
                        $data = mysqli_query($conn, $sql);
                            while ($dataAll = mysqli_fetch_array($data)) {
                            ?>
                                <option value="<?php echo $dataAll['grade_id']?>"><?php echo $dataAll['stud_grade']?></option>';
                        <?php
                            }
                        ?>
                    </select>

                <h5>For Specialized Subject ONLY*</h5>
                        <label for="track">Track</label>
                        <select name="tracks" class="select">
                            <option value="<?php echo $track;?>"><?php echo $trackName;?></option>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM tracks ORDER BY track_name ASC");
                            while ($row = mysqli_fetch_array($query)) {
                            ?>
                            <option value="<?php echo htmlentities($row['track_id']); ?>"><?php echo $row['track_name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <label for="strand">Strand</label>
                        <select name="strand" id="strand">
                            <option value="<?php echo $strand;?>"><?php echo $strandName;?></option>
                        </select>
                </div>
            </div>
            <br><br>
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

            <div class="edit-form-container" id="sub_cont">
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
                    echo "<script>document.querySelector('#sub_cont').style.display = 'flex';</script>";    
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