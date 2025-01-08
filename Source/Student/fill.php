<?php
//requested term
$product = $_REQUEST['adv'];

//define connection
$conn = mysqli_connect("localhost","root","root","class_sched_db");
if ($product !== "") {
	
	$query = mysqli_query($conn, "SELECT grade, section FROM teacher 
    WHERE mname ='$product'");
	$row = mysqli_fetch_array($query);

	$supplier = $row["grade"];
	$unit = $row["section"];


}

// Store it in a array
$result = array("$supplier", "$unit");
// Send in JSON encoded form
$myJSON = json_encode($result);
echo $myJSON;

?>
