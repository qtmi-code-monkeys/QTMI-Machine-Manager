<?php
/*
$sent_id = -1;
$only_one = true;
//	echo "yellow";
echo "cust ID = ".$_GET["custId"];
if(isset($_GET["custId"])){
	echo "yellow-mellow";
	$sent_id = $_GET["custId"];
	$only_one = true;
}
*/


$dbLink = mysql_connect('localhost', 'warren', 'usnusn');
if(!$dbLink){
	die('Could not connect: '. mysql_error());
}

include_once "../model/QTMIBaseClass.php"; 
include_once "../model/SystemRev.php"; 
include_once "../model/ListFiles.php"; 
include_once "../model/MachineNote.php"; 
include_once "../model/UploadController.php"; 
include_once "../model/Customer.php"; 
include_once "../model/CustomerMachine.php"; 
include_once "../model/CustomerMachineNote.php"; 
include_once "../model/CustomerMachineContacts.php"; 
include_once "../model/AlarmViewer.php"; 
include_once "../lib/AppManager.php"; 
include_once "../lib/LinkMaker.php"; 
include_once "../lib/SearchManager.php"; 
include_once "../lib/Util.php"; 
include_once "../lib/JsWidgets.php"; 
//include_once '../interface/global_includes.php';

$newCustomer = new Customer($dbLink);

$newCustomer->getCustomers();


foreach($newCustomer->customers as $id){
//	if(!$only_one || $sent_id == $id){
//		if($id == 5){
		$newCustomer->id = $id;
		$newCustomer->setCustomer_noParams();
		//echo "customer is ".$newCustomer->name;
		$newCustomerMachine = new CustomerMachine($dbLink, "FUSION");
		$newCustomerMachine->customer = $newCustomer;
		$newCustomerMachine->loadErrors();
//		}
//	}
}
echo "finished with error logging.";
// close DB connection
mysql_close($dbLink);
?>

