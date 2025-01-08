<?php 
    include("header.php");
    include("../../Inc/connect.php");

    $id_c =$_GET['a_id'];
    
    $query = mysqli_query($conn, "SELECT * FROM `grade` WHERE `grade_id` = '$id_c'");
    while($row=mysqli_fetch_array($query)){         
        $id = $row['grade_id'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .box1{
            width:auto;
            padding: 10px;
            margin: 10px;
            outline: none;

        }
    </style>
</head>
<body>
    <section class="dashboard">
        <div class="top">
            <i class="fas fa-bars sidebar-toggle"></i>
            <span>UPDATE CLASS OR ADD SECTION</span>
            <a href="m-class.php"><i class="fa-solid fa-arrow-left"></i></a>
        </div>

        <div class="dash-content">
            <div class="bread">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="m-setup.php"><i class="bi bi-house-door"></i></a></li>
                <li class="breadcrumb-item"><a href="m-class.php">Grade</a></li>
                <li class="breadcrumb-item active"><a href="m-class-edit.php">Section</a></li>
                </ol>
            </div>

                <div class="table-responsive">
                    <!-- MODAL FOR ADDING SECTIONS -->
                    <h3>ADD SECTION TO GRADE LEVEL</h3>
                    <form action="c-update-yl.php?a_id=<?php echo $id_c ?>" method="post" class="add-sec">
                        <table class="table-container" id="dynamic_field">
                        <tr>
                            
                        </tr>
                            <tr>
                                <td><input type="text" name="section1[]" placeholder="Enter Section Name" class="form-control name_list box1"><input type="hidden" name="grade1[]" value="<?php echo $id_c?>"/></td>
                                <td> <input type="button" name="add" id="add_sec" class="btn_create1" value="Add More"></td>
                                <td colspan="2" >
                                <input type="submit" name="submit1" id="submit1" class="btn_edit1" value="Submit">
                                </td>
                            </tr>
                        
                        
                        </table>
                    </form>
                </div>
                <div class="table-responsive">
            <i class="uil uil-search"></i><input type="text" placeholder="Search here..." id="search-ins" style="float:right;padding:10px;border:none;border-bottom:2px solid blue;outline:none;">
            <div id="result"></div>
                <script>
                $(document).ready(function(){
                    load_data();

                    function load_data(query)
                    {
                        var a_id = <?php echo json_encode($_GET['a_id']); ?>;
                        $.ajax({
                            url:"a-auto-search-section.php",
                            method:"POST",
                            data:{query:query,a_id:a_id}, // Pass the a_id parameter
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
            <!--EDITING SECTION NAME -->
            <!-- -------------- -->
    <section class="edit-form-container" id="sec_cont1">
        <?php
            if(isset($_GET['e_trid'])){
            $edit_id = $_GET['e_trid'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `section` WHERE section_id = $edit_id");
            if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_array($edit_query)){
                $id = $fetch_edit['stud_grade'];
                $sid = $fetch_edit['section_id'];
                $sub_n =   $fetch_edit['section_name'];
            };
        ?>
         <form action="c-update-yl.php" method="post" enctype="multipart/form-data">
            <div class="flex-container">
                <div class="cont1">
                    <input type="hidden" name="grade" value="<?php echo $id; ?>">
                    <input type="hidden" name="sId" value="<?php echo $sid; ?>">
                    <label for="fname">Edit Section</label>
                    <input type="text" class="box" required name="section" value="<?php echo $sub_n; ?>" >
                </div>
            </div>
                    <input type="submit" value="Update" name="sec_update" class="btn_edit1">
                    <input type="reset" value="x" id="close_section" class="btn_cancel1">
         </form>
         <?php

         };
         echo "<script>
         
         document.querySelector('#sec_cont1').style.display = 'flex';
         document.querySelector('#sec_cont1').style.transition = 'transform 0.4s, top 0.4s';
         
         </script>";    
      };
   ?>
    </section>

            <!-- --------------------------------- -->
            <!-- POP UP MODAL FOR DELETING SECTION -->
            <!-- --------------------------------- --> 

            <div class="edit-form-container" id="cont_sec">
                    <?php
                        if(isset($_GET['d_trid'])){
                        $t_id = $_GET['d_trid'];  
                        $edit_query = mysqli_query($conn, "SELECT * FROM `section` WHERE section_id = $t_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($fetch_edit = mysqli_fetch_array($edit_query)){
                                    $id = $fetch_edit['stud_grade'];
                                    $sid = $fetch_edit['section_id'];
                                    $sub_n =   $fetch_edit['section_name'];
                                };
                        ?>
                    <form action="delete.php"method="post" enctype="multipart/form-data">
                        <div class="flex-container">
                            <h3>Are you sure that you want to delete this Section: <?php echo $sub_n; ?> ?</h4><br>
                            <input type="hidden" name="sid" value="<?php echo $sid; ?>">
                            <input type="hidden" name="grade" value="<?php echo $id; ?>">
                        </div>
                                
                                <input type="submit" value="Delete" name="del_sec" class="del_teach btn_delete1">&nbsp;
                                <input type="reset" value="cancel" id="close_del_sec" class="btn_cancel1">
                    </form>
                    <?php

                    };
                    echo "<script>document.querySelector('#cont_sec').style.display = 'flex';</script>";    
                };
            ?>
            </div>
    <!-- JS POPUP FOR EDITING AND UPDATING -->
<script src="../../assets/JS/script-popup.js"></script>
    <script>
                $(document).ready(function(){
                    var i=1;
                    $('#add_sec').click(function(){
                        i++;
                        $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="section1[]" placeholder="Enter Section Name" class="form-control name_list box1" /><input type="hidden" name="grade1[]" value="<?php echo $id_c?>"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove btn_delete1">X</button></td></tr>');
                    });
                    
                    $(document).on('click', '.btn_remove', function(){
                        var button_id = $(this).attr("id"); 
                        $('#row'+button_id+'').remove();
                    });
                });
            </script>
<?php
    include("footer.php");
?>

</body>
</html>