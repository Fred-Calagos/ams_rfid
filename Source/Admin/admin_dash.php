<?php

    include "header.php";
    include "../../Inc/connect.php";
    if (!isset($_SESSION["username"])) {
        ?>
            <script type="text/javascript">
                window.location="../../index.php";
            </script>
        <?php
    }
    $username = $_SESSION['username'];
    $query = "SELECT *, CONCAT(admin_fname,' ',admin_mname,' ',admin_lname) AS adfname FROM `admin` WHERE rfid_admin = '$username'";
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<section class="dashboard">
        <div class="top">
        <i class="fas fa-bars sidebar-toggle"></i>
        <span><?php echo $admin['adfname']?>
        <img src="<?php echo $admin['profile']; ?>" alt="Admin Image"></span>
        </div>
        <div class="dash-content">
            <div class="overview">

                <div class="title">
                    <i class="fas fa-dashboard"></i>
                    <span class="text">DASHBOARD</span>
                </div>
                <div class="content-dashboard">
                    <div class="flex-container1">
                        <div class="flex-row effect8">
                            <a href="m-student.php">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <h3>NUMBER OF STUDENTS</h3>
                            <?php
            
                                    $select_rows = mysqli_query($conn, "SELECT * FROM `new_students`") or die('query failed');
                                    $row_count = mysqli_num_rows($select_rows);

                                    ?>

                                    <span style="font-size:20px;"><?php echo $row_count; ?></span>
                                <?php

                                if(isset($message)){
                                foreach($message as $message){
                                    echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
                                };
                                };

                            ?>
                            </a>
                        </div>
                        <div class="flex-row effect8">
                        <i class="fa-solid fa-table-list"></i>
                        <a href="a-attendance.php">
                            <h3>ATTENDANCE</h3>
                            <?php
            
                                    $select_rows = mysqli_query($conn, "SELECT * FROM `attendance_gate`") or die('query failed');
                                    $row_count = mysqli_num_rows($select_rows);

                                    ?>

                                    <span style="font-size:20px;"><?php echo $row_count; ?></span>

                                <?php

                                if(isset($message)){
                                foreach($message as $message){
                                    echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
                                };
                                };

                            ?>
                            </a>
                        </div>
                        <div class="flex-row effect8">
                        <a href="logs.php">
                        <i class="fa-regular fa-address-book"></i>
                            <h3>ACTIVITY LOGS</h3>
                        <?php
                            $select_rows = mysqli_query($conn, "SELECT * FROM `logs`") or die('query failed');
                            $row_count = mysqli_num_rows($select_rows);
                        ?>

                        

                            <span style="font-size:20px;"><?php echo $row_count; ?></span>
                            </a>
                        </div>
                        <div class="flex-row effect8">
                        <a href="m-report.php">
                        <i class="fa-solid fa-book-bookmark"></i>
                            <h3>REPORT</h3>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- GATE ATTENDNACE CHART -->
                <div class="title">
                    <i class="ri-bar-chart-box-fill"></i>
                    <span class="text">CHARTS</span>
                </div>
                
                <div class="table-responsive">
                    <?php
                    $query = "SELECT
                                YEAR(att_date) AS year,
                                MONTHNAME(att_date) AS month,
                                DAY(att_date) AS day,
                                SUM(CASE WHEN am_status = 'Absent' OR pm_status = 'Absent' THEN 1 ELSE 0 END) AS absent,
                                SUM(
                                        CASE 
                                            WHEN (amti IS NOT NULL AND amto IS NOT NULL AND am_status = 'Present') OR (pmti IS NOT NULL AND pmto IS NOT NULL and pm_status = 'Present') THEN 1 
                                            ELSE 0 
                                        END
                                    ) AS present,
                                SUM(CASE WHEN am_status = 'late' OR pm_status = 'Late' OR (am_status = 'late' OR pm_status = 'Late') THEN 1 ELSE 0 END) AS late,
                                SUM(
                                        CASE 
                                            WHEN (amti IS NOT NULL AND amto IS NULL) OR (amti IS NULL AND amto IS NOT NULL) OR (pmti IS NOT NULL AND pmto IS NULL) OR (pmti IS NULL AND pmto IS NOT NULL) THEN 1 
                                            ELSE 0 
                                        END
                                    ) AS cutting
                            FROM 
                                attendance_gate
                            GROUP BY YEAR(att_date), MONTHNAME(att_date), DAY(att_date)
                            ORDER BY DAY(att_date) asc";
                    $result = mysqli_query($conn, $query);

                    // Fetch the data and store it in an array
                    $data = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $data[] = $row;
                    }
                    ?>

                    <div id="reportsChart"><h3>GATE ATTENDANCE</h3></div>

                    <script>
                    document.addEventListener("DOMContentLoaded", () => {
                    // Use PHP data in JavaScript
                    const data = <?php echo json_encode($data); ?>;

                    // Round the values to whole numbers
                    const roundedData = data.map(item => ({
                        present: Math.round(item.present),
                        absent: Math.round(item.absent),
                        late: Math.round(item.late),
                        cutting: Math.round(item.cutting),
                        day: `Day-${item.day}`
                    }));
                   
                    console.log("Rounded Data:", roundedData);
                    new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [
                            { name: 'Present', data: roundedData.map(item => item.present) },
                            { name: 'Absent', data: roundedData.map(item => item.absent) },
                            { name: 'Late', data: roundedData.map(item => item.late) }, 
                            { name: 'Cutting', data: roundedData.map(item => item.cutting) }
                        ],
                        chart: {
                            height: 200,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                        },
                        markers: {
                            size:5
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d', '#ff0771'],
                        fill: {
                            type: "gradient",
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.3,
                                opacityTo: 0.4,
                                stops: [0, 90, 100]
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        xaxis: {
                            type: 'category',
                            categories: roundedData.map(item => item.day)
                        },
                        tooltip: {
                            x: {
                                format: 'MMM'
                            },
                            y: {
                                formatter: function(value) {
                                    return Math.round(value); // Round the tooltip values to integers
                                }
                            }
                        }
                    }).render();
                });

                    </script>
                </div>
                    <div class="flex-container1">
                        <div class="flex-row effect8">
                            <?php
                                $query = "SELECT gr.stud_grade as gradeName, count(ns.grade) AS studentCount 
                                        FROM new_students AS ns
                                        LEFT JOIN grade AS gr ON ns.grade = gr.grade_id
                                        GROUP BY gr.stud_grade, ns.grade";
                                $result = mysqli_query($conn, $query);

                                // Fetch the data and store it in an array
                                $data = array();
                                $totalStudents = 0; // Initialize total students counter
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $studentCounts[] = $row['studentCount'];
                                    $labels[] = $row['gradeName']; // Storing grade names or labels
                                    $totalStudents += $row['studentCount']; // Increment total students counter

                                    // Store the total number of students for each grade
                                    $gradeTotals[$row['gradeName']] = $row['studentCount'];
                                }
                            ?>

                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Number of Students by Grade</h5>

                                        <!-- Bar Chart -->
                                        <div id="barChart1"></div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                // Assuming you have the student counts data available in an array called 'studentCounts'
                                                const studentCounts = <?php echo json_encode($studentCounts); ?>;
                                                const labels = <?php echo json_encode($labels); ?>;

                                                new ApexCharts(document.querySelector("#barChart1"), {
                                                    series: [{
                                                        name: 'Number of Students',
                                                        data: studentCounts
                                                    }],
                                                    chart: {
                                                        type: 'bar',
                                                        height: 100
                                                    },
                                                    plotOptions: {
                                                        bar: {
                                                            horizontal: true,
                                                            columnWidth: '55%',
                                                            endingShape: 'rounded'
                                                        },
                                                    },
                                                    dataLabels: {
                                                        enabled: false
                                                    },
                                                    xaxis: {
                                                        categories: labels,
                                                        labels: {
                                                            show: true,
                                                        }
                                                    },
                                                    yaxis: {
                                                        title: {
                                                            text: 'Students'
                                                        }
                                                    },
                                                    tooltip: {
                                                        enabled: true,
                                                        shared: true,
                                                        followCursor: true,
                                                        intersect: false,
                                                        inverseOrder: true,
                                                        custom: function({ series, seriesIndex, dataPointIndex, w }) {
                                                            return '<div class="tooltip">' +
                                                                '<span>' + series[seriesIndex][dataPointIndex] + ' students</span>' +
                                                                '</div>'
                                                        }
                                                    },
                                                }).render();
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <div class="flex-row">
                        <?php
                            $query = "SELECT t_gender, COUNT(t_gender) AS genderC FROM teacher_info GROUP BY t_gender";
                            $result = mysqli_query($conn, $query);

                            // Fetch the data and store it in an array
                            $data = array();
                            while ($row = mysqli_fetch_assoc($result)) {
                                $genderCounts[$row['t_gender']] = $row['genderC']; // Store counts by gender
                            }
                        ?>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">TEACHER GENDER BAR CHART</h5>

                                    <!-- Bar Chart -->
                                    <div id="barChart"></div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                            // Assuming you have the gender counts data available in an array called 'genderCounts'
                                            const genderCounts = <?php echo json_encode($genderCounts); ?>;
                                            const genders = Object.keys(genderCounts);
                                            const counts = Object.values(genderCounts);

                                            new ApexCharts(document.querySelector("#barChart"), {
                                                series: [{
                                                    name: 'Count',
                                                    data: counts
                                                }],
                                                chart: {
                                                    type: 'bar',
                                                    height: 100
                                                },
                                                plotOptions: {
                                                    bar: {
                                                        horizontal: true,
                                                        columnWidth: '10%',
                                                        endingShape: 'rounded'
                                                    },
                                                },
                                                dataLabels: {
                                                    enabled: false
                                                },
                                                xaxis: {
                                                    categories: genders,
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Count'
                                                    }
                                                }
                                            }).render();
                                        });
                                    </script>
                                    <!-- End Bar Chart -->

                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                    

                

    </section>
    <?php
        include "footer.php";
    ?>
</body>
</html>