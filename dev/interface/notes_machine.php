<?php
include_once 'global_includes.php';

if(isset($_REQUEST["machine_type"])) $_SESSION['machine_type'] = $_REQUEST["machine_type"];
if(isset($_REQUEST["division"])) $_SESSION['division'] = $_REQUEST["division"];

$machineNote = new MachineNote($dbLink);
$machineNote->machine_type = $_SESSION['machine_type'];
$machineNote->division = $_SESSION['division'];

if(isset($_REQUEST["addNoteNow"])){
	$machineNote->note = $_REQUEST["machineNote"];
	$machineNote->created_by = $_SESSION['username'];
	$machineNote->addMachineNote();
}

$linkMaker = new LinkMaker();
$linkMaker->machine_type = $_SESSION['machine_type'];

?>


<html>
<head>
	<?php echo $SYSTEM_cssLink; ?>
</head>


<body>

<?php echo $SYSTEM_pageTitleLink; ?>
<div class='pageTitle' ><?php echo $machineNote->division; ?> Notes for: <?php echo $machineNote->machine_type; ?> </div>
<div>
<a class='breadCrumb' href="homepage.php">Home Page</a>   
</div>


<?php if ($machineNote->division == "All") : ?>

<br/>
	<div class='sectionHeader' >R and D</div>
	<?php $machineNote->division = "RandD"; ?>
	<?php $machineNote->listMachineNotes(); ?>

	<div class='sectionHeader' >Manufacturing</div>
	<?php $machineNote->division = "Manufacturing"; ?>
	<?php $machineNote->listMachineNotes(); ?>

	<div class='sectionHeader' >Tech</div>
	<?php $machineNote->division = "Tech"; ?>
	<?php $machineNote->listMachineNotes(); ?>

	<div class='sectionHeader' >Process</div>
	<?php $machineNote->division = "Process"; ?>
	<?php $machineNote->listMachineNotes(); ?>


<?php else : ?>

<div class="formBackground">
	<form name="addNotesMachine" enctype="multipart/form-data" action="notes_machine.php" method="POST">
	 <h1 id='formLabel' >Note: </h1> 
	 <textarea id="machineNote" name="machineNote" rows="10" cols="50"></textarea> 
	<input type="hidden" name="machine_type" value="<?php echo $machineNote->machine_type; ?>" />
	<input type="hidden" name="division" value="<?php echo $machineNote->division; ?>" />
	<input type="hidden" name="addNoteNow" value="1" /></br>
	<input type="submit" value="Add Note" />
	</form>
</div>

<?php 
echo "<form id='searchForm' name='searchForm' action='note_machine.php' enctype='multipart/form-data'  method='POST'>";
$searchManager->showSearchForm(); 
echo "</form>";
?>

<?php $machineNote->listMachineNotes(); ?>

<?php endif; ?>
</body>
<?php
// close DB connection
mysql_close($dbLink);
?>