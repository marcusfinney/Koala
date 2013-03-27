<?php 
session_start();
ob_start(); 

if (!isset($_SESSION['username']))
{
    header("Location: index.php?error=unauthorized");
    die();
}
else
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
