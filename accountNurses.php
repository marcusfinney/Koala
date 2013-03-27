<?php
ob_start(); 
require_once("logincheck.php");
if (!isset($_SESSION['username']))
{
    header("Location: index.php");
    die();
    echo "<script type='text/javascript'>alert('Incorrect username/password');</script>";

}
?>
<html>
	<head>
		<title>Account</title>
	</head>
<body>
<h3>Account</h3>
Welcome back Nurse <?php echo $_SESSION["userrecord"]["firstname"];?> <?php echo $_SESSION["userrecord"]["lastname"];?>! <br>
<a href="logout.php">Logout</a>
<table>
 	<tr>		
	</tr>
</table>
</body>
</html>
