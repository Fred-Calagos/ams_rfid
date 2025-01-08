<?php  
session_start();
include "inc/connect.php";

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

	if($rows['status'] === 'Active'){
		
			$acheck="SELECT * FROM `user` WHERE id='$userid'";
			$ares=mysqli_query($conn,$acheck);
			
			if(mysqli_num_rows($ares) > 0)
			{
				$row = mysqli_fetch_array($ares);
				if($row['role']  === '1'){
				
					$_SESSION['username']=$row['username'];
				header('location:source/admin/admin_dash.php');		
				}elseif($row['role']  === '2'){
				
				$_SESSION['username']=$row['username'];
				header('location:source/student/stud_dash.php');		
				}elseif($row['role']  === '3'){
				
					$_SESSION['username']=$row['username'];
					header("Location:source/teacher/teacher_dash.php");		
				}
			else{
				
				//header('location: updateadmin.php');
				echo "<script>window.location.href='index.php' </script>";
			}
	
		}
	}else{
		header("Location:index.php?error=Your account is not active");
	}

}else{
	header("Location:index.php?error=Incorrect Username or Password");
}