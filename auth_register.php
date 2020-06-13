<?php
require('./php/db_connect.php');
session_start();
require 'php/functions.php';
  $error = null;
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (!empty($_POST['userid']) and !empty($_POST['email']) and !empty($_FILES["picture"]["name"]) and !empty($_POST['firstname']) and !empty($_POST['lastname'])) {
      $userid =test_input($_POST['userid']);
      $email = test_input($_POST['email']);
      $firstname = test_input($_POST['firstname']);
      $lastname = test_input($_POST['lastname']);

      $picture = $_FILES["picture"]["name"];
      $imgContent = '';
      $targetDir =  "uploads/";
      $fileName = basename($picture); 
      $targetFilePath = $targetDir.$fileName;
      $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

      $allowTypes = array('jpg','png','jpeg','gif'); 
       //validate image type
      if(in_array($fileType, $allowTypes)){ 
          $image = $_FILES['picture']['tmp_name']; 
          //$img_data = file_get_contents($image);
      }else{ 
        $error = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
        exit('Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'); 
      }

      
      $verify_email_sql = "SELECT * FROM users WHERE `email`='$email'";
      $userExists = mysqli_query($dbconnect,$verify_email_sql);
      
      if (mysqli_num_rows($userExists)  !== 0 ) {
        echo "Email $email already exists";
      }else{
        
        $pass = rand(0,100).$userid;
        $hashpass = password_hash($pass, PASSWORD_DEFAULT);
        $account_number = generate_account_number($dbconnect);

        //move uploaded file
        if(move_uploaded_file($image,$targetFilePath)){
          echo $targetFilePath;
        }else{
          die('error uploading file');
        };
        $sql = "INSERT INTO 
        users(
          nickname,
          email,
          firstname,
          lastname,
          account_number,
          picture_name,
          hashed_password) 
        VALUES( 
        '$userid',
        '$email',
        '$firstname',
        '$lastname',
        '$account_number',
        '$fileName',
        '$hashpass')";  
        
        //$sql = "INSERT INTO users(picture) VALUES('$img_data')";
        if ($dbconnect->query($sql)) {
          $row= [
            'user_id' => $userid,
            'email' => $email,
            'firstname' => $lastname,
            'lastname' => $lastname,
            'account_number' => $account_number,
            'password' => $pass
          ];
          // Send verification mail
          send_mail($row);
          // $to = $email;
          // $subject = "Email Verification for $uname"; 
          // $message = "<p>Your password is $pass</p>";
          // $headers = "From:arnoldekechi1998@gmail.com\r\n";
          // $headers .= "MIME-Version: 1.0" . "\r\n";
          // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

          // mail($to,$subject,$message,$headers);
            
          // header('location:emails_activate.php');
          // echo 'passed';
        }else{
          echo mysqli_error($dbconnect);
        }
      }
    }else{
      $error = "All fields are required";
    } 
  }
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }
    function generate_account_number ($db){
      $init = rand(10000000,999999999);
      $account_number_sql = "SELECT * FROM users WHERE `account_number`='$init'";
      $res = mysqli_query($db,$account_number_sql);
    
      if( mysqli_num_rows($res) > 0 ){
        generate_account_number();
      }else{
        return $init;
      }
      
    };
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Merchant Registration| FHC-Internet Banking</title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="template language" name="keywords">
    <meta content="Tamerlan Soziev" name="author">
    <meta content="Admin dashboard html template" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="favicon.png" rel="shortcut icon">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <link href="bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="bower_components/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
    <link href="bower_components/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css/" rel="stylesheet">
    
    <link href="css/main.css?version=4.4.0" rel="stylesheet">
 
  </head>

  
  <body>
    <div class="all-wrapper menu-side with-pattern">
      <div class="auth-box-w wider">
        <div class="logo-w">
          <a href="index.html"><img alt="" src="img/logo-big.png"></a>
        </div>
        <h4 class="auth-header">
          Merchant Registration
        </h4>
        <form name="registration_form" class= "form-control form-signin"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" >
		<!-- Display validation errors-->
		<div class="form-group">
            <label for="">Nickname</label><input class="form-control" placeholder="Enter username" id="userid" name="userid" type="text"value="" required>
            <div class="pre-icon os-icon os-icon-user-male-circle"></div>
            
          </div>
          <div class="form-group">
            <label for=""> Email address</label><input class="form-control" placeholder="Enter email" id="email" name="email" type="email" value="" required>
            <div class="pre-icon os-icon os-icon-email-2-at2"></div>
          </div>
          <div class="form-group">
            <label for=""> Profile Picture</label><input class="form-control" name="picture" data-error="Your picture is required" placeholder="Profile Picture" required="required" type="file">
            <div class="help-block form-text with-errors form-control-feedback"></div>
          </div>		 
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for=""> First Name</label><input class="form-control" placeholder="Enter First Name" name="firstname" id="password" type="text" id="inputpassword" required>
                <div class="pre-icon os-icon os-icon-fingerprint"></div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group"> 
                <label for=""> Last Name</label><input class="form-control" placeholder="Enter Last Name" name="lastname" id="cpassword" type="text" id="confirmpassword" required>
              </div>
            </div>
          </div>
          <div class="buttons-w">
            <button class="btn btn-primary" name="register" type="submit">Register Now</button> 
          <p> Member?  <a href="auth_admin_login.php"> Log in </a></p>
      
          <p id="err-class"><?php echo $error?></p>
          </div>
        </form>
      </div>
    </div>
  </body>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"> 
    </script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js">
    </script>

</html>
