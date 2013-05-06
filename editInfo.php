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
    if ($accountType == 1 and !isset($_SESSION["patientrecord"]))
    {
        header("Location: accountDoctors.php?error=noneselected");
        die();
    }
    if ($accountType == 2 and !isset($_SESSION["patientrecord"]))
    {
        header("Location: accountNurses.php?error=noneselected");
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
        <title>Edit Patient Info | Well-Check Clinic</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" href="favicon.ico">
    </head>

    <body>
        <div class="container">
            <?php
                $title = "";
                if ($accountType == 1) $title = "Dr.";
                if ($accountType == 2) $title = "Nurse";
                echo "<h1 class='pull-left'>{$title} {$_SESSION["userrecord"]["firstname"]} {$_SESSION["userrecord"]["lastname"]}</h1>";
            ?>
            <a href="logout.php"><h1 class="pull-right btn btn-inverse">Sign Out</h1></a>

            <!--
                need to create pages for all the tabs
                planning on making each page have the same 'top' section, just different content
            -->

            <ul class="clear nav nav-tabs">
                <li><a href="account<?php echo $_SESSION["accountType"];?>.php">Select Patient</a></li>
                <li><a href="vitalm.php">Vitals</a></li>
                <li><a href="notes.php">Notes</a></li>
                <?php if ($accountType != 2) echo '<li><a href="messagePage.php">Messages</a></li>'; ?>
                <?php if ($accountType == 1) echo '<li><a href="prescriptionPage.php">Prescriptions</a></li>'; ?>
                <li class="active"><a href="editInfo.php">Edit Info</a></li>
            </ul>

            <div class="<?php if (!$_GET or isset($_GET["status"])) echo 'fadeIn ';?>tabcontent">
                <div class="row">

                    <div class="span9 offset3">
                        <!-- <h3><?php echo "{$_SESSION['patientrecord']['lastname']}, {$_SESSION['patientrecord']['firstname']}";?></h3> -->

                        <form class="form-horizontal" method="post" action="editInfoController.php">

                            <!-- UPDATE  `Koala`.`Patients` SET  `email` =  'jose@email.com' WHERE  `Patients`.`idpatient` =14; -->

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
                                    <h3><?php echo "{$_SESSION['patientrecord']['lastname']}, {$_SESSION['patientrecord']['firstname']}";?></h3>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="idnurse">Assigned Nurse</label>
                                <div class="controls">
                                    <select id="idnurse" name="idnurse"<?php if ($accountType == 2 or $accountType == 3) echo ' disabled';?>>
                                        <option value="0">None Selected</option>
                                        <?php
                                            while ($nurse = mysql_fetch_assoc($nurses))
                                            {
                                                $selected = '';
                                                if ($nurse['idnurse'] == $p['idnurse']) $selected = ' selected="selected"';
                                                echo "<option value={$nurse['idnurse']}{$selected}>{$nurse['lastname']}, {$nurse['firstname']}</option>";
                                            }
                                        ?>
                                    </select>
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
                                <label class="control-label" for="email">Pharmacy</label>
                                <div class="controls">
                                    <input type="email" id="pharmacy" name="pharmacy" value='<?php echo $p["pharmacy"];?>' required="required">
                                </div>
                            </div>                            

                            <!-- <div class="control-group">
                                <label class="control-label" for="confirmemail">Confirm Email</label>
                                <div class="controls">
                                    <input type="email" id="confirmemail" name="confirmemail">
                                </div>
                            </div> -->

                            <div class="control-group">
                                <label class="control-label" for="telephone">Phone Number</label>
                                <div class="controls">
                                    <input type="text" id="telephone" name="telephone" value=<?php echo $p["tele"];?> >
                                </div>
                            </div>

                            <!-- <div class="control-group">
                                <label class="control-label" for="password">Password</label>
                                <div class="controls">
                                    <?php
                                        if (isset($_GET) and isset($_GET["error"]) and $_GET["error"] == "passwordmismatch") {
                                            echo '<p class="label label-important fadeIn">Passwords do not match.</p><br>';
                                        }
                                    ?>
                                    <input type="password" id="password" name="password">
                                </div>
                            </div> -->

                            <div class="control-group">
                                <label class="control-label" for="address">Address</label>
                                <div class="controls">
                                    <!-- <input type="text" id="address" name="address"> -->
                                    <textarea id="address" name="address"><?php echo $p["address"];?></textarea>
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

                        </form>

                    </div>

                </div>

            </div>
        </div>

    </body>
</html>
