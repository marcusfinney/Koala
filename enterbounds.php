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
    if ($accountType == 2)
    {
        header("Location: accountNurses.php?error=unauthorized");
        die();
    }
    if ($accountType == 3)
    {
        header("Location: accountPatients.php?error=unauthorized");
        die();
    }
}

$iddoctor = $_SESSION["userrecord"]["iddoctor"];
$idnurse = $_SESSION["patientrecord"]["idnurse"];
$idpatient = $_SESSION["patientrecord"]["idpatient"];
$HRmin = $_POST["HRmin"];
$HRmax = $_POST["HRmax"];
$BSmin = $_POST["BSmin"];
$BSmax = $_POST["BSmax"];
$BPmin = $_POST["BPmin"];
$BPmax = $_POST["BPmax"];
$Wmin = $_POST["Wmin"];
$Wmax = $_POST["Wmax"];

include 'config.php';

mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());

if (!$HRmin or !$HRmax or !$BSmin or !$BSmax
    or !$BPmin or !$BPmax or !$Wmin or !$Wmax or !$idpatient or !$iddoctor or !$idnurse)
{
    header("location: vitalm.php?error=incompleteform");
}
        
$sql = "INSERT INTO Bounds (iddoctor, idnurse, idpatient, HRmin, HRmax, BSmin, BSmax, BPmin, BPmax, Wmin, Wmax)
        VALUES ($iddoctor, $idnurse, $idpatient, '$HRmin', '$HRmax', '$BSmin', '$BSmax', '$BPmin', '$BPmax', '$Wmin', '$Wmax')";

$newbound = mysql_query($sql);
		
if ($newbound)
{header('location: vitalm.php?status=success');}
else
{header('location: vitalm.php?error=error');}
?>                       