<?php
  include("../../Inc/connect.php");

if (!empty($_POST["munCode"])) {
  $munCode = mysqli_real_escape_string($conn, $_POST["munCode"]);
  $query = mysqli_query($conn, "SELECT * FROM `refbrgy` WHERE `citymunCode` ='$munCode'");
  ?>
  <option value="">Select Barangay</option>
  <?php
  while ($row = mysqli_fetch_array($query)) {
    ?>
    <option value="<?php echo htmlentities($row['brgyCode']); ?>"><?php echo htmlentities($row['brgyDesc']); ?></option>
    <?php
  }
}
?>
