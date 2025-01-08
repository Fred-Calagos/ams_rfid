<?php
include "header.php";
include("../../Inc/connect.php");
include "delete_btm.php";
if (!isset($_SESSION["username"])) {
    ?>
    <script type="text/javascript">
        window.location = "admin_dash.php";
    </script>
<?php
}

date_default_timezone_set('Asia/Manila'); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORT: GATE ATTENDANCE</title>
    <script src="../../assets/js/jquery.js" type="text/javascript"></script>
    <script src="../../assets/js/js-script.js" type="text/javascript"></script>
    <script src="../../assets/jquery/jquery.min.js"></script>
</head>

<body>
    <section class="dashboard">
        <div class="top">
            <i class="fas fa-bars sidebar-toggle"></i>
            <div class="search-box">
                <i class="uil uil-search"></i>
            </div>
        </div><br>
        <div class="dash-content">
            <div class="bread">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="m-setup.php"><i class="bi bi-house-door"></i></a></li>
                    <li class="breadcrumb-item active"><a href="m-teachload.php">TEACHING LOAD</a></li>
                </ul>
            </div>
            <div class="table-responsive">

                <div class="items-controller">
                    <h5>Show</h5>
                    <select name="" id="itemperpage">
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="08" selected>08</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                    </select>
                    <h5>ITEM</h5>
                    <button onclick="print_div()">PRINT</button>
                    <br><br>
                </div>
                <form action="" method="post" name="form1">
					<table class="table">
                        <tr>
							<td>
                            <select name="month">
                                <option value="" selected disabled hidden>SELECT MONTH</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <!-- Add other months as needed -->
                            </select><br>
							</td>
							<td>
								 <input type="submit" name="submit2" class="btn btn-info" value="Submit">
							</td>
						</tr>
					</table>
                </form>
                <?php
                if(isset($_POST['submit2'])) {
                    $selectedMonth = $_POST['month'];
                    $firstDayOfMonth = date("Y-$selectedMonth-0");
                    $totalDaysInMonth = date("t", strtotime($firstDayOfMonth));
                    // Fetching Students 
                    $fetchingStudents = mysqli_query($conn, "SELECT DISTINCT ag.student_id, CONCAT(ns.lname, ' ', ns.fname, ' ', ns.mname) AS full_name
                                         FROM attendance_gate AS ag
                                         LEFT JOIN new_students AS ns ON ag.student_id = ns.student_id
                                         WHERE MONTH(ag.att_date) = '$selectedMonth'") 
                                         or die(mysqli_error($conn));

                    $totalNumberOfStudents = mysqli_num_rows($fetchingStudents);
                
                }else{
                    $firstDayOfMonth = date("Y-m-0");
                    $totalDaysInMonth = date("t", strtotime($firstDayOfMonth));
                    // Fetching Students 
                    $fetchingStudents = mysqli_query($conn, "SELECT DISTINCT ag.student_id, CONCAT(ns.lname, ' ', ns.fname, ' ', ns.mname) AS full_name
                    FROM attendance_gate AS ag
                    LEFT JOIN new_students AS ns ON ag.student_id = ns.student_id") or die(mysqli_error($conn));
                    $totalNumberOfStudents = mysqli_num_rows($fetchingStudents);
                }
                ?>

                <div class="scroll" style="overflow-x:auto;">
            <div class="printable">
                <br>
                <img src="../../images/admin/DepEd_circ.png" alt="" srcset="" style="width:100px;height:auto;float:left">
                <img src="../../images/admin/DepEd_abbr.png" alt="" srcset="" style="width:auto;height:100px;padding:10px;float:right">
                <br><br>
                </tr>
                <table class="table-container" id="tbl_cont">
                <tr>
                <br><br>
                    <td rowspan="3">Names</td>
                    <?php
                    for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                        $currentDate = date('Y-m-d', strtotime("$firstDayOfMonth + $j days"));
                        $dayOfWeek = date('N', strtotime($currentDate));
                        if ($dayOfWeek >= 6) { // 6 corresponds to Saturday
                            continue;
                        }
                        $day = date("D", strtotime($currentDate));
                        echo "<td colspan='2'>$j</td>";
                        // Add your logic here for displaying each day
                    }
                    ?>


                    <tr>
                        <?php
                        for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                            $currentDate = date('Y-m-d', strtotime("$firstDayOfMonth + $j days"));
                            $day = date("D", strtotime($currentDate));
                            if (date('N', strtotime($currentDate)) >= 6) {
                                // Skip Saturday and Sunday
                                continue;
                            }
                            echo "<td colspan='2'>$day</td>";
                        }
                        ?>
                    </tr>

                </tr>
                <tr>
                    <?php
                    for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                        $currentDay = date('N', strtotime("$firstDayOfMonth + $j days"));
                        if ($currentDay >= 6) {
                            // Skip Saturday and Sunday
                            continue;
                        }
                        echo "<td>AM</td><td>PM</td>";
                    }
                    ?>  
                </tr>

                <?php
                while ($student = mysqli_fetch_assoc($fetchingStudents)) {
                    $student_id = $student['student_id'];
                    $sname = $student['full_name'];
                    echo "<tr>";
                    echo "<td>$sname</td>";
                    for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                        $currentDay = date('N', strtotime("$firstDayOfMonth + $j days"));
                        if ($currentDay >= 6) {
                            // Skip Saturday and Sunday
                            continue;
                        }
                        $dayFormatted = sprintf('%02d', $j);
                        $dateOfAttendance = date("Y-m-$dayFormatted", strtotime("$firstDayOfMonth + $j days"));
                        $fetchingStudentsAttendance = mysqli_query($conn, "SELECT * FROM attendance_gate WHERE student_id = '$student_id' AND att_date = '$dateOfAttendance'") or die(mysqli_error($conn));

                        $isAttendanceAdded = mysqli_num_rows($fetchingStudentsAttendance);
                        $dashLog = "-";
                        if ($isAttendanceAdded > 0) {
                            $studentAttendance = mysqli_fetch_assoc($fetchingStudentsAttendance);
                            $amti = $studentAttendance['amti'];
                            $amto = $studentAttendance['amto'];
                            $pmti = $studentAttendance['pmti'];
                            $pmto = $studentAttendance['pmto'];
                            $curr_date = $studentAttendance['att_date'];
                            $am_stats = $studentAttendance['am_status'];
                            $pm_stats = $studentAttendance['pm_status'];
                            $att_date = $studentAttendance['att_date'];
                            // For morning status
                            if (!empty($amti) && empty($amto)){
                                $morning_status = "C";
                            }else{
                                $morning_status = ($am_stats == "Present" ? "P" : ($am_stats == "Late" ? "L" : "A"));
                            }
                            
                            // For afternoon status
                            if(!empty($pmti) && empty($pmto)){
                                $afternoon_status = "C";
                            } else{
                                $afternoon_status = ($pm_stats == "Present" ? "P": ($pm_stats == "Late" ? "L" : "A"));
                            }

                            
                            
                            echo "<td>$morning_status</td>";
                            echo "<td>$afternoon_status</td>";
                        } else {
                            echo "<td></td><td></td>";
                        }
                    }
                    
                }
                ?>
               </tr>
                </table>
                </div>
                </div>
            </div>
        </div>
    </section>
    <script>
    // JavaScript code to handle printing
    function print_div() {
        // Hide elements not to be printed
        document.querySelector("button").style.display = "none";

        // Get the HTML content of the table-container
        var divContent = document.querySelector(".printable").outerHTML;

        // Open a new window
        var printWindow = window.open('', '', 'width=900,height=600');

        // Set the HTML content of the new window to the div content
        printWindow.document.write('<html><head><title>Print Table</title>');
        printWindow.document.write('<style>@media print {');
        printWindow.document.write('body { font-size: 12px; }');
        printWindow.document.write('table { border-collapse: collapse; margin: auto; }');
        printWindow.document.write('td{border:2px solid black}');
        printWindow.document.write('img {margin-bottom:20px}');
        printWindow.document.write('}</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(divContent);
        printWindow.document.write('</body></html>');

        // Print the new window
        printWindow.print();

        // Close the new window
        printWindow.close();

        // Show the hidden elements
        document.querySelector("button").style.display = "block";
    }
</script>
 
    <?php
    include "footer.php";
    ?>
</body>

</html>
