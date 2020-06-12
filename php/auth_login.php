<?php 
$userid = mysqli_real_escape_string($dbconnect, $_POST["userid"]);
$result = $dbconnect->query("SELECT * FROM users where `nickname` = '$userid'");

    if($result -> num_rows == 0){
        //check if user exist
        $echo = "User is missing from record";
    }
    else{
        //user exist
        $user = $result->fetch_assoc();
        $password = mysqli_real_escape_string($dbconnect, $_POST["password"]);
        
        $passindb = trim($user['hashed_password']);
        $email = trim($user['email']);

        if(password_verify($password,$passindb)){
            $_SESSION['user_id'] = $_POST["userid"];
            $_SESSION['email'] = $email;
            $_SESSION['status'] = $user['status'];
            $_SESSION['is_admin'] = $user['admin'];
            $_SESSION['account_number'] = $user['account_number'];
            $_SESSION['account_balance'] = $user['account_balance'];
            $_SESSION['isloggedin'] = true;

            if ($_SESSION['status'] !== 'active') {
                $echo = "account has been suspended contact admin";
            }
                header("location:apps_bank_itransfer.php");
        }else{
            $echo = "Incorrect username or password";
        }
    }

?>