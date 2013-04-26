<?php
session_start();

if (!isset($_SESSION['username']))
{
    header("Location: index.php?error=unauthorized");
    die();
}
else
{
    $accountType = $_SESSION["userrecord"]["association"];
    if ($accountType == 1 and !$_POST)
    {
        header("Location: accountDoctors.php?error=unauthorized");
        die();
    }
    if ($accountType == 2 and !$_POST)
    {
        header("Location: accountNurses.php?error=unauthorized");
        die();
    }

}

$iddoctor = $_SESSION["patientrecord"]["iddoctor"];
$idnurse = $_SESSION["patientrecord"]["idnurse"];
$idpatient = $_SESSION["patientrecord"]["idpatient"];
$timeofday = $_POST["timeofday"];
//$timeanddate = $_POST["timeanddate"];
$heartrate = $_POST["heartrate"];
$bloodsugar = $_POST["bloodsugar"];
$bloodpressure = $_POST["bloodpressure"];
$weight = $_POST["weight"];

include 'config.php';

mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());

if (!$iddoctor or !$idnurse or !$idpatient or !$timeofday
    or !$heartrate or !$bloodsugar or !$bloodpressure or !$weight)
{
    header("location: vitalm.php?error=incompleteform");
}
        
$sql = "INSERT INTO Vitals (iddoctor, idnurse, idpatient, timeofday, heartrate, bloodsugar, bloodpressure, weight)
        VALUES ($iddoctor, $idnurse, $idpatient, $timeofday, '$heartrate', '$bloodsugar', '$bloodpressure', '$weight')";

$newvital = mysql_query($sql);
		
if ($newvital)
{header('location: vitalm.php?status=success');}
else
{header('location: vitalm.php?error=error');}
?>                       
