<?php
include_once 'global_includes.php';
$_SESSION['machine_type'] =  "FUSION";

$machineUpgrade = new MachineUpgrade();
$machineUpgrade->machine_type = $_SESSION['machine_type'];

?>

<html>
<head>
	<?php echo $SYSTEM_cssLink; ?>
</head>


<body>

<?php echo $SYSTEM_pageTitleLink; ?>
<div class='pageTitle' ><?php echo $listFiles->machine_type; ?> </div>
<div>
<a class='breadCrumb' href="homepage.php">Fusion Upgrades</a> 
</div>


</br>

<?php if($appManager->isAdmin()) {?>
	<div class="formBackground_adm">
		<form name="addFileForm" enctype="multipart/form-data" action="add_fusion_upgrade.php" method="POST" >
		<h1 class='formLabel' >Next Full Version Number: <b id='boldValue' ><?php echo $systemRev->next_full_rev; ?></h1>
		<input type="hidden" name="nextFullVersionNumber" value="<?php echo $systemRev->next_full_rev; ?>" />
		<h1 class='formLabel' >Next Incremental Version Number: <b id='boldValue' ><?php echo $systemRev->next_inc_rev; ?></b></h1>
		<input type="hidden" name="nextIncVersionNumber" value="<?php echo $systemRev->next_inc_rev; ?>" />
		<h1 class='formLabel' >Upload File: <font style='font-size:16; font-weight:16; color:red'>  (Extension must be cd3)</font> </h1>
		<h1 class='formLabel' ><input name="qtmiFile" type="file" /> </h1>
		<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
		 <h1 class='formLabel' >Description of Changes: </h1> 
		 <textarea id="descriptionOfChanges" name="descriptionOfChanges" rows="10" cols="50" ></textarea> 
		<h1 class='formLabel' ><input name="incCheckBox" type="checkbox" onclick="releaseBoxInc()" />Incremental release </h1> 
		<h1 class='formLabel' ><input name="fullCheckBox" type="checkbox" onclick="releaseBoxFull()" />Full Release</h1>
		<input type="hidden" name="machineType" value="<?php echo $systemRev->machine; ?>" />
		<input type="hidden" name="codeBase" value="<?php echo $systemRev->code_base; ?>" />
		<input type="submit" value="Add File" />
		</form>
	</div>
	
	
	
	<div class="formBackground">
		<form name="addNotesMachine" enctype="multipart/form-data" action="add_fusion_upgrade.php" method="POST">
		 <h1 id='formLabel' >Upgrade: </h1> 
		Subject: <input type="text" name="customerMachineNoteSubject" size="60" value="<?php echo $customerMachineNote->note_subject; ?>" /></br>
		 <textarea id="machineNote" name="customerMachineNote" rows="10" cols="50"><?php echo $customerMachineNote->note; ?></textarea> 
		<input type="hidden" name="machine_type" value="<?php echo $customerMachineNote->machine_type; ?>" />
		<input type="hidden" name="division" value="<?php echo $customerMachineNote->division; ?>" />
		<input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>" />
		<input type="hidden" name="addNoteNow" value="1" /></br>
		<input type="submit" value="Add Note" />
		</form>
	</div>	
<?php }?>


<?php $listFiles->listAllFiles(); ?> </br>


<script language="javascript" >
function releaseBoxInc(){
	document.addFileForm.fullCheckBox.checked = false;
}
function releaseBoxFull(){
	document.addFileForm.incCheckBox.checked = false;
}
</script >

</body>
</html>

<?php
// close DB connection
mysql_close($dbLink);
?>
