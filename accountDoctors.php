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
        <div class="container">
            <?php
                echo "<h1 class='pull-left'>Dr. {$_SESSION["userrecord"]["firstname"]} {$_SESSION["userrecord"]["lastname"]}</h1>";
            ?>
            <a href="logout.php"><h1 class="pull-right btn btn-inverse">Sign Out</h1></a>

            <!--
                need to create pages for all the tabs
                planning on making each page have the same 'top' section, just different content
            -->

            <ul class="clear nav nav-tabs">
                <li class="active"><a href="">Select Patient</a></li>
                <li><a href="">Vitals</a></li>
                <li><a href="">Notes</a></li>
                <li><a href="">Messages</a></li>
                <li><a href="">Prescriptions</a></li>
                <li><a href="">Edit Info</a></li>
            </ul>

            <div class="fadeIn tabcontent">
                <div class="row">
                    <div class="span6">
                        <!-- <h4>Select a Patient</h4> -->
                        <?php
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
                                echo '  <form class="form-horizontal" method="post">

                                            <div class="control-group">
                                                <div class="controls">
                                                    <h3>Select A Patient</h3>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <div class="controls">
                                                    <select name="Patients">';
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
                    <div class="span5">
                        <!-- <h4>Register a Patient</h4> -->
                        <form class="form-horizontal" method="post" action="createPatient.php">

                            <div class="control-group">
                                <div class="controls">
                                    <h3>Register A Patient</h3>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="firstname">First Name</label>
                                <div class="controls">
                                    <input type="text" id="firstname" name="firstname" autofocus>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="lastname">Last Name</label>
                                <div class="controls">
                                    <input type="text" id="lastname" name="lastname">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="age">Age</label>
                                <div class="controls">
                                    <input type="number" min="1" max="150" id="age" name="age">
                                    <!--
                                    <?php 
                                        echo "<select name='age'>";
                                        for ($i = 0; $i <= 150; $i++) {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                        echo "</select>"; 
                                    ?>
                                    -->
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="gender">Gender</label>
                                <div class="controls">
                                    <select id="gender" name="gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="email">Email</label>
                                <div class="controls">
                                    <input type="email" id="email" name="email">
                                </div>
                            </div>

                            <!-- <div class="control-group">
                                <label class="control-label" for="confirmemail">Confirm Email</label>
                                <div class="controls">
                                    <input type="email" id="confirmemail" name="confirmemail">
                                </div>
                            </div> -->

                            <div class="control-group">
                                <label class="control-label" for="username">Username</label>
                                <div class="controls">
                                    <?php
                                        if ($_GET and $_GET["error"] == "usernametaken") {
                                            echo '<p class="label label-warning">That username is taken.</p><br>';
                                        }
                                    ?>
                                    <input type="text" id="username" name="username">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="password">Password</label>
                                <div class="controls">
                                    <?php
                                        if ($_GET and $_GET["error"] == "passwordmismatch") {
                                            echo '<p class="label label-important">Passwords do not match.</p><br>';
                                        }
                                    ?>
                                    <input type="password" id="password" name="password">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="confirmpassword">Confirm Password</label>
                                <div class="controls">
                                    <input type="password" id="confirmpassword" name="confirmpassword">
                                </div>
                            </div>

                            <div class="control-group">
                                <div class="controls">
                                    <?php
                                        if ($_GET and $_GET["error"] == "incompleteform") {
                                            echo '<p class="label label-important">You must fill out all fields.</p><br>';
                                        }
                                    ?>
                                    <input class="btn btn-primary" type="submit" value="Register Patient">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>

        <?php
            if ($_GET and $_GET["status"] == "success") {
               echo '<script>alert("Patient successfully registered.")</script>';
            }
        ?>
        <?php
            if ($_GET and $_GET["error"] == "unauthorized") {
               echo '<script>alert("You are not authorized to view that page.")</script>';
            }
        ?>
    </body>
</html>
