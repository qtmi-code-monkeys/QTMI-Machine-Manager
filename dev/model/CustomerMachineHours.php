<?php
include_once "../lib/LinkMaker.php"; 
include_once "../lib/Util.php";
 
class CustomerMachineHours extends QtmiBaseClass {
    // declare properties
    public $id = -1;       
    public $customer_id = -1;
    public $customer_name = -1;
    public $customer_machine_id = -1;
    public $customer_machine_type = "";
    public $created_on = "";
   	public $turbo_on = "";
   	public $water_chiller_run_time = "";
   	public $glow_hydro_rp_on = "";
   	public $dep_rp_on = "";
   	public $dep_motor_run_time = "";
   	public $rotation_motor_o_ring = "";
   	public $glow_hydro_rp_oil_life_meter = "";
   	public $dep_rough_pump_oil_life = "";
   	public $lens_count = "";
   	public $lens_count_setpoint = "";   	
   	public $machine_on_time = "";
   	
    public $customerMachineContacts;
    public $listFiles;
 	public $code_base = "";
 	public $sort = "DESC";
    
 	private $linkMaker = "";
    private $util = "";
    private $csv_dir = "";
    
    	//Creates a row in the database for this customer hour log
    	//Manual addition (?)
    	public function addCustomerMachineHours() {
		$today = date('y-m-j');
		$this->last_hmi_update = $today;
		$this->last_plc_update = $today;
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine` WHERE `customer_id` = '%s' AND `machine_type` = '%s'",  mysql_real_escape_string($this->customer_id), mysql_real_escape_string($this->customer_machine_type));
		$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				$this->customer_machine_id = $row['id'];
				$this->customer_name = $row['customer_name'];
				
			}
			
		
		$query = sprintf("INSERT INTO `hmi_plc_mgr`.`customer_machine_hours` (
		`id`,
		`customer_id`, 
		`customer_name`, 
		`customer_machine_id`, 
		`customer_machine_type`, 
		`created_on`, 
		`turbo_on`, 
		`water_chiller_run_time`, 
		`glow_hydro_rp_on`, 
		`dep_rp_on`, 
		`dep_motor_run_time`, 
		`rotation_motor_o_ring`, 
		`glow_hydro_rp_oil_life_meter`, 
		`dep_rough_pump_oil_life`, 
		`lens_count`, 
		`lens_count_setpoint`, 
		`machine_on_time`
		
		)
		VALUES (
		NULL ,'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'
		);",  
		mysql_real_escape_string($this->customer_id), 
		mysql_real_escape_string($this->customer_name), 	//need to change back to customer_name
		mysql_real_escape_string($this->customer_machine_id),	//need to change back to customer_machine_id
		mysql_real_escape_string($this->customer_machine_type),		
		mysql_real_escape_string($today), 
		mysql_real_escape_string($this->turbo_on), 
		mysql_real_escape_string($this->water_chiller_run_time), 
		mysql_real_escape_string($this->glow_hydro_rp_on),
		mysql_real_escape_string($this->dep_rp_on),
		mysql_real_escape_string($this->dep_motor_run_time), 
		mysql_real_escape_string($this->rotation_motor_o_ring), 
		mysql_real_escape_string($this->glow_hydro_rp_oil_life_meter), 
		mysql_real_escape_string($this->dep_rough_pump_oil_life),
		mysql_real_escape_string($this->lens_count),
		mysql_real_escape_string($this->lens_count_setpoint),
		mysql_real_escape_string($this->machine_on_time));
		//echo $query;
		mysql_query($query);
		
		/*		Debug code to check info being submitted to the database
		echo "<table border=1  style='background:#F3F7F7' >";
				echo "<tr>";
					echo "<td style='font-size:18'><b>Customer</b></td>";
					echo "<td style='font-size:18'><b>Machine</b></td>";
					echo "<td style='font-size:18'><b>Date</b></td>";
					echo "<td style='font-size:18'><b>Turbo Hours</b></td>";
					echo "<td style='font-size:18'><b>Chiller Run Time</b></td>";
					echo "<td style='font-size:18'><b>Glow & Hydro Roughing Pump Run Time</b></td>";
					echo "<td style='font-size:18'><b>Dep Chamber Roughing Pump Run Time</b></td>";
					echo "<td style='font-size:18'><b>Dep Motor Run Time</b></td>";
					echo "<td style='font-size:18'><b>Rotation Motor O-Ring</b></td>";
					echo "<td style='font-size:18'><b>Glow & Hydroo Roughing Pump Oil Life</b></td>";
					echo "<td style='font-size:18'><b>Dep Roughing Pump Oil Life</b></td>";
					echo "<td style='font-size:18'><b>Lens Count</b></td>";
					echo "<td style='font-size:18'><b>Lens Count Setpoint</b></td>";
					echo "<td style='font-size:18'><b>Machine Run Time</b></td>";					
				echo "</tr>";
				echo "<tr>";
					echo "<td style='font-size:18'>".$this->customer_id."</td>";
					echo "<td style='font-size:18'>".$this->customer_machine_type."</td>";
					echo "<td style='font-size:18'>".$today."</td>";
					echo "<td style='font-size:18'>".$this->turbo_on."</td>";
					echo "<td style='font-size:18'>".$this->water_chiller_run_time."</td>";
					echo "<td style='font-size:18'>".$this->glow_hydro_rp_on."</td>";
					echo "<td style='font-size:18'>".$this->dep_rp_on."</td>";
					echo "<td style='font-size:18'>".$this->dep_motor_run_time."</td>";
					echo "<td style='font-size:18'>".$this->rotation_motor_o_ring."</td>";
					echo "<td style='font-size:18'>".$this->glow_hydro_rp_oil_life_meter."</td>";
					echo "<td style='font-size:18'>".$this->dep_rough_pump_oil_life."</td>";
					echo "<td style='font-size:18'>".$this->lens_count."</td>";
					echo "<td style='font-size:18'>".$this->lens_count_setpoint."</td>";
					echo "<td style='font-size:18'>".$this->machine_on_time."</td>";					
				echo "</tr>";			
				echo "<tr>";
					echo "<td style='font-size:18'>".settype($this->customer_id, "int")."</td>";
					echo "<td style='font-size:18'>".settype($this->customer_machine_type, "string")."</td>";
					echo "<td style='font-size:18'>".$today."</td>";
					echo "<td style='font-size:18'>".settype($this->turbo_on, "int")."</td>";
					echo "<td style='font-size:18'>".settype($this->water_chiller_run_time, "int")."</td>";
					echo "<td style='font-size:18'>".settype($this->glow_hydro_rp_on, "int")."</td>";
					echo "<td style='font-size:18'>".settype($this->dep_rp_on, "int")."</td>";
					echo "<td style='font-size:18'>".settype($this->dep_motor_run_time, "int")."</td>";
					echo "<td style='font-size:18'>".settype($this->rotation_motor_o_ring, "int")."</td>";
					echo "<td style='font-size:18'>".settype($this->glow_hydro_rp_oil_life_meter, "int")."</td>";
					echo "<td style='font-size:18'>".settype($this->dep_rough_pump_oil_life, "int")."</td>";
					echo "<td style='font-size:18'>".settype($this->lens_count, "int")."</td>";
					echo "<td style='font-size:18'>".settype($this->lens_count_setpoint, "int")."</td>";
					echo "<td style='font-size:18'>".settype($this->machine_on_time, "int")."</td>";					
				echo "</tr>";
				echo "<tr>";
					echo "<td style='font-size:18'>".gettype($this->customer_id)."</td>";
					echo "<td style='font-size:18'>".gettype($this->customer_machine_type)."</td>";
					echo "<td style='font-size:18'>".gettype($today)."</td>";
					echo "<td style='font-size:18'>".gettype($this->turbo_on)."</td>";
					echo "<td style='font-size:18'>".gettype($this->water_chiller_run_time)."</td>";
					echo "<td style='font-size:18'>".gettype($this->glow_hydro_rp_on)."</td>";
					echo "<td style='font-size:18'>".gettype($this->dep_rp_on)."</td>";
					echo "<td style='font-size:18'>".gettype($this->dep_motor_run_time)."</td>";
					echo "<td style='font-size:18'>".gettype($this->rotation_motor_o_ring)."</td>";
					echo "<td style='font-size:18'>".gettype($this->glow_hydro_rp_oil_life_meter)."</td>";
					echo "<td style='font-size:18'>".gettype($this->dep_rough_pump_oil_life)."</td>";
					echo "<td style='font-size:18'>".gettype($this->lens_count)."</td>";
					echo "<td style='font-size:18'>".gettype($this->lens_count_setpoint)."</td>";
					echo "<td style='font-size:18'>".gettype($this->machine_on_time)."</td>";					
				echo "</tr>";	
				echo "<tr>";
					echo "<td style='font-size:18'>".$this->customer_id."</td>";
					echo "<td style='font-size:18'>".$this->customer_machine_type."</td>";
					echo "<td style='font-size:18'>".$today."</td>";
					echo "<td style='font-size:18'>".$this->turbo_on."</td>";
					echo "<td style='font-size:18'>".$this->water_chiller_run_time."</td>";
					echo "<td style='font-size:18'>".$this->glow_hydro_rp_on."</td>";
					echo "<td style='font-size:18'>".$this->dep_rp_on."</td>";
					echo "<td style='font-size:18'>".$this->dep_motor_run_time."</td>";
					echo "<td style='font-size:18'>".$this->rotation_motor_o_ring."</td>";
					echo "<td style='font-size:18'>".$this->glow_hydro_rp_oil_life_meter."</td>";
					echo "<td style='font-size:18'>".$this->dep_rough_pump_oil_life."</td>";
					echo "<td style='font-size:18'>".$this->lens_count."</td>";
					echo "<td style='font-size:18'>".$this->lens_count_setpoint."</td>";
					echo "<td style='font-size:18'>".$this->machine_on_time."</td>";					
				echo "</tr>";
				*/
	}
	
	public function showMachineHours() {
		$today = date('y-m-j');
		//$this->linkMaker->machine_type = $this->customer_machine_type;
		//$this->linkMaker->code_base = $this->code_base;
		
		$rowCounter = 0;
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_hours` ORDER BY `customer_machine_hours`.`id`%s",mysql_real_escape_string($this->sort));
		$result = mysql_query($query);
		//echo $query;
		echo "<table border=1  style='background:#F3F7F7' >";
				echo "<tr>";
					echo "<td style='font-size:18'><b>Customer</b></td>";
					echo "<td style='font-size:18'><b>Machine</b></td>";
					echo "<td style='font-size:18'><b>Date</b></td>";
					echo "<td style='font-size:18'><b>Turbo Hours</b></td>";
					echo "<td style='font-size:18'><b>Chiller Run Time</b></td>";
					echo "<td style='font-size:18'><b>Glow & Hydro Roughing Pump Run Time</b></td>";
					echo "<td style='font-size:18'><b>Dep Chamber Roughing Pump Run Time</b></td>";
					echo "<td style='font-size:18'><b>Dep Motor Run Time</b></td>";
					echo "<td style='font-size:18'><b>Rotation Motor O-Ring</b></td>";
					echo "<td style='font-size:18'><b>Glow & Hydroo Roughing Pump Oil Life</b></td>";
					echo "<td style='font-size:18'><b>Dep Roughing Pump Oil Life</b></td>";
					echo "<td style='font-size:18'><b>Lens Count</b></td>";
					echo "<td style='font-size:18'><b>Lens Count Setpoint</b></td>";
					echo "<td style='font-size:18'><b>Machine Run Time</b></td>";					
				echo "</tr>";
				
		
			while ($row = mysql_fetch_assoc($result)) {
				//$this->listFiles->setFile($row['file_id']);		
			
				if($rowCounter % 2 == 0) echo "<tr style='background:#F5E0EB'>";
				else echo "<tr>";
					echo "<td valign=top align=left>".$row['customer_name']."</td>";
					echo "<td valign=top align=left>".$row['customer_machine_type']."</td>";
					echo "<td valign=top align=left>".$row['created_on']."</td>";
					echo "<td valign=top align=left>".$row['turbo_on']."</td>";
					echo "<td valign=top align=left>".$row['water_chiller_run_time']."</td>";
					echo "<td valign=top align=left>".$row['glow_hydro_rp_on']."</td>";
					echo "<td valign=top align=left>".$row['dep_rp_on']."</td>";
					echo "<td valign=top align=left>".$row['dep_motor_run_time']."</td>";
					echo "<td valign=top align=left>".$row['rotation_motor_o_ring']."</td>";
					echo "<td valign=top align=left>".$row['glow_hydro_rp_oil_life_meter']."</td>";
					echo "<td valign=top align=left>".$row['dep_rough_pump_oil_life']."</td>";
					echo "<td valign=top align=left>".$row['lens_count']."</td>";
					echo "<td valign=top align=left>".$row['lens_count_setpoint']."</td>";
					echo "<td valign=top align=left>".$row['machine_on_time']."</td>";
				echo "</tr>";
				$rowCounter++;
			}	
		echo "</table>";
	}
	
	

	
	public function loadHours() {
		exec('mkdir ../../customers/hours_logs');	
		exec('mkdir ../../customers/hours_logs/'.$this->customer->code);	
		exec('mkdir ../../customers/hours_logs/'.$this->customer->code.'/'.$this->machine_type);	
		$this->csv_dir = '../../customers/hours_logs/'.$this->customer->code.'/'.$this->machine_type.'/';
		$dirList = scandir($this->csv_dir, 1);
		
		foreach($dirList as $dir) 
		{  
		
			$hoursLog = $dir . "/hours.csv";
				
			if(!$this->haveHoursBeenLogged($hoursLog)){
				$csv_array = $this->readHours($hoursLog);
				$this->insertHours($csv_array);
				$this->insertLoggedFile($hoursLog);
			}
			
		} 

	}	

	// method declaration
			
	public function haveHoursBeenLogged($dirName) {
		$returnValue = false;
		
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_hours_log` WHERE `customer_machine_hours_log`.`dirName` = '%s' AND `customer_machine_hours_log`.`customer_id` = '%s' AND `customer_machine_hours_log`.`machine_type` = '%s' ",  mysql_real_escape_string($dirName), mysql_real_escape_string($this->customer->id), mysql_real_escape_string($this->machine_type));
		//echo $query;
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
			$returnValue = true;
		}
		return $returnValue;
	}
	 


	// method declaration
	public function insertLoggedFile($filename) {
		$query = sprintf("INSERT IGNORE INTO `hmi_plc_mgr`.`customer_machine_hours_log` (
			`id` ,
			`customer_id` ,
			`machine_type` ,
			`dir_name` 
			)
			VALUES (
			NULL , '%s', '%s', '%s'
			);", 
			mysql_real_escape_string($this->customer->id), 
			mysql_real_escape_string($this->machine_type), 
			mysql_real_escape_string($filename));
			//echo $query . "\n\n";
		if(mysql_query($query)) echo "Logged CSV File \n";
	
	}
	




	// method declaration
	public function readHours($csvFile) {
		$csv_array = $this->util->csv_to_array($this->csv_dir . $csvFile);
		return $csv_array;
	}	

	// method declaration	
	public function insertHours($csv_array) {
		foreach ($csv_array as &$value) {
			if($this->areHoursPresent($value['Date']) == 0){
				$query = sprintf("INSERT IGNORE INTO `hmi_plc_mgr`.`customer_machine_hours` (
				`id` ,
				`customer_id` ,
				`customer_name` ,
				`customer_machine_id` ,
				`created_on` ,
				`turbo_on` ,
				`water_chiller_run_time` ,
				`glow_hydro_rp_on` ,
				`dep_rp_on` ,
				`dep_motor_run_time` ,
				`rotation_motor_o_ring` ,
				`glow_hydro_rp_oil_life_meter` ,
				`dep_rough_pump_oil_life` ,
				`lens_count` ,
				`lens_count_setpoint` ,
				`machine_on_time` ,
		
				)
				VALUES (
				NULL , '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'
				);", 
				mysql_real_escape_string($this->id),  
				mysql_real_escape_string($this->customer_id), 
				mysql_real_escape_string($this->customer_name), 
				mysql_real_escape_string($this->customer_machine_id),
				mysql_real_escape_string($today), 
				mysql_real_escape_string($this->turbo_on), 
				mysql_real_escape_string($this->water_chiller_run_time), 
				mysql_real_escape_string($this->glow_hydro_rp_on),
				mysql_real_escape_string($this->dep_rp_on),
				mysql_real_escape_string($this->dep_motor_run_time), 
				mysql_real_escape_string($this->rotation_motor_o_ring), 
				mysql_real_escape_string($this->glow_hydro_rp_oil_life_meter), 
				mysql_real_escape_string($this->dep_rough_pump_oil_life),
				mysql_real_escape_string($this->lens_count);
				mysql_real_escape_string($this->lens_count_setpoint);
				mysql_real_escape_string($this->machine_on_time));
				//echo $query;
				mysql_query($query);
					//echo $query . "\n\n";
				if(mysql_query($query)) echo "inserted!";
			}
		}	
	}	
	
	// method declaration
	public function areHoursPresent($createdDate) {
		$returnValue = 0;	
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_hours` WHERE `customer_machine_hours`.`customer_id` = '%s' AND `customer_machine_hours`.`created_on_date` = '%s'", mysql_real_escape_string($this->customer->id), mysql_real_escape_string($createdDate));
		//echo $query . "\n\n";
		if($result = mysql_query($query)){
			echo "Result reached". "\n";
		}else{
			echo "Result not reached". "\n";
		}
		while ($row = mysql_fetch_assoc($result)) {
			$returnValue = 1;
		}
		return $returnValue;
		
	}
	
	

		
	}

    ?>