<?php
include_once 'global_includes.php';

if(isset($_REQUEST["customerId"])) $_SESSION['customerId'] = $_REQUEST["customerId"];
if(isset($_REQUEST["customerId"])) $_SESSION['customerMachineId'] = $_REQUEST["customerMachineId"];

$customerMachineUpgrade = new CustomerMachineUpgrade($dbLink);
$customerMachineUpgrade->machine_type = $_SESSION['machine_type'];
$customerMachineUpgrade->customer_id = $_SESSION['customerId'];
$customerMachineUpgrade->customer_machine_id = $_SESSION['customerMachineId'];

$customer = new Customer($dbLink);
$customer->setCustomerName($customerMachineUpgrade->customer_id);




if(isset($_REQUEST["addUpgradeNow"])){
	$customerMachineUpgrade->upgrade_subject = $_REQUEST["customerMachineUpgradeSubject"];
	$customerMachineUpgrade->upgrade = $_REQUEST["customerMachineUpgrade"];
	$customerMachineUpgrade->created_by = $_SESSION['username'];
	$customerMachineUpgrade->addCustomerMachineUpgrade();
}

if(isset($_REQUEST["linkUpgradeNow"])){
	$customerMachineUpgrade->linkMachineUpgrade($_REQUEST["upgradeId"]);
}

$linkMaker = new LinkMaker();
$linkMaker->machine_type = $_SESSION['machine_type'];

if(isset($_REQUEST["retreiveUpgrade"])){
	$customerMachineNote->retrieveMyLastUpgrade();
}

$customerMachineUpgrade->prepareMyUpgrades();


?>


<html>
<head>
	<?php echo $SYSTEM_cssLink; ?>
</head>


<body>

<?php echo $SYSTEM_pageTitleLink; ?>
<div class='pageTitle' ><?php echo $customerMachineUpgrade->machine_type; ?>  Upgrades for: <?php echo $customer->name; ?>  </div>
<div>
<a class='breadCrumb' href="homepage.php">Home Page</a>   
</div>


<div class="formBackground">
	<form name="addUpgradeMachine" enctype="multipart/form-data" action="upgrades_customer_machine.php" method="POST">
	 <h1 id='formLabel' >Upgrade: </h1> 
	 <?php $customerMachineUpgrade->listAvailableUpgrades();  ?>
	<a href='upgrades_customer_machine.php?retreiveMessage=yes'>Retrieve lost message</a></br>
	Subject: <input type="text" name="customerMachineUpgradeSubject" size="60" value="<?php echo $customerMachineUpgrade->upgrade_subject; ?>" /></br>
	 <textarea id="machineNote" name="customerMachineUpgrade" rows="10" cols="50"><?php echo $customerMachineUpgrade->upgrade; ?></textarea> 
	<input type="hidden" name="machine_type" value="<?php echo $customerMachineUpgrade->machine_type; ?>" />
	<input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>" />
	<input type="hidden" name="addUpgradeNow" value="1" /></br>
	<input type="submit" value="Add Upgrade" />
	</form>
</div>

	<?php $customerMachineUpgrade->listCustomerMachineUpgrades(); ?>

</body>
<?php
// close DB connection
mysql_close($dbLink);
?>