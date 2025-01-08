<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

    include("header.php");
    include("../../Inc/connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACTIVITY LOGS</title>
    <link rel="stylesheet" href="../../assets/css/logs.css">
</head>
<body>
<section class="dashboard">
        <div class="top">
        <i class="fas fa-bars sidebar-toggle"></i>
        </div>
        <div class="dash-content">
        <div class="table-responsive">
            <h2>ACTIVITY LOG</h2>
                        <table class="table-container">
                            <thead>
                                <tr>
                                    <th>Icon</th>
                                    <th>Date</th>
                                    <th>User ID</th>
                                    <th>Action</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php   
                                include("../../Inc/connect.php");
                                $n = 0;
                                $query=mysqli_query($conn,"select * from `logs` order by id DESC");
                                while($row=mysqli_fetch_array($query))
                                    {
                                        $n++;
                                ?>
                                <tr>
                                    <td><i class="icon <?php echo $row['icon'];?>"></i></td>
                                    <td><?php echo date('M d', strtotime($row['createdat'])); ?></td>
                                    <td><?php echo $row['user_id'];?></td>
                                    <td><?php echo $row['action'];?></td>
                                    <td><?php echo date('g:i A', strtotime($row['createdat'])); ?></td>
                                </tr>
                                <?php
                    }
                ?>
                            </tbody>

                        </table>
                    </div>


                
    </div>
</section>
<?php
        include "footer.php";
    ?>
</body>
</html>