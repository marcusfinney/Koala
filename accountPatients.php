<?php 
session_start();
ob_start(); 

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
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Patient Account | Well-Check Clinic</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" href="favicon.ico">
	</head>
<body>
<h3>Account</h3>
Welcome back <?php echo $_SESSION["userrecord"]["firstname"];?> <?php echo $_SESSION["userrecord"]["lastname"];?>! <br>
<a href="logout.php">Logout</a>
<table>
	<tr>		
 		<td>Your doctor is 
 			<?php 
 			
 				$myiddoctor = $_SESSION["userrecord"]["iddoctor"];

				include 'config.php';

				mysql_connect($host, $user, $password) or die("cant connect");
				mysql_select_db($database) or die(mysql_error());
				$usertable = 'Doctors';
				$sql="SELECT * FROM {$usertable} WHERE iddoctor='{$myiddoctor}'";
				$result=mysql_query($sql);

				$count=mysql_num_rows($result);
				if($count > 0){echo $_SESSION["userrecord"]["firstname"];}
?></td>
	</tr>
 	<tr>		
 		<td></td>
	</tr>
</table>
<?php
    if ($_GET and $_GET["error"] == "unauthorized") {
       echo '<script>alert("You are not authorized to view that page.")</script>';
    }
?>
</body>
</html>
