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
    if ($accountType != 4 and !$_POST)
    {
        header("Location: accountDoctors.php?error=unauthorized");
        die();
    }

}

include 'config.php';

mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());

$sql = "SELECT *
        FROM Doctors
        WHERE iddoctor=5";
$result = mysql_query($sql);
$doctor = mysql_fetch_assoc($result);

$_SESSION["doctorrecord"] = $doctor;

header("location: editDoctor.php");

?>