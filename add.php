<?php
require_once("../connection.php");
require_once("../validation.php");
if(isset($_POST['name'])){


    //Required Validation
    $validationStatus=validation(
        ['name','email','username','password','address','gender','dob','standard','phone',
        'course','amount'],$_POST);
    if(count($validationStatus)){
        $return= [
            "status"=>0,
            "data"=>"",
            "message"=>implode(',',$validationStatus)." Required"
        ];
        return print_r(json_encode($return));    
    }


    //Username validation or email id validation
    $email=$_POST['email'];
    $query="select * from students where email='$email'";
    $stmt = $conn->query($query);
    $result = $stmt->rowCount();

    if($result>0){
        $return= [
            "status"=>0,
            "data"=>"",
            "message"=>"Email id already exist"
        ];
        return print_r(json_encode($return));    
        // return print_r($return);    
    }

    $username=$_POST['username'];
    $query="select * from users where username='$username'";
    $stmt = $conn->query($query);
    $result = $stmt->rowCount();

    if($result>0){
        $return= [
            "status"=>0,
            "data"=>"",
            "message"=>"Username already exist"
        ];
        return print_r(json_encode($return));    
        // return print_r($return);    
    }












    $empCount="select * from students order by enroll_no DESC limit 1";
    $stmt = $conn->query($empCount);
    $result = $stmt->fetch(); 
    
    $std_id="STUD00";
    if(!isset($result['enroll_no'])){
        $std_id.=1;
    }else{
        $std_id.=filter_var($result['enroll_no'],FILTER_SANITIZE_NUMBER_INT)+1;
    }
    //Student create
    $sql = "INSERT INTO students (enroll_no, name, gender,email,phone,dob,address,standard) VALUES (?,?,?,?,?,?,?,?)";
    $conn->prepare($sql)->execute([$std_id,$_POST['name'],$_POST['gender'],$_POST['email'],$_POST['phone'],date('Y-m-d',strtotime($_POST['dob'])),$_POST['address'],$_POST['standard']]);
    
    //Login create
    $sql1 = "INSERT INTO users (username,password,user_id,role) VALUES (?,?,?,?)";
    $conn->prepare($sql1)->execute([$_POST['username'],md5($_POST['password']),$std_id,'student']);

    //payment
    $sql1 = "INSERT INTO payments 
    (student_id,course_id,payment_date,total_amount,payment_method,status)
     VALUES (?,?,?,?,?,?)";
    $conn->prepare($sql1)->execute(
        [$std_id,$_POST['course'],date('Y-m-d'),$_POST['amount'],'Net Banking','Paid']);

    

    $return= [
        "status"=>1,
        "data"=>"",
        "message"=>"Added Successfully"
    ];
        return print_r(json_encode($return));    
    // return print_r($return);
}
$return= [
    "status"=>0,
    "data"=>"",
    "message"=>"Method not allowed"
];
        return print_r(json_encode($return));    

//return print_r($return);
?>