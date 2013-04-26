<?php
session_start();
ob_start(); 

if(!isset($_SESSION['username']))
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
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor Account | Well-Check Clinic</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" href="favicon.ico">
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
                <li><a href="accountDoctors.php">Select Patient</a></li>
                <li><a href="vitalm.php">Vitals</a></li>
                <li><a href="accountDoctors.php">Notes</a></li>
                <li class="active"><a href="messagePage.php">Messages</a></li>
                <li><a href="prescriptionPage.php">Prescriptions</a></li>
                <li><a href="editInfo.php">Edit Info</a></li>
            </ul>

            <div class="<?php if (!$_GET or isset($_GET["status"])) echo 'fadeIn ';?>tabcontent">
                <div class="row">
                    
                    <div class="span9 offset3">
                        <!-- <h4>Create A Prescription</h4> -->
                        <form class="form-horizontal" method="post" action="createMessage.php">

                            <div class="control-group">
                                <div class="controls">
                                    <h3>Create a Message</h3>
                                </div>
                            </div>

                             <div class="control-group">
                                <label class="control-label" for="message">Message</label>
                                <div class="controls">
                                    <textarea rows="20" cols="5" id="message" name="message"></textarea>
                                </div>
                            </div>
                            

                            <div class="control-group">
                                <div class="controls">
                                    <?php
                                        if (isset($_GET) and isset($_GET["error"]) and $_GET["error"] == "incompleteform") {
                                            echo '<p class="label label-important fadeIn">You must fill out all fields.</p><br>';
                                        }
                                    ?>
                                    <input class="btn btn-primary" type="submit" value="Send Message">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
