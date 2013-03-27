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
=======
<!doctype html>
<html lang="en">
    <head>
        <title>Doctor Account | Well-Check Clinic</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <?php
            session_start();
            echo "<h1>Dr. {$_SESSION["userrecord"]["firstname"]} {$_SESSION["userrecord"]["lastname"]}</h1>";

            include 'config.php';
            mysql_connect($host, $user, $password) or die("cant connect");
            mysql_select_db($database) or die(mysql_error());

            $myID = $_SESSION["userrecord"]["iddoctor"];

            $sql = "SELECT idpatient, firstname, lastname
                    FROM Patients
                    WHERE iddoctor={$myID}";
            $mypatients = mysql_query($sql);
            
            $numberofpatients = mysql_num_rows($mypatients);

            if ($numberofpatients == 0) {
                echo '<p>You have no registered patients.</p>';
            }
            else {
                // ADD THE PAGE FOR VIEWING PATIENT DATA IN THE ACTION FIELD OF NEXT LINE
                echo '<form method="post" action="">
                        <select name="Patients">';
                while ($row = mysql_fetch_assoc($mypatients)) {
                    echo  "<option value={$row['idpatient']}>{$row['lastname']}, {$row['firstname']}</option>";
                }
                echo '  </select>
                        <input type="submit" name="submit" value="Select Patient">
                      </form>';
            }
        ?>

        <p><a href="register.php"><button>Register a Patient</button></a></p>

        <p><a href="logout.php"><button>Logout</button></a></p>

    </body>
>>>>>>> ff0ff5e226a36b97f5cb2080d345635fea8581cc
</html>
