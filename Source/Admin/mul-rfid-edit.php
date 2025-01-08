<?php
error_reporting(0);

include_once '../../inc/connect.php';

// Check if 'ids' parameter is set in the URL
if (isset($_GET['ids'])) {
    // Retrieve the IDs from the URL
    $ids = explode(',', $_GET['ids']);

    // Fetch the records based on the IDs
    $records = array();
    foreach ($ids as $id) {
        $id = intval($id);
        $res = $conn->query("SELECT * FROM rfid WHERE id = $id");

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
    <title>AMS | Update RFID</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css" />
    <script src="../../assets/js/jquery.js" type="text/javascript"></script>
    <script src="../../assets/js/js-script.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>

    <div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">

            <div class="navbar-header">
                <!-- Your navbar-header content -->
            </div>

        </div>
    </div>
    <div class="clearfix"></div>

    <div class="container">
        <!-- Your container content -->
    </div>

    <div class="clearfix"></div><br />

    <div class="container">
        <form method="post" action="mul-rfid-update.php">
            <table class='table table-bordered'>
                <tr>
                    <th>RFID Number</th>
                    <th>Status</th>
                </tr>
                <?php foreach ($records as $row): ?>
                    <tr>
                        <td>
                            <input type="hidden" name="id[]" value="<?php echo $row['id']; ?>" />
                            <input type="text" name="rfid_no[]" value="<?php echo $row['rfid_no']; ?>" class="form-control" />
                        </td>
                        <td>
                            <select name="rfid_status[]" class="form-control">
                                <option value="Lost" <?php if ($row['rfid_status'] == 'Lost') echo 'selected="selected"'; ?>>Lost</option>
                                <option value="Vacant" <?php if ($row['rfid_status'] == 'Vacant') echo 'selected="selected"'; ?>>Vacant</option>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2">
                        <button type="submit" name="savemul" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> &nbsp; Update all</button>&nbsp;
                        <a href="m-rfid.php" class="btn btn-large btn-success"> <i class="glyphicon glyphicon-fast-backward"></i> &nbsp; cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>

</body>

</html>

