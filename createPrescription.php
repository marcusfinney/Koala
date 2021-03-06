<?php

session_start();
ob_start();

if(!isset($_SESSION['username']))
{
    header("Location: index.php?error=unauthorized");
    die();
}
else
{
    $accountType = $_SESSION["userrecord"]["association"];
    if ($accountType == 1 and !$_POST)
    {
        header("Location: prescriptionPage.php?error=unauthorized");
        die();
    }
    if ($accountType == 2)
    {
        header("Location: prescriptionPage.php?error=unauthorized");
        die();
    }
    if ($accountType == 3)
    {
        header("Location: prescriptionPage.php?error=unauthorized");
        die();
    }
}

$iddoctor			= $_SESSION["userrecord"]["iddoctor"];
$to					= $_POST["to"];
$presName			= $_POST["presName"];
$presQuantity		= $_POST["presQuantity"];
$presRefill			= $_POST["presRefill"];
$presApp			= $_POST["presApp"];


if (!$presName or !$presQuantity or !$presRefill or $presApp == 0)
{
    header("location: prescriptionPage.php?error=incompleteform");
    die();
}
if($to == 'none')
{
	header("location: prescriptionPage.php?error=nopharmacy");
	die();
}
if($presApp == 1) {
	$presApp = "Once A Day";
}
else{
	if($presApp == 2){
		$presApp = "After Every Meal";
	}
	else{
		if($presApp == 3){
			$presApp = "Before Sleep";
		}
		else{
			$presApp = "As Needed";
		}
	}
}

/*$sql = "INSERT INTO Prescriptions (presName, presQuantity, presRefill, presApp)
        VALUES ('$presName', $presQuantity, '$presRefill', '$presApp')";
$newrecord = mysql_query($sql); */


$subject = "Prescription request";
$message = "Prescription Name: " . $presName . "\n" .
			"Patient Name: " . $_SESSION["patientrecord"]["firstname"] . " " . $_SESSION["patientrecord"]["lastname"] . "\n" .
		   "Prescription Quantity: " . $presQuantity . "\n" .
		   "Prescription Application: " . $presApp . "\n" . 
		   "Prescription Refill Date: " . $presRefill;
$from = $_SESSION["userrecord"]["email"];
echo $from;
echo $message;
$headers = "From: " . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";

// Success status
if(mail)
header("location: prescriptionPage.php?status=success");
else
header("location: prescriptionPage.php?status=error");

?>