<?php
include_once 'global_includes.php';	

$thisCustomer = new Customer($dbLink);

if(isset($_REQUEST["custId"])) $thisCustomer->id = $_REQUEST["custId"];
$thisCustomer->getCustData();

if(isset($_REQUEST["updateCustNow"])){
	$thisCustomer->id = $_REQUEST["custId"];
	$thisCustomer->name = $_REQUEST["customerName"];
	$thisCustomer->code = $_REQUEST["customerCode"];
//	if (isset($_REQUEST["hcCheckBox"])) $newCustomer->has_hc = "on";
//	if (isset($_REQUEST["fusionCheckBox"])) $newCustomer->has_fusion = "off";
	if (isset($_REQUEST["hcCheckBox"])) 
		$thisCustomer->has_hc = isset($_REQUEST["hcCheckBox"]);
	else
		$thisCustomer->has_hc = 0;	
	if (isset($_REQUEST["fusionCheckBox"])) 
		$thisCustomer->has_fusion = isset($_REQUEST["fusionCheckBox"]);
	else
		$thisCustomer->has_fusion = 0;
		
	$thisCustomer->updateCust();
	
	header('Location: ' . 'add_customer.php');
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
<div class="formBackground_adm">
	<form name="editCustomerForm" action="edit_customer.php" method="POST">
	Name <input id="customerName" type="text" name="customerName" value="<?php echo $thisCustomer->name; ?>" /> </br>
	Name <input id="customerCode" type="text" name="customerCode" value="<?php echo $thisCustomer->code; ?>" /> </br>
	Has HC <input name="hcCheckBox" type="checkbox" <?php echo $thisCustomer->has_hc_html; ?> /></br>
	Has Fusion <input name="fusionCheckBox" type="checkbox" <?php echo $thisCustomer->has_fusion_html; ?> /></br>
	<input type="hidden" name="updateCustNow" value="1" /></br>
	<input type="hidden" name="custId" value="<?php echo $thisCustomer->id; ?>" /></b>
	<input type="submit" value="Update Customer" /> 
	</form>
</div>


</body>
</html>

<?php
// close DB connection
mysql_close($dbLink);
?>