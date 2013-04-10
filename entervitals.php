<?php
session_start();
include 'config.php';

mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());

$patientID = $_SESSION["patientrecord"]["idpatient"];
$location = 'Vitals';
$sql = "INSERT INTO {$location} (iddoctor, username, password, email, firstname, lastname, age, gender, association) VALUES ('$myiddoctor','$myusername','$mypassword','$myemail','$myfirstname','$mylastname','$myage','$mygender', '$myassociation')";
$result = mysql_query($sql);
		
if ($result) 
{
	echo "<script>alert('Vitals entered successfully');</script>";
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=vitalsm.php">';    
}
?>                       