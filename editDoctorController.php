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
    if ($accountType == 3 and !$_POST)
    {
        header("Location: accountPatients.php?error=unauthorized");
        die();
    }
}

$iddoctor = $_SESSION["doctorrecord"]["iddoctor"];

// get new info
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$age = $_POST["age"];
$gender = $_POST["gender"];
$email = $_POST["email"];
$tele = $_POST["tele"];
$address = $_POST["address"];

$pass=(isset($_POST['password'])) ? $_POST['password'] : $_SESSION['password'];


// // make sure required fields aren't empty


// //connect to database
include 'config.php';
mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());

// // run SQL query to update Doctor record
//$sql = "";
//if ($_SESSION["userrecord"]["association"] == 0) {
    $sql = "UPDATE Doctors
            SET firstname='{$firstname}', lastname='{$lastname}',
                age={$age}, gender='{$gender}',
                email='{$email}', tele='{$tele}', address='{$address}', password='{$pass}'
            WHERE iddoctor={$iddoctor}";
//}

// // this is here just in case, but don't think it's possible for it to happen
$newrecord = mysql_query($sql);

if(!$newrecord) {
    header('location: editDoctor.php?status=failure');
    
}


// // updates current patient info in $_SESSION
$sql = "SELECT *
        FROM Doctors
        WHERE iddoctor={$iddoctor}";
$result = mysql_query($sql);
$doctor = mysql_fetch_assoc($result);

$_SESSION["doctorrecord"] = $doctor;

if ($_SESSION["userrecord"]["association"] == 3) {
    $_SESSION["userrecord"] = $doctor;
}

// // return with success status
header("location: accountAdmins.php?status=success");

?>