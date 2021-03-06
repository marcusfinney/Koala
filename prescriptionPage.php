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
                <li><a href="accountDoctors.php">Select Patient</a></li>
                <li><a href="vitalm.php">Vitals</a></li>
                <li><a href="notes.php">Notes</a></li>
                <li><a href="messagePage.php">Messages</a></li>
                <li class="active"><a href="prescriptionPage.php">Prescriptions</a></li>
                <li><a href="editInfo.php">Edit Info</a></li>
            </ul>

            <div class="<?php if (!$_GET or isset($_GET["status"])) echo 'fadeIn ';?>tabcontent">
                <div class="row">
                    
                    <div class="span9 offset3">
                        <!-- <h4>Create A Prescription</h4> -->
                        <form class="form-horizontal" method="post" action="createPrescription.php">

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
                                    <input type="number" min="1" max="999" id="presQuantity" name="presQuantity" required="required">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="presQuantity">Refill Date</label>
                                <div class="controls">
                                    <input type="date" id="presRefill" name="presRefill" required="required">
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
                                <label class="control-label" for="presQuantity">Pharmacy</label>
                                <div class="controls">
                                	<input type="text" id="to" name="to" value=<?php echo $_SESSION["patientrecord"]["pharmacy"]; ?> >                                    
                                </div>
                            </div>                            


                            <div class="control-group">
                                <div class="controls">
                                    <?php
                                        if (isset($_GET) and isset($_GET["error"]) and $_GET["error"] == "incompleteform") {
                                            echo '<p class="label label-important fadeIn">You must fill out all fields.</p><br>';
                                        }
                                    ?>
                                    <input class="btn btn-primary" type="submit" value="Submit Prescription to Parmacy">
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
                if (isset($_GET["error"]) and $_GET["error"] == "nopharmacy")
                {
                	echo '<script>alert("You must set the email address associated to the patient in the edit info section.")</script>';
                }
            }
        ?>
    </body>
</html>
