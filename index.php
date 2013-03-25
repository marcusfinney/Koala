<html>
 	<head>
 		<title>Login</title>
 	<head>
 <body>

 <form method = "post" action = "checklogin.php">
 <table>
 	<tr>
 		<td>Association:</td>
 		<td><select name="association">
 				<option value="Admins">-Select-</option>
 				<option value="Doctors">Doctor</option>
 				<option value="Nurses">Nurse</option>
 				<option value="Patients">Patient</option>
 			</select></td>
 	</tr>
 	<tr>
		 <td>Username:</td>
		 <td><input type="text" name="username"></td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><input type="password" name="password"></td>
 	<tr>
 		<td><input type="submit" name="submit" value="Login"></td>
 </table>
</form>
</body>
</html>
