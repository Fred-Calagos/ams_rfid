<?php  
session_start();
include "inc/connect.php";

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$username = test_input($_POST['username']);
	$password = test_input($_POST['password']);
	$role = test_input($_POST['role']);

	if (empty($username)) {
		header("Location:index.php?error=User Name is Required");
	}else if (empty($password)) {
		header("Location: index.php?error=Password is Required");
	}else {
		// STUDENT ACCOUNT
		// Hashing the password
		// $password = md5($password);
        if ($role == '2') {
			$sql = "SELECT * FROM `user` WHERE username='$username' AND password='$password' AND role = '$role'";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				// the user name must be unique
				$row = mysqli_fetch_assoc($result);
				if ($row['status'] === 'Active') {
					if ($row['password'] === $password && $row['role'] === $role) {
						$_SESSION['id1'] = $row['id'];
						$_SESSION['role'] = $row['role'];
						$_SESSION['username'] = $row['username'];
						header("Location:source/student/stud_dash.php");
					} else {
						header("Location:index.php?error=Incorrect username or password");
					}
				} else {
					header("Location:index.php?error=Your account is not active");
				}
			}else {
				header("Location:index.php?error=Incorrect username or password");
			}
		}elseif ($role === '1') {
			// ADMIN ACCOUNT
			$sql1 = "SELECT * FROM `admin` WHERE admin_username='$username' AND admin_password='$password' AND role = '$role'";
			$result1 = mysqli_query($conn, $sql1);

			if (mysqli_num_rows($result1) > 0) {
				// the user name must be unique
				$row1 = mysqli_fetch_assoc($result1);
				if ($row1['admin_password'] === $password && $row1['role'] === $role) {
					$_SESSION['fname'] = $row1['admin_fname'];
					$_SESSION['id'] = $row1['id'];
					$_SESSION['role'] = $row1['role'];
					$_SESSION['username'] = $row1['admin_username'];

					header("Location:source/admin/admin_dash.php");

				}else {
					header("Location:index.php?error=Incorect usename or password");
				}
			}else {
				header("Location:index.php?error=Incorrect username or password");
			}
		}elseif ($role === '3') {
			// TEACHER	 ACCOUNT
			$sql1 = "SELECT * FROM `user` WHERE username='$username' AND password='$password' AND role = '$role'";
			$result1 = mysqli_query($conn, $sql1);

			if (mysqli_num_rows($result1) > 0) {
				// the user name must be unique
				$row = mysqli_fetch_assoc($result1);
				if ($row['status'] === 'Active') {
					if ($row['password'] === $password && $row['role'] === $role) {
						$_SESSION['id1'] = $row['id'];
						$_SESSION['role1'] = $row['role'];
						$_SESSION['username'] = $row['username'];

						header("Location:source/teacher/teacher_dash.php");

					}else {
						header("Location:index.php?error=Incorect username or password");
					}
				} else {
					header("Location:index.php?error=Your account is not active");
				}
			}else {
				header("Location:index.php?error=Incorrect username or password");
			}
		}
	}
	
}else {
	header("Location: index.php");
}