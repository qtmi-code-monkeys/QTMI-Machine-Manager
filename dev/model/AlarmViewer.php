<?php 
class AlarmViewer extends QtmiBaseClass {

    public $sort = "ASC";    
    
   function __construct($link) {
       parent::__construct($link);
      // print "In SubClass constructor\n";
   }

   function __destruct() {
      // parent::__destruct();
      // print "In SubClass deconstructor\n";
   }
   
   	// method declaration
	public function getAlarmsForCustomer($customer) {	
		$rowCounter = 0;
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_error` WHERE `customer_machine_error`.`customer_id` = '%s' ORDER BY `created_on_date` DESC, created_on_time DESC LIMIT 0, 100", mysql_real_escape_string($customer->id));

//		echo $query;
		echo "<div><table>";
		echo "<tr><td id='customer_".$customer->id."' class='sectionHeader' >".$customer->name."</td></tr>";		
		echo "<tr><table border=1  style='background:#F3F7F7' >";
				echo "<tr>";
					echo "<td style='font-size:18'><b>Date</b></td>";
					echo "<td style='font-size:18'><b>Time</b></td>";
					echo "<td style='font-size:18'><b>Type</b></td>";
					echo "<td style='font-size:18'><b>Description</b></td>";
				echo "</tr>";
		$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				if($rowCounter % 2 == 0) echo "<tr style='background:#F5E0EB'>";
				else echo "<tr>";
				echo "<td valign=top align=left>".$row['created_on_date']."</td>";
				echo "<td valign=top align=left>".$row['created_on_time']."</td>";
				echo "<td valign=top align=left>".$row['type']."</td>";
				echo "<td valign=top align=left>".$row['description']."</td>";
				echo "</tr>";
				$rowCounter++;
			}	
		echo "</table></tr>";
		echo "</table></div>";

	}

}


?>