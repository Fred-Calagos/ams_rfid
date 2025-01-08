<?php
  include("../../Inc/connect.php");

if (!empty($_POST["provCode"])) {
  $provCode = mysqli_real_escape_string($conn,$_POST["provCode"]);
  $query = mysqli_query($conn, "SELECT * FROM `refcitymun` WHERE `provCode` ='$provCode'");
  ?>
  <option value="">Select Municipality</option>
  <?php
  while ($row = mysqli_fetch_array($query)) {
    ?>
    <option value="<?php echo htmlentities($row['citymunCode']); ?>"><?php echo htmlentities($row['citymunDesc']); ?></option>
    <?php
  }
}
?>
