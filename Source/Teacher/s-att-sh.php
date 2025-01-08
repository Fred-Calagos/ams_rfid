<?php
include "header.php";
include("../../Inc/connect.php");
if (!isset($_SESSION["username"])) {
    ?>
    <script type="text/javascript">
        window.location = "admin_dash.php";
    </script>
<?php
}
$username = $_SESSION["username"];
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

    <style>
    .puts1 {
        text-align: left;
        border-radius: 4px;
        outline: 0;
        padding: 5px;
        width: 100%; /* Set width to 100% */
        font-size: 10px;
        border: 1px solid rgb(165, 161, 161);
    }
    labels {
        text-align: right;
        font-size: 7px;
        padding: 2px;
    }
    </style>
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
            <div class="table-responsive">
            <div class="bread">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="s-attendance.php"><i class="bx bxs-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="s-att-sh.php">Senior High School</a></li>
                </ul>
            </div>
            </div>
            <div class="table-responsive">
            <form action="" method="post" name="form1">
					<table class="table">
                        <tr >
                            <td>
                            <select name="idtl" >
                                <option value="" selected disabled hidden>Select Subject</option>
                                <?php
                                    $res = mysqli_query($conn, "SELECT tl.*, ti.t_rfid AS trfid, tl.id_tl AS idtl, sub.sub_name AS sname, sub.s_id AS sId, CONCAT(adv.t_ln,', ',adv.t_fn,' ',adv.t_mn) AS advName FROM teaching_load AS tl
                                    LEFT JOIN subjects AS sub ON tl.s_id = sub.s_id
                                    LEFT JOIN teacher_info AS ti ON tl.t_id = ti.t_id
                                    LEFT JOIN teacher_info AS adv ON tl.adv_id = adv.t_id
                                    LEFT JOIN grade AS gr ON sub.grade_id = gr.grade_id
                                    LEFT JOIN hs_cat AS hs ON gr.hs_id = hs.hs_id
                                    WHERE ti.t_id = tl.t_id AND ti.t_rfid = '$username' and sub.s_id = tl.s_id AND gr.hs_id = '2'");
                                    while ($row = mysqli_fetch_array($res)) {
                                        ?>
                                        <option value="<?php echo $row['idtl']; ?>"><?php echo $row['sname'] . ' | ' . $row['advName']; ?></option>
                                        <?php
                                    }
                                    ?>
                            </select><br>
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
                                <option value="" selected disabled hidden>Select Year</option>
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
                <?php
                if(isset($_POST['submit2'])) {
                    $seclectedTl = $_POST['idtl'];
                    $selectedMonth = $_POST['month'];
                    $year           = $_POST['year'];
                    $firstDayOfMonth = date("Y-$selectedMonth-0");
                    $totalDaysInMonth = date("t", strtotime($firstDayOfMonth));
                    // Fetching Students 
                    $fetchingStudents = mysqli_query($conn, "SELECT 
                                        ag.student_id,
                                        tr.track_name AS trName, st.strand_name AS stName,
                                        CONCAT(adv.t_ln,', ',adv.t_fn,' ',adv.t_mn) AS advName,
                                        GROUP_CONCAT(DISTINCT ns.lname,', ', ns.fname, ' ', ns.mname) AS full_name,
                                        gr.stud_grade AS grName, sc.section_name AS secName, sy.sy_name AS syName,
                                        sem.semName AS semName
                                        FROM attendance_class AS ag
                                        LEFT JOIN teaching_load AS tl ON ag.id_tl = tl.id_tl
                                        LEFT JOIN teacher_info AS adv ON tl.adv_id = adv.t_id
                                        LEFT JOIN teacher AS advId ON adv.t_id = advId.t_id
                                        LEFT JOIN grade AS gr ON advId.grade = gr.grade_id
                                        LEFT JOIN section AS sc ON advId.section = sc.section_id
                                        LEFT JOIN new_students AS ns ON ag.student_id = ns.student_id
                                        LEFT JOIN school_year AS sy ON ns.sy_enrolled = sy.sy_id
                                        LEFT JOIN tracks AS tr ON ns.track_id = tr.track_id
                                        LEFT JOIN strands AS st ON ns.strand_id = st.strand_id
                                        LEFT JOIN semester AS sem ON ag.sem_id = sem.sem_id
                                         WHERE MONTH(ag.cl_date) = '$selectedMonth' AND YEAR(ag.cl_date) = '$year' AND ag.id_tl = '$seclectedTl'
                                         GROUP BY ag.student_id, gr.stud_grade, sc.section_name, sy.sy_name, tr.track_name, st.strand_name, sem.semName
                                         ORDER BY full_name ASC ") 
                                         or die(mysqli_error($conn));
                


                    
                ?>
                                    <div class="scroll" style="overflow-x:auto;">
            <div class="printable">
                    

                        <!-- JUNIOR HIGH SCHOOL INFORMATION HEADER -->

                <table class="table-container" id="tbl_cont">
                <tr>
                    <td colspan="8" style="text-align:center;border:none"><img src="../../images/admin/DepEd_circ.png" alt="" srcset="" height="100" width="100"></td>
                    <td colspan="18" style="border:none;text-align:center"><h2>School Form 2 (SF2) Daily Attendance Report of Learners</h2></td>
                    <td colspan="11" style="text-align:center;border:none"><img src="../../images/admin/DepEd_abbr.png" alt="" srcset="" height="100" width="100"></td>
                </tr>
                <tr>
                <td colspan="2"><label for="">School Name</label></td>
                    <td  colspan="9">
                        <input type="text" name="schoolId" class="puts1" id="schoolId" value="Canipaan National High School" readonly>
                    </td> 
                    <td colspan="2" style="text-align:right;"><label for="sy">School ID</label></td>                   
                    <td colspan="4">
                        <input type="text" name="sy" class="puts1" id="sy" value="303446" readonly>
                    </td>
                    <td colspan="2"><label for="">District</label></td>                    
                    <td colspan="4" >
                        <input type="text" name="rfidcard" class="puts1" id="rfidcard" value="Hinunangan" readonly>
                    </td>
                    <td colspan="2"  style="text-align:right;"><label for="">Division</label></td>                    
                    <td colspan="10" >
                        <input type="text" name="rfidcard" class="puts1" id="rfidcard" value="Southern Leyte" readonly>
                    </td>
                    <td style="text-align:right;"><label for="">Region</label></td>                    
                    <td >
                        <input type="text" name="rfidcard" class="puts1" id="rfidcard" value="VIII" readonly>
                    </td>
                </tr>





                <br>
                </tr>
                <?php
$absentCount = 0;
$presentCount = 0;
$cuttingCount = 0;
$lateCount = 0;
$absentStudentCount = 0;
$presentStudentCount = 0;
$cuttingStudentCount = 0;
$lateStudentCount = 0;

// Fetch school year, grade, section
$student = mysqli_fetch_array($fetchingStudents);

if ($student) {
    $syName = $student['syName'];
    $grName = $student['grName'];
    $secName = $student['secName'];
    $trName = $student['trName'];
    $stName = $student['stName'];
    $semName = $student['semName'];
    
    ?>
    <!-- SECOND ROW -->
    <tr>
        <td colspan="2" style="text-align:right"><label for="">Semester</label></td>
        <td  colspan="6">
            <input type="text" name="sem" class="puts1" id="sem" value="<?php echo $semName?>" readonly>
        </td>
        <td colspan="3" style="text-align:right"><label for="">School Year</label></td>
        <td colspan="10">
            <input type="text" name="sy" class="puts1" id="sy" value="<?php echo $syName?>" readonly>
        </td>
        <td colspan="3" style="text-align:right"><label for="">Grade Level</label></td>
        <td colspan="3">
            <input type="text" name="gl" class="puts1" id="gl" value="<?php echo $grName;?>" readonly>
        </td>   
        <td colspan="4" style="text-align:right"><label for="">Track and Strand</label></td>
        <td  colspan="10">
            <input type="text" name="ts" class="puts1" id="ts" value="<?php echo $trName .'-'. $stName?>" eadonly>
        </td>    
    </tr>
    <tr>
        <td colspan="2" style="text-align:right"><label for="">Section</label></td>
        <td colspan="5">
            <input type="text" name="sec" class="puts1" id="sec" value="<?php echo $secName;?>" readonly>
        </td>
        <td colspan="5" style="text-align:right"><label for="">Course (for TVL only)</label></td>
        <td  colspan="11">
            <input type="text" name="cors" class="puts1" id="cors" readonly>
        </td>   
        <td colspan="6"style="text-align:right"><label for="">Month of</label></td>
        <?php

            // Fetch month name based on the month ID
            $fetchMonthQuery = mysqli_query($conn, "SELECT month_name FROM month WHERE month_id = '$selectedMonth'");
            $monthData = mysqli_fetch_assoc($fetchMonthQuery);
            $monthName = $monthData['month_name'];

            // Display the month name in the input field
            ?>
            <td colspan="8">
                <input type="text" name="mon" class="puts1" id="mon" value="<?php echo $monthName; ?>" readonly>
            </td>
    </tr>
    <tr>
        <!-- iteration of the date of the month -->
        <td rowspan="2">No.</td>
        <td rowspan="2">Students Names</td>
            <?php
            for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                $currentDate = date('Y-m-d', strtotime("$firstDayOfMonth + $j days"));
                $dayOfWeek = date('N', strtotime($currentDate));
                if ($dayOfWeek >= 6) { // 6 corresponds to Saturday
                    continue;
                }
                $day = date("D", strtotime($currentDate));
                echo "<td>$j</td>";
            }
            ?>

        <td colspan="4">
            <h5>Total for the Month</h5>
        </td >
        <td rowspan="2" colspan="10" style="text-align:center">
        <p>REMARKS (If NLS, state reason, please refer to legend number 2.</p>
        <p>If TRANSFERRED IN/OUT, write the name of School.)</p>
        </td>
    </tr>
    <tr>
            <?php
            // iteration of the days of the month

                for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                    $currentDate = date('Y-m-d', strtotime("$firstDayOfMonth + $j days"));
                    $dayAbbreviated = date("D", strtotime($currentDate)); // Get abbreviated day name
                    
                    if (date('N', strtotime($currentDate)) >= 6) {
                        // Skip Saturday and Sunday
                        continue;
                    }

                    // Map abbreviated day names
                    switch ($dayAbbreviated) {
                        case 'Mon':
                            $dayAbbreviated = 'M';
                            break;
                        case 'Tue':
                            $dayAbbreviated = 'T';
                            break;
                        case 'Wed':
                            $dayAbbreviated = 'W';
                            break;
                        case 'Thu':
                            $dayAbbreviated = 'Th';
                            break;
                        case 'Fri':
                            $dayAbbreviated = 'F';
                            break;
                        default:
                            // Handle any other cases here
                            break;
                    }
                    
                    echo "<td>$dayAbbreviated</td>";
                }

            ?>
        <td>A</td>
        <td>P</td>
        <td>C</td>
        <td>L</td>
    </tr>
    <?php
$n=0;
// Loop through students
do {
    $student_id = $student['student_id'];
    $sname = $student['full_name'];

    // Initialize counts for each student
    $absentStudentCount = 0;
    $presentStudentCount = 0;
    $cuttingStudentCount = 0;
    $lateStudentCount = 0;
    $n++;
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

        $fetchingStudentsAttendance = mysqli_query($conn, "SELECT * FROM attendance_class WHERE student_id = '$student_id' AND cl_date = '$dateOfAttendance'") or die(mysqli_error($conn));
        $isAttendanceAdded = mysqli_num_rows($fetchingStudentsAttendance);

        if ($isAttendanceAdded > 0) {
            $studentAttendance = mysqli_fetch_assoc($fetchingStudentsAttendance);
            $clin = $studentAttendance['time_in'];
            $clout = $studentAttendance['time_out'];
            $curr_date = $studentAttendance['cl_date'];
            $clstat = $studentAttendance['attendance_status'];

            // For morning status
            if (!empty($clin) && empty($clout)) {
                $morning_status = "C";
                $cuttingStudentCount++;
            } else {
                $morning_status = ($clstat == "Present" ? "P" : ($clstat == "Late" ? "L" : "A"));
                if ($morning_status == "P") {
                    $presentStudentCount++;
                } elseif ($morning_status == "A") {
                    $absentStudentCount++;
                } elseif ($morning_status == "L") {
                    $lateStudentCount++;
                }
            }

            echo "<td>$morning_status</td>";
        } else {
            echo "<td></td>";
        }
    }

    // Display counts for the current student
    echo "<td>$absentStudentCount</td>";
    echo "<td>$presentStudentCount</td>";
    echo "<td>$cuttingStudentCount</td>";
    echo "<td>$lateStudentCount</td>";
    echo "<td colspan='10'></td>";
    echo "</tr>";
} while ($student = mysqli_fetch_array($fetchingStudents));

}


// Fetching details only once for the first row

$presentCount += $presentStudentCount;
$absentCount += $absentStudentCount;
$cuttingCount += $cuttingStudentCount;
$cuttingCount += $lateStudentCount;
?>
                </table>
                </div>
                </div>
            </div>
        </div>
                    <?php 
                }else{
                    $firstDayOfMonth = date("Y-m-0");
                    $totalDaysInMonth = date("t", strtotime($firstDayOfMonth));
                    // Fetching Students 
                    $fetchingStudents = mysqli_query($conn, "SELECT 
                                        ag.student_id, CONCAT(ns.lname, ', ', ns.fname, ' ', ns.mname) AS full_name, 
                                        CONCAT(adv.t_ln,', ',adv.t_fn,' ',adv.t_mn) AS advName,
                                        gr.stud_grade AS grName, sc.section_name AS secName, sy.sy_name AS syName
                                        FROM attendance_class AS ag
                                        LEFT JOIN teaching_load AS tl ON ag.id_tl = tl.id_tl
                                        LEFT JOIN teacher_info AS adv ON tl.adv_id = adv.t_id
                                        LEFT JOIN teacher AS advId ON adv.t_id = advId.t_id
                                        LEFT JOIN grade AS gr ON advId.grade = gr.grade_id
                                        LEFT JOIN section AS sc ON advId.section = sc.section_id
                                        LEFT JOIN new_students AS ns ON ag.student_id = ns.student_id
                                        LEFT JOIN school_year AS sy ON ns.sy_enrolled = sy.sy_id
                                        GROUP BY ag.student_id, full_name, advName, grName, secName, syName
                                        ORDER BY full_name ASC") or die(mysqli_error($conn));
                                        $totalNumberOfStudents = mysqli_num_rows($fetchingStudents);
?>

                <div class="scroll" style="overflow-x:auto;">
            <div class="printable">
                    

                        <!-- JUNIOR HIGH SCHOOL INFORMATION HEADER -->

                <table class="table-container" id="tbl_cont">
                <tr>
                    <td colspan="7" style="text-align:center;border:none"><img src="../../images/admin/DepEd_circ.png" alt="" srcset="" height="100" width="100"></td>
                    <td colspan="18" style="border:none;text-align:center"><h2>School Form 2 (SF2) Daily Attendance Report of Learners</h2></td>
                    <td colspan="10" style="text-align:center;border:none"><img src="../../images/admin/DepEd_abbr.png" alt="" srcset="" height="100" width="100"></td>
                </tr>
                <tr>
                <td><label for="">School Name</label></td>
                    <td  colspan="9">
                        <input type="text" name="schoolId" class="puts1" id="schoolId" value="Canipaan National High School" readonly>
                    </td> 
                    <td colspan="2" style="text-align:right;"><label for="sy">School ID</label></td>                   
                    <td colspan="4">
                        <input type="text" name="sy" class="puts1" id="sy" value="303446" readonly>
                    </td>
                    <td colspan="2"><label for="">District</label></td>                    
                    <td colspan="5" >
                        <input type="text" name="rfidcard" class="puts1" id="rfidcard" value="Hinunangan" readonly>
                    </td>
                    <td colspan="3"  style="text-align:right;"><label for="">Division</label></td>                    
                    <td colspan="6" >
                        <input type="text" name="rfidcard" class="puts1" id="rfidcard" value="Southern Leyte" readonly>
                    </td>
                    <td style="text-align:right;"><label for="">Region</label></td>                    
                    <td>
                        <input type="text" name="rfidcard" class="puts1" id="rfidcard" value="VIII" readonly>
                    </td>
                </tr>
                <tr>
                    <td><label for="">School Year</label></td>
                    <td colspan="8">
                        <input type="text" name="sy" class="puts1" id="sy" value="<?php echo isset($syName) ? $syName : ''; ?>" readonly>
                    </td>
                    <td colspan="2" style="text-align:right"><label for="">Grade Level</label></td>
                    <td colspan="7">
                        <input type="text" name="gl" class="puts1" id="gl" value="<?php echo isset($grName) ? $grName : ''; ?>" readonly>
                    </td>  
                    <td colspan="3" style="text-align:right"><label for="">Section</label></td>
                    <td colspan="10">
                        <input type="text" name="sec" class="puts1" id="sec" value="<?php echo isset($secName) ? $secName : ''; ?>" readonly>
                    </td>
                    <td style="text-align:right"><label for="">Month of</label></td>
                    <td colspan="8">
                        <input type="text" name="mon" class="puts1" id="mon" value="<?php echo isset($selectedMonth) ? $selectedMonth : ''; ?>" readonly>
                    </td>  
                </tr>




                <br>
                <tr>
                    <td rowspan="2">Students Names</td>
                        <?php
                        for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                            $currentDate = date('Y-m-d', strtotime("$firstDayOfMonth + $j days"));
                            $dayOfWeek = date('N', strtotime($currentDate));
                            if ($dayOfWeek >= 6) { // 6 corresponds to Saturday
                                continue;
                            }
                            $day = date("D", strtotime($currentDate));
                            echo "<td>$j</td>";
                            // Add your logic here for displaying each day
                        }
                        ?>

                    <td colspan="4">
                        <h5>Total for the Month</h5>
                    </td >
                    <td rowspan="2" colspan="10" style="text-align:center">
                    <p>REMARKS (If NLS, state reason, please refer to legend number 2.</p>
                    <p>If TRANSFERRED IN/OUT, write the name of School.)</p>
                    </td>
                </tr>

                    <tr>
                        <?php
                            for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                                $currentDate = date('Y-m-d', strtotime("$firstDayOfMonth + $j days"));
                                $dayAbbreviated = date("D", strtotime($currentDate)); // Get abbreviated day name
                                
                                if (date('N', strtotime($currentDate)) >= 6) {
                                    // Skip Saturday and Sunday
                                    continue;
                                }

                                // Map abbreviated day names to the desired format
                                switch ($dayAbbreviated) {
                                    case 'Mon':
                                        $dayAbbreviated = 'M';
                                        break;
                                    case 'Tue':
                                        $dayAbbreviated = 'T';
                                        break;
                                    case 'Wed':
                                        $dayAbbreviated = 'W';
                                        break;
                                    case 'Thu':
                                        $dayAbbreviated = 'Th';
                                        break;
                                    case 'Fri':
                                        $dayAbbreviated = 'F';
                                        break;
                                    default:
                                        // Handle any other cases here
                                        break;
                                }
                                
                                echo "<td>$dayAbbreviated</td>";
                            }

                        ?>
                    <td>A</td>
                    <td>P</td>
                    <td>C</td>
                    <td>L</td>
                    </tr>

                </tr>
                <?php
                $absentCount = 0;
                $presentCount = 0;
                $cuttingCount = 0;
                $lateCount = 0;
                $absentStudentCount = 0;
                $presentStudentCount = 0;
                $cuttingStudentCount = 0;
                $lateStudentCount = 0;
                while ($student = mysqli_fetch_assoc($fetchingStudents)) {
                    $student_id = $student['student_id'];
                    $sname = $student['full_name'];
                    echo "<tr>";
                    echo "<td >$sname</td>";
                    
                    for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                        $currentDay = date('N', strtotime("$firstDayOfMonth + $j days"));
                        if ($currentDay >= 6) {
                            // Skip Saturday and Sunday
                            continue;
                        }
                        $dayFormatted = sprintf('%02d', $j);
                        $dateOfAttendance = date("Y-m-$dayFormatted", strtotime("$firstDayOfMonth + $j days"));
                        $fetchingStudentsAttendance = mysqli_query($conn, "SELECT * FROM attendance_class WHERE student_id = '$student_id' AND cl_date = '$dateOfAttendance'") or die(mysqli_error($conn));

                        $isAttendanceAdded = mysqli_num_rows($fetchingStudentsAttendance);
                        $dashLog = "-";
                        if ($isAttendanceAdded > 0) {
                            $studentAttendance = mysqli_fetch_assoc($fetchingStudentsAttendance);
                            $clin = $studentAttendance['time_in'];
                            $clout = $studentAttendance['time_out'];
                            $curr_date = $studentAttendance['cl_date'];
                            $clstat = $studentAttendance['attendance_status'];

                            // For morning status
                            if (!empty($clin) && empty($clout)){
                                $morning_status = "C";
                                $cuttingStudentCount++;
                            }else{
                                $morning_status = ($clstat == "Present" ? "P" : ($clstat == "Late" ? "L" : "A"));
                                if ($morning_status == "P") {
                                    $presentStudentCount++;
                                } elseif ($morning_status == "A") {
                                    $absentStudentCount++;
                                }elseif ($morning_status == "L") {
                                    $lateStudentCount++;
                                }
                
                            }
                            
                            
                            echo "<td>$morning_status</td>";
                        } else {
                            echo "<td></td>";
                        }

                    }
                    echo "<td>$absentStudentCount</td>";
                    echo "<td>$presentStudentCount</td>";
                    echo "<td>$cuttingStudentCount</td>";
                    echo "<td>$lateStudentCount</td>";
                    echo "<td colspan='10'></td>";
                }

                $presentCount += $presentStudentCount;
                $absentCount += $absentStudentCount;
                $cuttingCount += $cuttingStudentCount;
                $cuttingCount += $lateStudentCount;
                ?>
                </tr>
                </table>
                </div>
                </div>
            </div>
        </div>
        <?php

                }

                ?>
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
        printWindow.document.write('body { font-size: 10px; }');
        printWindow.document.write('table { border-collapse: collapse; margin: auto; border: 1px solid black; width: 100%; }');
        printWindow.document.write('td { border: 2px solid black; width:100%; white-space:nowrap;padding:7px;}'); // Adjusted width to auto
        printWindow.document.write('img { margin: 10px 0; }');
        printWindow.document.write('.puts1 {text-align: left;outline: none;padding: 5px;width: 100%; /* Set width to 100% */border: 1px solid gray;border-radius: 4px;}');
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
