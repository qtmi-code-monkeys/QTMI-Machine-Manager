<?php
include_once 'global_includes.php';

$_SESSION['machine_type'] = "FUSION";
$today = date('y-m-j');
$newCustomer = new Customer($dbLink);
$newCustomer->getCustomers();

function __construct(){
		
}

$listFiles = new ListFiles($dbLink);
$listFiles->machine_type = $_SESSION['machine_type'] ;

$counter =0;

$newCustomerMachineHours = new CustomerMachineHours($dbLink, $_SESSION['machine_type']);
if(isset($_REQUEST["addCustHoursNow"])){
	/*foreach($_REQUEST as $value){
		if(!$counter = 0 || !$counter = 1){
			try{
				settype($value, "int");
			}
			catch(Exception $e){
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		}
	}
	*/

	if($_REQUEST["machineType"] == "f")
		$newCustomerMachineHours->customer_machine_type ="FUSION";
	else if($_REQUEST["machineType"] == "h")
		$newCustomerMachineHours->customer_machine_type ="HC";	
	$newCustomerMachineHours->customer_id = $_REQUEST["customer_id"];
	$newCustomerMachineHours->created_on = $today;	
	$newCustomerMachineHours->turbo_on =$_REQUEST["turboRunTime"];
	$newCustomerMachineHours->water_chiller_run_time = $_REQUEST["chillerRunTime"];
	$newCustomerMachineHours->glow_hydro_rp_on = $_REQUEST["ghrpRunTime"];
	$newCustomerMachineHours->dep_rp_on = $_REQUEST["dcrpRunTime"];
	$newCustomerMachineHours->dep_motor_run_time = $_REQUEST["depMotorRunTime"];
	$newCustomerMachineHours->rotation_motor_o_ring = $_REQUEST["rotMotorORing"];
	$newCustomerMachineHours->glow_hydro_rp_oil_life_meter = $_REQUEST["ghrpOilLife"];
	$newCustomerMachineHours->dep_rough_pump_oil_life = $_REQUEST["dcrpOilLife"];
	$newCustomerMachineHours->lens_count = $_REQUEST["lensCount"];
	$newCustomerMachineHours->lens_count_setpoint = $_REQUEST["lensCountSetpoint"];
	$newCustomerMachineHours->machine_on_time = $_REQUEST["machineRunTime"];
	
	$newCustomerMachineHours->addCustomerMachineHours();
	
}

if(isset($_REQUEST["getCustomerFusionHours"])){
	
		foreach($newCustomer->customers as $id){

			$newCustomer->id = $id;
			$newCustomer->setCustomer_noParams();
			$newCustomerMachineHours->customer_machine_type = "FUSION";
			$newCustomerMachineHours->customer = $newCustomer;
			$newCustomerMachineHours->loadHours();

	}
}

/*  only to be used when we are getting HC hours

if(isset($_REQUEST["getCustomerHCHours"])){
	
		foreach($newCustomer->customers as $id){

			$newCustomer->id = $id;
			$newCustomer->setCustomer_noParams();
			$newCustomerMachineHours->customer_machine_type = "HC";
			$newCustomerMachineHours->customer = $newCustomer;
			$newCustomerMachineHours->loadHours();

	}
}

*/


?>


<html>
<head>
	<?php echo $SYSTEM_cssLink; ?>

	<?php echo $jsWidgets->getCustomerContactsPopupWindow(); ?>
	
<script language="javascript" >
	function checkRequiredFields(){
	  if(document.getElementById('customer_id').value == "" 
	  || document.getElementById('machineType').value == "" 
	  || document.getElementById('turboRunTime').value == "" 
	  || document.getElementById('chillerRunTime').value == "" 
	  || document.getElementById('ghrpRunTime').value == ""
	  || document.getElementById('dcrpRunTime').value == "" 
	  || document.getElementById('depMotorRunTime').value == "" 
	  || document.getElementById('rotMotorORing').value == "" 
	  || document.getElementById('ghrpOilLife').value == ""
	  || document.getElementById('dcrpOilLife').value == "" 
	  || document.getElementById('lensCount').value == "" 
	  || document.getElementById('lensCountSetpoint').value == "" 
	  || document.getElementById('machineRunTime').value == "" ){
	    alert("Please specify ALL of the following:\n Customer, Is Fusion/Is HC, Turbo Run Time, Chiller Run Time,
	    \n Glow & Hydrop Roughing Pump Run Time, Dep Chamber Roughing Pump Run Time, \n
	    Dep Motor Run Time, Rotation Motor O-Ring, Glow & Hydrop Roughing Pump Oil Life,\n
	    Dep Roughing Pump Oil Life, Lens Count, Lens Count Setpoint, Machine Run Time.");
	    return false;
	  }
	  }else{
	   document.form.submit();
	    return true;
	  }
	}

</script>

</head>


<body>

<?php echo $SYSTEM_pageTitleLink; ?>
<div class='pageTitle' >Customer Hour Log</div>

<div>
<a class='breadCrumb' href="homepage.php">Home Page</a> 
</div>
</br>

<?php if($appManager->isAdmin()) {?>
	<div class="formBackground_adm">
		<form name="addCustomerFusionForm" action="view_all_customer_hours.php" method="POST" onsubmit="return checkRequiredFields()" >
		Select a Customer 
		<select id="customer_id" name="customer_id">
		<?php echo $newCustomer->getSelectCustomerOptions('f'); ?>
		</select></br>
		Is HC <input id="machineType" name="machineType" type="radio" value="h"/></br>
		Is Fusion <input id="machineType" name="machineType" type="radio" value="f"/></br>
		Turbo Run Time <input id="turboRunTime" type="text" name="turboRunTime" /> </br>
		Chiller Run Time <input id="chillerRunTime" type="text" name="chillerRunTime" /> </br>
		Glow & Hydro Roughing Pump Run Time <input id="ghrpRunTime" type="text" name="ghrpRunTime" /> </br>
		Dep Chamber Roughing Pump Run Time <input id="dcrpRunTime" type="text" name="dcrpRunTime" /> </br>
		Dep Motor Run Time <input id="depMotorRunTime" type="text" name="depMotorRunTime" /> </br>
		Rotation Motor O-Ring <input id="rotMotorORing" type="text" name="rotMotorORing" /> </br>
		Glow & Hydro Roughing Pump Oil Life <input id="ghrpOilLife" type="text" name="ghrpOilLife" /> </br>
		Dep Roughing Pump Oil Life <input id="dcrpOilLife" type="text" name="dcrpOilLife" /> </br>
		Lens Count	 <input id="lensCount" type="text" name="lensCount" /> </br>
		Lens Count Setpoint	 <input id="lensCountSetpoint" type="text" name="lensCountSetpoint" /> </br>
		Machine Run Time <input id="machineRunTime" type="text" name="machineRunTime" /> </br>
		<input type="hidden" name="addCustHoursNow" value="1" /> </br>
		<input type="submit" value="Add Customer Hour Log" /> 
		</form> 
	</div>
<?php } ?>


<form name="getCustomerFusionHours" action="view_all_customer_hours.php" method="POST">
<input type="hidden" name="getCustomerFusionHours" value="1"/>
<br><input type="submit" value="Refresh Hours" /></br>
</form>


<!-- only to be used when we are getting hours logs from HC machines

<form name="getCustomerHCHours" action="view_all_customer_hours.php" method="POST">
<input type="hidden" name="getCustomerHCHours" value="1"/>
<br><input type="submit" value="Get Customer HC Hours" /></br>
</form>
-->



<?php  echo $newCustomerMachineHours->showAllCustomersMachineHours($newCustomerMachineHours->customer_machine_type);?>

</body>
</html>

<?php
// close DB connection
mysql_close($dbLink);
?>

