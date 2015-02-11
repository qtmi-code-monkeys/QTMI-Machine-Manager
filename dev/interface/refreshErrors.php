<?php
error_reporting(E_ALL); 
ini_set("display_errors", 1); 

$returnStatement =  "didn't work";

///var/www/HMI_PLC_MANAGER/dev/cron/cronController.php


chdir('/var/www/HMI_PLC_MANAGER/dev/cron');

//echo exec('whoami');
//echo '<br/>';
//echo exec('pwd');
//echo '<br/>';

$returnStatement =  exec('php cronController.php');

if($returnStatement =  "finished with error logging."){
	$returnStatus = "<font style='background:#01DF01'>All Fusion alarm data was loaded into the Database.</font>";
}else{
	$returnStatus = "<font style='background:#FF0000'>Problem. All Fusion alarm data was not loaded into the Database.</font>";
}

echo $returnStatus;

echo "<br/><br/>Please click the Back button to return to MM.";
//print_r(error_get_last());
?>