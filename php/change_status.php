<?php

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);

require('db_connect.php');
session_start();
$userid =  $data->id;
$action = $data->action;

function trim_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $newStatus = '';
    //echo json_encode([$action]);
if ($action !== ''){
    if($action){
        $newStatus = 1;
        $verbal_status = 'active';
    }else{
        $newStatus = 0;
        $verbal_status = 'suspended';
    }
    $sql = "UPDATE users SET `admin`='$newStatus' WHERE `account_number`='$userid'";
    if(mysqli_query($dbconnect,$sql)){
        $sql = "SELECT * FROM users WHERE `account_number`='$userid'";
        if(mysqli_query($dbconnect,$sql)){
            $newStatus = mysqli_fetch_assoc(mysqli_query($dbconnect,$sql));
            echo json_encode(['message'=>'success','verbal_status'=>$verbal_status,'status'=>$newStatus['admin']]);
        }
    }else{
        http_response_code(400);
        echo json_encode(['message'=>'failed']);
    }
}else{
   http_response_code(400);
     
}




?>