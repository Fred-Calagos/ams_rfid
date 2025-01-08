<?php
include "header.php";
include "../../Inc/connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>

    .upload{
        width: 100px;
        position: relative;
        }

        .upload img{
        border-radius: 50%;
        border: 6px solid #eaeaea;
        object-fit: cover;
        }

        .upload .round{
        position: absolute;
        bottom: 0;
        right: 0;
        background: #00B4FF;
        width: 32px;
        height: 32px;
        line-height: 33px;
        text-align: center;
        border-radius: 50%;
        overflow: hidden;
        }

        .upload .round input[type = "file"]{
        position: absolute;
        transform: scale(2);
        opacity: 0;
        }

</style>
<script>
    function GetProDetails(str){
        if(str.length == 0){
            document.getElementById("grade").value = "";
            document.getElementById("section").value = "";
            return;
        }
        else{

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
            
                if (this.readyState == 4 && this.status == 200){
                    
                    var myObj = JSON.parse(this.responseText);
                    document.getElementById("grade").value = myObj[0];
                    document.getElementById("section").value = myObj[1];
                }
            };
            xmlhttp.open("GET", "stud-fill.php?adv=" + str, true);
            xmlhttp.send();

        }
        }
</script>
</head>
<body>
    <section class="dashboard">
            <div class="top">
            <i class="fas fa-bars sidebar-toggle"></i>
                
                
            </div>

            <div class="dash-content">
        </div>
    </section>

    <?php
        include "footer.php"; 
    ?>
</body>
</html>