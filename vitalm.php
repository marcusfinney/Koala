<?php 
session_start();
ob_start(); 
require_once("conf.php");


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
        <script type="text/javascript" src="expandCollapse.js"></script>
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
                <div id="para1" style="display:block">
                	<div class="span5">
                        <form class="form-horizontal" method="post" action="entervitals.php">
                            <div class="control-group">
                                <div class="controls">
                                    <h3><?php echo "{$_SESSION['patientrecord']['lastname']}, {$_SESSION['patientrecord']['firstname']}";?></h3>
                                </div>
                            </div>
                          <!--  <div class="control-group">
                            	<label class="control-label" for="timeanddate">Vitals Audit</label>
                            	<div class="controls">
                                    <input type="datetime" id="timeanddate" name="timeanddate" required="required">
								</div>
							</div>	-->
                            <div class="control-group">
                                <label class="control-label" for="timeofday">Time of Day</label>
                                <div class="controls">
									<select id="timeofday" name="timeofday" required="required">
 										<option value="0">Morning</option>
 										<option value="1">Afternoon</option>
 										<option value="2">Evening</option>
 									</select>                             
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="heartrate">Heart Rate(bpm)</label>
                                <div class="controls">
                                    <input type="number" id="heartrate" name="heartrate" required="required">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="bloodsugar">Blood Sugar(mg/dl)</label>
                                <div class="controls">
                                    <input type="number" id="bloodsugar" name="bloodsugar" required="required">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="bloodpressure">Blood Pressure(mmHg)</label>
                                <div class="controls">
                                    <input type="number" id="bloodpressure" name="bloodpressure" required="required">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="weight">Mass(kg)</label>
                                <div class="controls">
                                    <input type="number" id="weight" name="weight" required="required">
                                </div>
                            </div>	
                            <div class="control-group">
                                <div class="controls">
                                    <?php
                                        if (isset($_GET) and isset($_GET["error"]) and $_GET["error"] == "incompleteform") {
                                            echo '<p class="label label-important fadeIn">You must fill out all fields.</p><br>';
                                        }
                                    ?>
                                    <input class="btn btn-primary" type="submit" value="Enter Vitals">
                                <!--    <input type="button" class="btn btn-secondary" onclick="return toggle('para1')" value="View Vitals"> -->
                                </div>
                            </div>
                                <div>
                            		<font color ="blue"><?php echo "{$_SESSION['patientrecord']['iddoctor']} {$_SESSION['patientrecord']['idnurse']} {$_SESSION['patientrecord']['idpatient']}"?></font>
                            	</div>
                        </form>
                    </div>
                    </div>
                    <div class="span2">
                <div id="para2" style="display:block">
                        <div class="control-group">
                            <div class="controls">
                                <h3>Most Recent</h3>
                            </div>
                        </div>
                    <div style="width:300px; height:285px; overflow: auto;">
						<?php
                            include 'config.php';
                            mysql_connect($host, $user, $password) or die("cant connect");
                            mysql_select_db($database) or die(mysql_error());

                            $doctorID = $_SESSION["userrecord"]["iddoctor"];
                            $patientID = $_SESSION["patientrecord"]["idpatient"];
                            $nurseID = $_SESSION["patientrecord"]["idnurse"];
                            
                            $sql = "SELECT * 
									FROM  Vitals
									WHERE iddoctor={$doctorID}
									AND  idnurse={$nurseID}
									AND  idpatient={$patientID}
									ORDER BY iddoctor={$doctorID} DESC";	
                            
                            $myvitals = mysql_query($sql)or die('Invalid query: ' .mysql_error());
                            
                            $numberofvitals = mysql_num_rows($myvitals);

                            if ($numberofvitals == 0) 
                            {
								echo 'No vitals entered.';
                            }
                            else
                            {
                            	//set up with arrays so database prints in reverse(most recent)	
                                $vitalcount = 0;
                                while ($row = mysql_fetch_assoc($myvitals)) 
                                {
                                	$timeanddate = $row['timeanddate'];
                                	$heartrate = $row["heartrate"];
                                	$bloodsugar = $row['bloodsugar'];
                                	$bloodpressure = $row['bloodpressure'];
                                	$weight = $row['weight'];
                                	if($row['timeofday'] == 0){$timeofday = "Morning";}
                                	if($row['timeofday'] == 1){$timeofday = "Afternoon";}
                                	if($row['timeofday'] == 2){$timeofday = "Evening";}
                                	
									$vitalreport[$vitalcount] = $timeanddate."<br>"
 							      			."{$_SESSION['patientrecord']['firstname']}"
 							        		." "
 							        		."{$_SESSION['patientrecord']['lastname']}"."<br>"
   											. '<i>'.$timeofday.'</i>' . "<br>"
   											."<br>".'Heart Rate: ' . '<font color ="red">'.$heartrate.'</font>' . "<br>"
 							        		.'Blood Sugar: ' . '<font color ="blue">'.$bloodsugar.'</font>' . "<br>"
   											.'Blood Pressure: ' . '<font color ="green">'.$bloodpressure.'</font>' . "<br>"
   											.'Mass: ' . '<font color ="orange">'.$weight.'</font>'. "<br>"
											."----------------------------------------------------" . "<br>";
									$vitalcount++;
 							    } 
 							    $i=$vitalcount-1;	
 							    
 							    while($i>=0)
 							    {
 							    	print $vitalreport[$i];
 							    	$i--;
 							    }
 							}
                        ?> 
                    </div>
                    <!-- <input type="button" class="btn btn-secondary" onclick="return toggle('para1')" value="Enter Vitals"> -->
                    </div>
                    </div>
                    </div>
                    <div>
                    	<div class="span10">
                    		<br>
                    		<?php
								$pc = new C_PhpChartX(array(array(1, 2, 3)),'Vitals');
								$pc->set_title(array('text'=>'Vitals'));
								$pc->set_animate(true);	
								$pc->add_plugins(array('trendline'));
								$pc->draw();
							?>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if (isset($_GET))
            {
                if (isset($_GET["status"]) and $_GET["status"] == "success")
                {
                    echo '<script>alert("Vitals successfully updated.")</script>';
                }
                if (isset($_GET["error"]) and $_GET["error"] == "unauthorized")
                {
                    echo '<script>alert("You are not authorized to view that page.")</script>';
                }
                if (isset($_GET["error"]) and $_GET["error"] == "error")
                {
                    echo '<script>alert("Unable to update vitals information.")</script>';
                }
                if (isset($_GET["error"]) and $_GET["error"] == "idsnotworking")
                {
                    echo '<script>alert("Not recognizing ID tags.")</script>';
                }
            }
        ?>
    </body>
</html> 