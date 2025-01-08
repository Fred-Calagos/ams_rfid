<?php
include("../../Inc/connect.php");

$status = isset($_GET['status']) ? $_GET['status'] : 'All'; // Default to 'All' if status is not set

// Fetch records with the specified status
if ($status === 'All') {
    $query = "SELECT * FROM `rfid`";
} else {
    $query = "SELECT * FROM `rfid` WHERE rfid_status = '$status'";
}

$res = $conn->query($query);
$count = $res->num_rows;

if ($count > 0) {
    while ($row = $res->fetch_array()) {
        $statusClass = ''; // Default class

        switch ($row['rfid_status']) {
            case 'Active':
                $statusClass = 'active-status';
                break;
            case 'Lost':
                $statusClass = 'lost-status';
                break;
            case 'Vacant':
                $statusClass = 'vacant-status';
                break;
        }

        echo '<tr>';
        echo '<td><input type="checkbox" name="chk[]" class="chk-box" value="' . $row['id'] . '"  /></td>';
        echo '<td>' . $row['rfid_no'] . '</td>';
        echo '<td class="' . $statusClass . '">' . $row['rfid_status'] . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="3"> No Records Found ...</td></tr>';
}
?>
