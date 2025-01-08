<?php

    include "header.php";
    include "../../Inc/connect.php";
    if (!isset($_SESSION["username"])) {
        ?>
            <script type="text/javascript">
                window.location="../../index.php";
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
</head>
<body>
<section class="dashboard">
        <div class="top">
        <i class="fas fa-bars sidebar-toggle"></i>
        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="fas fa-dashboard"></i>
                    <span class="text">ADMINISTRATIVE OFFICER ROLE</span>
                </div>

                <div class="table-responsive">
                    <form action="create.php" method="POST" class="form-section" enctype="multipart/form-data">
                        <table class="table">
                        <tr>
                            <td><input type="text" class="puts" name="AdminRole" placeholder="Add Administrative Role"></td>
                            <td><input type="submit" class="btn_create1 puts" value="ADD" name="addAdminRole"></td>
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
                                    <th>Administrative Officer Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $n = 0;
                                    
                                    $res = mysqli_query($conn, "SELECT * FROM `administrativerole` order by AdminRole ASC");
                                    while ($row = mysqli_fetch_array($res)) {
                                            $n++;
                                            ?>
                                                <tr>
                                                    <td><?php echo $n?></td>
                                                    <td><?php echo $row['AdminRole']?></td>
                                                    <td><a href="m-adminrole.php?id_adminrole=<?php echo $row["id"];?>"><i class="fas fa-edit btn_edit1"></i></a>
                                                </tr>
                                                <?php       

                                        }
                                    ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- -------------- -->
    <!--EDITING ADMIN ROLE-->
    <!-- -------------- -->
    <section class="edit-form-container" id="AdministrativeRoleCont">
        <?php
            if(isset($_GET['id_adminrole'])){
            $editAdminRole = $_GET['id_adminrole'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `administrativerole` WHERE id = $editAdminRole");
            if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_array($edit_query)){
                $id = $fetch_edit['id'];
                $sub_n =   $fetch_edit['AdminRole'];
            };
        ?>
            <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
                <div class="flex-container">
                    <div class="cont1">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <label for="name">Edit Grade</label>
                        <input type="text" class="box" required name="AdminRole" value="<?php echo $sub_n; ?>" >
                    </div>
                </div>
                        <input type="submit" value="Update" name="adminRoleUpt" class="btn_edit1">
                        <input type="reset" value="x" id="close_adminrole" class="option-btn btn_cancel1">
            </form>
         <?php

         };
         echo "<script>
         
         document.querySelector('#AdministrativeRoleCont').style.display = 'flex';
         document.querySelector('#AdministrativeRoleCont').style.transition = 'transform 0.4s, top 0.4s';
         
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