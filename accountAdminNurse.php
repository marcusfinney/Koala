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
                echo "<h1 class='pull-left'> Administrator </h1>";
            ?>
            <a href="logout.php"><h1 class="pull-right btn btn-inverse">Sign Out</h1></a>

            <!--
                need to create pages for all the tabs
                planning on making each page have the same 'top' section, just different content
            -->

            
            <ul class="clear nav nav-tabs">
                <li ><a href="accountAdmins.php">Manage Doctor Accounts</a></li>
                <li class="active"><a href="accountAdminNurse.php">Manage Nurse Accounts</a></li>

            </ul>
            
            
                     <div class="<?php if (!$_GET or isset($_GET["status"])) echo 'fadeIn ';?>tabcontent">
                <div class="row">
                    <div class="span6">
                        <!-- <h4>Select a Patient</h4> -->
                        <?php
                            include 'config.php';
                            mysql_connect($host, $user, $password) or die("cant connect");
                            mysql_select_db($database) or die(mysql_error());

                            $myID = $_SESSION["userrecord"];

                            $sql = "SELECT idnurse, firstname, lastname
                                    FROM Nurses ";
                            $mynurses = mysql_query($sql);
                            
                            $numberofnurses = mysql_num_rows($mynurses);

                            if ($numberofnurses == 0) {
                                echo '<p>You have no registered nurses.</p>';
                            }
                            else {
                         
                                echo '  <form class="form-horizontal" method="post" action="selectNurse.php">

                                            <div class="control-group">
                                                <div class="controls">
                                                    <h3>Select A Nurse</h3>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <div class="controls">
                                                    <select name="Nurse">';
                                while ($row = mysql_fetch_assoc($mynurses)) {
                                    echo  "             <option value={$row['idnurse']}>{$row['lastname']}, {$row['firstname']}</option>";
                                }
                                echo '              </select>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <div class="controls">
                                                    <input class="btn btn-primary" type="submit" value="Select Nurse">
                                                </div>
                                            </div>

                                        </form>';
                            }
                        ?>
                    </div>

                    <div class="span5">
                        <!-- <h4>Register a Patient</h4> -->
                        <form class="form-horizontal" method="post" action="createNurse.php">

                            <div class="control-group">
                                <div class="controls">
                                    <h3>Register A Nurse</h3>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="firstname">First Name</label>
                                <div class="controls">
                                    <input type="text" id="firstname" name="firstname" required="required" autofocus>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="lastname">Last Name</label>
                                <div class="controls">
                                    <input type="text" id="lastname" name="lastname" required="required">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="age">Age</label>
                                <div class="controls">
                                    <input type="number" min="1" max="150" id="age" name="age" required="required">
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
                                <label class="control-label" for="address">Address</label>
                                <div class="controls">
                                    <input type="text" id="address" name="address"required="required">
                                </div>
                            </div> 

                            <div class="control-group">
                                <label class="control-label" for="email">Email</label>
                                <div class="controls">
                                    <input type="email" id="email" name="email" required="required">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="tele">Telephone</label>
                                <div class="controls">
                                    <input type="number" id="tele" name="tele"required="required">
                                </div>
                            </div> 

                            <div class="control-group">
                                <label class="control-label" for="username">Username</label>
                                <div class="controls">
                                    <?php
                                        if (isset($_GET) and isset($_GET["error"]) and $_GET["error"] == "usernametaken") {
                                            echo '<p class="label label-warning fadeIn">That username is taken.</p><br>';
                                        }
                                    ?>
                                    <input type="text" id="username" name="username" required="required">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="password">Password</label>
                                <div class="controls">
                                    <?php
                                        if (isset($_GET) and isset($_GET["error"]) and $_GET["error"] == "passwordmismatch") {
                                            echo '<p class="label label-important fadeIn">Passwords do not match.</p><br>';
                                        }
                                    ?>
                                    <input type="password" id="password" name="password" required="required">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="confirmpassword">Confirm Password</label>
                                <div class="controls">
                                    <input type="password" id="confirmpassword" name="confirmpassword" required="required">
                                </div>
                            </div>

                            <div class="control-group">
                                <div class="controls">
                                    <?php
                                        if (isset($_GET) and isset($_GET["error"]) and $_GET["error"] == "incompleteform") {
                                            echo '<p class="label label-important fadeIn">You must fill out all fields.</p><br>';
                                        }
                                    ?>
                                    <input class="btn btn-primary" type="submit" value="Register Nurse">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>

        <?php
            if (isset($_GET))
            {
                if (isset($_GET["status"]) and $_GET["status"] == "success")
                {
                    echo '<script>alert("Nurse successfully updated.")</script>';
                }
                if (isset($_GET["status"]) and $_GET["status"] == "deleted")
                {
                    echo '<script>alert("Nurse successfully deleted.")</script>';
                }
                if (isset($_GET["error"]) and $_GET["error"] == "unauthorized")
                {
                    echo '<script>alert("You are not authorized to view that page.")</script>';
                }

            }
        ?>
    </body>
</html>
