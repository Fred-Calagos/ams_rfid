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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Genearate Number of Teachers</title>
<script src="../../assets/js/jquery.js" type="text/javascript"></script>
<script src="../../assets/js/js-script.js" type="text/javascript"></script>
</head>

<body>
<section class="dashboard">
    <div class="top">
        <i class="fas fa-bars sidebar-toggle"></i>
            
        <img src="../../images/admin/profile.jpg" alt="">
        <a href="m-instructor.php" class="btn btn-medium btn-info"><i class="fa-solid fa-left-long"></i></a>    
    </div>
    <div class="dash-content">
        <br>
        <div class="container">
        
        </div>

        <div class="container">
            <form method="post" action="mul_add.php">

                <table class='table-tr'>
                    <tr>
                        <th colspan="2">Enter how many records you want to insert</th>
                    </tr>
                    <tr>
                        <td>
                        <input type="text" name="no_of_rec" placeholder="how many records u want to enter ? ex : 1 , 2 , 3 , 5" maxlength="3" pattern="[0-9]+" class="form-control" required />
                        </td>

                    </tr>
                    <tr>
                    <td><button type="submit" name="btn-gen-form"  value="Generate" class="btn btn-primary"><i class="fa-solid fa-user-plus">GENERATE</i></button>
                        </td>
                    </tr>
                </table>

            </form>

        </div>
    </div>
</section>
<?php
    include "footer.php";
?>
</body>
</html>