<?php 
require('./db_connect.php');  
session_start();
  require 'php/functions.php';
  if(isset($_SESSION['isloggedin']) !== true){

    session_unset();
    session_destroy();
    header("Location: index.html");

  }
  function trim_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $res = '';
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['amount']) and  
        isset($_POST['bank_name']) and 
        isset($_POST['bank_address']) and
        isset($_POST['country']) and
        isset($_POST['account_name']) and
        isset($_POST['account_number']) and
        isset($_POST['transfer_details']) and
        isset($_POST['transfer_type']) and
        isset($_POST['short_code'])
        ) 
        {
            $amount = $_POST['amount'];
            $bank_name = $_POST['bank_name'];
            $bank_address = $_POST['bank_address'];
            $country = $_POST['country'];
            $account_name = $_POST['account_name'];
            $account_number = $_POST['account_number'];
            $transfer_details = $_POST['transfer_details'];
            $transfer_type = $_POST['transfer_type'];
            $short_code = $_POST['short_code'];

            if (empty($amount) || 
            empty($bank_name) || 
            empty($bank_address) || 
            empty($country) || 
            empty($account_name) || 
            empty($account_number) || 
            empty($transfer_details) || 
            empty($transfer_type) || 
            empty($short_code)) 
            {
            //user didn't send all that is required
                http_response_code(401);
                header("bad request: ensure all fiels are filled");
            }else{
            // user has successfully passed validation'
                $email = $_SESSION['email'];
                $amount = trim_input($amount);
                $bank_name = trim_input($bank_name);
                $bank_address = trim_input($bank_address);
                $country = trim_input($country);
                $account_name = trim_input($account_name); 
                $account_number = trim_input($account_number);
                $transfer_details = trim_input($transfer_details);
                $transfer_type = trim_input($transfer_type); 
                $short_code = trim_input($short_code); 
                $transaction_id = generate_transaction_id($dbconnect);
                
                $sql = "INSERT INTO transactionhistory (email,transaction_id,bankname,bankaddress,country,accountname,accountnumber,shortcode,amount,details,transfertype) 
                        VALUES ('$email','$transaction_id','$bank_name','$bank_address','$country','$account_name','$account_number','$short_code','$amount','$transfer_details','debit')";
                $result = mysqli_query($dbconnect,$sql);
                if ($result) {
                  $msg = 'success'; 
                  $res = true; 
                    
                }else{
                    echo json_encode(['msg'=>'server error']);
                }        
            }
            
    }else{
        echo 'not set';
    }

} 

?>