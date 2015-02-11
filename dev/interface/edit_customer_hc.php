<?php
include_once 'global_includes.php';

// Set Customer ID and machine ID
if(isset($_REQUEST["customer_id"])) $customer_id = $_REQUEST["customer_id"];
if(isset($_REQUEST["machine_id"])) $machine_id = $_REQUEST["machine_id"];

$_SESSION['machine_type'] = "HC";

$newCustomer = new Customer($dbLink);
$newCustomer->setCustomerName($customer_id);

$newCustomerMachine = new CustomerMachine($dbLink, "HC");

$newCustomerMachine->setCustomerMachine($machine_id);

$newCustomerMachine->customer = $newCustomer;
$newCustomerMachine->machine_type = $_SESSION['machine_type'];
$newCustomerMachine->id = $machine_id;


$listFiles = new ListFiles($dbLink);
$listFiles->machine_type = $_SESSION['machine_type'] ;


if(isset($_REQUEST["editCustMachineNow"])){
	$newCustomer->setCustomer($_REQUEST["customer_id"], "h");
	$newCustomerMachine->customer_id = $newCustomer->id;
	$newCustomerMachine->customer_name = $newCustomer->name;
	$newCustomerMachine->id = $machine_id;

	//echo $_REQUEST["hmi_id"];
	if(isset($_REQUEST["hmi_id"]) && $_REQUEST["hmi_id"] != ""){
		$listFiles->setFile($_REQUEST["hmi_id"]);
		$newCustomerMachine->code_base = "HMI";
		$newCustomerMachine->insertArchiveFile(); 			
		$newCustomerMachine->current_hmi_file_id = $listFiles->id;	
		$newCustomerMachine->current_hmi = $listFiles->filename;	
		$newCustomerMachine->current_hmi_version = $listFiles->fileVersion;	
		$newCustomerMachine->editCustomerMachineHMI();
	}

	if(isset($_REQUEST["plc_id"]) && $_REQUEST["plc_id"] != ""){
		$listFiles->setFile($_REQUEST["plc_id"]);
		$newCustomerMachine->code_base = "PLC";	
		$newCustomerMachine->insertArchiveFile(); 		
		$newCustomerMachine->current_plc_file_id = $listFiles->id;	
		$newCustomerMachine->current_plc = $listFiles->filename;	
		$newCustomerMachine->current_plc_version = $listFiles->fileVersion;	
		$newCustomerMachine->editCustomerMachinePLC();
	}
	
	//header('Location: add_customer_hc.php');
}




?>


<html>
<head>
	<?php echo $SYSTEM_cssLink; ?>

<script language="javascript" >
	function checkRequiredFields(){
	  if(document.getElementById('hmi_ip').value.length < 9 || document.getElementById('hmi_ip').value.length > 13) {
	    alert("Your HMI IP needs to be of the following format: 10.10.XXX.XXX");
	    return false;
	  }else if(document.getElementById('plc_ip').value.length < 9 || document.getElementById('plc_ip').value.length > 13){
	    alert("Your PLC IP needs to be of the following format: 10.10.XXX.XXX");
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
<div class='pageTitle' >Edit HC for <?php echo $newCustomer->name; ?></div>

<div>
<a class='breadCrumb' href="homepage.php">Home Page</a> 
</div>
</br>

<div class="formBackground_adm">
	<form name="editCustomerHCForm" action="edit_customer_hc.php" method="POST" onsubmit="return checkRequiredFields()" >
		<table border='0' >
		<tr>
			<td class='formLabel' >
				Customer Name: <?php echo $newCustomer->name; ?>
			</td>
		</tr>
		<input type="hidden"  id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>" /> 
		<input type="hidden"  id="machine_id" name="machine_id" value="<?php echo $machine_id; ?>" /> 
		<tr>
			<td>
				<table border='0' class='selectHMIBackground' >
					<tr>
						<td class='formFieldLabel'>
							Select a Fusion HMI:
						</td>
					</tr>
					<tr>
						<td>
							<select id="hmi_id" name="hmi_id">
							<?php echo $listFiles->code_base = "HMI"; ?>
							<?php echo $listFiles->getSelectFileOptions(); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
						<?php $newCustomerMachine->showCurrentHMIDetails(); ?>	
						</td>
					</tr>				
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table border='0' class='selectPLCBackground'>
					<tr>
						<td class='formFieldLabel'>
						Select a Fusion PLC:
						</td>
					</tr>
					<tr>
						<td>
						<select id="plc_id" name="plc_id">
						<?php echo $listFiles->code_base = "PLC"; ?>
						<?php echo $listFiles->getSelectFileOptions(); ?>
						</select>
						</td>
					</tr>
					<tr>
						<td>
						<?php $newCustomerMachine->showCurrentPLCDetails(); ?>		
						</td>
					</tr>				
				</table>
			</td>
		</tr>
		
		<tr>
			<td>
			<input type="hidden" name="editCustMachineNow" value="1" /> 
			<input type="submit" value="Edit Customer HC" /> 
			</td>
		</tr>

		</tr>
		</table>
	</form> 
</div>






<?php 
$newCustomerMachine->machine_type = $_SESSION['machine_type']; 
$newCustomerMachine->code_base = "HMI"; 
echo "<div class='sectionHeader'>HMI Archives</div>";
$newCustomerMachine->showArchiveFiles(); 
$newCustomerMachine->code_base = "PLC"; 
echo "<div class='sectionHeader'>PLC Archives</div>";
$newCustomerMachine->showArchiveFiles(); 
?>

</body>
</html>

<?php
// close DB connection
mysql_close($dbLink);
?>

