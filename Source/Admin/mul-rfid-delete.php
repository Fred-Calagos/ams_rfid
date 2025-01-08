<?php
error_reporting(0);

include_once '../../inc/connect.php';

$chk = isset($_POST['chk']) ? $_POST['chk'] : array();
$chkcount = count($chk);

if ($chkcount === 0) {
    echo json_encode(['status' => 'error', 'message' => 'At least one checkbox must be selected!']);
} else {
    $deletedCount = 0;

    foreach ($chk as $del) {
        $sql = $conn->query("DELETE FROM rfid WHERE id=" . intval($del));

        if ($sql) {
            $deletedCount++;
        }
    }

    if ($deletedCount === $chkcount) {
        echo json_encode(['status' => 'success', 'message' => 'Successfully deleted!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error while deleting, please try again.']);
    }
}
?>
