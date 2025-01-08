<?php
include("../../Inc/connect.php");

if (!empty($_POST["strandId"])) {
    $trackId = mysqli_real_escape_string($conn, $_POST["strandId"]);
    $query = mysqli_query($conn, "SELECT * FROM `strands` WHERE `track_id` ='$trackId'");
    ?>
    <option value="">Select Strand</option>
    <?php
    while ($row = mysqli_fetch_array($query)) {
        ?>
        <option value="<?php echo htmlentities($row['strand_id']); ?>"><?php echo htmlentities($row['strand_name']); ?></option>
        <?php
    }
}
?>