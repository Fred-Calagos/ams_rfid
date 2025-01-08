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
                                <select name="event">
                                    <option value="" selected disabled hidden>--Select Event--</option>
                                    <?php
                                    $sql = "SELECT * FROM event_sched ORDER BY id asc";
                                    $role = mysqli_query($conn, $sql);
                                        while ($allrole = mysqli_fetch_array($role)) {
                                        ?>
                                            <option value="<?php echo $allrole['id']?>"><?php echo $allrole['event_name']?></option>';
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
                            
                                <button onclick="print_div()" class="btn_edit1"><i class="fas fa-print "></i>  PRINT</button>
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
                                       $i=0;
                                       $res = mysqli_query($conn, "SELECT ag.stud_rfid,
                                       es.event_name as en, es.event_date as ed, es.am_ti as amti, es.am_to as amto, es.pm_ti as pmti, es.pm_to as pmto, es.eve_ti as avti, es.eve_to as avto,
                                       ag.mti as mti, ag.mto as mto, ag.aftti as aftti, ag.aftto as aftto, ag.eveti as eveti, ag.eveto as eveto,
                                       GROUP_CONCAT(DISTINCT ns.lname,', ', ns.fname, ' ', ns.mname) AS full_name,
                                       ns.section AS ns_sec,
                                       ns.grade AS ns_gr,
                                       GROUP_CONCAT(DISTINCT adv.t_ln,', ', adv.t_fn, ' ',adv.t_mn) AS tfull_name

                                       FROM `attendance_event` AS ag 
                                       LEFT JOIN new_students AS ns ON ag.stud_rfid = ns.student_id
                                       LEFT JOIN teacher_info AS adv ON ns.adviser = adv.t_id
                                       LEFT JOIN event_sched AS es ON ag.eid = es.id
                                       WHERE ag.eid LIKE '$_POST[event]%' 
                                       AND ns.grade LIKE '$_POST[gr]%' 
                                       AND ns.section LIKE '$_POST[sc]%'
                                       GROUP BY ag.stud_rfid, ns.section, ns.grade, es.event_name, 
                                       es.event_date, es.am_ti, es.am_to, es.pm_ti, es.pm_to, es.eve_ti, es.eve_to,
                                       ag.mti, ag.mto, ag.aftti, ag.aftto, ag.eveti, ag.eveto
                                       ");
                                    ?>
                                        <thead>
                                            <?php
                                                // Fetching details only once for the first row
                                                $row1 = mysqli_fetch_array($res);

                                                if ($row1) {
                                                    // Fetching details only once for the first row
                                                    $studSec = isset($row1['ns_sec']) ? $row1['ns_sec'] : '';
                                                    $studGrade = isset($row1['ns_gr']) ? $row1['ns_gr'] : '';
                                                    $advName = isset($row1['tfull_name']) ? $row1['tfull_name'] : '';
                                                    $eventName  = isset($row1['en']) ? $row1['en'] : '';
                                                    $eventDate  = isset($row1['ed']) ? $row1['ed'] : '';
                                                }
                                            ?>
                                        <tr>
                                            <th colspan="9" style="text-align:center"><h1> <?php echo isset($eventName) ? $eventName : 'DID NOT MATCH'; ?></h1></th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Adviser: <?php echo isset($advName) ? $advName : ''; ?></th>
                                            <th colspan="2">Grade: <?php echo isset($studGrade) ? $studGrade : ''; ?></th>
                                            <th colspan="2">Section: <?php echo isset($studSec) ? $studSec : ''; ?></th>
                                            <th colspan="2">Date Implemented: <?php echo isset($eventDate) ? $eventDate : ''; ?></th>
                                        </tr>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Student Name</th>
                                            <th colspan="2">Morning</th>
                                            <th colspan="2">Afternoon</th>
                                            <th colspan="2">Evening</th>
                                        </tr>
                                    
                                        <tr>
                                            <th>TIME IN</th>
                                            <th>TIME OUT</th>
                                            <th>TIME IN</th>
                                            <th>TIME OUT</th>
                                            <th>TIME IN</th>
                                            <th>TIME OUT</th>
                                        </tr>
                                        
                                    </thead>
                                    <tbody>
                                        <?php
                                        $n=0;
                                        // Loop through attendance records for the same grade and section
                                        do {
                                            $studName   = isset($row1['full_name']) ? $row1['full_name'] : '';
                                            $amti       = isset($row1['mti']) ? $row1['mti'] : '';
                                            $amto       = isset($row1['mto']) ? $row1['mto'] : '';
                                            $pmti       = isset($row1['aftti']) ? $row1['aftti'] : '';
                                            $pmto       = isset($row1['aftto']) ? $row1['aftto'] : '';
                                            $eveti      = isset($row1['eveti']) ? $row1['eveti'] : '';
                                            $eveto      = isset($row1['eveto']) ? $row1['eveto'] : '';
                                            $n++;
                                        ?>
                                        <tr>
                                            <td><?php echo $n; ?></td>
                                            <td><?php echo $studName; ?></td>
                                            <td><?php echo $amti;?></td>
                                            <td><?php echo $amto; ?></td>
                                            <td><?php echo $pmti;?></td>
                                            <td><?php echo $pmto; ?></td>
                                            <td><?php echo $eveti; ?></td>
                                            <td><?php echo $eveto; ?></td>
                                        </tr>
                                        <?php
                                        } while ($row1 = mysqli_fetch_array($res));
                                        ?>
                                    </tbody>
                                <?php
                                   }else{
                                       
                                       $res = mysqli_query($conn,"SELECT ag.stud_rfid, 
                                       CONCAT(ns.lname,', ', ns.fname, ' ', ns.mname) AS full_name, ns.section as ns_sec, ns.grade as ns_gr,
                                        es.event_name as en, es.event_date as ed, es.am_ti as amti, es.am_to as amto, es.pm_ti as pmti, es.pm_to as pmto, es.eve_ti as avti, es.eve_to as avto, ag.mti as mti, ag.mto as mto, ag.aftti as aftti, ag.aftto as aftto, ag.eveti as eveti, ag.eveto as eveto
                                        FROM `attendance_event` AS ag
                                        LEFT JOIN new_students AS ns ON ag.stud_rfid = ns.student_id
                                        LEFT JOIN event_sched AS es ON ag.eid = es.id");
                                        ?>
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Event Name</th>
                                            <th rowspan="2">Student Name</th>
                                            <th colspan="2">Morning</th>
                                            <th colspan="2">Afternoon</th>
                                            <th colspan="2">Evening</th>
                                        </tr>
                                    
                                        <tr>
                                            <th>TIME IN</th>
                                            <th>TIME OUT</th>
                                            <th>TIME IN</th>
                                            <th>TIME OUT</th>
                                            <th>TIME IN</th>
                                            <th>TIME OUT</th>
                                        </tr>
                                        
                                    </thead>
                                        <?php
                                       while ($row = mysqli_fetch_array($res)){
                                        $studName   = $row['full_name'];
                                        $eventName  = $row['en'];
                                        $eventDate  = $row['ed'];
                                        $amti       = $row['mti'];
                                        $amto       = $row['mto'];
                                        $pmti       = $row['aftti'];
                                        $pmto       = $row['aftto'];
                                        $eveti      = $row['eveti'];
                                        $eveto      = $row['eveto'];
                                        ?>

                                        <tr>
                                        <td><?php echo $eventName ?></td>
                                        <td><?php echo $studName ?></td>
                                        <td><?php echo $amti  ?></td>
                                        <td><?php echo $amto  ?></td>
                                        <td><?php echo $pmti  ?></td>
                                        <td><?php echo $pmto  ?></td>
                                        <td><?php echo $eveti ?></td>
                                        <td><?php echo $eveto ?></td>
                                        </tr>
                                        
                                        <?php
                                   }
                                }
                                ?>
                            
 
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
        printWindow.document.write('td{border:2px solid black}');
        printWindow.document.write('th{border:2px solid black}');
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
