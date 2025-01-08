<?php
    include "header.php";
    include("../../Inc/connect.php");

    $id_ins = $_GET['id'];

    $query = mysqli_query($conn,"SELECT * FROM teacher WHERE id = '$id_ins'");
    while($row=mysqli_fetch_array($query)){
        $ins_f = $row['fname'];
        $ins_m = $row['lname'];
        $ins_l = $row['mname'];
        $ins_gr = $row['grade'];
        $ins_sc = $row['section'];
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
    <BR>
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
        <form action="i-ins-update.php" method="post" class="edit-ins" enctype="multipart/form-data">
        <div class="half">

        <div class="item">
            <input type="hidden" name="id" value="<?php echo $id_ins;?>">
            <label for="fname">First Name:</label>
            <input type="text" name="fname" value="<?php echo $ins_f; ?>" required><br>
        </div>

        <div class="item">
            <label for="mname">Middle Name:</label>
            <input type="text" name="mname" value="<?php echo $ins_m; ?>"><br>
        </div>

        <div class="item">
            <label for="lname">Last Name:</label>
            <input type="text" name="lname" value="<?php echo $ins_l; ?>" required><br>
        </div>

        </div>

        <div class="half">
            <div class="item">
                <label for="grade">Grade:</label>
                <select name="gr" onchange="getInsEdit(this.value);" class="form-control">
                    <option value=""><?php echo $ins_gr; ?></option>
                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM grade ORDER BY stud_grade ASC");
                    while ($row = mysqli_fetch_array($query)) {
                        ?>
                        <option value="<?php echo htmlentities($row['stud_grade']); ?>"><?php echo $row['stud_grade']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="item">
                <label for="section">Section:</label>
                <select name="sc" id="section" class="form-control">
                    <option value=""><?php echo $ins_sc; ?></option>
                </select>
            </div>
            <div class="item">
                <label for="ins_update">SUbmit:</label>
                <input type="submit" value="Update" id="ins_update" name="ins_update">
            </div>
        </div>
        </form>
    </div>
    <script src="../../assets/js/dependent.js"></script>
    </section>
    <!-- FOOTER -->
    <?php
        include "footer.php";
    ?>
</body>
</html>