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
}

        header("Location: vitalm.php");

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Patient Account | Well-Check Clinic</title>
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
                <li class="active"><a href="accountPatients.php">Vitals</a></li>
                <!-- <li><a href="accountPatients.php">Notes</a></li> -->
                <li><a href="messagePage.php">Messages</a></li>
                <li><a href="updateInfo.php">Update Info</a></li>
            </ul>

            <div class="fadeIn tabcontent">

                <div class="row">

                    <div class="span12">
                        <p align="center">placeholder text</p>
                        <p align="center">placeholder text</p>
                        <p align="center">placeholder text</p>
                        <p align="center">placeholder text</p>
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
            }
        ?>
    </body>
</html>
