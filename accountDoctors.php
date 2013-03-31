<!DOCTYPE html>

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
    if ($accountType == 2)
    {
        header("Location: accountNurses.php?error=unauthorized");
        die();
    }
    if ($accountType == 3)
    {
        header("Location: accountPatients.php?error=unauthorized");
        die();
    }
}
?>

<html lang="en">
    <head>
        <title>Doctor Account | Well-Check Clinic</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <?php
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
                        <input class="btn" type="submit" name="submit" value="Select Patient">
                      </form>';
            }
        ?>

        <p><a class="btn" href="register.php">Register a Patient</a></p>

        <p><a class="btn" href="logout.php">Logout</a></p>

        <?php
            if ($_GET and $_GET["error"] == "unauthorized") {
               echo '<script>alert("You are not authorized to view that page.")</script>';
            }
        ?>
    </body>
</html>
