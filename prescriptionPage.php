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
                <li class="active"><a href="accountDoctors.php">Select Patient</a></li>
                <li><a href="vitalm.php">Vitals</a></li>
                <li><a href="accountDoctors.php">Notes</a></li>
                <li><a href="accountDoctors.php">Messages</a></li>
                <li><a href="prescriptionPage.php">Prescriptions</a></li>
                <li><a href="editInfo.php">Edit Info</a></li>
            </ul>

            <div class="<?php if (!$_GET or isset($_GET["status"])) echo 'fadeIn ';?>tabcontent">
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
                    <div class="span5">
                        <!-- <h4>Create A Prescription</h4> -->
                        <form class="form-horizontal" method="post" action="createPatient.php">

                            <div class="control-group">
                                <div class="controls">
                                    <h3>Create A Prescription</h3>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="presName">Prescription Name</label>
                                <div class="controls">
                                    <input type="text" id="presName" name="presName" required="required" autofocus>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="age">Quantity</label>
                                <div class="controls">
                                    <input type="number" min="1" max="999" id="age" name="age" required="required">
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
                                <label class="control-label" for="presQuantity">Refill Date</label>
                                <div class="controls">
                                    <input type="text" id="presRefill" name="presRefill" required="required">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="presApp">Application Instrution</label>
                                <div class="controls">
                                    <select id="presApp" name="presApp">
                                        <option value="0">Select Application method</option>
                                        <option value="1">Once a day</option>
                                        <option value="2">After every meal</option>
                                        <option value="3">Before sleep</option>
                                        <option value="4">As needed</option>
                                    </select>
                                </div>
                            </div>


                            <div class="control-group">
                                <div class="controls">
                                    <?php
                                        if (isset($_GET) and isset($_GET["error"]) and $_GET["error"] == "incompleteform") {
                                            echo '<p class="label label-important fadeIn">You must fill out all fields.</p><br>';
                                        }
                                    ?>
                                    <input class="btn btn-primary" type="submit" value="Submit Prescription">
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
                    echo '<script>alert("Prescription successfully created.")</script>';
                }
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
