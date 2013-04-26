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
        <link rel="icon" href="favicon.ico">
	</head>

    <body>
        <div class="container">
            <?php
                echo "<h1 class='pull-left'>Nurse {$_SESSION["userrecord"]["firstname"]} {$_SESSION["userrecord"]["lastname"]}</h1>";
            ?>
            <a href="logout.php"><h1 class="pull-right btn btn-inverse">Sign Out</h1></a>

            <!--
                need to create pages for all the tabs
                planning on making each page have the same 'top' section, just different content
            -->

            <ul class="clear nav nav-tabs">
                <li class="active"><a href="accountNurses.php">Select Patient</a></li>
                <li><a href="vitalm.php">Vitals</a></li>
                <li><a href="notes.php">Notes</a></li>
                <li><a href="editInfo.php">Edit Info</a></li>
            </ul>

            <div class="<?php if (!$_GET or isset($_GET["status"])) echo 'fadeIn ';?>tabcontent">
                <div class="row">
                    <div class="span10 offset2">
                        <!-- <h4>Select a Patient</h4> -->
                        <?php
                            include 'config.php';
                            mysql_connect($host, $user, $password) or die("cant connect");
                            mysql_select_db($database) or die(mysql_error());

                            $myID = $_SESSION["userrecord"]["idnurse"];

                            $sql = "SELECT idpatient, firstname, lastname
                                    FROM Patients
                                    WHERE idnurse={$myID}";
                            $mypatients = mysql_query($sql);
                            
                            $numberofpatients = mysql_num_rows($mypatients);

                            if ($numberofpatients == 0) {
                                echo '<p>You have no registered patients.</p>';
                            }
                            else {
                                // ADD THE PAGE FOR VIEWING PATIENT DATA IN THE ACTION FIELD OF NEXT LINE

                                // Non-bootstrapped version
                                // echo '  <form>
                                //             <select name="Patients">';
                                // while ($row = mysql_fetch_assoc($mypatients)) {
                                //     echo  "     <option value={$row['idpatient']}>{$row['lastname']}, {$row['firstname']}</option>";
                                // }
                                // echo '      </select>
                                //             <br>
                                //             <input class="btn btn-primary" type="submit" value="Select Patient">
                                //         </form>';

                                // Bootstrapped version
                                echo '  <form class="form-horizontal" method="post" action="selectPatient.php">

                                            <div class="control-group">
                                                <div class="controls">
                                                    <h3>Select A Patient</h3>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <div class="controls">
                                                    <select name="Patient">';
                                while ($row = mysql_fetch_assoc($mypatients)) {
                                    echo  "             <option value={$row['idpatient']}>{$row['lastname']}, {$row['firstname']}</option>";
                                }
                                echo '              </select>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <div class="controls">
                                                    <input class="btn btn-primary" type="submit" value="Select Patient">
                                                </div>
                                            </div>

                                        </form>';
                            }
                        ?>
                    </div>

                </div>

            </div>

        </div>

        <?php
            if (isset($_GET))
            {
                if (isset($_GET["error"]) and $_GET["error"] == "unauthorized")
                {
                    echo '<script>alert("You are not authorized to view that page.")</script>';
                }
                if (isset($_GET["error"]) and $_GET["error"] == "noneselected")
                {
                    echo '<script>alert("You must select a patient.")</script>';
                }
            }
        ?>

    </body>
</html>
