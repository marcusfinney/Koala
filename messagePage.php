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
    if ($accountType == 1 and !isset($_SESSION["patientrecord"]))
    {
        header("Location: accountDoctors.php?error=noneselected");
        die();
    }
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
                $title = "";
                if ($accountType == 1) $title = "Dr.";
                if ($accountType == 3) $title = "Welcome,";
                echo "<h1 class='pull-left'>{$title} {$_SESSION["userrecord"]["firstname"]} {$_SESSION["userrecord"]["lastname"]}</h1>";
            ?>
            <a href="logout.php"><h1 class="pull-right btn btn-inverse">Sign Out</h1></a>

            <ul class="clear nav nav-tabs">
                <?php if ($accountType == 1) echo '<li><a href="accountDoctors.php">Select Patient</a></li>'; ?>
                <li><a href="vitalm.php">Vitals</a></li>
                <?php if ($accountType != 3) echo '<li><a href="notes.php">Notes</a></li>'; ?>
                <li class="active"><a href="messagePage.php">Messages</a></li>
                <?php if ($accountType == 1) echo '<li><a href="prescriptionPage.php">Prescriptions</a></li>'; ?>
                <?php if ($accountType != 3) echo '<li><a href="editInfo.php">Edit Info</a></li>';
                      else                   echo '<li><a href="updateInfo.php">Update Info</a></li>'; ?>
            </ul>

            <div class="<?php if (!$_GET or isset($_GET["status"])) echo 'fadeIn ';?>tabcontent">
                <div class="row">
                    
                    <div class="span5 offset1">
                        <br><br><br>
                        <table class="table table-striped message-table">
                        <?php
                            include 'config.php';
                            mysql_connect($host, $user, $password) or die("cant connect");
                            mysql_select_db($database) or die(mysql_error());

                            $doctorid = $_SESSION["userrecord"]["iddoctor"];
                            $patientid = $_SESSION["patientrecord"]["idpatient"];
            
                            $sql = "SELECT * 
                                    FROM  Messages
                                    WHERE iddoctor={$doctorid} AND  idpatient={$patientid}
                                    ORDER BY dateandtime ASC";
            
                            $mymessages = mysql_query($sql)or die('Invalid query: ' .mysql_error());
            
                            $numberofmessages = mysql_num_rows($mymessages);

                            if ($numberofmessages == 0) 
                            {
                                echo 'No Messages.';
                            }
                            else
                            {
                            //set up with arrays so database prints in reverse(most recent) 
                            $messagecount = 0;
                            while ($row = mysql_fetch_assoc($mymessages)) 
                            {
                            $dateandtime = $row['dateandtime'];

                            if($row['authorid'] == 1){
                                $author = "Dr." . $row['authorname'];
                            }
                            else{
                                $author = $row['authorname'];
                            }

                            $message = $row['message'];
                        
                            $messagereport[$messagecount] = "<tr>
                                                            <td>{$dateandtime}</td>
                                                            <td>From: {$author}</td>
                                                            <td>{$message}</td>
                                                            </tr>";
                                                            
                            $messagecount++;
                            } 
                            $i=$messagecount-1;   
                            $m=$messagecount-1;
                            while($i>=0)
                                {
                                print $messagereport[$i];
                                $i--;
                                }
                            }
                        ?> 
                        <tr></tr>
                    </table>

                    </div>
                    <div class="span5">
                        <!-- <h4>Create A Prescription</h4> -->
                        <form class="form-horizontal" method="post" action="createMessage.php">

                            <div class="control-group">
                                <div class="controls">
                                    <br><br>
                                    <h3>Create a Message</h3>
                                </div>
                            </div>

                             <div class="control-group">
                                <label class="control-label" for="message"></label>
                                <div class="controls">
                                    <textarea rows="10" cols="10" id="message" name="message"></textarea>
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
