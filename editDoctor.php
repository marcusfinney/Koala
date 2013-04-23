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
    if ($accountType != 0 )
    {
        header("Location: accountAdmins.php?error=noneselected");
        die();
    }

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
        <title>Edit Doctor Info | Well-Check Clinic</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" href="favicon.ico">
    </head>

    <body>
        <div class="container">
            <?php

                echo "<h1 class='pull-left'>Administrator</h1>";
            ?>
            <a href="logout.php"><h1 class="pull-right btn btn-inverse">Sign Out</h1></a>

            <!--
                need to create pages for all the tabs
                planning on making each page have the same 'top' section, just different content
            -->


            <ul class="clear nav nav-tabs">
                <li class="active"><a href="accountAdmins.php">Manage Doctor accounts</a></li>
                <!--<li><a href="accountAdmins.php">Add Nurse account</a></li>-->

            </ul>
            
              <div class="<?php if (!$_GET or isset($_GET["status"])) echo 'fadeIn ';?>tabcontent">
                <div class="row">

                    <div class="span9 offset3">
                        <!-- <h3><?php echo "{$_SESSION['doctorrecord']['lastname']}, {$_SESSION['doctorrecord']['firstname']}";?></h3> -->

                        <form class="form-horizontal" method="post" action="editDoctorController.php">

                            <!-- UPDATE  `Koala`.`Patients` SET  `email` =  'jose@email.com' WHERE  `Patients`.`idpatient` =14; -->
            
                             <?php
                                $p = $_SESSION["doctorrecord"];

                                include 'config.php';
                                mysql_connect($host, $user, $password) or die("cant connect");
                                mysql_select_db($database) or die(mysql_error());


                            ?>
            
                    <div class="span5">
                    

                            <div class="control-group">
                                <div class="controls">
                                    <h3>Edit Doctor info</h3>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="firstname">First Name</label>
                                <div class="controls">
                                    <input type="text" id="firstname" name="firstname" value=<?php echo $p["firstname"];?> required="required" autofocus>
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
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="address">Address</label>
                                <div class="controls">
                                    <textarea id="address" name="address"><?php echo $p["address"];?></textarea>

                                </div>
                            </div> 

                            <div class="control-group">
                                <label class="control-label" for="email">Email</label>
                                <div class="controls">
                                    <input type="email" id="email" name="email" value=<?php echo $p["email"];?> required="required">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="tele">Telephone</label>
                                <div class="controls">
                                    <input type="number" id="tele" name="tele" value=<?php echo $p["tele"];?> required="required">
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
                                    <input type="text" id="username" name="username" value=<?php echo $p["username"];?> disabled>
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
                                    <input type="password" id="password" name="password" value=<?php echo $p["password"];?> required="required">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="confirmpassword">Confirm Password</label>
                                <div class="controls">
                                    <input type="password" id="confirmpassword" name="confirmpassword" value=<?php echo $p["password"];?> required="required">
                                </div>
                            </div>

                               
                                
                               <div class="control-group">

                                    <div class="controls">
                                        <?php
                                            if (isset($_GET) and isset($_GET["error"]) and $_GET["error"] == "incompleteform") {
                                                echo '<p class="label label-important fadeIn">You must fill out all fields.</p><br>';
                                            }
                                        ?>
                                        <input class="btn btn-primary" type="submit" value="Edit Doctor information">
                                    </div>


                        </form>
                    </div>
                    
                    </div>
                    
                    
                    <form class="form-horizontal" method="post" action="accountAdmins.php">
                                                      <div class="controls">

                                        <input class="btn btn-primary" type="submit" value="Delete doctor account">
                                    </div>
                                </div>
                         </form>
                </div>
            </div>
        </div>
    </body>
</html>
