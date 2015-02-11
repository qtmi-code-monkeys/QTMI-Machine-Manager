<?php
include_once 'global_includes.php';
$_SESSION['machine_type'] =  "FUSION";
$_SESSION['code_base'] =  "HMI";	


$systemRev = new SystemRev($dbLink);
$systemRev->machine = "FUSION";
$systemRev->code_base = "HMI";
$systemRev->populateObj();

$listFiles = new ListFiles($dbLink);
$listFiles->machine_type = "FUSION";
$listFiles->code_base = "HMI";

$linkMaker = new linkMaker();
$linkMaker->machine_type = "FUSION";
$linkMaker->code_base = "HMI";

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
		<form name="addFileForm" enctype="multipart/form-data" action="upload_file.php" method="POST" >
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
