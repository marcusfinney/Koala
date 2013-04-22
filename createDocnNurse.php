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

//$iddoctor           = $_SESSION["userrecord"]["iddoctor"];
$firstname          = $_POST["firstname"];
$lastname           = $_POST["lastname"];
$age                = $_POST["age"];
$gender             = $_POST["gender"];
$address             = $_POST["address"];
$email              = $_POST["email"];
$tele              = $_POST["tele"];
$username           = $_POST["username"];
$ppassword           = $_POST["password"];
$confirmpassword    = $_POST["confirmpassword"];


if (!$firstname or !$lastname or !$age or !$email
    or !$username or !$ppassword or !$confirmpassword)
{
    header("location: accountDoctors.php?error=incompleteform");
    die();
}
// if ($email != $confirmemail)
// {
//     header("location: accountDoctors.php?error=emailmismatch");
//     die();
// }

if ($ppassword != $confirmpassword)
{
    header("location: accountDoctors.php?error=passwordmismatch");
    die();
}

include 'config.php';

mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());

$sql = "SELECT *
        FROM Doctors
        WHERE username='{$username}'";
$existingdoctor = mysql_query($sql);

if (mysql_num_rows($existingdoctor) == 1)
{
    header('location: accountDoctors.php?error=usernametaken');
    die();
}

$sql = "INSERT INTO Doctors (firstname, lastname, tele, address, age, gender, email, username, password, association)
        VALUES ('$firstname', '$lastname', $tele, '$address', $age, '$gender', '$email', '$username', '$ppassword', 1)";
$newrecord = mysql_query($sql);

if ($newrecord)
{
    header('location: accountAdmins.php?status=success');
    //echo '<META HTTP-EQUIV="Refresh" Content="0; URL=accountAdmins.php?status=success">';
}

        
// $sql = "INSERT INTO {$location} (iddoctor, username, password, email, firstname, lastname, age, gender, association) VALUES ('$myiddoctor','$myusername','$mypassword','$myemail','$myfirstname','$mylastname','$myage','$mygender', '$myassociation')";
// $result = mysql_query($sql);

// if ($result) 
// {
//     echo "<script>alert('You have successfully registered a new user.');</script>";
//     echo '<META HTTP-EQUIV="Refresh" Content="0; URL=accountDoctors.php">';    

// }

?>