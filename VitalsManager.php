<!DOCTYPE html>

<?php
session_start();
ob_start(); 

if (!isset($_SESSION['username']))
{
    header("Location: index.php?error=unauthorized");
    die();
}
/*else
{
    $accountType = $_SESSION["userrecord"]["association"];
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
}*/

if $accountType = $_SESSION["userrecord"]["association"];
    if ($accountType == (3))
    {
            echo "<h1>{$_SESSION["userrecord"]["firstname"]} {$_SESSION["userrecord"]["lastname"]}</h1>";

            include 'config.php';
            mysql_connect($host, $user, $password) or die("cant connect");
            mysql_select_db($database) or die(mysql_error());

            $myID = $_SESSION["userrecord"]["idpatient"];

            $sql = "SELECT timeofday, timeanddate, heartrate, bloodsugar, bloodpressure, weight
                    FROM Vitals
                    WHERE idpatient={$myID}";
            $myVitals = mysql_query($sql);
            
            $dailyVitals = mysql_num_rows($myVitals);

            if ($dailyVitals == 0) {
                echo '<p>You have not entered any vitals yet.</p>';
            }
            else {
          			echo $myvitals;
            }
    }
  


?>

<html lang="en">
	<head>
		<title>Vitals Manager</title>
        <link rel="stylesheet" href="css/style.css">
	</head>
<body>
	 	<tr>
	 		<td>Gender:</td>
			<td><select name="gender">
 				<option value="">-Select-</option>
 				<option value="male">male</option>
 				<option value="female">female</option>
 			</select></td>
	 	</tr>
</body>
</html>