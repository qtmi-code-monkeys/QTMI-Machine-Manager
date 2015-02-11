<?php
include_once 'global_includes.php';

$newCustomer = new Customer($dbLink);
if(isset($_REQUEST["addCustNow"])){
	$newCustomer->name = $_REQUEST["customerName"];
	$newCustomer->code = $_REQUEST["customerCode"];
//	if (isset($_REQUEST["hcCheckBox"])) $newCustomer->has_hc = "on";
//	if (isset($_REQUEST["fusionCheckBox"])) $newCustomer->has_fusion = "off";
	if (isset($_REQUEST["hcCheckBox"])) $newCustomer->has_hc = isset($_REQUEST["hcCheckBox"]);
	if (isset($_REQUEST["fusionCheckBox"])) $newCustomer->has_fusion = isset($_REQUEST["fusionCheckBox"]);
	$newCustomer->addCustomer();
}


?>


<html>
<head>
	<?php echo $SYSTEM_cssLink; ?>
</head>


<body>

<?php echo $SYSTEM_pageTitleLink; ?>
<div class='pageTitle' >Customer</div>

<div>
<a class='breadCrumb' href="homepage.php">Home Page</a> 
</div>
</br>

<?php if($appManager->isAdmin()) {?>
	<div class="formBackground_adm">
		<form name="addCustomerForm" action="add_customer.php" method="POST">
		Name <input id="customerName" type="text" name="customerName" /> </br>
		Code <input id="customerCode" type="text" name="customerCode" /> </br>
		Has HC <input name="hcCheckBox" type="checkbox" /></br>
		Has Fusion <input name="fusionCheckBox" type="checkbox" /></br>
		<input type="hidden" name="addCustNow" value="1" /> 
		<input type="submit" value="Add Customer" /> 
		</form> 
	</div>
<?php } ?>

<?php $newCustomer->listCustomers();  ?>


</body>
</html>

<?php
// close DB connection
mysql_close($dbLink);
?>

