<?php
ob_start(); 

session_start();

include 'config.php';

mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());

$usertable=$_POST["association"];
$myusername=$_POST["username"];
$mypassword=$_POST["password"];


$sql="SELECT * FROM {$usertable} WHERE username='{$myusername}' AND password='{$mypassword}'";
$result=mysql_query($sql);

//$count=mysql_num_rows($result);

// if($count == 0)
// {
// 	//echo "Must login to view this page";
// }
// else
// {echo 'login success';}
?> 