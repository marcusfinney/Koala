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

$idpatient = $_SESSION["patientrecord"]["idpatient"];

// get new info
$idnurse = $_POST["idnurse"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$age = $_POST["age"];
$gender = $_POST["gender"];
$email = $_POST["email"];
$telephone = $_POST["telephone"];
$address = $_POST["address"];

// make sure required fields aren't empty
if (!$firstname or !$lastname or !$age or !$gender or !$email)
{
    header('location: editInfo.php?error=requiredNotDone');
    die();
}

//connect to database
include 'config.php';
mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());

// run SQL query to update patient record
$sql = "";
if ($_SESSION["userrecord"]["association"] == 1) {
    $sql = "UPDATE Patients
            SET idnurse={$idnurse},
                firstname='{$firstname}', lastname='{$lastname}',
                age={$age}, gender='{$gender}',
                email='{$email}', tele='{$telephone}', address='{$address}'
            WHERE idpatient={$idpatient}";
}
// don't update nurse if current user is a nurse
elseif ($_SESSION["userrecord"]["association"] == 2) {
    $sql = "UPDATE Patients
            SET firstname='{$firstname}', lastname='{$lastname}',
                age={$age}, gender='{$gender}',
                email='{$email}', tele='{$telephone}', address='{$address}'
            WHERE idpatient={$idpatient}";
}
// this is here just in case, but don't think it's possible for it to happen
else {
    location('location: editInfo.php?status=failure');
}
$newrecord = mysql_query($sql);


// updates current patient info in $_SESSION
$sql = "SELECT *
        FROM Patients
        WHERE idpatient={$idpatient}";
$result = mysql_query($sql);
$patient = mysql_fetch_assoc($result);

$_SESSION["patientrecord"] = $patient;


// return with success status
header("location: editInfo.php?status=success");

?>