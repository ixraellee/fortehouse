<?php
require('./db_connect.php');

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE `account_number` = '$id'";
$result = mysqli_query($dbconnect,$sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $path = $row['picture'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    
    header("content-type: image/$ext");
    echo $path;
}


?>