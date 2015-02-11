<?php
include_once 'global_includes.php';

$newCustomer = new Customer($dbLink);
$newCustomer->id = $_REQUEST["customerId"];
$newCustomer->setCustomer_noParams();

$newCustomerMachine = new CustomerMachine($dbLink, "FUSION");
$newCustomerMachine->customer_id = $_SESSION['customerId'];
$newCustomerMachine->customer_machine_id = $_SESSION['customerMachineId'];

$customerMachineNote = new CustomerMachineNote($dbLink);
$customerMachineNote->machine_type = $_SESSION['machine_type'];
$customerMachineNote->division = "Tech";
$customerMachineNote->customer_id = $_SESSION['customerId'];
$customerMachineNote->customer_machine_id = $_SESSION['customerMachineId'];


$customerMachineNote->note_subject = "";
$customerMachineNote->note = "";
if(isset($_REQUEST["retreiveMessage"]) && $_REQUEST["retreiveMessage"] == "yes"){
	$customerMachineNote->retrieveMyLastNote();
}

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
<div><a href='add_customer_fusion.php' target='_top' >Back to Customer Fusions</a> | <?php echo $newCustomerMachine->getContactLinkButton(); ?></div>
</td>
<td valign=top >
<div>
	<form target="_top" name="addNotesMachineRemoteView" enctype="multipart/form-data" action="remote_view_fusion.php" method="POST">
		<table>
		<tr class='formBackground' >
			<td>
				<div>

				<a href='remote_view_fusion_frameTop.php?retreiveMessage=yes&customerId=<?php echo $_SESSION['customerId']; ?>'>Retrieve lost message</a></br>
				Subject: <input type="text" name="customerMachineNoteSubject" size="60" value="<?php echo $customerMachineNote->note_subject; ?>" /> <input type="submit" value="Add Note" /></br>			
				<textarea id="machineNote" name="customerMachineNote" rows="5" cols="70"><?php echo $customerMachineNote->note; ?></textarea> 
				<input type="hidden" name="machine_type" value="FUSION" />
				<input type="hidden" name="division" value="Tech" />
				<input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>" />
				<input type="hidden" name="addNoteNow" value="1" />
				</div>			
			</td>
		</tr>
		</table>
	</form>
</div>
</td>
</tr>
</table>
<?php 
echo "<form target='_top' id='searchForm' name='searchForm' action='remote_view_fusion.php' enctype='multipart/form-data'  method='POST'>";
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

