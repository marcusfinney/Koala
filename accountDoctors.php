<?php

require_once("logincheck.php");
?>
<html>
	<head>
		<title>Account</title>
	</head>
<body>
<h3>Account</h3>
<table>
 	<tr>		
 		<td>Welcome back Dr. <?php echo $_SESSION["userrecord"]["firstname"];?> <?php echo $_SESSION["userrecord"]["lastname"];?>!</td>
	</tr> 	
 	<tr>		
 		<td><a href="register.php"><button>Register a Patient</button></a></td>
	</tr>
 	<tr>		
 		<td><br><br><br><a href="logout.php">Logout</a></td>
	</tr>
</table>

</body>
</html>
