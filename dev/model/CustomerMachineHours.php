<?php
include_once "../lib/LinkMaker.php"; 
include_once "../lib/Util.php";
<<<<<<< HEAD

=======
//include_once "../emailer/sendMail.php";		missing required file Mail.php
 
>>>>>>> hour-meter
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
   	
<<<<<<< HEAD
=======
   	
   	
   	
>>>>>>> hour-meter
    public $customerMachineContacts;
    public $listFiles;
 	public $code_base = "";
 	public $sort = "DESC";
<<<<<<< HEAD
=======
 	public $today;
 	public $creation_date = ""; 
 	public $latestDate = "";
 	
 	public $customer = "";
>>>>>>> hour-meter
    
 	private $linkMaker = "";
    private $util = "";
    private $csv_dir = "";
    
<<<<<<< HEAD
    	//Creates a row in the database for this customer hour log
    	//Manual addition (?)
    	public function addCustomerMachineHours() {
		$today = date('y-m-j');
		$this->last_hmi_update = $today;
		$this->last_plc_update = $today;
=======
    //private $sendMail = '';
    
    	//Creates a row in the database for this customer hour log
    	//Manual addition (?)
    	
    	function __construct($link, $machine_type) {
       parent::__construct($link);
      // print "In SubClass constructor\n";
      $this->customer_machine_type = $machine_type;
     $this->linkMaker = new LinkMaker($link);
      $this->util = new Util($link);
     $this->customerMachineContacts = new CustomerMachineContacts($link);
     $this->listFiles = new ListFiles($link);
     $this->today = date('y-m-j');
     //$this->sendMail = new sendMail();
   }
    	public function addCustomerMachineHours() {
		
>>>>>>> hour-meter
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
<<<<<<< HEAD
		mysql_real_escape_string($this->customer_name), 	//need to change back to customer_name
		mysql_real_escape_string($this->customer_machine_id),	//need to change back to customer_machine_id
=======
		mysql_real_escape_string($this->customer_name), 	
		mysql_real_escape_string($this->customer_machine_id),	
>>>>>>> hour-meter
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
	
<<<<<<< HEAD
	public function showMachineHours() {
		$today = date('y-m-j');
		//$this->linkMaker->machine_type = $this->customer_machine_type;
		//$this->linkMaker->code_base = $this->code_base;
		
		$rowCounter = 0;
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_hours` ORDER BY `customer_machine_hours`.`id`%s",mysql_real_escape_string($this->sort));
		$result = mysql_query($query);
		//echo $query;
=======
	public function showAllCustomersMachineHours($machine_type="FUSION") {	//defaults to showing FUSIONM machine hours	
		$today = date('y-m-j');
		//$this->linkMaker->machine_type = $this->customer_machine_type;
		//$this->linkMaker->code_base = $this->code_base;
		$logDate = "";
		$rowCounter = 0;
		$counter = 0;
		echo "<table border=1  style='background:#F3F7F7' >";
				echo "<tr>";
					echo "<td/><td/><td/><td/><td/><td/><td style='font-size:18'><b>Key</b></td><td/><td/><td/><td/><td/>";
				echo "</tr>";	
				echo "<tr>";
					echo "<td style='font-size:18'><b>Less than 75% part life exhausted</b></td>";	
					echo "<td style='font-size:18'><b>75% - 89% part life exhausted</b></td>";
					echo "<td style='font-size:18'><b>90% - 94% part life exhausted</b></td>";
					echo "<td style='font-size:18'><b>95+% part life exhausted Hours</b></td>";
					echo "<td style='font-size:18'><b>Turbo Hours Set Point</b></td>";
					echo "<td style='font-size:18'><b>Chiller Run Time Set Point</b></td>";
					echo "<td style='font-size:18'><b>Glow & Hydro Roughing Pump Run Time Set Point</b></td>";
					echo "<td style='font-size:18'><b>Dep Chamber Roughing Pump Run Time Set Point</b></td>";
					echo "<td style='font-size:18'><b>Dep Motor Run Time Set Point</b></td>";
					echo "<td style='font-size:18'><b>Rotation Motor O-Ring Set Point</b></td>";
					echo "<td style='font-size:18'><b>Glow & Hydroo Roughing Pump Oil Life Set Point</b></td>";
					echo "<td style='font-size:18'><b>Dep Roughing Pump Oil Life Set Point</b></td>";
				echo "</tr>";	
				echo "<tr>";	
					echo "<td style='font-size:18; background-color:green'></td>";
					echo "<td style='font-size:18; background-color:yellow'></td>";
					echo "<td style='font-size:18; background-color:orange'></td>";
					echo "<td style='font-size:18; background-color:red'></td>";
					echo "<td style='font-size:18'><b>20,000 Hours</b></td>";
					echo "<td style='font-size:18'><b>720 Hours</b></td>";
					echo "<td style='font-size:18'><b>17,500 Hours</b></td>";
					echo "<td style='font-size:18'><b>17,500 Hours</b></td>";
					echo "<td style='font-size:18'><b>17,500 Hours</b></td>";
					echo "<td style='font-size:18'><b>2,160 Hours</b></td>";
					echo "<td style='font-size:18'><b>720 Hours</b></td>";
					echo "<td style='font-size:18'><b>720 Hours</b></td>";							
				echo "</tr></br></br>";
		
>>>>>>> hour-meter
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
<<<<<<< HEAD
				
		
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
=======
		foreach($this->customer->customers as $id){
			
			//print_r($this->customer->customers);
			//print_r($id);
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_hours` WHERE `customer_machine_hours`.`customer_id` = '%s' AND `customer_machine_hours`.`customer_machine_type` = '%s' ORDER BY `created_on` %s limit 1",mysql_real_escape_string($id), mysql_real_escape_string($machine_type), mysql_real_escape_string($this->sort));
				$result = mysql_query($query);	
		//echo $query;
				while ($row = mysql_fetch_assoc($result)) {
				
				
				//$this->listFiles->setFile($row['file_id']);		
			
						if($rowCounter % 2 == 0) echo "<tr style='background:#F5E0EB'>";
						else echo "<tr>";
							echo "<td valign=top align=left>".$row['customer_name']."</td>";
							echo "<td valign=top align=left>".$row['customer_machine_type']."</td>";
							echo "<td valign=top align=left>".$row['created_on']."</td>";
							echo $this->checkHours(0,$row['turbo_on']).$row['turbo_on']."</td>";
							echo $this->checkHours(3,$row['water_chiller_run_time']).$row['water_chiller_run_time']."</td>";
							echo $this->checkHours(1,$row['glow_hydro_rp_on']).$row['glow_hydro_rp_on']."</td>";
							echo $this->checkHours(1,$row['dep_rp_on']).$row['dep_rp_on']."</td>";
							echo $this->checkHours(1,$row['dep_motor_run_time']).$row['dep_motor_run_time']."</td>";
							echo $this->checkHours(2,$row['rotation_motor_o_ring']).$row['rotation_motor_o_ring']."</td>";
							echo $this->checkHours(3,$row['glow_hydro_rp_oil_life_meter']).$row['glow_hydro_rp_oil_life_meter']."</td>";
							echo $this->checkHours(3,$row['dep_rough_pump_oil_life']).$row['dep_rough_pump_oil_life']."</td>";
							echo "<td valign=top align=left>".$row['lens_count']."</td>";
							echo "<td valign=top align=left>".$row['lens_count_setpoint']."</td>";
							echo "<td valign=top align=left>".$row['machine_on_time']."</td>";
						echo "</tr>";
						$rowCounter++;
						}
					}	
		echo "</table>";
	}
	
		public function checkHours($cycle,$hours){
	
		$max_hours = array(20000,17500,2160,720);
		
		//foreach($max_hours as $max_hour){		//was going to loop through the array. dont need to as it can be handle linearly for each hour log
		
			$usage = $hours/$max_hours[$cycle];
			//echo $usage."</br>";
			if($usage >= .75 && $usage < .9){
				return "<td valign=top align=left style='background-color:yellow'>";	
			}
			else if($usage >=.9 && $usage < .95){
				return "<td valign=top align=left style='background-color:orange'>";	
			}
			else if($usage >=.95){
				return "<td valign=top align=left style='background-color:red'>";	
			}
			else{
				return "<td valign=top align=left style='background-color:green'>";	
			}
		//}
			
	}	
	
	/*		Deemed not necessary. Commenting out in case that is reversed in the future.
	
	public function showSelectCustomersMachineHours($machineType="FUSION") {	//defaults to showing FUSIONM machine hours	
		$today = date('y-m-j');
		//$this->linkMaker->machine_type = $this->customer_machine_type;
		//$this->linkMaker->code_base = $this->code_base;
		$logDate = "";
		$rowCounter = 0;
		$counter = 0;
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
		foreach($this->customer->customers as $id){
			
			//print_r($this->customer->customers);
			//print_r($id);
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_hours` WHERE `customer_machine_hours`.`customer_id` = '%s', AND `customer_machine_hours`.`customer_machine_type` = '%s' ORDER BY `created_on` %s limit 1",mysql_real_escape_string($id), mysql_real_escape_string($machineType), mysql_real_escape_string($this->sort));
				$result = mysql_query($query);	
		//echo $query;
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
					}	
		echo "</table>";
	}

	*/

	public function loadHours() {
		exec('mkdir ../../customers/data_logs');	
		exec('mkdir ../../customers/data_logs/'.$this->customer->code);	
		exec('mkdir ../../customers/data_logs/'.$this->customer->code.'/'.$this->customer_machine_type);	
		$this->csv_dir = '../../customers/data_logs/'.$this->customer->code.'/'.$this->customer_machine_type.'/';
		//echo "</br>" . $this->csv_dir . "</br>";
		if(!strcmp($this->customer_machine_type, "FUSION")){
			$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer` WHERE `customer`.`has_fusion` = '1' AND `customer`.`id` ='%s'", mysql_real_escape_string($this->customer->id));
		}
		else if (!strcmp($this->customer_machine_type, "HC")){
			$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer` WHERE `customer`.`has_hc` = '1' AND `customer`.`id` ='%s'", mysql_real_escape_string($this->customer->id));
		}
		$result = mysql_query($query);
		if (!$result) {
   			 $message  = 'Invalid query: ' . mysql_error() . "\n";
   			 $message .= 'Whole query: ' . $query;
   			 die($message);
		}

		while ($row = mysql_fetch_assoc($result)){
			$dirList = scandir($this->csv_dir, 1);
			
			foreach($dirList as $dir) 
			{  
				if($dir != "." && $dir != ".." ){
					$hoursLog = $dir . "/hours.csv";
					//echo $hoursLog;
					$this->creation_date = $dir;	
					if(!$this->haveHoursBeenLogged($hoursLog)){
						//echo "Hours haven't been logged.";
						$csv_array = $this->readHours($hoursLog);
						foreach($csv_array as $value){
							$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine` WHERE `customer_id` = '%s' AND `machine_type` = '%s'",  mysql_real_escape_string($this->customer->id), mysql_real_escape_string($this->customer_machine_type));
							$result = mysql_query($query);
							while ($row = mysql_fetch_assoc($result)) {
								$this->customer_machine_id = $row['id'];
				
							}
			
							$this->customer_name = $this->customer->name;
							$this->customer_id = $this->customer->id;
							$this->turbo_on = $value['Turbo On'];
							$this->water_chiller_run_time = $value[' Water Chiller Run Time'];
							$this->glow_hydro_rp_on = $value[' Glow/Hydro RP On'];
							$this->dep_rp_on = $value[' Dep RP On'];
							$this->dep_motor_run_time = $value[' DEP Motor Run Time'];
							$this->rotation_motor_o_ring = $value[' Rotation Motor O-ring'];
							$this->glow_hydro_rp_oil_life_meter = $value[' Glow Hydro RP Oil Life Meter'];
							$this->dep_rough_pump_oil_life = $value[' DEP Rough Pump Oil Life'];
							$this->lens_count = $value[' Lens Count'];
							$this->lens_count_setpoint = $value[' Lens Count Setpoint'];
							$this->machine_on_time = $value[' Machine On time'];
						}					
						$this->insertHours($csv_array);
						$this->insertLoggedFile($hoursLog);
					}
				}
			} 
	
		}	
	}
>>>>>>> hour-meter

	// method declaration
			
	public function haveHoursBeenLogged($dirName) {
<<<<<<< HEAD
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
		$query = sprintf("INSERT IGNORE INTO `hmi_plc_mgr`.`customer_machine_error_file_log` (
			`id` ,
			`customer_id` ,
			`machine_type` ,
			`filename` 
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
	




=======
		//echo "In 'haveHoursBeenLogged'.";
		$returnValue = false;
		
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_hours_log` WHERE `customer_machine_hours_log`.`dir_name` = '%s' AND `customer_machine_hours_log`.`customer_id` = '%s' AND `customer_machine_hours_log`.`customer_machine_type` = '%s' ",  mysql_real_escape_string($dirName), mysql_real_escape_string($this->customer->id), mysql_real_escape_string($this->customer_machine_type));
		
		$result = mysql_query($query);
		
		
		while ($row = mysql_fetch_assoc($result)) {
			$returnValue = true;
		}
		/*if($returnValue){
			echo "Return value is true".'</br>';
		}
		else
		{
			echo "Return value is false".'</br>';	
		}*/
		return $returnValue;
	}

	// method declaration
	public function insertLoggedFile($dirName) {
		//echo "In 'insertLoggedFile'.".'</br>';
		$query = sprintf("INSERT INTO `hmi_plc_mgr`.`customer_machine_hours_log` (
			`id` ,
			`customer_id` ,
			`customer_name` ,
			`dir_name`,
			`customer_machine_type` 
			)
			VALUES (
			NULL , '%s', '%s', '%s', '%s'
			);", 
			mysql_real_escape_string($this->customer->id), 
			mysql_real_escape_string($this->customer->name), 
			mysql_real_escape_string($dirName),
			mysql_real_escape_string($this->customer_machine_type));
			//echo $query . "\n\n";
			mysql_query($query);
		//if(mysql_query($query)) echo "Logged CSV File \n";
	
}
	
>>>>>>> hour-meter
	// method declaration
	public function readHours($csvFile) {
		$csv_array = $this->util->csv_to_array($this->csv_dir . $csvFile);
		return $csv_array;
	}	

<<<<<<< HEAD
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
				mysql_real_escape_string($this->lens_count));
				mysql_real_escape_string($this->lens_count_setpoint));
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
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_hours` WHERE `customer_machine_hours`.`customer_id` = '%s' AND `customer_machine_error`.`created_on_date` = '%s'", mysql_real_escape_string($this->customer->id), mysql_real_escape_string($createdDate));
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

=======
	// method declaration	
	public function insertHours($csv_array) {			
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
					mysql_real_escape_string($this->customer_name), 	
					mysql_real_escape_string($this->customer_machine_id),	
					mysql_real_escape_string($this->customer_machine_type),		
					mysql_real_escape_string($this->creation_date), 
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
					
					//if(mysql_query($query)) echo "inserted!";
			}
			
	
			
		
						
	}	
>>>>>>> hour-meter
    ?>