<?php  
include "inc/connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="assets/css/login.css">
	<link rel="stylesheet" href="assets/vendor/fontawesome/font_v6/css/all.css">
	<link href="assets/vendor/fontawesome/web-fonts-with-css/css/fontawesome-all.css" rel="stylesheet">


	<style>

    </style>
</head>
<body>
<div class="container" id="container">
	<div class="form-container sign-in-container">
        <form action="login.php" method="post">
			<h1>LOGIN</h1>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?=$_GET['error']?>
                </div>
            <?php } ?>
			<input type="text" name="username" id="rfidcard" placeholder="Username" required>
			<input type="password" name="password" id="pass" placeholder="Password">
            <div class="passcont">
            <input class="check" type="checkbox" onclick="showPassword()"><span>Show Password</span>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: maroon; border-color: gold;">LOGIN</button>
		</form>
        <script src="assets/js/rfid.js"></script>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-right">
				<?php 
					            $query=mysqli_query($conn,"select * from `school_profile` order by id ASC");
								while($row=mysqli_fetch_array($query))
									{
								?>
									<img src="images/admin/<?php echo $row['image'];?>" alt="" srcset="">
									<h2><?php echo $row['name'];?></h2>
									<ul class="s_contact">
										<li><a href="<?php echo $row['s_fb'];?>"  target="_blank"><i class="fa-brands fa-facebook"></i></a></li>
										<li><a href="<?php echo $row['s_email'];?>"></i><i class="fa-solid fa-at"></i></a></li>
										<li><a href="<?php echo $row['s_no'];?>"><i class="fa-solid fa-phone"></i></a></li>
									</ul>
							<?php
								}
							?>
			</div>
		</div>
	</div>
</div>
    </div>
    <script>
     function showPassword() {
        var x = document.getElementById("pass");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

</script>
</body>
</html>
