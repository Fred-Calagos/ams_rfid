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
                    
                    <br><br>
                </div>
                <form action="" method="post" name="form1">
                    <div class="row well">
                        <ul>
                            <li>
                                <select name="month" id="">
                                    <option value="" selected disabled hidden>Select Month</option>
                                    <?php
                                        $query = mysqli_query($conn, "SELECT * FROM `month` ORDER BY id ASC");
                                        while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <option value="<?php echo $row['month_id']; ?>"><?php echo $row['month_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                </select>
                            </li>
                            <li>
                                <select name="gr" onchange="getGrade(this.value);" class="form-control">
                                        <option selected disabled hidden>Select Grade</option>
                                        <?php
                                        $query = mysqli_query($conn, "SELECT * FROM grade ORDER BY stud_grade ASC");
                                        while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <option value="<?php echo htmlentities($row['grade_id']); ?>"><?php echo $row['stud_grade']; ?></option>
                                            <?php
                                        }
                                        ?>
                                </select>
                            </li>
                            <li>
                                <select name="sc" id="section" class="form-control">
                                    <option>Select Section</option>
                                </select>
                            </li>
                            <li>
                                <input type="submit" name="submit" class="btn_create1" value="Submit">
                            </li>
                            <button onclick="print_div()" class="btn_edit1"><i class="fas fa-print"></i> PRINT</button>
                        </ul>
                    </div>
                </form>

                <div class="scroll" style="overflow-x:auto;">
                    <div class="printable">
                            <br>
                                <img src="../../images/admin/DepEd_circ.png" alt="" srcset="" style="width:100px;height:auto;float:left">
                                <img src="../../images/admin/DepEd_abbr.png" alt="" srcset="" style="width:auto;height:100px;padding:10px;float:right">
                            <br><br>
                        <table class="table-container" id="tbl_cont">

                        <?php 
                                   if (isset($_POST["submit"])) {
                                   $selectedMonth = $_POST['month'];
                                
                                    $i=0;
                                    $res = mysqli_query($conn, "SELECT ag.student_id,
                                    SUM(ag.am_log_in) AS amin, 
                                    SUM(ag.am_log_out) AS amout, 
                                    SUM(ag.pm_log_in) AS pmin,
                                    SUM(ag.pm_log_out) AS pmout,
                                    GROUP_CONCAT(DISTINCT ns.lname,', ', ns.fname, ' ', ns.mname) AS full_name,
                                    ns.section AS ns_sec,
                                    ns.grade AS ns_gr,
                                    gr.stud_grade AS grName,
                                    sc.section_name AS scName,
                                    GROUP_CONCAT(DISTINCT adv.t_ln,', ', adv.t_fn, ' ',adv.t_mn) AS tfull_name
                                    FROM `attendance_gate` AS ag 
                                    LEFT JOIN new_students AS ns ON ag.student_id = ns.student_id
                                    LEFT JOIN teacher_info AS adv ON ns.adviser = adv.t_id
                                    LEFT JOIN grade AS gr ON ns.grade = gr.grade_id
                                    LEFT JOIN section AS sc ON ns.section = sc.section_id 
                                    WHERE ns.section LIKE '$_POST[sc]%' 
                                    AND ns.grade LIKE '$_POST[gr]%' 
                                    AND MONTH(ag.att_date)  LIKE '$selectedMonth%'
                                    GROUP BY ag.student_id, ns.section, ns.grade");
                                    ?>
                                    
                                    <thead>
                                        <tr>
                                            <th colspan="9" style="text-align:center">GATE ATTENDANCE LOG REPORT</th>
                                        </tr>
                                        <?php
                                            $row1 = mysqli_fetch_array($res);

                                            if ($row1 !== null) { // Check if $row1 is not null
                                                $studSec = $row1['scName'] ?? ''; // Use null coalescing operator to handle null values
                                                $studGrade = $row1['grName'] ?? ''; // Use null coalescing operator to handle null values
                                                $advName = $row1['tfull_name'] ?? ''; // Use null coalescing operator to handle null values
                                            ?>
                                        <tr>
                                            <th colspan="2">Adviser: <?php echo $advName ?></th>
                                            <th colspan="2">Grade: <?php echo $studGrade ?></th>
                                            <th colspan="2">Section: <?php echo $studSec ?></th>
                                        </tr>
                                        <?php
                                        } else {
                                            // Handle the case when $row1 is null, for example, display a message indicating no data found.
                                            echo "<tr><td colspan='6'>No data found.</td></tr>";
                                        }
                                        ?>
                                        <tr>
                                            <th rowspan="2">No.</th>
                                            <th rowspan="2">Student Name</th>
                                            <th colspan="2">Morning</th>
                                            <th colspan="2">Afternoon</th>
                                        </tr>
                                        <tr>
                                            <th>IN</th>
                                            <th>OUT</th>
                                            <th>IN</th>
                                            <th>OUT</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                    <?php
                                        // Fetching the first row
                                        $row1 = mysqli_fetch_array($res);

                                        // Check if $row1 is not null
                                        if ($row1 !== null) {
                                            $n = 0; // Initialize counter
                                            // Loop through the rows
                                            do {
                                                $studName   = $row1['full_name'];
                                                $amin       = $row1['amin'];
                                                $amout      = $row1['amout'];
                                                $pmin       = $row1['pmin'];
                                                $pmout      = $row1['pmout'];
                                                $n++; // Increment counter
                                        ?>
                                        <tr>
                                            <td><?php echo $n; ?></td>
                                            <td><?php echo $studName; ?></td>
                                            <td style="text-align:center"><?php echo $amin; ?></td>
                                            <td style="text-align:center"><?php echo $amout; ?></td>
                                            <td style="text-align:center"><?php echo $pmin; ?></td>
                                            <td style="text-align:center"><?php echo $pmout; ?></td>
                                        </tr>
                                        <?php
                                            } while ($row1 = mysqli_fetch_array($res)); // Fetch the next row
                                        } else {
                                            // Handle the case when $res is empty, for example, display a message indicating no data found.
                                            echo "<tr><td colspan='6'>No data found.</td></tr>";
                                        }
                                        ?>

                                    </tbody>

                                    <?php
                                    
                                   }else{
                                       
                                    $res = mysqli_query($conn, "SELECT DISTINCT ag.student_id as student_id,
                                    SUM(DISTINCT ag.am_log_in) as amin, SUM(DISTINCT ag.am_log_out) as amout, SUM(DISTINCT ag.pm_log_in) as pmin,SUM(DISTINCT ag.pm_log_out) as pmout, 
                                    GROUP_CONCAT(DISTINCT ns.lname,', ',ns.fname,' ',ns.mname) as full_name
                                    FROM `attendance_gate` AS ag
                                    LEFT JOIN new_students as ns ON ag.student_id = ns.student_id
                                    GROUP BY ag.student_id, ns.lname
                                    ORDER BY full_name ASC
                                    ");
                                        ?>
                                    <thead>
                                        <tr>
                                            <th colspan="6">Log Attendance Report</th>
                                        </tr>
                                        <tr>
                                            <th rowspan="2">No.</th>
                                            <th rowspan="2">Student Name</th>
                                            <th colspan="2">Morning</th>
                                            <th colspan="2">Afternoon</th>
                                        </tr>
                                        <tr>
                                            <th>IN</th>
                                            <th>OUT</th>
                                            <th>IN</th>
                                            <th>OUT</th>
                                        </tr>
                                        
                                    </thead>
                                        <?php
                                        $n = 0;
                                        $prevStudentId = null;
                                        
                                        while ($row = mysqli_fetch_array($res)) {
                                            $amin = $row['amin'];
                                            $amout = $row['amout'];
                                            $pmin = $row['pmin'];
                                            $pmout = $row['pmout'];
                                            $studName = $row['full_name'];
                                                $n++;
                                        ?>
                                                <tr>
                                                    
                                                    <td><?php echo $n; ?></td>
                                                    <td><?php echo $studName; ?></td>
                                                    <td style="text-align:center"><?php echo $amin?></td>
                                                    <td style="text-align:center"><?php echo $amout?></td>
                                                    <td style="text-align:center"><?php echo $pmin?></td>
                                                    <td style="text-align:center"><?php echo $pmout?></td>
                                                </tr>
                                        <?php
                                        }
                                   }

                                ?>
                            </tbody>
 
                        </table>
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
        printWindow.document.write('table { border-collapse: collapse; margin: auto; width:100%; }');
        printWindow.document.write('td{border:1px solid black}');
        printWindow.document.write('th{border:1px solid black}');
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
    <script src="../../assets/js/dependent.js"></script>
</body>

</html>
