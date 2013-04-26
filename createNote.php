<?php
session_start();
ob_start();

include 'config.php';

mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());


if ($_SESSION["userrecord"]["association"] == 1) //if user is a doctor
{
	$iddoctor  = $_SESSION["userrecord"]["iddoctor"];
	$idpatient = $_SESSION["patientrecord"]["idpatient"];
	$idnurse   = "-1"; //if logged in as doctor, $idnurse is set to -1 to show the message was not created by a nurse
}
else //user is a nurse
{
	$iddoctor  = $_SESSION["patientrecord"]["iddoctor"];
	$idpatient = $_SESSION["patientrecord"]["idpatient"];
	$idnurse   = $_SESSION["userrecord"]["idnurse"];
}

$message			= $_POST["message"];

//insert note into database
$sql = "INSERT INTO Notes (iddoctor, idpatient, idnurse, note)
        VALUES ($iddoctor, $idpatient, $idnurse, '$message')";
$newrecord = mysql_query($sql);

//success or fail message
if($newrecord){
	header("location:notes.php?status=success");
}
else{
	header("location:notes.php?status=fail");
}

?>