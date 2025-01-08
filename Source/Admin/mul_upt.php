<?php
include_once '../../inc/connect.php';

	$id = $_POST['id'];
	$fn = $_POST['fn'];
	$mn = $_POST['mn'];
	$ln = $_POST['ln'];
	$gr = $_POST['gr'];
	$sc = $_POST['sc'];

	$chkcount = count($id);
	for($i=0; $i<$chkcount; $i++)
	{
		$conn->query("UPDATE teacher SET fname ='$fn[$i]', mname='$mn[$i]', lname='$ln[$i]', grade='$gr[$i]', section='$sc[$i]' WHERE id=".$id[$i]);
	}
	header("Location: m-instructor.php");