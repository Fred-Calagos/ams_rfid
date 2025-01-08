<?php
//fetch.php
include("../../Inc/connect.php");
$output = '';
$pagi = '';
$n = 0;



    if(isset($_POST["query"]))
        {
        $search = mysqli_real_escape_string($conn, $_POST["query"]);
        $query = "SELECT teacher.*, CONCAT(teacher_info.t_fn,' ',teacher_info.t_mn,' ',teacher_info.t_ln) AS advName, gr.stud_grade AS grade, sc.section_name AS section FROM `teacher`
        INNER JOIN teacher_info ON teacher.t_id = teacher_info.t_id
        LEFT JOIN grade AS gr ON teacher.grade = gr.grade_id
        LEFT JOIN section AS sc ON teacher.section = sc.section_id

        WHERE CONCAT(teacher_info.t_fn,' ',teacher_info.t_mn,' ',teacher_info.t_ln) LIKE '%".$search."%'
        OR grade LIKE '%".$search."%'
        OR section LIKE '%".$search."%'
        ";
        }
    else
    {
    $query = "SELECT teacher.*,CONCAT(teacher_info.t_fn,' ',teacher_info.t_mn,' ',teacher_info.t_ln) AS advName, gr.stud_grade AS grade, sc.section_name AS section FROM `teacher`
    INNER JOIN teacher_info ON teacher.t_id = teacher_info.t_id
    LEFT JOIN grade AS gr ON teacher.grade = gr.grade_id
    LEFT JOIN section AS sc ON teacher.section = sc.section_id ORDER BY id desc";
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
                    <th colspan="3">Adviser Name</th>
                    <th>Grade</th>
                    <th>Section</th>
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
            <td colspan="3">'.$row['advName'].'</td>
            <td>'.$row['grade'].'</td>
            <td>'.$row['section'].'</td>
            <td>
                <a href="m-instructor.php?id_adv='.$row['id'].'&name='.$row['t_id'].'"><i class="fas fa-edit btn_edit1"></i></a>
                <a href="m-instructor.php?adv_id='.$row['id'].'"><i class="fas fa-trash btn_delete1"></a></a></td>
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
