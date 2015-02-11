<?php
include_once 'global_includes.php';

// Frame variable
if(isset($_REQUEST["fusionIp"])) $fusionIp = $_REQUEST["fusionIp"];

// Add Note
if(isset($_REQUEST["division"])) $_SESSION['division'] = $_REQUEST["division"];
if(isset($_REQUEST["customerId"])) $_SESSION['customerId'] = $_REQUEST["customerId"];
if(isset($_REQUEST["customerMachineId"])) $_SESSION['customerMachineId'] = $_REQUEST["customerMachineId"];
if(isset($_REQUEST["fusionIp"])) $_SESSION['fusionIp'] = $_REQUEST["fusionIp"];

$customerMachineNote = new CustomerMachineNote($dbLink);
$customerMachineNote->machine_type = $_SESSION['machine_type'];
$customerMachineNote->division = $_SESSION['division'];
$customerMachineNote->customer_id = $_SESSION['customerId'];
$customerMachineNote->customer_machine_id = $_SESSION['customerMachineId'];

$newCustomer = new Customer($dbLink);
$newCustomer->id = $_SESSION['customerId'];
$newCustomer->setCustomer_noParams();

if(isset($_REQUEST["addNoteNow"])){
	$customerMachineNote->note_subject = $_REQUEST["customerMachineNoteSubject"];
	$customerMachineNote->note = $_REQUEST["customerMachineNote"];
	$customerMachineNote->created_by = $_SESSION['username'];
	$customerMachineNote->addCustomerMachineNote();
}

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
   "http://www.w3.org/TR/html4/frameset.dtd">
<HTML>
<HEAD>
<TITLE>Remote View for: <?php echo $newCustomer->name; ?></TITLE>
</HEAD>
  <FRAMESET rows="80, 400">
      <FRAME src="remote_view_hc_frameTop.php?customerId=<?php echo $_SESSION['customerId']; ?>">
      <FRAME src="<?php echo $_SESSION['fusionIp']; ?>">
  </FRAMESET>
  <NOFRAMES>
      <P>This page cannot be displayed
  </NOFRAMES>
</HTML>