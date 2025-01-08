<?php
error_reporting(0);
include_once '../../inc/connect.php';

if(isset($_POST['save_mul']))
{		
	$total = $_POST['total'];
		
	for($i=1; $i<=$total; $i++)
	{
		$adv_id= $_POST["adv_name$i"];	
        $gr = $_POST["gr$i"];	
        $sc = $_POST["sc$i"];			
		$sql="INSERT INTO teacher (t_id,grade,section) VALUES('".$adv_id."','".$gr."','".$sc."')";
		$sql = $conn->query($sql);		
	}
	
	if($sql)
	{
		?>
        <script>
		alert('<?php echo $total." records was inserted !!!"; ?>');
		window.location.href='m-instructor.php';
		</script>
        <?php
	}
	else
	{
		?>
        <script>
		alert('error while inserting , TRY AGAIN');
		</script>
        <?php
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css" />
<script src="../../assets/js/jquery.js" type="text/javascript"></script>
    <script src="../../assets/js/js-script.js" type="text/javascript"></script>
</head>

<body>
<br><br><br>

<div class="container">
<a href="generate.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records</a>
</div>

<div class="clearfix"></div><br />

<div class="container">
<?php
if(isset($_POST['btn-gen-form']))
{
	?>
    <form method="post">
    <input type="hidden" name="total" value="<?php echo $_POST["no_of_rec"]; ?>" />
	<table class='table table-bordered'>
    
    <tr>
    <th>#/??#</th>
    <th>ADVISER NAME</th>
    <th>Grade</th>
    <th>Section</th>
    </tr>
	<?php
	for($i=1; $i<=$_POST["no_of_rec"]; $i++) 
	{
		?>
        <tr>
            <td><?php echo $i; ?></td>
            <td>
                <select name="adv_name<?php echo $i; ?>" class="form-control" id="" required>
                        <option value="" selected disabled hidden >--SELECT ADVISER--</option>
                        <?php
                        $sql = "SELECT * FROM teacher_info ORDER BY t_id asc";
                        $allgender = mysqli_query($conn, $sql);
                            while ($genderall = mysqli_fetch_array($allgender)) {
                            ?>
                                <option value="<?php echo $genderall['t_id']?>"><?php echo $genderall['t_ln'].",".$genderall['t_fn']." ".$genderall['t_mn']?></option>';
                        <?php
                            }
                        ?>
                    </select>
            </td>     
            <td>
            <select name="gr<?php echo $i; ?>" onchange="getGrademul(this.value, <?php echo $i; ?>);" class="form-control">
                    <option>Select Grade</option>
                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM grade ORDER BY stud_grade ASC");
                    while ($row = mysqli_fetch_array($query)) {
                        ?>
                        <option value="<?php echo htmlentities($row['grade_id']); ?>"><?php echo $row['stud_grade']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </td>
            <td>
                <select name="sc<?php echo $i; ?>" id="section<?php echo $i; ?>" class="form-control">
                    <option>Select Section</option>
                </select>
            </td>
        </tr>
        <?php
	}
	?>
    <tr>
    <td colspan="3">
    
    <button type="submit" name="save_mul" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> &nbsp; Insert all Records</button> 

    <a href="m-instructor.php" class="btn btn-large btn-success"> <i class="glyphicon glyphicon-fast-backward"></i> &nbsp; Back</a>
    
    </td>
    </tr>
    </table>
    </form>
	<?php
}
?>
</div>
<script src="../../assets/js/dependent.js"></script>
</body>
</html>