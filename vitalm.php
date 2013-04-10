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
        <title>Vitals Manager | Well-Check Clinic</title>
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
            <ul class="clear nav nav-tabs">
                <li><a href="account<?php echo $_SESSION["accountType"];?>.php">Select Patient</a></li>
                <li class="active"><a href="vitalm.php">Vitals</a></li>
                <li><a href="account<?php echo $_SESSION["accountType"];?>.php">Notes</a></li>
                <li><a href="account<?php echo $_SESSION["accountType"];?>.php">Messages</a></li>
                <li><a href="account<?php echo $_SESSION["accountType"];?>.php">Prescriptions</a></li>
                <li class="active"><a href="editInfo.php">Edit Info</a></li>
            </ul>

            <div class="<?php if (!$_GET or isset($_GET["status"])) echo 'fadeIn ';?>tabcontent">
                <div class="row">
                    <div class="span9 offset3">
                        <!-- <h3><?php echo "{$_SESSION['patientrecord']['lastname']}, {$_SESSION['patientrecord']['firstname']}";?></h3> -->
                        <form class="form-horizontal" method="post" action="">
                            <?php
                                $p = $_SESSION["patientrecord"];
								$patientID = $_SESSION["patientrecord"]["idpatient"];
								
                                include 'config.php';
                                mysql_connect($host, $user, $password) or die("cant connect");
                                mysql_select_db($database) or die(mysql_error());

								$sql = "SELECT timeofday, timeanddate, heartrate, bloodsugar, bloodpressure, weight
        						FROM Vitals
    							WHERE idpatient={$patientID}";
    							
                                $numberofvitals = mysql_query($sql);
                                
                                if ($numberofpatients == 0) {
                                echo '<p>No vitals currently entered.</p>';}
                              	else
                              	{
                              		while($numberofpatients = mysql_fetch_assoc($numberofpatients))
                              		{echo $numberofpatients['heartrate'];
                            ?>
                            <div class="control-group">
                                <div class="controls">
                                    <h3><?php echo "{$_SESSION['patientrecord']['lastname']}, {$_SESSION['patientrecord']['firstname']}";?></h3>
                                </div>
                            </div>

							//to select from the table 
                           <php? /*<div class="control-group">
                                <label class="control-label" for="idnurse">Assigned Nurse</label>
                                <div class="controls">
                                    <select id="idnurse">
                                        <option>None Selected</option>
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
                            </div>*/ ?>
                            <div class="control-group">
                            	<label class="timeanddate" for="timeanddate">Date</label>
                            	<div class="controls">
                            		<input id="timeanddate" name="timeanddate">
									<script type="text/javascript">
									  document.getElementById('timeanddate').value = Date();
									</script>
								</div>
							</div>	
                            <div class="control-group">
                                <label class="control-label" for="timeofday">Time of Day</label>
                                <div class="controls">
									<select name="timeofday">
 										<option value="">-Select-</option>
 										<option value="0">Morning</option>
 										<option value="1">Afternoon</option>
 										<option value="2">Evening</option>
 									</select>                             
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="heartrate">Heart Rate</label>
                                <div class="controls">
                                    <input type="text" id="heartrate" name="heartrate"><php? echo 'bpm';?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="bloodsugar">Blood Sugar</label>
                                <div class="controls">
                                    <input type="text" id="bloodsugar" name="bloodsugar"><php? echo 'mg/dl';?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="bloodpressure">Blood Pressure</label>
                                <div class="controls">
                                    <input type="text" id="bloodpressure" name="bloodpressure"><php? echo ' mmHg';?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="weight">Weight</label>
                                <div class="controls">
                                    <input type="text" id="weight" name="weight"><php? echo 'kg';?>
                                </div>
                            </div>
                            /*<div class="control-group">
                                <label class="control-label" for="age">Age</label>
                                <div class="controls">
                                    <input type="number" min="1" max="150" id="age" name="age" value=<?php echo $p["age"];?> >
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
                            </div>*/
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



<?php
session_start();
include 'config.php';

mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());

$patientID = $_SESSION["patientrecord"]["idpatient"];
$location = 'Vitals';
$sql = "INSERT INTO {$location} (iddoctor, username, password, email, firstname, lastname, age, gender, association) VALUES ('$myiddoctor','$myusername','$mypassword','$myemail','$myfirstname','$mylastname','$myage','$mygender', '$myassociation')";
$result = mysql_query($sql);
		
if ($result) 
{
	echo "<script>alert('Vitals entered successfully');</script>";
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=vitalsm.php">';    
}
?>                          