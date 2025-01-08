<?php
$conn = mysqli_connect("localhost","root","root","class_sched_db");
//Check Connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL:" .mysqli_connect_error();
}
?>