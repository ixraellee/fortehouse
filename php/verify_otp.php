<?php

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);

require('db_connect.php');
session_start();
$userid = $_SESSION['email'];
///echo json_encode([$userid]);

function trim_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  
  
$otp = $data->otp;
if (!empty($otp)){
    $otp = trim_input($otp);
    $sql = "SELECT * FROM users WHERE `email`='$userid' ";
    $result = mysqli_query($dbconnect,$sql);
    
    if($result){
        
        $row = mysqli_fetch_assoc($result);
        $dbotp = $row['otp'];
        if($otp == $dbotp){
            http_response_code(200);
            echo json_encode(['message'=> 'success']);
        }else{
           http_response_code(400);
        echo json_encode(['bad request, incorrect orp']); 
        }
    }else{
        http_response_code(401);
        echo json_encode(['unauthorized']); 
    }
}else{
    http_response_code(400);
    echo json_encode(['failed mf']);
}
//echo json_encode([]);




?>