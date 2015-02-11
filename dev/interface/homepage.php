<?php
include_once 'global_includes.php';

$linkMaker = new linkMaker();
?>

<html>
<head>
	<?php echo $SYSTEM_cssLink; ?>
</head>


<body>

<?php echo $SYSTEM_pageTitleLink; ?>

<div class='pageTitle' >Home Page </div>



<div>
	<table>
		<tr>
			<td colspan=2 class='sectionHeader' >CUSTOMER</td>
		</tr>
		<tr>
			<td>
				<img src='img/shim.gif' width=10 height=1 />
			</td>
			<td class='linksBar' >
			<a href="add_customer.php">Customers</a> | <a href="add_customer_fusion.php">Customer Fusions</a> |  <a href="add_customer_hc.php">Customer Hardcoaters</a>
			</td>
		</tr>			
		<tr>
			<td colspan=2 class='sectionHeader' >FUSION</td>
		</tr>
		<tr>
			<td>
				<img src='img/shim.gif' width=10 height=1 />
			</td>
			<td class='linksBar' >
			<a href="customer_fusion_alarms.php">Alarms</a> | <a href="add_fusion_plc.php">PLC</a>  | <a href="add_fusion_hmi.php">HMI</a> 
		</tr>
<!--		
		
		<tr>
			<td>
				<img src='img/shim.gif' width=10 height=1 />
			</td>
			<td>
			<?php echo $linkMaker->getNotesForMachine("FUSION"); ?>
			</td>
		</tr>
-->		
		<tr>
			<td colspan=2 class='sectionHeader' >HARDCOATER</td>
		</tr>
		<tr>
			<td>
				<img src='img/shim.gif' width=10 height=1 />
			</td>
			<td class='linksBar' >
			<a href="customer_hc_alarms.php">Alarms</a> | <a href="add_hc_plc.php">PLC</a>  | <a href="add_hc_hmi.php">HMI</a> 
			</td>
		</tr>	
<!--		
		<tr>
			<td>
				<img src='img/shim.gif' width=10 height=1 />
			</td>
			<td>
			<?php echo $linkMaker->getNotesForMachine("HC"); ?>
			</td>
		</tr>
-->		
	</table>
</div>

</body>

</html>
