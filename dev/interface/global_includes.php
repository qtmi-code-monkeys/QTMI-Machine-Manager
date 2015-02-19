<?php
include_once "../model/QTMIBaseClass.php"; 
include_once "../model/SystemRev.php"; 
include_once "../model/ListFiles.php"; 
include_once "../model/MachineNote.php"; 
include_once "../model/UploadController.php"; 
include_once "../model/Customer.php"; 
include_once "../model/CustomerMachine.php"; 
include_once "../model/CustomerMachineNote.php"; 
include_once "../model/CustomerMachineUpgrade.php"; 
include_once "../model/CustomerMachineContacts.php"; 
include_once "../model/AlarmViewer.php"; 
include_once "../lib/AppManager.php"; 
include_once "../lib/LinkMaker.php"; 
include_once "../lib/SearchManager.php"; 
include_once "../lib/Util.php"; 
include_once "../lib/JsWidgets.php"; 

/**
initilaze general DB connection
 */

$dbLink = mysql_connect('localhost', 'warren', 'usnusn');
if(!$dbLink){
	die('Could not connect: '. mysql_error());
}

/**
Secure Login  
 */
include_once '../secure_login/includes/db_connect.php';
include_once '../secure_login/includes/functions.php';

sec_session_start();

if (login_check($mysqli) == true){

}else{
	// Check if we need to store the note that was being written
	if(isset($_REQUEST["addNoteNow"])){
		$customerMachineNote = new CustomerMachineNote($dbLink);	
		$customerMachineNote->note_subject = $_REQUEST["customerMachineNoteSubject"];
		$customerMachineNote->note = $_REQUEST["customerMachineNote"];
		$customerMachineNote->created_by = $_REQUEST["username"];
		$customerMachineNote->saveMyLastNote();
	}
	header('Location: ' . '../secure_login/index.php');
}

$SYSTEM_logoutLink = "<a href='../secure_login/includes/logout.php'>log out</a>";



/**
CSS 
 */


$pageTitle = "<title>QTMI Machine Manager</title>";
$SYSTEM_cssLink = $pageTitle."<link rel='stylesheet' type='text/css' href='../css/qtmiMgr.css'>";

//$SYSTEM_pageTitleLink = "<div class='siteTitle' >QTMI Fusion and HC Software Manager</br><font class='welcomeUser'>Welcome, ".$_SESSION['username']." (".$SYSTEM_logoutLink . ") ".$_SESSION['email']."</font></div>"; 

$SYSTEM_pageTitleLink = "<div class='siteTitle' >QTMI Machine Manager</br><font class='welcomeUser'>Welcome, ".$_SESSION['username']." (".$SYSTEM_logoutLink . ") </font></div>"; 

$appManager = new AppManager();

$jsWidgets = new JsWidgets();

// Search Manager

//set Search term 1
if(isset($_REQUEST["searchTerm1"])) $_SESSION['searchTerm1'] = $_REQUEST["searchTerm1"];
//set Search operator 1
if(isset($_REQUEST["logicalOperator1"])) $_SESSION['logicalOperator1'] = $_REQUEST["logicalOperator1"];
//set Search term 2
if(isset($_REQUEST["searchTerm2"])) $_SESSION['searchTerm2'] = $_REQUEST["searchTerm2"];
$searchManager = new searchManager();


//if(isset($_SESSION['searchTerm1'])) echo $_SESSION['searchTerm1'];

// Set Customer Id
if(isset($_REQUEST["cutomerId"])) $_SESSION['customerId'] = $_REQUEST["customerId"];




?>