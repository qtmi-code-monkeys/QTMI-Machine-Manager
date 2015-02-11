<?php
include_once 'global_includes.php';

$alarmViewer = new AlarmViewer($dbLink);
$customer = new Customer($dbLink);
$customer->getCustomers();
?>




<html>
<head>
	<?php echo $SYSTEM_cssLink; ?>
</head>


<body>

<?php echo $SYSTEM_pageTitleLink; ?>
<div class='pageTitle' >Customer Fusion Alarms</div>

<div>
<a class='breadCrumb' href="homepage.php">Home Page</a> 
</div>
<div>
<a  href="http://10.10.1.2/QTMI_server/getFusionErrors.php">Get Alarms from Machines</a> |  <a  href="http://162.242.221.50/HMI_PLC_MANAGER/dev/interface/refreshErrors.php">Load Alarms into Database</a>
</div>

</br>


<?php
echo "<table>";
echo "<tr>";
echo "<td align='left' valign='top' >";
$custCount = 0;
$columnCount = 5;
foreach ($customer->customers as $id) {
	$customer->id = $id;
	$customer->setCustomer_noParams();
	if($custCount == $columnCount) {echo "</td><td align='left' valign='top'>"; $custCount = 0;}
	echo "<a href='#customer_".$customer->id."'>".$customer->name."</a></br>";
	$custCount++;
}	
echo "</td>";
echo "<tr>";
echo "</table>";
?>


<?php
foreach ($customer->customers as $id) {
	$customer->id = $id;
	$customer->setCustomer_noParams();
	$alarmViewer->getAlarmsForCustomer($customer);
}	
?>


</body>
</html>

<?php
// close DB connection
mysql_close($dbLink);
?>

