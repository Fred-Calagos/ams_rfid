<?php
  include("../../Inc/connect.php");

if(!empty($_POST["cat_id"])) 
    {
        $id=intval($_POST['cat_id']);
        $query=mysqli_query($conn,"SELECT * FROM refcitymun WHERE provCode=$id");
        ?>
        <select name="faculty"  onChange="getMun(this.value);"  style="width: 100%; padding: 0.375rem 0.75rem;    border-color: #ced4da;">
        <option value="">Select Municipality</option>
        <?php
        while($row=mysqli_fetch_array($query))
        {
        ?>
            <option value="<?php echo htmlentities($row['provCode']); ?>"><?php echo htmlentities($row['citymunDesc']); ?></option>
            <?php
        }
    }
?>
<script>
    function getMun(val) {
      $.ajax({
        type: "POST",
        url: "get_subcat.php",
        data:'cat_id='+val,
        success: function(data){
          $("#subcategory").html(data);
        }
      });
    }
    function selectCountry(val) {
      $("#search-box").val(val);
      $("#suggesstion-box").hide();
    }
  </script>