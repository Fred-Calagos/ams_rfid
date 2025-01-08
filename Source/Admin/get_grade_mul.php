<?php
include("../../Inc/connect.php");

if (!empty($_POST["stud_grade"]) && !empty($_GET["total"])) {
    $studGrade = mysqli_real_escape_string($conn, $_POST["stud_grade"]);
    $no = $_GET['total'];
    $query = mysqli_query($conn, "SELECT * FROM `section` WHERE `stud_grade` ='$studGrade'");
    ?>
    <option value="">Select Section</option>
    <?php
    while ($row = mysqli_fetch_array($query)) {
        ?>
        <option value="<?php echo htmlentities($row['section_id']); ?>"><?php echo htmlentities($row['section_name']); ?></option>
        <?php
    }
}
?>
