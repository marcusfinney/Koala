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

<!doctype html>
<html lang="en">
    <head>
        <title>Doctor Account | Well-Check Clinic</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <?php
            //session_start();
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
</html>
