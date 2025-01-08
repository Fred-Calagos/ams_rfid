<?php
include "header.php";
include("../../Inc/connect.php");

// Function to update RFID status
// Count records for each status
$activeCount = $conn->query("SELECT COUNT(*) as total FROM `rfid` WHERE rfid_status = 'Active'")->fetch_assoc()['total'];
$lostCount = $conn->query("SELECT COUNT(*) as total FROM `rfid` WHERE rfid_status = 'Lost'")->fetch_assoc()['total'];
$vacantCount = $conn->query("SELECT COUNT(*) as total FROM `rfid` WHERE rfid_status = 'Vacant'")->fetch_assoc()['total'];

// Fetch all records
$query = "SELECT * FROM `rfid`";
$res = $conn->query($query);
$count = $res->num_rows;

// Total number of records
$totalRecords = $conn->query("SELECT COUNT(*) as total FROM `rfid`")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../../assets/js/jquery.js" type="text/javascript"></script>
    <script src="../../assets/js/js-script.js" type="text/javascript"></script>
    <script src="../../assets/jquery/jquery.min.js"></script>
    <style>
        .total-registration{
            font-weight: bold;
        }

        .card-container {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .card {
            flex: 1;
            padding: 20px;
            border-radius: 10px;
            margin: 0 10px;
            background-color: blue;
            text-align: center;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
<section class="dashboard">
    <div class="top">
        <i class="fas fa-bars sidebar-toggle"></i>
        <div class="search-box">
            <i class="uil uil-search"></i>
            <input type="text" id="searchInput" onkeyup="searchByRfid()" placeholder="Search by RFID number...">
        </div>
        
        <img src="../../images/admin/profile.jpg" alt="">
    </div>

    <div class="dash-content">
        <div class="row well">
            <ul>
                <li><a href="rfid-generate.php" class="btn btn-large btn-info"><i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp; Add RFID Number</a></li>
            </ul>
        </div><br>

        <!-- Display Cards -->
        <div class="card-container">
            <div class="card total-registration" onclick="filterTable('All')">Total Registered: <?php echo $totalRecords; ?></div>
            <div class="card active-status" onclick="filterTable('Active')">Active: <?php echo $activeCount; ?></div>
            <div class="card lost-status" onclick="filterTable('Lost')">Lost: <?php echo $lostCount; ?></div>
            <div class="card vacant-status" onclick="filterTable('Vacant')">Vacant: <?php echo $vacantCount; ?></div>
        </div>

        <div class="table-responsive">
            <form action="" method="post" name="frm">
                <div class="table_section1">
                    <table class="table-container" id="rfidTable">
                        <tr>
                            <th>Check</th>
                            <th>RFID Number</th>
                            <th>Status</th>
                        </tr>
                        <?php
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

                                ?>
                                <tr>
                                    <td><input type="checkbox" name="chk[]" class="chk-box" value="<?php echo $row['id']; ?>"  /></td>
                                    <td><?php echo $row['rfid_no']; ?></td>
                                    <td class="<?php echo $statusClass; ?>"><?php echo $row['rfid_status']; ?></td>
                                </tr>
                                <?php
                            }	
                        } else {
                            ?>
                            <tr>
                                <td colspan="3"> No Records Found ...</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </form>
            <table class="table-container">
                <tr>
                    <td><label><input type="checkbox" class="select-all" /> Check / Uncheck All</label></td>
                    <td colspan="2">
                        <span style="word-spacing:normal;"> with selected :</span>
                        <span><img src="edit.png" onClick="edit_records();" alt="edit" />edit</span>
                        <span><img src="delete.png" onClick="delete_records();" alt="delete" />delete</span>
                    </td>
                </tr>    
            </table>
        </div>
    </div>
</section>

<?php
include "footer.php";
?>
<script>

</script>

<script>
function searchByRfid() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("rfidTable");
    tr = table.getElementsByTagName("tr");
    for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
        td = tr[i].getElementsByTagName("td")[1]; // Assuming RFID number is in the second column
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
function filterTable(status) {
        // Filter the table based on the selected status
        var table = document.getElementById("rfidTable");
        var rows = table.getElementsByTagName("tr");

        for (var i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
            var statusCell = rows[i].getElementsByTagName("td")[2]; // Assuming status is in the third column

            if (status === 'All' || statusCell.classList.contains(status.toLowerCase() + '-status')) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
    function edit_records() {
        // Your existing edit_records function
        var selectedRecords = $('input[name="chk[]"]:checked').map(function(){
            return this.value;
        }).get();

        if (selectedRecords.length === 0) {
            alert('At least one checkbox must be selected to proceed!');
            return;
        }

        // Redirect to the edit page with selected record IDs
        window.location.href = 'mul-rfid-edit.php?ids=' + selectedRecords.join(',');
    }
    function delete_records() {
        // Your existing delete_records function
        var selectedRecords = $('input[name="chk[]"]:checked').map(function(){
            return this.value;
        }).get();

        if (selectedRecords.length === 0) {
            alert('At least one checkbox must be selected to proceed!');
            return;
        }

        // Display confirmation dialog
        var confirmDelete = confirm("Are you sure you want to delete?");
        
        if (confirmDelete) {
            // User clicked 'Yes', proceed with the delete
            $.ajax({
                type: 'POST',
                url: 'mul-rfid-delete.php',
                data: { chk: selectedRecords },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        // You can also reload the page or perform other actions if needed
                        window.location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error occurred during the AJAX request.');
                }
            });
        } else {
            // User clicked 'No', do nothing
        }
    }
</script>

</body>
</html>
