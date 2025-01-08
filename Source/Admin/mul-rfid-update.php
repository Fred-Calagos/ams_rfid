<?php
include_once '../../inc/connect.php';
$id = $_POST['id'];
$rfid_no = $_POST['rfid_no'];
$rfid_status = $_POST['rfid_status'];

$chk = $_POST['chk'];
$chkcount = count($id);
for($i=0; $i<$chkcount; $i++)
{
	$conn->query("UPDATE `rfid` SET rfid_no ='$rfid_no[$i]', rfid_status='$rfid_status[$i]' WHERE id=".$id[$i]);
}
header("Location: m-rfid.php");
?>