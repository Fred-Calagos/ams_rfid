<?php
	
	error_reporting(0);

	include_once '../../inc/connect.php';

	if (isset($_GET['idp'])) {
		// Retrieve the IDs from the URL
		$ids = explode(',', $_GET['idp']);
	
		// Fetch the records based on the IDs
		$records = array();
		foreach ($ids as $id) {
			$id = intval($id);
			$res = $conn->query("SELECT * FROM teacher WHERE id = $id");
	
			if ($res && $row = $res->fetch_assoc()) {
				$records[] = $row;
			}
		}
	} else {
		// 'ids' parameter is not set, handle the situation (e.g., redirect to an error page)
		header("Location: error.php");
		exit;
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EDIT TEACHER</title>
<!--<link rel="stylesheet" href="style.css" type="text/css" />-->
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css" />
	<script src="../../assets/js/jquery.js" type="text/javascript"></script>
    <script src="../../assets/js/js-script.js" type="text/javascript"></script>
	<script src="../../assets/js/dependent.js"></script>
</head>

<body>

<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
 
        <div class="navbar-header">
            <a class="navbar-brand" href="http://cleartuts.blogspot.com" title='Programming Blog'>CLEARTUTS</a>
            <a class="navbar-brand" href="http://cleartuts.blogspot.com/search/label/CRUD">CRUD</a>
            <a class="navbar-brand" href="http://cleartuts.blogspot.com/search/label/PDO">PDO</a>
            <a class="navbar-brand" href="http://cleartuts.blogspot.com/search/label/jQuery">jQuery</a>
        </div>
 
    </div>
</div>
<div class="clearfix"></div>

<div class="container">
<a href="generate.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records</a>
</div>

<div class="clearfix"></div><br />

<div class="container">
	<form method="post" action="mul_upt.php">
		<table class='table table-bordered'>
			<tr>
				<th>First Name</th>
				<th>Middle Name</th>
				<th>Last Name</th>
				<th>Grade</th>
				<th>Section</th>
			</tr>
			<?php foreach ($records as $row): ?>
					<tr>
					<td>
				
					<input type="hidden" name="id[]" value="<?php echo $row['id'];?>" />
					<input type="text" name="fn[]" value="<?php echo $row['fname'];?>" class="form-control" />
					</td>
					<td>
					<input type="text" name="mn[]" value="<?php echo $row['mname'];?>" class="form-control" />
					</td>
					<td>
					<input type="text" name="ln[]" value="<?php echo $row['lname'];?>" class="form-control" />
					</td>
					<td>
					<select name="gr[]" class="form-control" onchange="getGradeEdit(this.value, <?php echo $row['id'];?>);" required>
						<option value="<?php echo $row['grade'];?>"><?php echo $row['grade'];?></option>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM grade ORDER BY stud_grade ASC");
                        while ($row1 = mysqli_fetch_array($query)) {
                            ?>
                            <option style="text-align-last:left;" value="<?php echo htmlentities($row1['stud_grade']); ?>"><?php echo $row1['stud_grade']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
					</td>
					<td>
					<select name="sc[]" id="section" class="form-control">
						<option value="<?php echo $row['section'];?>"><?php echo $row['section'];?></option>
                    </select>
					</td>
					</tr>
					<?php endforeach; ?>
			<tr>
				<td colspan="2">
				<button type="submit" name="savemul" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> &nbsp; Update all</button>&nbsp;
				<a href="m-instructor.php" class="btn btn-large btn-success"> <i class="glyphicon glyphicon-fast-backward"></i> &nbsp; cancel</a>
				</td>
			</tr>
		</table>


	</form>
</div>
</body>
</html>