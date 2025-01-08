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
                    <li class="breadcrumb-item"><a href="m-report.php"><i class="bx bxs-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="">Gate Attendance Report</a></li>
                </ul>
            </div>
            <div class="table-responsive">
            <form action="" method="post" name="form1">
					<table class="table-container">
                        <tr>
                            <td>
                            <select name="adviser" id="" required>
                                    <option value="" selected disabled hidden >--Select Adviser--</option>
                                    <?php
                                    $sql = "SELECT teacher.*, concat(teach.t_ln, ', ',teach.t_fn, ' ',teach.t_mn) as teach_n FROM teacher
                                            INNER JOIN teacher_info AS teach ON teacher.t_id = teach.t_id ORDER BY teach.t_ln asc";
                                    $allteach = mysqli_query($conn, $sql);
                                        while ($teach = mysqli_fetch_array($allteach)) {
                                            $adv = $teach['teach_n'];
                                        ?>
                                            <option value="<?php echo $teach['t_id']?>"><?php echo $adv?></option>';
                                    <?php
                                        }
                                    ?>
                                </select>
                            </td>
							<td>
                            <select name="month" >
                                <option value="" selected disabled hidden>Select Month</option>
                                <?php
                                    $query = mysqli_query($conn, "SELECT * FROM `month` ORDER BY id ASC");
                                    while ($row = mysqli_fetch_array($query)) {
                                        ?>
                                        <option value="<?php echo $row['month_id']; ?>"><?php echo $row['month_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                            </select><br>
							</td>
                            <td>
                                <select name="year" id="">
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                </select>
                            </td>
							<td>
								 <input type="submit" name="submit2" class="btn btn_create1" value="Submit">
							</td>
                            <td>
                            <button onclick="print_div()" class="btn_edit1"><i class="bi bi-printer"> </i>PRINT</button>
                            </td>
						</tr>
					</table>
                </form>
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
                </div>

                <?php
                if(isset($_POST['submit2'])) {
                    $selectedMonth = $_POST['month'];
                    $year           = $_POST['year'];
                    $adv = $_POST['adviser'];
                    $firstDayOfMonth = date("Y-$selectedMonth-0");
                    $totalDaysInMonth = date("t", strtotime($firstDayOfMonth));
                    // Fetching Students 
                    $fetchingStudents = mysqli_query($conn, "SELECT DISTINCT ag.student_id, CONCAT(ns.lname, ' ', ns.fname, ' ', ns.mname) AS full_name
                                         FROM attendance_gate AS ag
                                         LEFT JOIN new_students AS ns ON ag.student_id = ns.student_id
                                         WHERE MONTH(ag.att_date) = '$selectedMonth' AND YEAR(ag.att_date) = '$year' AND ns.adviser = '$adv'") 
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

                </tr>
                <table class="table-container" id="tbl_cont">
                <tr>
                    <td colspan="10"  style="text-align:center;border:none"><img src="../../images/admin/DepEd_circ.png" alt="" srcset="" height="100" width="100"></td>
                    <td colspan="25" style="border:none;text-align:center"><h2>School Form 2 (SF2) Daily Gate Attendance Report of Learners</h2></td>
                    <td colspan="10" style="text-align:center;border:none"><img src="../../images/admin/DepEd_abbr.png" alt="" srcset="" height="100" width="100"></td>
                </tr>
                <tr>
                <br><br>
                    <td rowspan="3">No</td>
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
                $n=0;
                while ($student = mysqli_fetch_assoc($fetchingStudents)) {
                    $student_id = $student['student_id'];
                    $sname = $student['full_name'];
                    $n++;;
                    echo "<tr>";
                    echo "<td>$n</td>";
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
        printWindow.document.write('body { font-size:10px;}');
        printWindow.document.write('table { border-collapse: collapse; margin: auto; }');
        printWindow.document.write('td { border: 2px solid black; width: 100vw%; white-space:nowrap;padding:5px;font-size:10px;}'); // Adjusted width to auto
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
