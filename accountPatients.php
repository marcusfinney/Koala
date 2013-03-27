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
Welcome back <?php echo $_SESSION["userrecord"]["firstname"];?> <?php echo $_SESSION["userrecord"]["lastname"];?>! <br>
<a href="logout.php">Logout</a>
<table>
	<tr>		
 		<td>Your doctor is 
 			<?php 
 			
 				$myiddoctor = $_SESSION["userrecord"]["iddoctor"];
 				session_start();

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
</body>
</html>
