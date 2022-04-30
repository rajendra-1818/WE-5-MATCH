<?php
require_once("../connection.php");
require_once("../validation.php");
$student_id=$_POST['student_id'];

$query="select * from students where enroll_no='$student_id'";
$stmt = $conn->query($query);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

$query="select * from payments p inner join course c on p.course_id=c.course_id where student_id='$student_id'";
$stmt = $conn->query($query);
$paymentDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query="select * from grades where student_id='$student_id'";
$stmt = $conn->query($query);
$gradeDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query="select * from attendance where student_id='$student_id'";
$stmt = $conn->query($query);
$attedanceDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

$profile=[];
$profile['details']=$student;
$profile['paymentDetails']=$paymentDetails;
$profile['gradeDetails']=$gradeDetails;
$profile['attendance']=$attedanceDetails;

$return= [
    "status"=>1,
    "data"=>$profile,
    "message"=>"Profile Details"
];
return print_r(json_encode($return));
?>