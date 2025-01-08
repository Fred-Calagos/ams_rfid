<table class="table-container">
    <thead>
        <tr>
            <th>No.</th>
            <th>Section Name</th>
            <th>Year Level</th>
            <th>ACTION</th>

        </tr>
    </thead>
    <tbody>
        <?php   
            include("../../Inc/connect.php");
            $n = 0;
            $query=mysqli_query($conn,"select * from `section` order by section_id ASC");
            while($row=mysqli_fetch_array($query))
                {
                    $n++;
            ?>
            <tr>
                <td><?php echo $n; echo '.';?></td>
                <td><?php echo $row['section_name'];?></td>
                <td><?php echo $row['stud_grade'];?></td>
                <td><a href=""><i class="fas fa-edit edit"></i></a>
                    <a href=""><i class="fas fa-trash delete"></a></td>
            </tr>

        <?php
            }
        ?>
    </tbody>
</table>