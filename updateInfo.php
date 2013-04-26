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
    if ($accountType == 1 or $accountType == 2)
    {
        header("Location: accountDoctors.php?error=unauthorized");
        die();
    }
    // if ($accountType == 2 and !isset($_SESSION["patientrecord"]))
    // {
    //     header("Location: accountNurses.php?error=noneselected");
    //     die();
    // }
    // if ($accountType == 3)
    // {
    //     header("Location: accountPatients.php?error=unauthorized");
    //     die();
    // }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Update Account Info | Well-Check Clinic</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" href="favicon.ico">
    </head>

    <body>
        <div class="container">
            <?php
                echo "<h1 class='pull-left'>Welcome, {$_SESSION["userrecord"]["firstname"]} {$_SESSION["userrecord"]["lastname"]}</h1>";
            ?>
            <a href="logout.php"><h1 class="pull-right btn btn-inverse">Sign Out</h1></a>

            <!--
                need to create pages for all the tabs
                planning on making each page have the same 'top' section, just different content
            -->

            <ul class="clear nav nav-tabs">
                <li><a href="accountPatients.php">Vitals</a></li>
                <li><a href="messagePage.php">Messages</a></li>
                <li class="active"><a href="updateInfo.php">Update Info</a></li>
            </ul>

            <div class="<?php if (!$_GET or isset($_GET["status"])) echo 'fadeIn ';?>tabcontent">
                <div class="row">

                    <form class="form-horizontal" method="post" action="updateInfoController.php">
                        <div class="span6">

                            <?php
                                $p = $_SESSION["patientrecord"];

                                include 'config.php';
                                mysql_connect($host, $user, $password) or die("cant connect");
                                mysql_select_db($database) or die(mysql_error());

                                $sql = "SELECT idnurse, firstname, lastname
                                        FROM Nurses";
                                $nurses = mysql_query($sql);
                            ?>

                            <div class="control-group">
                                <div class="controls">
                                    <h3>Account Details</h3>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="firstname">First Name</label>
                                <div class="controls">
                                    <input type="text" id="firstname" name="firstname" value=<?php echo $p["firstname"];?> required="required">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="lastname">Last Name</label>
                                <div class="controls">
                                    <input type="text" id="lastname" name="lastname" value=<?php echo $p["lastname"];?> required="required">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="age">Age</label>
                                <div class="controls">
                                    <input type="number" min="1" max="150" id="age" name="age" value=<?php echo $p["age"];?> required="required">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="gender">Gender</label>
                                <div class="controls">
                                    <select id="gender" name="gender">
                                        <option value="male" <?php if ($p["gender"] == "male") echo 'selected="selected"';?> >Male</option>
                                        <option value="female" <?php if ($p["gender"] == "female") echo 'selected="selected"';?> >Female</option>
                                        <option value="other" <?php if ($p["gender"] == "other") echo 'selected="selected"';?> >Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="email">Email</label>
                                <div class="controls">
                                    <input type="email" id="email" name="email" value=<?php echo $p["email"];?> required="required">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="telephone">Phone Number</label>
                                <div class="controls">
                                    <input type="text" id="telephone" name="telephone" value=<?php echo $p["tele"];?> >
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="address">Address</label>
                                <div class="controls">
                                    <textarea id="address" name="address"><?php echo $p["address"];?></textarea>
                                </div>
                            </div>

                        </div>
                        
                        <div class="span5">

                            <div class="control-group">
                                <div class="controls">
                                    <h3>Change Password</h3>
                                    <?php
                                        if (isset($_GET) and isset($_GET["error"]) and $_GET["error"] == "incorrectpassword") {
                                            echo '<p class="label label-important fadeIn">Incorrect password.</p><br>';
                                        }
                                        if (isset($_GET) and isset($_GET["error"]) and $_GET["error"] == "passwordmismatch") {
                                            echo '<p class="label label-important fadeIn">Passwords do not match.</p><br>';
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="currentpassword">Current Password</label>
                                <div class="controls">
                                    <input type="password" id="currentpassword" name="currentpassword">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="newpassword">New Password</label>
                                <div class="controls">
                                    <input type="password" id="newpassword" name="newpassword">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="newpasswordconfirm">Re-type New Password</label>
                                <div class="controls">
                                    <input type="password" id="newpasswordconfirm" name="newpasswordconfirm">
                                </div>
                            </div>

                            <div class="control-group">
                                <div class="controls">
                                    <?php
                                        if (isset($_GET) and isset($_GET["error"]) and $_GET["error"] == "incompleteform") {
                                            echo '<p class="label label-important fadeIn">You must fill out all fields.</p><br>';
                                        }
                                    ?>
                                    <input class="btn btn-primary" type="submit" value="Save Changes">
                                </div>
                            </div>

                        </div>
                    </form>

                </div>

            </div>
        </div>

        <!--<?php
            if (isset($_GET))
            {
                if (isset($_GET["status"]) and $_GET["status"] == "success")
                {
                    echo '<script>alert("Account Infomation Successfully Updated")</script>';
                }
            }
        ?> -->

    </body>
</html>
