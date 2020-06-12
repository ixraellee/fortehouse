<?php
$host = $username = $password = '';
$db = 'forteho1_registration';
if($_SERVER['HTTP_HOST'] == 'localhost'){
    $host = 'localhost';
    $username= 'root';
    $password = '';
}else{
    $host = 'localhost';
    $username= '';
    $password = '';
};

$dbconnect = mysqli_connect($host,$username,$password,$db);

if (!$dbconnect) {
    die('unable to establish connection');
}
?>