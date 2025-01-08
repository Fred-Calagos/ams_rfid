<?php
    include "../../Inc/connect.php";
    class Delete_btm{
        private $conn;
        
        public function __construct($conn){
            $this->conn = $conn;
        }

        public function deleteStudent($stud_id){
            $query = "DELETE FROM new_students WHERE student_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $stud_id,);
            $stmt-> execute();
            $stmt->close();
        }

        public function deleteSection($sec_id){
            $query = "DELETE FROM section WHERE section_name = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $sec_id,);
            $stmt-> execute();
            $stmt->close();
        }
        public function deleteSched($sched_id){
            $query = "DELETE FROM att_sched WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $sched_id,);
            $stmt-> execute();
            $stmt->close();
        }
    }

    $deleteManager = new Delete_btm($conn);

    if(isset($_GET['stud_id']) && is_numeric($_GET['stud_id'])){
        $stud_id = $_GET['stud_id'];
        $deleteManager->deleteStudent($stud_id);

        header("location: m-student.php");
        exit();
    }
    if(isset($_GET['did']) && is_numeric($_GET['did'])){
        $sched_id = $_GET['did'];
        $deleteManager->deleteSched($sched_id);

        header("location: a-class-sched.php");
        exit();
    }
?>