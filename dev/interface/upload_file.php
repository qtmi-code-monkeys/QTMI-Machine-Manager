<?php
include_once 'global_includes.php';

// initilaze DB connection
$dbLink = mysql_connect('localhost', 'warren', 'usnusn');
if(!$dbLink){
	die('Could not connect: '. mysql_error());
}	


$system_time = round(microtime(true) * 1000);


$uploader = new UploadController($dbLink);
$uploader->created_by = $_SESSION['username'];
$uploader->system_time = $system_time;
$uploader->file_name = basename($_FILES['qtmiFile']['name']);
// Make File name unique
$uploader->file_name = str_replace( ".", $uploader->system_time.".", $uploader->file_name);
$uploader->file_tmp_name = $_FILES['qtmiFile']['tmp_name'];
if (isset($_REQUEST["fullCheckBox"])) $uploader->version_number = $_REQUEST["nextFullVersionNumber"];
if (isset($_REQUEST["incCheckBox"])) $uploader->version_number = $_REQUEST["nextIncVersionNumber"];
if (isset($_REQUEST["descriptionOfChanges"])) $uploader->descriptionOfChanges = $_REQUEST["descriptionOfChanges"];
if (isset($_REQUEST["machineType"])) $uploader->machine_type = $_REQUEST["machineType"];
if (isset($_REQUEST["codeBase"])) $uploader->code_base = $_REQUEST["codeBase"];
if (isset($_REQUEST["fullCheckBox"])) $uploader->release_type = "FULL";
if (isset($_REQUEST["incCheckBox"])) $uploader->release_type = "INC";
if (isset($_REQUEST["noteId"])) $uploader->note_id = $_REQUEST["noteId"];
if (isset($_REQUEST["customerNoteId"])) $uploader->customer_note_id = $_REQUEST["customerNoteId"];
$temp = explode(".", $_FILES['qtmiFile']["name"]);
$uploader->file_ext = end($temp);


$uploader->uploadFile();



if($uploader->error_message == ""){ 
	$uploader->saveFile();
	if($uploader->note_id == -1 && $uploader->customer_note_id == -1) $uploader->updateRevision();
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	//echo $_SERVER['HTTP_REFERER'];
}else{
	echo $uploader->error_message . "<br/>";
	echo "<a href='".$_SERVER['HTTP_REFERER']."'>Previous Page</a>";
}
	

// close DB connection
mysql_close($dbLink);
?>

