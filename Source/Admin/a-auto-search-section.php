<?php
//fetch.php
include("../../Inc/connect.php");
$output = '';
$pagi = '';
$n = '';
$ai = $_GET["a_id"];
// Check if the 'a_id' parameter is set in the POST data
if(isset($_REQUEST["query"]) && isset($_REQUEST["a_id"])) {
    // Escape the POST data to prevent SQL injection
    $search = mysqli_real_escape_string($conn, $_REQUEST["query"]);
    $aId = mysqli_real_escape_string($conn, $_REQUEST["a_id"]);

    // Get the grade ID associated with the section
    $gIds_query = mysqli_query($conn, "SELECT stud_grade FROM `section` WHERE `stud_grade` = '$aId'");
    $gIds_row = mysqli_fetch_assoc($gIds_query);
    $gIds = $gIds_row['stud_grade'];

    // Specify the table for the 'stud_grade' column to avoid ambiguity
    $query = "SELECT s.*, gr.stud_grade AS grName 
              FROM `section` AS s
              LEFT JOIN grade AS gr ON s.stud_grade = gr.grade_id
              WHERE s.stud_grade = '$gIds' AND s.section_name LIKE '%$search%'
              ORDER BY s.section_name ASC";
} else {
    // If 'a_id' is not set or if 'query' is not set, retrieve all sections
    $query = "SELECT s.*, gr.stud_grade AS grName 
              FROM `section` AS s
              LEFT JOIN grade AS gr ON s.stud_grade = gr.grade_id
              WHERE s.stud_grade = '$ai'
              ORDER BY s.section_name ASC";
}



    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0)
        {

            $output .= '
                
                <section class="header">
                
                    <div class="items-controller">
                        <h5>Show</h5>
                            <select name="" id="itemperpage">
                                <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="08" selected>08</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                            </select>
                        <h5>Per Page</h5>
                        <br><br>
                    </div>
            <div class="scroll" style="overflow-x:auto;">
            <table class="table-container"  >
            
            <thead>
                <tr>
                    <th>#</th>
                    <th>Section Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            ';

        while($row = mysqli_fetch_array($result))
        {
            $n++;
            $output .= '
                <tr>
                    <td>'.$n.'</td>
                    <td>'.$row['section_name'].'</td>
                    <td>

                        <a href="m-class-edit.php?e_trid='.$row["section_id"].'&a_id='.$row['stud_grade'].'"><i class="fas fa-edit btn_edit1"></i></a>
                        <a href="m-class-edit.php?d_trid='.$row['section_id'].'&a_id='.$row['stud_grade'].'"><i class="fas fa-trash btn_delete1"></i></a>
                    </td>
                </tr>
            ';
        }
        $output .= '
            </table>
                <div class="bottom-field">      
                    <ul class="pagination">
                        <li class="prev\"><a href="#" id="prev">&#139;</a></li>
                            <!-- page number here -->
                        <li class="next"><a href="#" id="next">&#155;</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <script src="../../assets/JS/main.js"></script>
    ';

            echo $output;
        }
    else
        {
                echo 'Data Not Found';
        }
        
    ?>
