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
    if ($accountType == 1 )
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


$username = $_POST["username"];


include 'config.php';
mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());


$sql = "DELETE FROM Doctors WHERE username='{$username}'";
$newrecord = mysql_query($sql);

if ($newrecord)
{
    header('location: accountAdmins.php?status=deleted');
}else{
    header('location: accountAdmins.php?status=fail');
}



?>