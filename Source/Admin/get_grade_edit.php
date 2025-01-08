<?php
include("../../Inc/connect.php");

if (!empty($_POST["stud_grade"])) {
    $studGrade = mysqli_real_escape_string($conn, $_POST["stud_grade"]);
    $query = mysqli_query($conn, "SELECT * FROM `section` WHERE `stud_grade` ='$studGrade'");
    ?>
    <option value="">Select Section</option>
    <?php
    while ($row = mysqli_fetch_array($query)) {
        ?>
        <option value="<?php echo htmlentities($row['section_name']); ?>"><?php echo htmlentities($row['section_name']); ?></option>
        <?php
    }
}
?>
