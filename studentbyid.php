<?php
require_once("../connection.php");
require_once("../validation.php");
$student_id=$_POST['student_id'];
$query="select * from students where enroll_no='$student_id'";
$stmt = $conn->query($query);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$return= [
    "status"=>1,
    "data"=>$result,
    "message"=>"Student"
];
return print_r(json_encode($return));

?>