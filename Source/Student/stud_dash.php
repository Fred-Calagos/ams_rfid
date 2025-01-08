<?php
    session_start();
    include "header.php";
    include "../../Inc/connect.php";

    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        header("Location: ../../index.php");
        exit; // Stop further execution
    }

    $username = $_SESSION['username'];
    $query = "SELECT * FROM new_students WHERE student_id = '$username'";
    $result = mysqli_query($conn, $query);
    $student = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stud_dash.css">
</head>
<style>
    .top i{
    margin-top: -10px;
}
</style>
<body>
<section class="dashboard">
        <div class="top">
            <i class="fas fa-bars sidebar-toggle"></i>
            <img src="<?php echo $student['images']; ?>" alt="Student Image">
        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="fas fa-dashboard"></i>
                    <span class="text">DASHBOARD</span>
                </div>
                <div class="table-responsive">
                    <?php
                    $query = "SELECT
                                YEAR(att_date) AS year,
                                MONTHNAME(att_date) AS month,
                                WEEK(att_date) AS week,
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
                            WHERE student_id = '$username'
                            GROUP BY 
                            YEAR(att_date), MONTHNAME(att_date), WEEK(att_date)";
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

                        new ApexCharts(document.querySelector("#reportsChart"), {
                            series: [
                                { name: 'Present', data: data.map(item => item.present) },
                                { name: 'Absent', data: data.map(item => item.absent) },
                                { name: 'Late', data: data.map(item => item.late) },
                                { name: 'Cutting', data: data.map(item => item.cutting) }
                            ],
                            chart: {
                                height: 300,
                                type: 'area',
                                toolbar: {
                                    show: false
                                },
                            },
                            markers: {
                                size: 4
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
                                categories: data.map(item => `${item.month}-WEEK-${item.week}`)
                            },
                            
                            tooltip: {
                                x: {
                                    format: 'MMM'
                                },
                            }
                        }).render();
                    });
                    </script>
                </div>
            </div>
        </div>
    </section>
    <?php include "footer.php"; ?>
</body>
</html>
