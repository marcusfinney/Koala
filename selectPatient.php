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
    if ($accountType == 3)
    {
        header("Location: accountPatients.php?error=unauthorized");
        die();
    }
}

include 'config.php';

mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());

$sql = "SELECT *
        FROM Patients
        WHERE idpatient={$_POST['Patient']}";
$result = mysql_query($sql);
$patient = mysql_fetch_assoc($result);

$_SESSION["patientrecord"] = $patient;

header("location: editInfo.php");

?>