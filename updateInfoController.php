<?php
ob_start();
session_start();

if (!isset($_SESSION['username']))
{
    header("Location: index.php?error=unauthorized");
    die();
}
else
{
    $accountType = $_SESSION["userrecord"]["association"];
    if ($accountType == 1)
    {
        header("Location: accountDoctors.php?error=unauthorized");
        die();
    }
    if ($accountType == 2)
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

$idpatient = $_SESSION["patientrecord"]["idpatient"];

// get new info
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$age = $_POST["age"];
$gender = $_POST["gender"];
$email = $_POST["email"];
$telephone = $_POST["telephone"];
$address = $_POST["address"];

// echo '-';
// echo $_POST["currentpassword"];
// echo '-';
// echo $_POST["newpassword"];
// echo '-';
// echo $_POST["newpasswordconfirm"];
// echo '-';
// echo $_SESSION["patientrecord"]["password"];
// echo '-';

// if ($_POST["oldpassword"] == $_SESSION["patientrecord"]["password"])
//     echo 'ldjflsdjlfdsjf';

$changepassword = false;
if ($_POST["currentpassword"] != "" && $_POST["newpassword"] != "" && $_POST["newpasswordconfirm"] != "")
{
    echo 'test';
    if ($_POST["currentpassword"] != $_SESSION["patientrecord"]["password"]) {
        header('location: updateInfo.php?error=incorrectpassword');
        die();
    }
    if ($_POST["newpassword"] != $_POST["newpasswordconfirm"])
    {
        header('location: updateInfo.php?error=passwordmismatch');
        die();
    }
    else
        $changepassword = true;
}

// // make sure required fields aren't empty
if (!$firstname or !$lastname or !$age or !$gender or !$email)
{
    header('location: editInfo.php?error=requiredNotDone');
    die();
}

// //connect to database
include 'config.php';
mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());

// // run SQL query to update patient record
$sql = "";
if (!$changepassword)
{
    $sql = "UPDATE Patients
            SET firstname='{$firstname}', lastname='{$lastname}',
                age={$age}, gender='{$gender}',
                email='{$email}', tele='{$telephone}', address='{$address}'
            WHERE idpatient={$idpatient}";
}
else
{
    $sql = "UPDATE Patients
            SET firstname='{$firstname}', lastname='{$lastname}',
                age={$age}, gender='{$gender}',
                email='{$email}', tele='{$telephone}', address='{$address}',
                password='{$_POST["newpassword"]}'
            WHERE idpatient={$idpatient}";
}


$newrecord = mysql_query($sql);


// // updates current patient info in $_SESSION
$sql = "SELECT *
        FROM Patients
        WHERE idpatient={$idpatient}";
$result = mysql_query($sql);
$patient = mysql_fetch_assoc($result);

$_SESSION["patientrecord"] = $patient;

if ($_SESSION["userrecord"]["association"] == 3) {
    $_SESSION["userrecord"] = $patient;
}

// // return with success status
header("location: updateInfo.php?status=success");

?>