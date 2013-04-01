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
    if ($accountType == 3)
    {
        header("Location: accountPatients.php?error=unauthorized");
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Nurse Account | Well-Check Clinic</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/style.css">
	</head>
<body>
<h3>Account</h3>
Welcome back Nurse <?php echo $_SESSION["userrecord"]["firstname"];?> <?php echo $_SESSION["userrecord"]["lastname"];?>! <br>
<a href="logout.php">Logout</a>
<table>
 	<tr>		
	</tr>
</table>

<?php
    if ($_GET and $_GET["error"] == "unauthorized") {
       echo '<script>alert("You are not authorized to view that page.")</script>';
    }
?>
</body>
</html>
