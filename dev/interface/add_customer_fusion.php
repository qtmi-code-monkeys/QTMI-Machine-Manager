<?php
include_once 'global_includes.php';

$_SESSION['machine_type'] = "FUSION";

$newCustomer = new Customer($dbLink);

$listFiles = new ListFiles($dbLink);
$listFiles->machine_type = $_SESSION['machine_type'] ;



$newCustomerMachine = new CustomerMachine($dbLink, "FUSION");
if(isset($_REQUEST["addCustMachineNow"])){
	$newCustomer->setCustomer($_REQUEST["customer_id"], "f");
	$newCustomerMachine->customer_id = $newCustomer->id;
	$newCustomerMachine->customer_name = $newCustomer->name;
	
	$listFiles->setFile($_REQUEST["hmi_id"]);
	$newCustomerMachine->current_hmi_file_id = $listFiles->id;	
	$newCustomerMachine->current_hmi = $listFiles->filename;	
	$newCustomerMachine->current_hmi_version = $listFiles->fileVersion;	
	$newCustomerMachine->current_hmi_ip = $_REQUEST["hmi_ip"];	
	
	$listFiles->setFile($_REQUEST["plc_id"]);
	$newCustomerMachine->current_plc_file_id = $listFiles->id;	
	$newCustomerMachine->current_plc = $listFiles->filename;	
	$newCustomerMachine->current_plc_version = $listFiles->fileVersion;	
	$newCustomerMachine->current_plc_ip = $_REQUEST["plc_ip"];		

	$newCustomerMachine->addCustomerMachine();
}




?>


<html>
<head>
	<?php echo $SYSTEM_cssLink; ?>

	<?php echo $jsWidgets->getCustomerContactsPopupWindow(); ?>
	
<script language="javascript" >
	function checkRequiredFields(){
	  if(document.getElementById('customer_id').value == "" 
	  || document.getElementById('hmi_id').value == "" 
	  || document.getElementById('hmi_ip').value == "" 
	  || document.getElementById('plc_id').value == "" 
	  || document.getElementById('plc_ip').value == "" ){
	    alert("Please specify ALL of the following:\n Customer, HMI, HMI IP, PLC, and PLC IP");
	    return false;
	  }else if(document.getElementById('hmi_ip').value.length < 9 || document.getElementById('hmi_ip').value.length > 16) {
	    alert("Your HMI IP needs to be of the following format: XXX.XXX.XXX.XXX");
	    return false;
	  }else if(document.getElementById('plc_ip').value.length < 9 || document.getElementById('plc_ip').value.length > 16){
	    alert("Your PLC IP needs to be of the following format: XXX.XXX.XXX.XXX");
	    return false;
	  }else{
	   document.form.submit();
	    return true;
	  }
	}

</script>

</head>


<body>

<?php echo $SYSTEM_pageTitleLink; ?>
<div class='pageTitle' >Customer Fusion</div>

<div>
<a class='breadCrumb' href="homepage.php">Home Page</a> 
</div>
</br>

<?php if($appManager->isAdmin()) {?>
	<div class="formBackground_adm">
		<form name="addCustomerFusionForm" action="add_customer_fusion.php" method="POST" onsubmit="return checkRequiredFields()" >
		Select a Customer 
		<select id="customer_id" name="customer_id">
		<?php echo $newCustomer->getSelectCustomerOptions('f'); ?>
		</select></br>
		Select a Fusion HMI
		<select id="hmi_id" name="hmi_id">
		<?php echo $listFiles->code_base = "HMI"; ?>
		<?php echo $listFiles->getSelectFileOptions(); ?>
		</select></br>
		HMI IP Address <input id="hmi_ip" type="text" name="hmi_ip" /> <b>(10.10.XXX.XXX)</b></br>
		Select a Fusion PLC
		<select id="plc_id" name="plc_id">
		<?php echo $listFiles->code_base = "PLC"; ?>
		<?php echo $listFiles->getSelectFileOptions(); ?>
		</select></br>
		PLC IP Address <input id="plc_ip" type="text" name="plc_ip" /> <b>(10.10.XXX.XXX)</b></br>
		<input type="hidden" name="addCustMachineNow" value="1" /> </br>
		<input type="submit" value="Add Customer Fusion" /> 
		</form> 
	</div>
<?php } ?>

<?php  echo $newCustomerMachine->listCustomerMachines(); ?>

</body>
</html>

<?php
// close DB connection
mysql_close($dbLink);
?>

