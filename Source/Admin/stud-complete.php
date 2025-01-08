<?php
require_once('../../Inc/connect.php');
 
function get_product($conn , $term){ 
 $query = "SELECT * FROM new_students WHERE student_id LIKE '%".$term."%' ORDER by student_id ASC";
 $result = mysqli_query($conn, $query); 
 $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
 return $data; 
}
 
if (isset($_GET['term'])) {
 $getProduct = get_product($conn, $_GET['term']);
 $prodList = array();
 foreach($getProduct as $product){
 $fname =$product['student_id'];
 $prodList[] = $fname;
 }
 echo json_encode($prodList);
}

?>