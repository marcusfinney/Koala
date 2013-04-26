<?php
session_start();
ob_start();

include 'config.php';

mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());


if ($_SESSION["userrecord"]["association"] == 1)
{
	$iddoctor  = $_SESSION["userrecord"]["iddoctor"];
	$idpatient = $_SESSION["patientrecord"]["idpatient"];
	$idnurse   = "-1";
}
else
{
	$iddoctor  = $_SESSION["patientrecord"]["iddoctor"];
	$idpatient = $_SESSION["patientrecord"]["idpatient"];
	$idnurse   = $_SESSION["userrecord"]["idnurse"];
}

$message			= $_POST["message"];

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