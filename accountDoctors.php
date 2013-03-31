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
            <div class="fadeIn">
                <div>
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
                            // removed <form method="post" action=""> for now
                            echo '<select name="Patients">';
                            while ($row = mysql_fetch_assoc($mypatients)) {
                                echo  "<option value={$row['idpatient']}>{$row['lastname']}, {$row['firstname']}</option>";
                            }
                            echo '  </select>
                                    <input class="btn" type="submit" name="submit" value="Select Patient">';
                        }
                    ?>
                </div>
                <div>
                    <h3>Register a Patient</h3>
                    <form>
                        <label for="firstname">First Name</label>
                        <input type="text" id="firstname">

                        <label for="lastname">Last Name</label>
                        <input type="text" id="lastname">

                        <label for="age">Age</label>
                        <input type="number" min="0" max="150" id="age">
                        <!--
                        <?php 
                            echo "<select name='age'>";
                            for ($i = 0; $i <= 150; $i++) {
                                echo "<option value='$i'>$i</option>";
                            }
                            echo "</select>"; 
                        ?>
                        -->

                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>

                        <label for="email">Email</label>
                        <input type="email" id="email">

                        <label for="confirmemail">Confirm Email</label>
                        <input type="email" id="confirmemail">

                        <label for="username">Username</label>
                        <input type="text" id="username">

                        <label for="password">Password</label>
                        <input type="password" id="password">

                        <label for="confirmpassword">Confirm Password</label>
                        <input type="password" id="confirmpassword">

                        <br>
                        <input type="submit" value="Register">
                    </form>
                </div>
            </div>
        </div>

        <?php
            if ($_GET and $_GET["error"] == "unauthorized") {
               echo '<script>alert("You are not authorized to view that page.")</script>';
            }
        ?>
    </body>
</html>
