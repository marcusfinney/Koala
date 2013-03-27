<?php

session_start();
include 'config.php';

mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());
if($_SESSION['userrecord']['association'] == (1 || 0))
{
	$myiddoctor = $_SESSION['userrecord']['iddoctor'];
if($_POST['submit'])
{
	$myusername = ($_POST['username']);
	$mypassword = ($_POST['password']);
	$myconfirmpassword = ($_POST['confirmpassword']);
	$myfirstname = ($_POST['firstname']);	
	$mylastname = ($_POST['lastname']);	
	$myemail = ($_POST['email']);	
	$myconfirmemail = ($_POST['confirmemail']);	
	$myage = ($_POST['age']);	
	$mygender = ($_POST['gender']);	
	$myassociation = ($_POST['association']);
	//makes sure all fields are filled in
	if((!$myusername)||(!$mypassword)||(!$myconfirmpassword)||
		(!$myfirstname)||(!$mylastname)||(!$myemail)||(!$myconfirmemail)||(!$myage)||(!$mygender)||(!$myassociation))
		{
			echo "<script>alert('Please fill in all of the fields.');</script>";
			exit;
		}
	//makes sure user email and passwords are correct
	if((!$mypassword)==($myconfirmpassword))
	{
		echo "<script>alert('Please confirm that your passwords match.');</script>";
		exit;
	}
	if((!$myemail)==($myconfirmemail))
	{
		echo "<script>alert('Please confirm that your emails match.');</script>";
		exit;
	}
	//makes sure user has made all selections
	if(($myassociation || $mygender) == "")
	{
		echo "<script>alert('Please make all selects.');</script>";
		exit;
	}
	if($myassociation == 2)
	{$location= 'Nurses';}
	if($myassociation == 3)
	{$location= 'Patients';}
	//checks for username or email already in system
	$mycheck = mysql_query("SELECT * FROM {$location} WHERE username='$myusername'");
	if(mysql_num_rows($mycheck) == 1)
	{
		echo "The username or email is already taken.";
		exit;
	}
	
	$sql = "INSERT INTO {$location} (iddoctor, username, password, email, firstname, lastname, age, gender, association) VALUES ('$myiddoctor','$myusername','$mypassword','$myemail','$myfirstname','$mylastname','$myage','$mygender', '$myassociation')";
	$result = mysql_query($sql);
	
	if ($result) 
	{
   		echo "<script>alert('You have successfully registered a new user.');</script>";
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=accountDoctors.php">';    

	}
}
}
else
{
    header("Location: index.php");
    die();
}
?>
<html>
	<head>
		<title>Register Your Account</title>
	</head>
<body>

<h3>Register</h3>
Go back to <a href="accountDoctors.php">account</a> page.<br><br>

Please fill in the following information please...
	 <form method = "post" action = "register.php">	
	 <table>
	 	<tr>
	 		<td>First Name:</td>
			<td><input type="text" name="firstname"></td>
	 	</tr>
	 	<tr>
	 		<td>Last Name:</td>
			<td><input type="text" name="lastname"></td>
	 	</tr>
	 	<tr>
	 		<td>Association:</td>
			<td><select name="association">
 				<option value="">-Select-</option>
 				<option value="3">Patient</option>
 			</select></td>
	 	</tr>	 
	 	<tr>
	 		<td>Age:</td>
			<td><?php $i=1;
					echo "<select name='age'>";
					while($i<=150){echo "<option value='$i'>$i</option>";
					$i++;} echo "</select>"; ?>
 			</select></td>
	 	</tr>	
	 	<tr>
	 		<td>Email:</td>
			<td><input type="text" name="email"></td>
	 	</tr>
	 	<tr>
	 		<td>Confirm Email:</td>
			<td><input type="text" name="confirmemail"></td>
	 	</tr>	 	
	 	<tr>
	 		<td>Username:</td>
	 		<td><input type="text" name="username"></td>
	 	</tr>
	 	<tr>
	 		<td>Password:</td>
	 		<td><input type="password" name="password"></td>
	 	</tr>
	 	<tr>
	 		<td>Confirm Password:</td>
			<td><input type="password" name="confirmpassword"></td>
	 	</tr>
	 	<tr>
	 		<td>Gender:</td>
			<td><select name="gender">
 				<option value="">-Select-</option>
 				<option value="male">male</option>
 				<option value="female">female</option>
 			</select></td>
	 	</tr>
	 	<tr>
	 		<td>Your patient's doctor ID is: <?php echo $_SESSION['userrecord']['iddoctor'];?></td>
	 	</tr>
		<tr>
			<td colspan="2"><input type="submit" name="submit" value="Register"></td>
	 	</tr>
</body>
</html>