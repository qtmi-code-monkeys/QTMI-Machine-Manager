<?php
include_once 'global_includes.php';

$newCustomer = new Customer($dbLink);
$newCustomer->id = $_REQUEST["customerId"];
$newCustomer->setCustomer_noParams();

$newCustomerMachine = new CustomerMachine($dbLink, "HC");
$newCustomerMachine->customer_id = $_SESSION['customerId'];
$newCustomerMachine->customer_machine_id = $_SESSION['customerMachineId'];

$customerMachineNote = new CustomerMachineNote($dbLink);
$customerMachineNote->machine_type = $_SESSION['machine_type'];
$customerMachineNote->division = "Tech";
$customerMachineNote->customer_id = $_SESSION['customerId'];
$customerMachineNote->customer_machine_id = $_SESSION['customerMachineId'];


?>


<html>
<head>
	<?php echo $SYSTEM_cssLink; ?>
	<?php echo $jsWidgets->getCustomerContactsPopupWindow(); ?>
</head>


<body>

<table>
<tr>
<td valign=top >
<div class='pageTitle' >Remote view of:  <?php echo $newCustomer->name;?></div>
<div><a href='add_customer_hc.php' target='_top' >Back to Customer HCs</a> | <?php echo $newCustomerMachine->getContactLinkButton(); ?></div>
</td>
<td valign=top >
<div>
	<form target="_top" name="addNotesMachineRemoteView" enctype="multipart/form-data" action="remote_view_fusion.php" method="POST">
		<table>
		<tr>
			<td>
			<input type="text" name="customerMachineNoteSubject" size="60" /></br>			
			<textarea id="machineNote" name="customerMachineNote" rows="5" cols="70"></textarea> 
			<input type="hidden" name="machine_type" value="FUSION" />
			<input type="hidden" name="division" value="Tech" />
			<input type="hidden" name="addNoteNow" value="1" />
			</td>
			<td>
			<input type="submit" value="Add Note" />
			</td>
		</tr>
		</table>
	</form>
</div>
</td>
</tr>
</table>
<?php 
echo "<form target='_top' id='searchForm' name='searchForm' action='remote_view_hc.php' enctype='multipart/form-data'  method='POST'>";
$searchManager->showSearchForm(); 
echo "</form>";
?>
<?php $customerMachineNote->listCustomerMachineNotes(); ?>
</body>
</html>
<?php
// close DB connection
mysql_close($dbLink);
?>

