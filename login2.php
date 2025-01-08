<?php

session_start();
include("connection.php"); 
 
 # LOG IN CREDENTIALS from form
$username=$_POST['username']; 
$password=$_POST['password']; 
 
# clean the strings 
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysqli_real_escape_string($conn,$username);
$password = mysqli_real_escape_string($conn,$password);

# find user in user table
$sql="SELECT * FROM `user` WHERE username='$username' and password='$password'";
$result=mysqli_query($conn,$sql);

# if user exists get id
if(mysqli_num_rows($result) > 0){
$rows = mysqli_fetch_array($result);
$_SESSION['id']=$rows['id'];
$userid=$_SESSION['id'];

	#Check if user role is admin
	if ($rows['role'] == '2'){
		$acheck="SELECT * FROM `admin` WHERE user_id='$userid'";
		$ares=mysqli_query($conn,$acheck);
		
		if(mysqli_num_rows($ares) > 0)
		{
			$row = mysqli_fetch_array($ares);
			$_SESSION['office']=$row['office'];
			$find_d = $_SESSION['office'];
			//header('location:a-dashboard.php');
			
			$_SESSION['status'] = " ";
			header('location:a-dashboard.php');

		
		}
		else{
			
			//header('location: updateadmin.php');
			echo "<script>window.location.href='updateclient.php' </script>";
		}

	}
	#Check if user role is client
	else
	if ($rows['userole'] == 'client') {
		$acheck="SELECT * FROM `people` WHERE user_id='$userid'";
		$ares=mysqli_query($conn,$acheck);

		#if user is admin and it's not his first session redirect to client portal
		if(mysqli_num_rows($ares) > 0)
		{
			//header('location:cli-dashboard.php');
			$row = mysqli_fetch_array($ares);
			$_SESSION['office']=$row['office'];
			$find_d = $_SESSION['office'];
			
			$_SESSION['status'] = " ";
			header('location:cli-dashboard.php');
		
		
		}
		#else if it's his first time logging in direct to client information update
		else{
			
			header('location: updateclient.php'); 
		}

	} 
	#Check if user role is storekeeper
	else
	if ($rows['userole'] == 'storekeeper') {
		$acheck="SELECT * FROM `skeeper` WHERE user_id='$userid'";
		$ares=mysqli_query($conn,$acheck);

		#if user is admin and it's not his first session redirect to client portal
		if(mysqli_num_rows($ares) > 0) 
		{
			
			header('location:skeeper-dashboard.php');
		
		
		}
		#else if it's his first time logging in direct to storekeeper information update
		else{

			header('location: updatestorek.php'); 
		}

	} 

	#if user is not found
	
	else
	{ 
		//$_SESSION['message']="User not found!";

		header('location:index.php');
	} 

}

else{
	echo "<script>alert('User not found!');</script>";
	echo "<script>window.location.href='index.php' </script>";

	$_SESSION['error'] = "Incorrect username or password !";
	header('location:index.php');
}

$head = "Head";
$sele="SELECT * FROM `people` WHERE office='$find_d' AND position = '$head'";
$sult=mysqli_query($conn,$sele);

if(mysqli_num_rows($sult) > 0){
	$ro= mysqli_fetch_array($sult);
	$_SESSION['head'] = $ro['id'];
	$head_id=$_SESSION['head'];
}


?>