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
}
?>
 <?php
include 'config.php';
mysql_connect($host, $user, $password) or die("cant connect");
mysql_select_db($database) or die(mysql_error());
//this example will display a line chart
$vit = mysql_query("SELECT * FROM Vitals");

$rows = array();
//flag is not needed
$flag = true;
$table = array();
$table['cols'] = array(

    //Labels your chart, this represent the column title
    array('label' => 'heartrate', 'type' => 'number'),
    array('label' => 'bloodsugar', 'type' => 'number'),
    array('label' => 'bloodpressure', 'type' => 'number'),
    array('label' => 'weight', 'type' => 'number')

);

$rows = array();
while($r = mysql_fetch_assoc($vit)) {
    $temp = array();
    // the following line will used to divide the line chart

    //Values of the each line
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
                if ($accountType == 3) $title = "Welcome, ";
                echo "<h1 class='pull-left'>{$title} {$_SESSION["userrecord"]["firstname"]} {$_SESSION["userrecord"]["lastname"]}</h1>";
            ?>
            <a href="logout.php"><h1 class="pull-right btn btn-inverse">Sign Out</h1></a>
            <ul class="clear nav nav-tabs">
                <?php if ($accountType == 1) echo '<li><a href="accountDoctors.php">Select Patient</a></li>'; ?>
                <?php if ($accountType == 2) echo '<li><a href="accountNurses.php">Select Patient</a></li>'; ?>
                <li class="active"><a href="vitalm.php">Vitals</a></li>
                <?php if ($accountType != 3) echo '<li><a href="notes.php">Notes</a></li>'; ?>
                <?php if ($accountType != 2) echo '<li><a href="messagePage.php">Messages</a></li>'; ?>
                <?php if ($accountType == 1) echo '<li><a href="prescriptionPage.php">Prescriptions</a></li>'; ?>
                <?php if ($accountType != 3) echo '<li><a href="editInfo.php">Edit Info</a></li>';?>
                <?php if ($accountType == 3) echo '<li><a href="updateInfo.php">Update Info</a></li>';?>
            </ul>
			<div class="<?php if (!$_GET or isset($_GET["status"])) echo 'fadeIn ';?>tabcontent">
				<div class="container-fluid">
 					<div class="row-fluid">
    					<div class="span5">
     					 <!--enter/show vitals-->
     					 	<div class="row-fluid">
     					 		<div class="span12">
     					 		</div>
     					 	</div>
     					 	<br><br><br><div>
     					 		<div class="span12 offset2">
				  				<button onclick="return toggle('para1')" class="btn btn-primary span10">Toggle Entry/Table</button>
				  				</div>
     					 	</div>
     					 	<div class="offset1"><br><br>
     					 		<div class="row-fluid" id="para1" style="display:none; width:430px; height:300px; overflow: auto;">
     					 			<table class="table table-striped">
     					 				<?php
                            				include 'config.php';
                          					mysql_connect($host, $user, $password) or die("cant connect");
                            				mysql_select_db($database) or die(mysql_error());

                           					$doctorID = $_SESSION["patientrecord"]["iddoctor"];
                            				$patientID = $_SESSION["patientrecord"]["idpatient"];
                            				$nurseID = $_SESSION["patientrecord"]["idnurse"];
                            
                            				$sql = "SELECT * 
											FROM  Vitals
											WHERE iddoctor={$doctorID}
											AND  idpatient={$patientID}
											ORDER BY iddoctor={$doctorID} DESC";	
                            
                            				$myvitals = mysql_query($sql)or die('Invalid query: ' .mysql_error());
                            
                            				$numberofvitals = mysql_num_rows($myvitals);

                            				if ($numberofvitals == 0) 
                            				{
												echo '<pre>'.'                 '.'No vitals entered.'.'</pre>';
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
    																		<td><font color='red'>$heartrate</font></td>
    																		<td><font color='green'>$bloodsugar</font></td>
    																		<td><font color='blue'>$bloodpressure</font></td>
    																		<td><font color='orange'>$weight</font></td>
  																		  </tr>";
											$vitalcount++;
 							    			} 
 							    			$i=$vitalcount-1;	
 							    			while($i>=0)
 							    				{
 							   					print $vitalreport[$i];
 							    				$i--;
 							    				}
 											}
 											$m=0;
 							    			if(isset($vitalcount))
 							    			{
 							    				if(isset($m))
 							    				{$m=$vitalcount-1;}
 							    			}
 											//for line chart
 											$j=$m;
     					 		  			if($j>2){
   											$l1 = array($Gheartrate[$j-3], $Gheartrate[$j-2], $Gheartrate[$j-1], $Gheartrate[$j]);
    										$l2 = array($Gbloodsugar[$j-3], $Gbloodsugar[$j-2], $Gbloodsugar[$j-1], $Gbloodsugar[$j]);
    										$l3 = array($Gbloodpressure[$j-3], $Gbloodpressure[$j-2], $Gbloodpressure[$j-1], $Gbloodpressure[$j]);
    										$l4 = array($Gweight[$j-3], $Gweight[$j-2], $Gweight[$j-1], $Gweight[$j]);}
    										else{
    										$l1 = array(0);
    										$l2 = array(0);
    										$l3 = array(0);
    										$l4 = array(0);}
    										/*
    										//Decides whether value most recently entered is in bounds of what doctor says is healthy. If not, graph line turns red, and notification is sent to doctor.
    										include 'config.php';
                          					mysql_connect($host, $user, $password) or die("cant connect");
                            				mysql_select_db($database) or die(mysql_error());

                           					$doctorID = $_SESSION["patientrecord"]["iddoctor"];
                            				$patientID = $_SESSION["patientrecord"]["idpatient"];
                            				$nurseID = $_SESSION["patientrecord"]["idnurse"];
                            
                            				$sql = "SELECT * 
											FROM  Bounds
											WHERE iddoctor={$doctorID}
											AND  idpatient={$patientID}
											ORDER BY iddoctor={$doctorID} DESC";	
                            
                            				$mybounds = mysql_query($sql)or die('Invalid query: ' .mysql_error());
                            
                            				$numberofbounds = mysql_num_rows($mybounds);

                            				if ($numberofbounds == 0)
                            				{}
                            				else
                            				{ 
                            				$boundcount=0;
                            				while($row2 = mysql_fetch_assoc($mybounds)){
                                			$boundHRmin = $row2['HRmin'];
                                			$boundBSmin = $row2['BSmin'];
                                			$boundBPmin = $row2['BPmin'];
                                			$boundWmin = $row2['Wmin'];
                                			$boundHRmax = $row2['HRmax'];
                                			$boundBSmax = $row2['BSmax'];
                                			$boundBPmax = $row2['BPmax'];
                                			$boundWmax = $row2['Wmax'];
                                			
                                			$Xheartrate[$boundcount] = $boundHRmin;
                                			$Yheartrate[$boundcount] = $boundHRmax;
                                			$Xbloodsugar[$boundcount] = $boundBSmin;
                                			$Ybloodsugar[$boundcount] = $boundBSmax;
                                			$Xbloodpressure[$boundcount] = $boundBPmin;
                                			$Ybloodpressure[$boundcount] = $boundBPmax;
                                			$Xweight[$vitalcount] = $boundWmin;
                                 			$Yweight[$vitalcount] = $boundWmax;
                               			
                                			$boundcount++;}
                                			$a=$boundcount-1;
                                			$Warning=0; $HRW=false; $BSW=false; $BPW=false; $WW=false;
                                			//heartrate
                                			if(($Gheartrate[$j] > $Yheartrate[$a]) or ($Gheartrate[$j] < $Xheartrate[$a]))
                                			{$Warning++; $HRW=true;}
                                			else
                                			{$HRW=false;}
                                			//bloodsugar
                                			if(($Gbloodsugar[$j] > $Ybloodsugar[$a]) or ($Gbloodsugar[$j] < $Xbloodsugar[$a]))
                                			{$Warning++; $BSW=true;}
                                			else
                                			{$BSW=false;}
                                			//bloodpressure
                                			if(($Gbloodpressure[$j] > $Ybloodpressure[$a]) or ($Gbloodpressure[$j] < $Xbloodpressure[$a]))
                                			{$Warning++; $BPW=true;}
                                			else
                                			{$BPW=false;}
                                			//weight(mass)
                                			if(($Gweight[$j] > $Yweight[$a]) or ($Gweight[$j] < $Xweight[$a]))
                                			{$Warning++; $WW=true;}
                                			else
                                			{$WW=false;}
											//$boundary = array($HRW,$BSW,$BPW,$WW);
											
											//so the warning level can't go below zero
											if($Warning<=0)
											{$Warning = 0;}   
                                			}$b=0;
                                			*/
                        				?> 
     					 				<tr></tr>
									</table>
     					 		</div>
     					 	</div>
<?php if(($accountType==2)){$forum = "action='entervitals.php'";} 
	  if(($accountType==3)){$forum = "action='entervitals.php'";}
      elseif($accountType==1){$forum = "action='enterbounds.php'";}?>     					 	
     					 	<div class="row-fluid" id='para2' style='display:block'>
     					 		<div class="span12 offset2">
     					 			<form class="row-fluid" method="post" <?php echo $forum;?>>
                   				     	<div class="control-group">
     					 					<?php echo "<h3 class=''>{$_SESSION["patientrecord"]["lastname"]}, {$_SESSION["patientrecord"]["firstname"]}</h3>"; ?>
     					 				</div>
                   				     	<?php 
                   				     	$vitalsNP = '<div class="control-group">
                               				<label class="control-label" for="timeofday"></label>
                               				<div class="controls">
												<select id="timeofday" class="span10" name="timeofday" required="required">
 													<option value="">Time of Day</option>
 													<option value="0">Morning</option>
 													<option value="1">Afternoon</option>
 													<option value="2">Evening</option>
 												</select>                             
                                			</div>
                           			 	</div>
                            			<div class="control-group">
                               				<label class="control-label" for="HRBS"></label>
                             			   	<div class="controls">
                                    			<input type="number" class="span5" step="any" id="heartrate" placeholder="Heart Rate(bpm)" name="heartrate" required="required">
                                   				<input type="number" class="span5" step="any" id="bloodsugar" placeholder="Blood Sugar(mg/dl)" name="bloodsugar" required="required">
                                			</div>
                            			</div>
                            			<div class="control-group">
                                			<label class="control-label" for="BPW"></label>
                                			<div class="controls">
                                    			<input type="number" class="span5" step="any" id="bloodpressure" placeholder="Blood Pressure(mmHg)" name="bloodpressure" required="required">
                                    			<input type="number" class="span5" step="any" id="weight" placeholder="Mass(kg)" name="weight" required="required">
                                			</div>
                            			</div>
                            			'; 	
                            			
                            			$vitalsD = '<div class="control-group">
                               			<label class="control-label" for="heartratebounds"></label>
                             			   	<div class="controls">
                                    			<input class="span5" type="number" step="any" id="HRmn" placeholder="Heart Rate Min" name="HRmin" required="required">
                                    			<input class="span5" type="number" step="any" id="HRmax" placeholder="Heart Rate Max" name="HRmax" required="required">
                                			</div>
                            		</div>
  					  				<div class="control-group">
                               			<label class="control-label" for="bloodsugarbounds"></label>
                             			   	<div class="controls">
                                    			<input class="span5" type="number" step="any" id="BSmn" placeholder="Blood Sugar Min" name="BSmin" required="required">	
                                    			<input class="span5" type="number" step="any" id="BSmax" placeholder="Blood Sugar Max" name="BSmax" required="required">
                                			</div>
                            		</div>  
  					  				<div class="control-group">
                               			<label class="control-label" for="bloodpressurebounds"></label>
                             			   	<div class="controls">
                                    			<input class="span5" type="number" step="any" id="BPmn" placeholder="Blood Pressure Min" name="BPmin" required="required">
                                    			<input class="span5" type="number" step="any" id="BPmax" placeholder="Blood Pressure Max" name="BPmax" required="required">
                                			</div>
                            		</div>  
  					  				<div class="control-group">
                               			<label class="control-label" for="weight"></label>
                             			   	<div class="controls">
                                    			<input class="span5" type="number" step="any" id="Wmn" placeholder="Weight Min" name="Wmin" required="required">
                                    			<input class="span5" type="number" step="any" id="Wmax" placeholder="Weight Max" name="Wmax" required="required">
                                			</div>
                            		</div> ';  
                            		
                            		        if($accountType==(1))
                          					{
                          						echo $vitalsD;
                          					}
                          					elseif($accountType==2)
                          					{
                          						echo $vitalsNP;
                          					}
                          					elseif($accountType==3)
                          					{
                          						echo $vitalsNP;
                          					}
                            		
                            		?>
                            			<div class="control-group">
                               				 <div class="controls">
    										<?php
                          					if ($_GET and $_GET["status"] == "success") 
                          					{
                          						if($accountType==(1))
                          						{
                          							echo '<p class="label label-inverse fadeIn span10">Weekly Bounds Successfully entered</p><br>';

                          						}
                          						elseif(($accountType==2))
                          						{
                          							$feed = $m+1;
                               				 		echo '<p class="label label-inverse fadeIn span10">Vitals Successfully entered ('.$feed.')</p><br>';
                          						} 
                          						elseif(($accountType==3))
                          						{
                          							$feed = $m+1;
                               				 		echo '<p class="label label-inverse fadeIn span10">Vitals Successfully entered ('.$feed.')</p><br>';
                          						}                     						
                            				}    										
    										if($accountType==(1))
                          						{
                          							echo '<input class="btn btn-primary span10" type="submit" value="Enter Ranges">';

                          						}
                          						elseif(($accountType==2))
                          						{
                               				 		echo '<input class="btn btn-primary span10" type="submit" value="Enter Vitals">';
                          						} 
                          						elseif(($accountType==3))
                          						{
                               				 		echo '<input class="btn btn-primary span10" type="submit" value="Enter Vitals">';
                          						} 
                        					?>
                                			</div>
                           				</div>
                        			</form>
     					 		</div>
     					 	</div>
  					  	</div>
  					  	<div><br>
  					  		<!--<div class="progress progress-striped active"> Sufficient Number of Vitals Entered?
  					  				<?php 	if($vitalcount = 0)
  											{echo '<div class="bar" style="width: 0%;"></div>';}
  										  	elseif($vitalcount = 1)
  											{echo '<div class="bar" style="width: 20%;"></div>';}
  										  	elseif($vitalcount = 2)
  											{echo '<div class="bar" style="width: 40%;"></div>';}
  											elseif($vitalcount = 3)
  											{echo '<div class="bar" style="width: 60%;"></div>';}
  											elseif($vitalcount = 4)
  											{echo '<div class="bar" style="width: 80%;"></div>';}
  											else
  											{echo '<div class="bar" style="width: 1000%;"></div>';} ?> 										
							</div>-->
  					  	</div>
  					  	<div class="span4">
  					  		<div class="row-fluid offset1">
     					 		<div class="span12"><br><br>
     					 		  <?php
									$pc = new C_PhpChartX(array($l1,$l2,$l3,$l4),'Vitals');

    								$pc->jqplot_show_plugins(true);
    								$pc->set_legend(array('show'=>true));
    								$pc->set_animate(true);

    								$pc->add_series(array('label'=>'Heart Rate'),array('showLabel'=>true));
    								$pc->add_series(array('label'=>'Blood Sugar'),array('showLabel'=>true));
    								$pc->add_series(array('label'=>'Blood Pressure'),array('showLabel'=>true));
    								$pc->add_series(array('label'=>'Mass'),array('showLabel'=>true));
    
    								$pc->set_title(array('text'=>'Vitals'));
									$pc->set_axes(array(
      								  'xaxis'=> array(	'min' => 	1,
      								  					'max' => 4,
      								  					'label'=> 'Most Recently Entered(At least 4)'),
      								  'yaxis'=> array(	'min' => 0,
      								  					'max' => 200,
      								  					'label'=>''	)
 									   ));
									$pc->set_series_color(array('red', 'green', 'blue','orange'));
   									$pc->draw(600,400);   
    								?>
     					 	<?php				
								//echo $Gheartrate[$j].' '.$Yheartrate[$a].' '.$Gheartrate[$j].' '.$Xheartrate[$a].'<br>';
								//echo $Gbloodsugar[$j].' '.$Ybloodsugar[$a].' '.$Gbloodsugar[$j].' '.$Xbloodsugar[$a];
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