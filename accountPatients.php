<?php

require_once("logincheck.php");
?>
<html>
	<head>
		<title>Account</title>
	</head>
<body>
<h3>Account</h3>
Welcome back <?php echo $_SESSION["userrecord"]["firstname"];?> <?php echo $_SESSION["userrecord"]["lastname"];?>! <br>
<a href="logout.php">Logout</a>
<table>
	<tr>		
 		<td>Your doctor is </td>
	</tr>
 	<tr>		
 		<td></td>
	</tr>
</table>
</body>
</html>
