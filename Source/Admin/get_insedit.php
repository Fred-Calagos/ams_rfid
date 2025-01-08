<?php
  include("../../Inc/connect.php");

if (!empty($_POST["grEdit"])) {
  $grEdit = mysqli_real_escape_string($conn, $_POST["grEdit"]);
  $query = mysqli_query($conn, "SELECT * FROM `section` WHERE `stud_grade` ='$grEdit'");
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
