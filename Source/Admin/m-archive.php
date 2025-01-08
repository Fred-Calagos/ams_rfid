<?php
    include "header.php";
    include("../../Inc/connect.php");
    include "delete_btm.php";
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
    <title>STUDENT LIST</title>
    <script src="../../assets/js/jquery.js" type="text/javascript"></script>
    <script src="../../assets/js/js-script.js" type="text/javascript"></script>
    <script src="../../assets/jquery/jquery.min.js"></script>
<style>
    .disable-background {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    z-index: 1;
    backdrop-filter: blur(10px); /* Apply blur effect */
}

.modal_add_student {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 2; /* Ensure the modal appears above the blur background */
    /* Add other styles as needed */
}
</style>
<script>
// $(function() {
//     $( "#adviser").autocomplete({
//     source: 'stud-complete.php',
//     });
// });

function GetProDetails(str){
if(str.length == 0){
    document.getElementById("grade").value = "";
    document.getElementById("section").value = "";
    document.getElementById("gradeName").value = "";
    document.getElementById("sectionName").value = "";
    return;
}
else{

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
    
        if (this.readyState == 4 && this.status == 200){
            
            var myObj = JSON.parse(this.responseText);
            document.getElementById("grade").value = myObj[0];
            document.getElementById("section").value = myObj[1];
            document.getElementById("gradeName").value = myObj[2];
            document.getElementById("sectionName").value = myObj[3];
        }
    };
    xmlhttp.open("GET", "stud-fill.php?adv=" + str, true);
    xmlhttp.send();

}
}
</script>
</head>
<body>
    <section class="dashboard">
        <div class="top">
        <i class="fas fa-bars sidebar-toggle"></i>

        </div>  
        <div class="dash-content">
        <div class="bread">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="m-setting.php"><i class="bx bxs-home"></i></a></li>
                <li class="breadcrumb-item active"><a href="#">STUDENT ARCHIVE</a></li>
                </ol>
            </div>
        <div class="table-responsive">
            <i class="uil uil-search"></i><input type="text" placeholder="Search here..." id="search-stud" style="float:right;padding:10px;border:none;border-bottom:2px solid blue;outline:none;">
            <div id="result"></div>
                    <script>
                        
                    $(document).ready(function(){

                        load_data();

                            function load_data(query)
                                {
                                    $.ajax({
                                            url:"a-auto-search-studentArchive.php",
                                            method:"POST",
                                            data:{query:query},
                                            success:function(data)
                                            {
                                                $('#result').html(data);
                                            }
                                        });
                                }
                            $('#search-stud').keyup(function(){
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

            <!-- ---------------------------------------- -->
            <!-- POP UP MODAL FOR ARCHIVING STUDENTS-->
            <!-- ---------------------------------------- -->

            <div class="edit-form-container" id="stud_ret">
                    <?php
                        if(isset($_GET['retId'])){
                        $t_id = $_GET['retId'];  
                        $edit_query = mysqli_query($conn, "SELECT * FROM `new_students` WHERE id = $t_id");
                            if(mysqli_num_rows($edit_query) > 0){
                                while($fetch_edit = mysqli_fetch_array($edit_query)){
                                    $dsid   = $fetch_edit['id'];
                                    $fn  = $fetch_edit['fname'];
                                    $mn  = $fetch_edit['mname'];
                                    $ln  = $fetch_edit['lname'];
                                };
                        ?>
                    <form action="c-update-yl.php"method="post" enctype="multipart/form-data">
                        <div class="flex-container">
                            <h4>Are you sure that you want to Retrieve this Student: <?php echo $fn.' '.$mn.' '.$ln; ?> ?</h4><br>
                            <input type="hidden" name="sId" value="<?php echo $dsid; ?>">
                            <input type="hidden" name="retId" value="1">
                        </div>
                                <br>
                                <input type="submit" value="RETRIEVE" name="ret_stud" class="btn_delete1">&nbsp;
                                <input type="reset" value="cancel" id="close_ret_stud" class="btn_cancel1">
                    </form>
                    <?php

                    };
                    echo "<script>document.querySelector('#stud_ret').style.display = 'flex';</script>";    
                };
            ?>
            </div>
    </section>
    <?php
        include "footer.php";
    ?>
    
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('add-student-modal').addEventListener('click', function () {
        // Show the modal and background disable
        document.getElementById('modal_add_student').style.display = 'block';
    });

    document.getElementById('btn_cancel').addEventListener('click', function () {
        // Hide the modal and background disable
        document.getElementById('modal_add_student').style.display = 'none';
    });
});
 </script>
<!-- JS POPUP FOR EDITING AND UPDATING -->
<script src="../../assets/JS/script-popup.js"></script>
</body>
</html>