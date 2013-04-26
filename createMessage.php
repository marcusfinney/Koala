<?php
session_start();
ob_start();

include 'config.php';

mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());


if ($_SESSION["userrecord"]["association"] == 1) //user is a doctor
{
	$iddoctor  = $_SESSION["userrecord"]["iddoctor"];
	$idpatient = $_SESSION["patientrecord"]["idpatient"];
}
else //user is a patient
{
	$iddoctor  = $_SESSION["patientrecord"]["iddoctor"];
	$idpatient = $_SESSION["patientrecord"]["idpatient"];
}

$authorname 		= $_SESSION["userrecord"]["firstname"] . " " . $_SESSION["userrecord"]["lastname"];
$authorid 			= $_SESSION["userrecord"]["association"];
$message			= $_POST["message"];

//inserting new message into database
$sql = "INSERT INTO Messages (iddoctor, idpatient, authorid, message, authorname)
        VALUES ($iddoctor, $idpatient, $authorid, '$message', '$authorname')";
$newrecord = mysql_query($sql);

//success or fail message
if($newrecord){
	header("location:messagePage.php?status=success");
}
else{
	header("location:messagePage.php?status=fail");
}

?>
