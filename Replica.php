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
 <?php
include 'config.php';
mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());
// The Chart table contain two fields: Weekly_task and percentage
//this example will display a pie chart.if u need other charts such as Bar chart, u will need to change little bit to make work with bar chart and others charts
$vit = mysql_query("SELECT * FROM Vitals");

/*
---------------------------
example data: Table (Chart)
--------------------------
Weekly_Task     percentage
Sleep           30
Watching Movie  40
work            44
*/

$rows = array();
//flag is not needed
$flag = true;
$table = array();
$table['cols'] = array(

    //Labels your chart, this represent the column title
    //note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage And string will be used for column title
    array('label' => 'heartrate', 'type' => 'number'),
    array('label' => 'bloodsugar', 'type' => 'number'),
    array('label' => 'bloodpressure', 'type' => 'number'),
    array('label' => 'weight', 'type' => 'number')

);

$rows = array();
while($r = mysql_fetch_assoc($vit)) {
    $temp = array();
    // the following line will used to slice the Pie chart

    //Values of the each slice
    $temp[] = array('v' => (int) $r['heartrate']); 
    $rows[] = array('c' => $temp);
    $temp[] = array('v' => (int) $r['bloodsugar']); 
    $rows[] = array('c' => $temp);
    $temp[] = array('v' => (int) $r['bloodpressure']); 
    $rows[] = array('c' => $temp);
    $temp[] = array('v' => (int) $r['weight']); 
    $rows[] = array('c' => $temp);
}

$table['rows'] = $rows;
$jsonTable = json_encode($table);
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
                <li><a href="editInfo.php">Edit Info</a></li>
            </ul>
			<div class="<?php if (!$_GET or isset($_GET["status"])) echo 'fadeIn ';?>tabcontent vitals">
				<div class="container-fluid">
 					<div class="row-fluid">
    					<div class="span5">
     					 <!--enter/show vitals-->
     					 	<div class="row-fluid">
     					 		<div class="span12">
     					 		</div>
     					 	</div>
     					 	<div class="row-fluid">
     					 		<div class="span12 offset4">
				  				<button onclick="return toggle('para1')" class="btn btn-primary">Enter Vitals</button>
				  				<button onclick="return toggle('para2')" class="btn btn-secondary">Vitals Feed</button>     					 		</div>
     					 	</div><br>
     					 	<div class="row-fluid" id="para1" style="display:none; width:500px; height:400px; overflow: auto;">
     					 		<div class="span12">
     					 			<table class="table table-striped">
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
                                	
                                			$Gtimeanddate[$vitalcount] = $timeanddate;
                                			$Gheartrate[$vitalcount] = $heartrate;
                                			$Gbloodsugar[$vitalcount] = $bloodsugar;
                                			$Gbloodpressure[$vitalcount] = $bloodpressure;
                                			$Gweight[$vitalcount] = $weight;
                                			
											$vitalreport[$vitalcount] =   "<tr>
    																		<td>$timeofday</td>
   																			<td>$timeanddate</td>
    																		<td>$heartrate</td>
    																		<td>$bloodsugar</td>
    																		<td>$bloodpressure</td>
    																		<td>$weight</td>
  																		  </tr>";
											$vitalcount++;
 							    			} 
 							    			$i=$vitalcount-1;	
 							    			$j=$vitalcount-1;
 							    			while($i>=0)
 							    				{
 							   					print $vitalreport[$i];
 							    				$i--;
 							    				}
 											}
                        				?> 
     					 				<tr></tr>
									</table>
     					 		</div>
     					 	</div>
     					 	<div class="row-fluid" id="para2" style="display:block">
     					 		<div class="span12"><br>
     					 			<form class="form-horizontal" method="post" action="entervitals.php">
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
                                			</div>
                           				</div>
                        			</form>
     					 		</div>
     					 	</div>
  					  	</div>
  					  	<div class="span5">
  					  		<div class="row offset1">
     					 		<div class="span12"><br><br>
     					 		  <?php
   									$l1 = array($Gheartrate[$j-3], $Gheartrate[$j-2], $Gheartrate[$j-1], $Gheartrate[$j]);
    								$l2 = array($Gbloodsugar[$j-3], $Gbloodsugar[$j-2], $Gbloodsugar[$j-1], $Gbloodsugar[$j]);
    								$l3 = array($Gbloodpressure[$j-3], $Gbloodpressure[$j-2], $Gbloodpressure[$j-1], $Gbloodpressure[$j]);
    								$l4 = array($Gweight[$j-3], $Gweight[$j-2], $Gweight[$j-1], $Gweight[$j]);


									$pc = new C_PhpChartX(array($l1,$l2,$l3,$l4),'Vitals');

    								$pc->jqplot_show_plugins(true);
    								$pc->set_legend(array('show'=>true));
    								$pc->set_animate(true);

    								$pc->add_series(array('showLabel'=>true));
    								$pc->add_series(array('showLabel'=>true));
    								$pc->add_series(array('showLabel'=>true));
    								$pc->add_series(array('showLabel'=>true));
    
    								$pc->set_title(array('text'=>'Vitals'));
									
   									$pc->draw(600,400);   
    								?>
     					 		</div>
							</div>
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