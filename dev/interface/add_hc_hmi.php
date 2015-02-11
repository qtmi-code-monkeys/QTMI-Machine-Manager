<?php
include_once 'global_includes.php';

$systemRev = new SystemRev($dbLink);
$systemRev->machine = "HC";
$systemRev->code_base = "HMI";
$systemRev->populateObj();

$listFiles = new ListFiles($dbLink);
$listFiles->machine_type = "HC";
$listFiles->code_base = "HMI";


?>

<html>
<head>
	<?php echo $SYSTEM_cssLink; ?>
</head>


<body>

<?php echo $SYSTEM_pageTitleLink; ?>
<div class='pageTitle' ><?php echo $listFiles->machine_type; ?> <?php echo $listFiles->code_base; ?></div>
<div>
<a class='breadCrumb' href="homepage.php">Home Page</a> 
</div>


</br>

<?php if($appManager->isAdmin()) {?>
	<div class="formBackground_adm">
		<form name="addFileForm" enctype="multipart/form-data" action="upload_file.php" method="POST">
		Next Full Version Number: <b><?php echo $systemRev->next_full_rev; ?></b></br>
		<input type="hidden" name="nextFullVersionNumber" value="<?php echo $systemRev->next_full_rev; ?>" />
		Next Incremental Version Number: <b><?php echo $systemRev->next_inc_rev; ?></b></br>
		<input type="hidden" name="nextIncVersionNumber" value="<?php echo $systemRev->next_inc_rev; ?>" />
		Upload File <font style='font-size:16; font-weight:16; color:red'> (Extension must be cd3)</font>: </br>
		<input name="qtmiFile" type="file" /> </br>
		<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
		 <h1 class='formLabel' >Description of Changes: </h1> 
		 <textarea id="descriptionOfChanges" name="descriptionOfChanges" rows="10" cols="50"></textarea> </br>
		<input name="incCheckBox" type="checkbox" onclick="releaseBoxInc()" />Incremental release </br> 
		<input name="fullCheckBox" type="checkbox" onclick="releaseBoxFull()" />Full Release</br>
		<input type="hidden" name="machineType" value="<?php echo $systemRev->machine; ?>" />
		<input type="hidden" name="codeBase" value="<?php echo $systemRev->code_base; ?>" />
		<input type="submit" value="Add File" />
		</form>
	</div>
<?php } ?>


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
