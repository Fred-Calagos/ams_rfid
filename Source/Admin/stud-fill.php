<?php
//requested term
$product = $_REQUEST['adv'];

//define connection
$conn = mysqli_connect("localhost","root","root","class_sched_db");
if ($product !== "") {
	
	$query = mysqli_query($conn, "SELECT t.*, g.stud_grade AS gname, s.section_name AS sname FROM teacher AS t
	LEFT JOIN grade AS g ON t.grade = g.grade_id
	LEFT JOIN section AS s ON t.section = s.section_id
    WHERE t.t_id  ='$product'");
	$row = mysqli_fetch_array($query);

	$grade = $row["grade"];
	$section = $row["section"];
	$gName = $row["gname"];
	$sName = $row['sname'];


}

// Store it in a array
$result = array("$grade", "$section", "$gName", "$sName");
// Send in JSON encoded form
$myJSON = json_encode($result);
echo $myJSON;

?>
