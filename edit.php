<?php
require_once("../connection.php");
require_once("../validation.php");
if(isset($_POST['name'])){
    $validationStatus=validation(
        ['name','address','gender','dob','standard','phone','student_id'],$_POST);
    if(count($validationStatus)){
        $return= [
            "status"=>0,
            "data"=>"",
            "message"=>implode(',',$validationStatus)." Required"
        ];
        return print_r(json_encode($return));    
    }

    $sql = "UPDATE students set name=?,gender=?,phone=?,dob=?,address=?,standard=? where enroll_no=?";
    $conn->prepare($sql)->execute([$_POST['name'],$_POST['gender'],$_POST['phone'],date('Y-m-d',strtotime($_POST['dob'])),$_POST['address'],$_POST['standard'],$_POST['student_id']]);

    if(isset($_POST['password']) && $_POST['password']){
        $sql = "UPDATE users set password=? where user_id=?";
        $conn->prepare($sql)->execute([md5($_POST['password']),$_POST['student_id']]);
    }

    $return= [
        "status"=>1,
        "data"=>"",
        "message"=>"Updated successfully"
    ];
    return print_r(json_encode($return)); 

}
?>