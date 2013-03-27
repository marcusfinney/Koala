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

$count=mysql_num_rows($result);

if($count > 0){
	$_SESSION["username"] = $myusername;
	$_SESSION["password"] = $mypassword;
	$_SESSION["userrecord"] = mysql_fetch_assoc($result);
	if($usertable == 'Doctors')
	{header("location:accountDoctors.php");}
	elseif($usertable == 'Nurses')
	{header("location:accountNurses.php");}
	elseif($usertable == 'Patients')
	{header("location:accountPatients.php");}
	else
	{header("location:accountAdmins.php");}}
elseif($count == 0)
{    
	echo "<script type='text/javascript'>alert('Incorrect username/password');</script>";
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';    

}
?>
<html>
	<head>
		<title></title>
	</head>
<body>
<br>
<!--Go back to <a href="index.php">login</a> page.-->
</body>
</html>