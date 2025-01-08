<?php
/*
* Author 	: Expert coder
* Email 	: expertcoder10@gmail.com
* Subject 	: Autocomplete using PHP/MySQL and jQuery
*/
// PDO connect *********
function connect() {
    return new PDO('mysql:host=localhost;dbname=class_sched_db', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}

$pdo = connect();
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT id as stud, CONCAT(lname,', ',mname,' ',fname) as flname FROM new_students WHERE fname LIKE (:keyword) OR lname LIKE (:keyword) OR mname LIKE (:keyword) ORDER BY lname ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$country_name = str_replace($_POST['keyword'], '<strong>'.$_POST['keyword'].'</strong>', $rs['flname']);
	// add new option
    echo '<li onclick="set_item(\''.$rs['stud'].'\')">'.$country_name.'</li>';
}
?>