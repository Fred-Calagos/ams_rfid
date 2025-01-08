<?php
  include("../../Inc/connect.php");

if (!empty($_POST["prov_Desc"])) {
  $provDesc = mysqli_real_escape_string($conn,$_POST["prov_Desc"]);
  $query = mysqli_query($conn, "SELECT * FROM `refcitymun` WHERE `provDesc` ='$provDesc'");
  ?>
  <option value="">Select Municipality</option>
  <?php
  while ($row = mysqli_fetch_array($query)) {
    ?>
    <option value="<?php echo htmlentities($row['citymunDesc']); ?>"><?php echo htmlentities($row['citymunDesc']); ?></option>
    <?php
  }
}
?>
