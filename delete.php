<?php
require_once("../connection.php");
require_once("../validation.php");
$student_id=$_POST['student_id'];

$query="DELETE FROM students WHERE enroll_no ='$student_id'";
$stmt = $conn->prepare($query);
$stmt->execute();

$query="DELETE FROM users WHERE user_id ='$student_id'";
$stmt = $conn->prepare($query);
$stmt->execute();


        
$return= [
    "status"=>1,
    "data"=>"",
    "message"=>"Deleted successfully"
];
return print_r(json_encode($return));

?>