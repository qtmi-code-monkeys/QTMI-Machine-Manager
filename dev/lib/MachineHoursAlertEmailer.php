<?php
include_once "../interface/global_includes.php";

class MachineHoursAlertEmailer extends QtmiBaseClass{
	
	public $customer_id = -1;
	public $customer_name = "";
	public $customer_machine_id = -1;
	public $customer_machine_type = "";
	
	private $sendMail = "";
	private $customerMachineHours = "";
	
	function __construct($link, ) {
       parent::__construct($link);
      // print "In SubClass constructor\n";
     $this->machine_type = $machine_type;
     $this->linkMaker = new LinkMaker($link);
     $this->util = new Util($link);
     $this->customerMachineContacts = new CustomerMachineContacts($link);
     $this->sendMail = new sendMail();
     $this->customerMachineHours = 
   }

	public function checkHours($cycle, $part, $part_run_time){
		
		$cycles_times = array(20k, 17.5k, 2160, 720)
		$usage = 0.0;
		foreach($cycle_times as $cycle_time){
			if($cycle == $cycle_time){
				if($part_run_time/$cycle >= .75 && <.90 &&!75% acknowledged){		//checks to see if the hours are within this tier, and if it has been acknowledged
					$query = sprintf("SELECT `75_percent_acknoweledged` FROM `hmi_plc_mgr`.`customer_machine_hours_alerts` WHERE `customer_machine_hours_alerts`.`customer_id` = '%s' AND `customer_machine_hours_alerts`.`machine_id` = '%s' AND `customer_machine_hours_alerts`.`part` = '%s'", mysql_real_escape_string($this->customer_id), 
					mysql_real_escape_string($this->customer_macfhine_id), mysql_real_escape_string($part));
					$result = mysql_query($query);
					echo "<td valign=top align=left style='background-color:yellow'>"								// change the color of the row	cell to Yellow
					if(!$result){
						$this->sendMail->sendUsageEmail($usage_level,$part)																//call the sendMail function for 75%
						$query = sprintf("INSERT INTO `hmi_plc_mgr`.`customer_machine_hours_alerts`( 
						`id`,
						`customer_id`,
						`customer_name`,
						`machine_id`,
						`part`,
						`75_percent_acknowledged`,
						`90_percent_acknowledged`,
						`95_plus_percent_acknowledged`)
						VALUES(
							NULL, '%s','%s','%s','%s', '1', '0', '0'
							);",
							mysql_real_escape_string($this->customer_id),
							mysql_real_escape_string($this->customer_name),
							mysql_real_escape_string($this->customer_machine_id),
							mysql_real_escape_string($part));
							echo $query;
							mysql_query($query);
							
							
					}
				}
				else if(part_run_time/cycle >=90% && < 95% &&!90% acknowledged){	checks to see if the hours are within this tier, and if it has been acknowledged
					change the color of the row cell to orange
				call the sendMail function for 90%
					return 90% usage acknowledged
				}
				else if(part_run_time/cycle == 95% || 96% || 97% || 98% || 99% || 110% &&! acknowledged){	checks to see if the hours are within this tier, and if it has been acknowledged
					change the color of the cell to red
					call the sendMail 95%+ function
				}
			}
		}
	}
}
?>