<!DOCTYPE html>
<html>
    <head><title>Auto Fill</title>
<script src="jquery.min.js"></script>

    <!-- jQuery UI library -->
<link rel="stylesheet" href="jquery-ui.css">
<script src="jquery-ui.min.js"></script>

</head>
<style>
    *{
        font-family: helvetica;
    }
    input, button{
        padding:10px 15px;
        outline:none;
        border-radius:5px ;
        border:1px solid black;
    }
    label{
        font-size:12px;
    }
    h4{
        color:green;
    }
</style>
    <body>
    <h4>Auto Fill Textbox</h4>
                                            
                        <!-- GRADE LEVEL -->

                        <div class="half">

                            <div class="item">
                                <label class="required" for="adviser">Adviser</label>
                                <input type="text" name="adviser" id="adviser" onchange="GetProDetails(this.value)"><br>
                            </div>

                            <div class="item">
                                <label class="required" for="grade">Grade</label>
                                <input type="text" name="grade" id="grade" placeholder="Grade">
                            </div>

                            <div class="item">
                                <label class="required" for="section">Section</label>
                                <input type="text" name="section" id="section" placeholder="Section">
                            </div>

                        </div>


    </body>
    <script>

$(function() {
    $( "#adviser" ).autocomplete({
    source: 'product.php',
    });
});

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
    xmlhttp.open("GET", "fill.php?adv=" + str, true);
    xmlhttp.send();

}
}
</script>
</html>