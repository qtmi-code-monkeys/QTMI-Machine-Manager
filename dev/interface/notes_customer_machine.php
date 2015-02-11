<?php
include_once 'global_includes.php';

if(isset($_REQUEST["division"])) $_SESSION['division'] = $_REQUEST["division"];
if(isset($_REQUEST["customerId"])) $_SESSION['customerId'] = $_REQUEST["customerId"];
if(isset($_REQUEST["customerId"])) $_SESSION['customerMachineId'] = $_REQUEST["customerMachineId"];

$customerMachineNote = new CustomerMachineNote($dbLink);
$customerMachineNote->machine_type = $_SESSION['machine_type'];
$customerMachineNote->division = $_SESSION['division'];
$customerMachineNote->customer_id = $_SESSION['customerId'];
$customerMachineNote->customer_machine_id = $_SESSION['customerMachineId'];

$customer = new Customer($dbLink);
$customer->setCustomerName($customerMachineNote->customer_id);

if(isset($_REQUEST["addNoteNow"])){
	$customerMachineNote->note_subject = $_REQUEST["customerMachineNoteSubject"];
	$customerMachineNote->note = $_REQUEST["customerMachineNote"];
	$customerMachineNote->created_by = $_SESSION['username'];
	$customerMachineNote->addCustomerMachineNote();
}

$linkMaker = new LinkMaker();
$linkMaker->machine_type = $_SESSION['machine_type'];

if(isset($_REQUEST["retreiveMessage"])){
	$customerMachineNote->retrieveMyLastNote();
}


?>


<html>
<head>
	<?php echo $SYSTEM_cssLink; ?>
</head>


<body>

<?php echo $SYSTEM_pageTitleLink; ?>
<div class='pageTitle' ><?php echo $customerMachineNote->machine_type; ?>  Notes for: <?php echo $customer->name; ?>  </div>
<div>
<a class='breadCrumb' href="homepage.php">Home Page</a>   
</div>

<?php if ($customerMachineNote->division == "All") : ?>

<br/>
	<div class='sectionHeader' >R and D</div>
	<?php $customerMachineNote->division = "RandD"; ?>
	<?php $customerMachineNote->listCustomerMachineNotes(); ?>

	<div class='sectionHeader' >Manufacturing</div>
	<?php $customerMachineNote->division = "Manufacturing"; ?>
	<?php $customerMachineNote->listCustomerMachineNotes(); ?>

	<div class='sectionHeader' >Tech</div>
	<?php $customerMachineNote->division = "Tech"; ?>
	<?php $customerMachineNote->listCustomerMachineNotes(); ?>

	<div class='sectionHeader' >Process</div>
	<?php $customerMachineNote->division = "Process"; ?>
	<?php $customerMachineNote->listCustomerMachineNotes(); ?>


<?php else : ?>

<div class="formBackground">
	<form name="addNotesMachine" enctype="multipart/form-data" action="notes_customer_machine.php" method="POST">
	 <h1 id='formLabel' >Note: </h1> 
	<a href='notes_customer_machine.php?retreiveMessage=yes'>Retrieve lost message</a></br>
	Subject: <input type="text" name="customerMachineNoteSubject" size="60" value="<?php echo $customerMachineNote->note_subject; ?>" /></br>
	 <textarea id="machineNote" name="customerMachineNote" rows="10" cols="50"><?php echo $customerMachineNote->note; ?></textarea> 
	<input type="hidden" name="machine_type" value="<?php echo $customerMachineNote->machine_type; ?>" />
	<input type="hidden" name="division" value="<?php echo $customerMachineNote->division; ?>" />
	<input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>" />
	<input type="hidden" name="addNoteNow" value="1" /></br>
	<input type="submit" value="Add Note" />
	</form>
</div>

<?php 
echo "<form id='searchForm' name='searchForm' action='notes_customer_machine.php' enctype='multipart/form-data'  method='POST'>";
$searchManager->showSearchForm(); 
echo "</form>";
?>
	<?php $customerMachineNote->listCustomerMachineNotes(); ?>

<?php endif; ?>
</body>
<?php
// close DB connection
mysql_close($dbLink);
?>