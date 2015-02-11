<?php
include_once 'global_includes.php';

$_SESSION['machine_type'] = "FUSION";

$newCustomer = new Customer($dbLink);
if(isset($_REQUEST["customer_id"])) $newCustomer->id =  $_REQUEST["customer_id"];
$newCustomer->setCustomer_noParams();

$newCustomerMachineContacts = new CustomerMachineContacts($dbLink);

if(isset($_REQUEST["customer_machine_id"])) $newCustomerMachineContacts->customer_machine_id =  $_REQUEST["customer_machine_id"];

if(isset($_REQUEST["updateContactCustMachineNow"])){
	$newCustomerMachineContacts->c1_name = $_REQUEST["c1_name"];
	$newCustomerMachineContacts->c1_number = $_REQUEST["c1_number"];
	$newCustomerMachineContacts->c1_email = $_REQUEST["c1_email"];
	$newCustomerMachineContacts->c2_name = $_REQUEST["c2_name"];
	$newCustomerMachineContacts->c2_number = $_REQUEST["c2_number"];
	$newCustomerMachineContacts->c2_email = $_REQUEST["c2_email"];
	$newCustomerMachineContacts->c3_name = $_REQUEST["c3_name"];
	$newCustomerMachineContacts->c3_number = $_REQUEST["c3_number"];
	$newCustomerMachineContacts->c3_email = $_REQUEST["c3_email"];
	$newCustomerMachineContacts->updateContactCustMachine();
}

$newCustomerMachineContacts->getCustomerContacts();

if($newCustomerMachineContacts->id == -1) $newCustomerMachineContacts->addCustomerMachineContacts();


?>


<html>
<head>
	<?php echo $SYSTEM_cssLink; ?>

</head>


<body>

<?php echo $SYSTEM_pageTitleLink; ?>
<div class='pageTitle' >Add Customer Fusion Contacts</div>

<div>
<a class='breadCrumb' href="homepage.php">Home Page</a> 
</div>
</br>

<?php if($appManager->isAdmin()) {?>
	<div class="formBackground_adm">
		<form name="addContactCustomerFusionForm" action="add_contacts_customer_fusion.php" method="POST" >
		<?php $_SESSION['machine_type']; ?> Contact Info For: <?php $newCustomer->name; ?></br>
		Customer 1 Name: <input id="c1_name" type="text" name="c1_name" value="<?php echo $newCustomerMachineContacts->c1_name; ?>" /></br>		
		Customer 1 Number: <input id="c1_number" type="text" name="c1_number" value="<?php echo $newCustomerMachineContacts->c1_number; ?>" /></br>		
		Customer 1 Email: <input id="c1_email" type="text" name="c1_email" value="<?php echo $newCustomerMachineContacts->c1_email; ?>" /></br></br>		
		Customer 2 Name: <input id="c2_name" type="text" name="c2_name" value="<?php echo $newCustomerMachineContacts->c2_name; ?>" /></br>		
		Customer 2 Number: <input id="c2_number" type="text" name="c2_number" value="<?php echo $newCustomerMachineContacts->c2_number; ?>" /></br>		
		Customer 2 Email: <input id="c2_email" type="text" name="c2_email" value="<?php echo $newCustomerMachineContacts->c2_email; ?>" /></br></br>		
		Customer 3 Name: <input id="c3_name" type="text" name="c3_name" value="<?php echo $newCustomerMachineContacts->c3_name; ?>" /></br>		
		Customer 3 Number: <input id="c3_number" type="text" name="c3_number" value="<?php echo $newCustomerMachineContacts->c3_number; ?>" /></br>		
		Customer 3 Email: <input id="c3_email" type="text" name="c3_email" value="<?php echo $newCustomerMachineContacts->c3_email; ?>" /></br></br>		
		<input type="hidden" name="customer_machine_id" value="<?php echo $newCustomerMachineContacts->customer_machine_id; ?>"  /> 
		<input type="hidden" name="updateContactCustMachineNow" value="1"  /> 
		<input type="submit" value="Update Customer Contacts" /> 
		</form> 
	</div>
<?php } ?>


</body>
</html>

<?php
// close DB connection
mysql_close($dbLink);
?>

