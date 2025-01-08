<?php 
    include("header.php");
    include '../../inc/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

/* Hover effect to make the box stand out */
.box2:hover {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Slightly stronger shadow on hover */
}

    </style>
</head>
<body>
    <section class="dashboard">
        <div class="top">
        <i class="fas fa-bars sidebar-toggle"></i>
            <span>CREATE CLASS</span>
        </div>
        <div class="dash-content">
            <div class="bread">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="m-setup.php"><i class="bx bxs-home"></i></a></li>
                <li class="breadcrumb-item active"><a href="m-class.php">Grade</a></li>
                </ol>
            </div>
            <div class="table-responsive">
                <form action="create.php" method="POST" class="form-section" enctype="multipart/form-data">
                    <table class="table">
                    <tr>
                        <td><input type="text" class="puts" name="grade" placeholder="Add Year Level"></td>
                        <td><select name="hsCat" class="puts">
                        <option value="" selected disabled hidden>Select Category</option>
                        <?php
                            $query = mysqli_query($conn, "SELECT * FROM `hs_cat` ORDER BY hs_id ASC");
                            while ($row = mysqli_fetch_array($query)) {
                                ?>
                                <option value="<?php echo $row['hs_id']; ?>"><?php echo $row['hs_name']; ?></option>
                                <?php
                            }
                            ?>
                        </select></td>
                        <td><input type="submit" class="btn_create1 puts" value="ADD" name="add-year"></td>
                    </tr>
                    </table>    
                </form>
            </div>
                <div class="table-responsive">
                    <form action="" method="Post" name="frm">
                    <table class="table-container">
                        <thead>

                            <tr>
                                <th>No.</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $n = 0;
                                
                                $res = mysqli_query($conn, "SELECT * FROM `grade` order by stud_grade DESC");
                                while ($row = mysqli_fetch_array($res)) {
                                        $n++;
                                        ?>
                                            <tr>
                                                <td><?php echo $n?></td>
                                                <td><?php echo $row['stud_grade']?></td>
                                                <td><a href="m-class.php?id_c=<?php echo $row["grade_id"];?>"><i class="fas fa-edit btn_edit1"></i></a>
                                                    <a href="m-class-edit.php?a_id=<?php echo $row["grade_id"];?>"><i class="fas fa-plus btn_create1"></i></a>
                                                    <a href="m-class.php?del_c=<?php echo $row["grade_id"]?>"><i class="fas fa-trash btn_delete1"></a></td>
                                            </tr>
                                            <?php       

                                    }
                                ?>
                        </tbody>
                    </table>
                    </form>
                </div>
                </section>
            <!-- -------------- -->
            <!--EDITING Grade Name -->
            <!-- -------------- -->
    <section class="edit-form-container" id="gr_cont">
        <?php
            if(isset($_GET['id_c'])){
            $edit_id = $_GET['id_c'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `grade` WHERE grade_id = $edit_id");
            if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_array($edit_query)){
                $id = $fetch_edit['grade_id'];
                $sub_n =   $fetch_edit['stud_grade'];
            };
        ?>
         <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
            <div class="flex-container">
                <div class="cont1">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <label for="fname">Edit Grade</label>
                    <input type="text" class="box" required name="gradeName" value="<?php echo $sub_n; ?>" >
                </div>
            </div>
                    <input type="submit" value="Update" name="gr_upt" class="btn_edit1">
                    <input type="reset" value="x" id="close_gr" class="option-btn btn_cancel1">
         </form>
         <?php

         };
         echo "<script>
         
         document.querySelector('#gr_cont').style.display = 'flex';
         document.querySelector('#gr_cont').style.transition = 'transform 0.4s, top 0.4s';
         
         </script>";    
      };
   ?>


    </section>
            <!-- ---------------------------------------- -->
            <!-- POP UP MODAL FOR DELETING Grades-->
            <!-- ---------------------------------------- -->

            <div class="edit-form-container" id="cont_delGrade">
                    <?php
                        if(isset($_GET['del_c'])){
                        $t_id = $_GET['del_c'];  
                        $edit_query = mysqli_query($conn, "SELECT * FROM `grade` WHERE grade_id = $t_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($fetch_edit = mysqli_fetch_array($edit_query)){
                                    $dsid   = $fetch_edit['grade_id'];
                                    $fn  = $fetch_edit['stud_grade'];
                                };
                        ?>
                    <form action="delete.php"method="post" enctype="multipart/form-data">
                        <div class="flex-container">
                            <h4>Are you sure that you want to delete this Grade: <?php echo $fn; ?> ?</h4><br>
                            <input type="hidden" name="gr_id" value="<?php echo $dsid; ?>">
                        </div>
                                <br>
                                <input type="submit" value="Delete" name="delete_grade" class="del_teach btn_delete1">&nbsp;
                                <input type="reset" value="cancel" id="close_del_grade" class="btn_cancel1">
                    </form>
                    <?php

                    };
                    echo "<script>document.querySelector('#cont_delGrade').style.display = 'flex';</script>";    
                };
            ?>
            </div>


        </div>
    </section>
<?php 
    include("footer.php");
?>
<!-- JS POPUP FOR EDITING AND UPDATING -->
<script src="../../assets/JS/script-popup.js"></script>
</body>
</html>