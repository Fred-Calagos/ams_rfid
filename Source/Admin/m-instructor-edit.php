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
                <input type="text" placeholder="Search here...">
            </div>
            
            <img src="../../images/admin/profile.jpg" alt="">
        </div>

        <div class="dash-content">
            <div class="row well">
                <ul>
                    <li><a href="generate.php" class="btn btn-large btn-info"><i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp; Add Teacher</a></li>
                </ul>
            </div><br>

            <div class="teacher-frm">
                <form action="" method="post" name="frm">
                    <div class="table_section">
                        <table class="table-container">
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Grade</th>
                                <th>Section</th>
                                <th>Action</th>
                            
                            </tr>
                        <?php
                            $res = $conn->query("SELECT * FROM teacher");
                            $count = $res->num_rows;

                            if($count > 0)
                            {
                                while($row=$res->fetch_array())
                                {
                                    ?>
                                    <tr>
                                    <td><input type="checkbox" name="chk[]" class="chk-box" value="<?php echo $row['id']; ?>"  /></td>
                                    <td><?php echo $row['fname']; ?></td>
                                    <td><?php echo $row['mname']; ?></td>
                                    <td><?php echo $row['lname']; ?></td>
                                    <td><?php echo $row['grade']; ?></td>
                                    <td><?php echo $row['section']; ?></td>
                                    <td><a href="i-ins-edit.php?id=<?php echo $row['id']?>&name=<?php echo $row['fname']?>"><i class="fas fa-edit edit"></i></a>
                                    <a href="delete_btm.php?stud_id=<?php echo $row['fname']?>" onclick="return confirm('Are you sure you want to delete <?php echo $row['fname'];?> ?')"><i class="fas fa-trash delete"></a></a></td>
                                    </tr>
                                    <?php
                                }	
                            }
                            else
                            {
                                ?>
                                <tr>
                                <td colspan="3"> No Records Found ...</td>
                                </tr>
                                <?php
                            }
                        ?>



                    </div>
                </form>
            </div>
        </div>
        
                <tr>
                <td colspan="7" style="text-align:left"><span><input type="checkbox" class="select-all"> Check / Uncheck All</span><span style="float:right">
                <span><img src="delete.png" onClick="delete_records();" alt="delete" />delete</span></span></td>
                </label>
                
                
                
                </tr>
                </table>
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
</body>
</html>