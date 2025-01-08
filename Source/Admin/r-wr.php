<!DOCTYPE html>
<html>
<head>
    <title>Weekly Attendance Report Filter</title>

    <style>
        #dtBasicExample{
            border-collapse: collapse;
            width: 95%;
            margin: auto;
        }
        #dtBasicExample th{
            background-color: #ffffff;
            color: rgb(0, 0, 0);
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            padding: 10px;
        }
        #dtBasicExample td{
            padding: 10px;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
            text-align: center;
        }
        #dtBasicExample tr:nth-child(odd) td{
            background-color: #a9a1a1;
            color: black;
        }
        #dtBasicExample tr:nth-child(even) td{
            background-color: #dddfef;
            color: black;
        }
        #print {
            background-color: blue;
            margin: 5px;
            border: none;
            outline: none;
            padding: 10px 20px;
            cursor: pointer;
            color: #fff;
            transition: all 0.5s ease-in;
            float: right;
        }
        #dtBasicExample #th-1{
            background-color: #EAEEE9;
        }
        #dtBasicExample #th-2{
            background-color: #CECECE;
        }
        #dtBasicExample .th-MA{
            background-color: #34282C;
            color: white;
        }
        #dtBasicExample .th-FA{
            background-color: #3A3B3C;
            color: white;
        }

        #print:hover,
        #save:hover {
            background-color: #333;
        }
        .school_name{
            display:none;
        }
        /* css for print */
        @media print {
            body {
                font-family: Arial, sans-serif;
            }
            body > *:not(.invoice-container) {
                display: none !important;
            }

            .invoice-container {
                margin-top: 20px;
                padding: 10px;
                margin: 10px;
                height: 90vh;
                width: 70%;
                text-align: center;  
            }
            .school_name{
                display:block;
            }

            #dtBasicExample {
                border-collapse: collapse;
                width: 70%;
                font-size: 13px;
                margin:10px;
                position: absolute;
            }

            #dtBasicExample th, #dtBasicExample td {
                border: 1px solid #ccc;
                padding: 8px;
                text-align: center;
            }
            #dtBasicExample td {
                font-size: 12px;
                text-align: left;
            }


            /* Add any other specific print styles you want */
            /* For example, you can hide the "Print Report" button when printing */
            button {
                display: none;
            }
            @page   
                {  
                size: auto;   
                margin: 15px;
                height: 100%;  
                }  
                body  
                {  
                background-color:#FFFFFF;   
                border: solid 1px black ;  
                margin: 0px;
                }      
        }
    </style>
    </head>
    <body>
        <button id="print" onclick="printTable()">PRINT</button><br>
            <form action="" method="POST">

                <label for="selectedWeek">Select a Week:</label>
                <input type="week" id="selectedWeek" name="selectedWeek" required>

                <input type="submit" name="submit" value="Filter">
            </form>
        
            <!-- The PHP code to generate the attendance report will be placed here -->

            <div class="invoice-container">
                <h1 class="school_name">Canipaan National High School</h1>
            <?php
            // Assuming you have already established a database connection.
            // Replace the database credentials with your own.
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "class_sched_db";

            // Connect to the database
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Get the current date and calculate the week start and end dates
            $currentDate = date("Y-m-d");
            $weekStart = date("Y-m-d", strtotime('last monday', strtotime($currentDate)));
            $weekEnd = date("Y-m-d", strtotime('next sunday', strtotime($currentDate)));

            // Query to fetch student data and attendance status for the week
            // Query to fetch student data and attendance status for the selected week (morning)
            $sqlMorning = "
                SELECT
                    student_id,
                    CONCAT(fname, ' ', mname, ' ', lname) AS student_name,
                    att_date AS login_date,
                    status AS attendance_status,
                    'Afternoon' AS attendance_type
                FROM
                    attendance
                WHERE att_date BETWEEN '$weekStart' AND '$weekEnd'
                ORDER BY student_id, login_date
            ";

            $result = $conn->query($sqlMorning);


            if (isset($_POST['submit'])) {
                $selectedWeek = $_POST['selectedWeek'];

                // Calculate the start and end dates for the selected week
                $weekStart = date("Y-m-d", strtotime('last monday', strtotime($selectedWeek)));
                $weekEnd = date("Y-m-d", strtotime('next sunday', strtotime($selectedWeek)));

                        // Query to fetch student data and attendance status for the selected week (morning)
                    $sqlMorning = "
                    SELECT
                        student_id,
                        att_date AS login_date,
                        status AS attendance_status,
                        'Afternoon' AS attendance_type
                    FROM
                        attendance
                    WHERE att_date BETWEEN '$weekStart' AND '$weekEnd'
                    ORDER BY student_id, att_date
                    ";

                    $result = $conn->query($sqlMorning);


                    if ($result->num_rows > 0) {
                        // Organize the results by student and day
                        $weeklyData = array();
                        
                        while ($row = $result->fetch_assoc()) {
                            $studentId = $row["student_id"];
                            $studentName = $row["student_name"];
                            $loginDate = $row["login_date"];
                            $attendanceStatus = $row["attendance_status"];
                            $attendanceType = $row["attendance_type"];
                
                            if (!isset($weeklyData[$studentId])) {
                                $weeklyData[$studentId] = array(
                                    "name" => $studentName,
                                    "days" => array()
                                );
                            }
                            if (!isset($weeklyData[$studentId]["days"][$loginDate])) {
                                $weeklyData[$studentId]["days"][$loginDate] = array(
                                    "Morning" => "      ",
                                    "Afternoon" => "       "
                                );
                            }
                            $weeklyData[$studentId]["days"][$loginDate][$attendanceType] = $attendanceStatus;
                        }
                
                        // Output the weekly report
                        echo "<h2>Weekly Attendance Report</h2>";
                        echo "<table id='dtBasicExample'>";
                        echo "<tr><th rowspan= '2'>Student Name</th>";
                    
                        // Generate table header with the dates of the week
                $currentDate = strtotime($weekStart);
                $dayCounter = 0; // Initialize the counter variable for header
                
                while ($currentDate <= strtotime($weekEnd) && $dayCounter < 7) {
                    echo "<th colspan='2'>" . date("Y-m-d (D)", $currentDate) . "</th>";
                    $currentDate = strtotime('+1 day', $currentDate);
                    
                    $dayCounter++;
                }
                
                echo "</tr>";
                echo "<tr>";

                // Generate nested table header with "Morning" and "Afternoon" for each date
                $currentDate = strtotime($weekStart);
                $dayCounter = 0; // Initialize the counter variable for header
                
                while ($currentDate <= strtotime($weekEnd) && $dayCounter < 7) {
                    echo "<th>Morning</th><th>Afternoon</th>";
                    $currentDate = strtotime('+1 day', $currentDate);
                    $dayCounter++;
                }
                
                echo "</tr>";

                foreach ($weeklyData as $studentId => $studentData) {
                    echo "<tr>";
                    echo "<td>" . $studentData['name'] . "</td>";
                    
                    // Loop through each day of the week and display the morning and afternoon attendance status
                    $currentDate = strtotime($weekStart);
                    $dayCounter = 0; // Initialize the counter variable for attendance data

                    while ($currentDate <= strtotime($weekEnd) && $dayCounter < 7) {
                        $formattedDate = date("Y-m-d", $currentDate);
                        $morningAttendance = $studentData['days'][$formattedDate]['Morning'] ?? "       ";
                        $afternoonAttendance = $studentData['days'][$formattedDate]['Afternoon'] ?? "       ";
                        echo "<td>" . $morningAttendance . "</td><td>" . $afternoonAttendance . "</td>";
                        $currentDate = strtotime('+1 day', $currentDate);
                        $dayCounter++;
                    }

                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "No data found.";
            }
            }

            // Close the database connection
            $conn->close();
    ?>
    </div>
        <script>
            function printTable() {
                // Get the table element by its ID
                var table = document.getElementById("dtBasicExample");

                // Open the print dialog
                window.print();
            }
        </script>
    </body>
</html>
