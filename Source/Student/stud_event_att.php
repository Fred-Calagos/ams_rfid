<?php
    session_start();
    include "header.php";
    include "../../Inc/connect.php";

    // Redirect if user is not logged in
    if (!isset($_SESSION['username'])) {
        header("Location: ../../index.php");
        exit();
    }

    // Fetch student information from the database
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
    <title>Event Attendance Record</title>
</head>
<body>
<div class="dashboard">
    <div class="top">
        <i class="fas fa-bars sidebar-toggle"></i>
    </div>
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="fas fa-user"></i>
                <span class="text">EVENT ATTENDANCE RECORD</span>
            </div>
        </div>

        
        <!-- TABLE FOR EVENT ATTENDANCE -->


        <div class="table-responsive">
        <h1 style="text-align:center">EVENT ATTENDANCE</h1><BR>
            <i class="uil uil-search"></i><input type="text" placeholder="Search here..." id="search-button" style="float:right;padding:10px;border:none;border-bottom:2px solid blue;outline:none;"><br>   
            <div id="result"></div>
            <script>
                $(document).ready(function(){
                    $('#search-button').click(function(){
                        var eventName = $('#search-event').val(); // Get the event name from the input field
                        load_data(eventName); // Pass the event name to the load_data function
                    });

                    function load_data(eventName) {
                        console.log(eventName); // Debugging line
                        $.ajax({
                            url: "stud_auto_search_event_att.php",
                            method: "POST",
                            data: { query: eventName }, // Send event name as 'query'
                            success: function(data) {
                                $('#result').html(data);
                            }
                        });
                    }
                    // Initial load with an empty string for the event name
                    load_data("");
                });
            </script>


        </div>
    </div>
</div>
<?php
    include "footer.php";
?>
</body>
</html>
