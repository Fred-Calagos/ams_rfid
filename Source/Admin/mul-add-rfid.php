<?php
error_reporting(0);
include_once '../../inc/connect.php';

// Check if the form is submitted and RFID card is tapped
if (isset($_POST['save_mul']) && isset($_POST['rfid_tapped'])) {
    $total = $_POST['total'];
    $insertedRecords = 0; // Variable to track the number of successfully inserted records

    for ($i = 1; $i <= $total; $i++) {
        $rfid_no = $_POST["rfid_no$i"];
        // Check if the RFID number already exists
        $checkDuplicate = $conn->query("SELECT COUNT(*) as total FROM rfid WHERE rfid_no = '$rfid_no'")->fetch_assoc()['total'];

        if ($checkDuplicate == 0) {
            $sql = "INSERT INTO `rfid` (rfid_no, rfid_status) VALUES ('$rfid_no', 'Vacant')";
            $inserted = $conn->query($sql);

            if ($inserted) {
                $insertedRecords++;
            }
        } else {
            ?>
            <script>
                alert('RFID Number <?php echo $rfid_no; ?> is already registered.');
                window.history.back(); // Go back to the previous page
                document.querySelectorAll('[name^="rfid_no"]').forEach(function(element) {
                    element.value = ''; // Clear all RFID input fields
                });
            </script>
            <?php
            exit; // Exit the script to prevent further execution
        }
    }

    if ($insertedRecords > 0) {
        ?>
        <script>
            if (confirm('<?php echo $insertedRecords . " records were inserted! Do you want to go back to the index page?"; ?>')) {
                window.location.href='m-rfid.php';
            }
        </script>
        <?php
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AMS | Adding RFID Numbers</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css" />
    <script src="../../assets/js/jquery.js" type="text/javascript"></script>
    <script src="../../assets/js/js-script.js" type="text/javascript"></script>

    <!-- Add the JavaScript code for client-side validation -->
    <script>
        function validateForm() {
            var total = document.getElementsByName('total')[0].value;

            for (var i = 1; i <= total; i++) {
                var rfidNo = document.getElementsByName('rfid_no' + i)[0].value;

                if (rfidNo.trim() === '') {
                    return false;
                }
            }

            return true;
        }
    </script>
</head>

<body>

<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="http://cleartuts.blogspot.com" title='Programming Blog'></a>
            <a class="navbar-brand" href="http://cleartuts.blogspot.com/search/label/CRUD"></a>
            <a class="navbar-brand" href="http://cleartuts.blogspot.com/search/label/PDO"></a>
            <a class="navbar-brand" href="http://cleartuts.blogspot.com/search/label/jQuery"></a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="container">
    <a href="rfid-generate.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records</a>
</div>

<div class="clearfix"></div><br />

<div class="container">
    <?php
    if(isset($_POST['btn-gen-form'])) {
    ?>
    <!-- Modify the form tag to include the onsubmit attribute -->
    <form method="post" onsubmit="return validateForm();">
        <input type="hidden" name="total" value="<?php echo $_POST["no_of_rec"]; ?>" />
        <input type="hidden" name="rfid_tapped" value="1" />
        <table class='table table-bordered'>
            <tr>
                <th>#</th>
                <th>RFID Number</th>
            </tr>
            <?php
            for($i=1; $i<=$_POST["no_of_rec"]; $i++) {
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><input type="text" name="rfid_no<?php echo $i; ?>" placeholder="RFID Number" class='form-control' /></td>
            </tr>
            <?php
            }
            ?>
            <tr>
                <td colspan="3">
                    <button type="submit" name="save_mul" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> &nbsp; Insert all Records</button>
                    <a href="m-rfid.php" class="btn btn-large btn-success"> <i class="glyphicon glyphicon-fast-backward"></i> &nbsp; Back to index</a>
                </td>
            </tr>
        </table>
    </form>
    <?php
    }
    ?>
</div>

<?php
// Display the warning message if it exists
if (!empty($warningMessage)) {
    ?>
    <div class="container mt-3">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $warningMessage; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <?php
}
?>
</body>
</html>
