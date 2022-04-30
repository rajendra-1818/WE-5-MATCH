<?php
require_once("../connection.php");
require_once("../validation.php");
$query="select * from students s inner join users u on s.enroll_no=u.user_id";
$stmt = $conn->query($query);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$allArr=[];
foreach($result as $rt){
    
    $student_id=$rt['enroll_no'];

    $query1="select * from payments p inner join course c on c.course_id=p.course_id  where p.student_id='$student_id'";
    $stmt1 = $conn->query($query1);
    $stResult = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    $rt['payment']=$stResult;

    $query2="select * from grades p inner join course c on c.course_id=p.course_id  where p.student_id='$student_id'";
    $stmt = $conn->query($query2);
    $gtResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $rt['grade']=$gtResult;

    $query3="select * from attendance  where student_id='$student_id'";
    $stmt = $conn->query($query3);
    $atResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $rt['attendance']=$atResult;

    array_push($allArr,$rt);
}


$return= [
    "status"=>1,
    "data"=>$allArr,
    "message"=>"Student List"
];
return print_r(json_encode($return));

?>