<?php
include_once "../lib/LinkMaker.php"; 
include_once "../lib/Util.php";

class CustomerMachine extends QtmiBaseClass {
    // declare properties
    public $id = -1;    
    public $machine_type = "";
    public $code_base = "";
    public $created_on = "";
    public $customer_id = -1;
    public $customer_machine_id = -1;
    public $customer_name = "";
    public $last_hmi_update = "";
    public $current_hmi_file_id = -1;
    public $current_hmi = "";
    public $current_hmi_version = "";
    public $current_hmi_ip = "";    
    public $last_plc_update = "";
    public $current_plc_file_id = -1;
    public $current_plc = "";
    public $current_plc_version = "";
    public $current_plc_ip = "";
    public $customer = "";
    public $customerMachineContacts;
    public $listFiles;

    private $linkMaker = "";
    private $util = "";
    private $csv_dir = "";


    public $sort = "DESC";    

   function __construct($link, $machine_type) {
       parent::__construct($link);
      // print "In SubClass constructor\n";
      $this->machine_type = $machine_type;
     $this->linkMaker = new LinkMaker($link);
      $this->util = new Util($link);
     $this->customerMachineContacts = new CustomerMachineContacts($link);
     $this->listFiles = new ListFiles($link);
   }

   function __destruct() {
      // parent::__destruct();
      // print "In SubClass deconstructor\n";
   }

	// method declaration
	public function addCustomerMachine() {
		$today = date('y-m-j');
		$this->last_hmi_update = $today;
		$this->last_plc_update = $today;
		
		$query = sprintf("INSERT INTO `hmi_plc_mgr`.`customer_machine` (
		`id` ,
		`machine_type` ,
		`created_on` ,
		`customer_id` ,
		`customer_name` ,
		`last_hmi_update` ,
		`current_hmi_file_id` ,
		`current_hmi` ,
		`current_hmi_version` ,
		`current_hmi_ip` ,
		`last_plc_update` ,
		`current_plc_file_id` ,
		`current_plc` ,
		`current_plc_version` , 
		`current_plc_ip` 
		)
		VALUES (
		NULL , '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'
		);", 
		mysql_real_escape_string($this->machine_type), 
		mysql_real_escape_string($today), 
		mysql_real_escape_string($this->customer_id), 
		mysql_real_escape_string($this->customer_name), 
		mysql_real_escape_string($this->last_hmi_update), 
		mysql_real_escape_string($this->current_hmi_file_id), 
		mysql_real_escape_string($this->current_hmi), 
		mysql_real_escape_string($this->current_hmi_version),
		mysql_real_escape_string($this->current_hmi_ip),
		mysql_real_escape_string($this->last_plc_update), 
		mysql_real_escape_string($this->current_plc_file_id), 
		mysql_real_escape_string($this->current_plc), 
		mysql_real_escape_string($this->current_plc_version),
		mysql_real_escape_string($this->current_plc_ip));
		//echo $query;
		mysql_query($query);
	}


	
	public function listCustomerMachines() {
		$this->linkMaker->machine_type = $this->machine_type;
		
		$rowCounter = 0;
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine` WHERE `customer_machine`.`machine_type` = '%s' ORDER BY `customer_machine`.`id` %s", mysql_real_escape_string($this->machine_type), mysql_real_escape_string($this->sort));

		//echo $query;
		echo "<table border=1  style='background:#F3F7F7' >";
				echo "<tr>";
					echo "<td style='font-size:18'><b>Customer</b></td>";
					echo "<td style='font-size:18'><b>Upgrades</b><br/><img src='img/shim.gif' width=100 height=1 /></td>";
					echo "<td style='font-size:18'><b>HMI</b></td>";
					echo "<td style='font-size:18'><b>HMI Net</b></td>";
					echo "<td style='font-size:18'><b>PLC</b></td>";
					echo "<td style='font-size:18'><b>PLC Net</b></td>";
				echo "</tr>";
		$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				if($rowCounter % 2 == 0) echo "<tr style='background:#F5E0EB'>";
				else echo "<tr>";
				echo "<td valign=top align=left>".$row['created_on']."</br><b style='font-size:24'>".$this->getEditCustomerLink($row['customer_name'], $row['customer_id'], $row['id'])."</b></br>".$this->getContactPopupLink($row['customer_id'], $row['id'])."</br>".$this->getLinksToNotes($row['customer_id'], $row['id'])."</td>";
				echo "<td valign=top align=left>".$this->getUpgrades($row['customer_id'], $row['id'])."</td>";
				$this->linkMaker->code_base = "HMI";
//				echo "<td valign=top align=left>".$row['last_hmi_update']."</br>".$this->linkMaker->getFileLink($row['current_hmi'])."</br><a href='1'>Image</a></br>".$row['current_hmi_version']."</td>";
				echo "<td valign=top align=left>".$row['last_hmi_update']."</br>".$this->linkMaker->getFileLink($row['current_hmi'])."</br>".$row['current_hmi_version']."</br>".$this->getCustomerArchiveLink($row['customer_name'], $row['customer_id'], $row['id'])."</td>";				
				echo "<td valign=top align=left>".$row['current_hmi_ip']."</br>".$this->getLinkToRemoteView($row['customer_id'], $row['id'], $row['current_hmi_ip'])."<a href='1'>Get Data</a></br><a href='1'>Push Data</a></br><a href='customer_load_data.php?customerId=".$row['customer_id']."'>Load Data</a></br></td>";				
				$this->linkMaker->code_base = "PLC";
				echo "<td valign=top align=left>".$row['last_plc_update']."</br>".$this->linkMaker->getFileLink($row['current_plc'])."</br>".$row['current_plc_version']."</br>".$this->getCustomerArchiveLink($row['customer_name'], $row['customer_id'], $row['id'])."</td>";
				echo "<td valign=top align=left>".$row['current_plc_ip']."</td>";
				echo "</tr>";
				$rowCounter++;
			}	
		echo "</table>";
	}
	

	// method declaration
	private function getContactPopupLink($customerId, $customerMachineId) {		
		$baseLink = "<a href='add_contacts_customer_fusion.php?customer_id=".$customerId."&customer_machine_id=".$customerMachineId."'>Add Contact</a>";
		return $baseLink;
	}

	// method declaration
	public function getContactLinkButton() {
		$this->customerMachineContacts->customer_machine_id = $this->customer_machine_id;
		$this->customerMachineContacts->getCustomerContacts();
		$contactsParams = "'".$this->customerMachineContacts->c1_name."', '".$this->customerMachineContacts->c1_number."', '".$this->customerMachineContacts->c1_email."',";
		$contactsParams .= "'".$this->customerMachineContacts->c2_name."', '".$this->customerMachineContacts->c2_number."', '".$this->customerMachineContacts->c2_email."',";
		$contactsParams .= "'".$this->customerMachineContacts->c3_name."', '".$this->customerMachineContacts->c3_number."', '".$this->customerMachineContacts->c3_email."'";
		$baseLink = "<button onclick=\"openCustomerContactsWin(".$contactsParams.")\">CONTACTS</button>";
		return $baseLink;
	}


	// method declaration
	private function getLinksToNotes($customerId, $customerMachineId) {
		$baseUrl = "notes_customer_machine.php?customerId=".$customerId."&customerMachineId=".$customerMachineId."&division=Tech";
		$returnString =  "<a href='".$baseUrl."'>Notes</a>";
		return $returnString;
	}

	// method declaration
	private function getUpgrades($customerId, $customerMachineId) {
		$baseUrl = "upgrades_customer_machine.php?customerId=".$customerId."&customerMachineId=".$customerMachineId."&division=Tech";
		$returnString = $this->getUpgradeCount($customerId)." <a href='".$baseUrl."'>UPGRADES</a>";
//		$baseUrl = "notes_customer_machine.php?customerId=".$customerId."&customerMachineId=".$customerMachineId."&division=Tech";
		return $returnString;
	}
	
	// method declaration
	private function getUpgradeCount($customerId) {
		$query = sprintf("SELECT `customer_machine_upgrade`.`created_on`,`customer_machine_upgrade`.`timeAdded`,`customer_machine_upgrade`.`created_by`,`customer_machine_upgrade`.`upgrade_subject`,`customer_machine_upgrade`.`upgrade`  FROM `hmi_plc_mgr`.`customer_machine_upgrade`, `hmi_plc_mgr`.`machine_upgrade_linker` WHERE `customer_machine_upgrade`.`machine_type` = '%s' AND `machine_upgrade_linker`.`customer_id` = '%s' AND `customer_machine_upgrade`.`id` = `machine_upgrade_linker`.`upgrade_id` ORDER BY `customer_machine_upgrade`.`id` %s", mysql_real_escape_string($this->machine_type), mysql_real_escape_string($customerId), mysql_real_escape_string($this->sort));
		$result = mysql_query($query);
		$num_rows = mysql_num_rows($result);
		return $num_rows;
	}	


	// method declaration
	private function getLinkToRemoteView($customerId, $customerMachineId, $hmiIP) {
		if($this->machine_type == "FUSION")
		$baseUrl = "remote_view_fusion.php?customerId=".$customerId."&customerMachineId=".$customerMachineId."&fusionIp="."http://".$hmiIP."/remote/default.htm?0&division=Tech";
		if($this->machine_type == "HC")
		$baseUrl = "remote_view_hc.php?customerId=".$customerId."&customerMachineId=".$customerMachineId."&fusionIp="."http://".$hmiIP."/remote/default.htm?0&division=Tech";
		$returnString =  "<a href='".$baseUrl."'>Remote View</a></br>";
		return $returnString;
	}


	// method declaration
	private function getEditCustomerLink($customer_name, $customer_id, $machine_id) {
		global $appManager;
	
		$returnString = "";
		
		if($appManager->isAdmin()){
			if($this->machine_type == "FUSION") $returnString = "<a href='edit_customer_fusion.php?customer_id=".$customer_id."&machine_id=".$machine_id."' >".$customer_name."</a>";
			if($this->machine_type == "HC") $returnString = "<a href='edit_customer_hc.php?customer_id=".$customer_id."&machine_id=".$machine_id."' >".$customer_name."</a>";
		}else{
			$returnString = $customer_name;
		}
		return $returnString;
	}

	// method declaration
	private function getCustomerArchiveLink($customer_name, $customer_id, $machine_id) {
		global $appManager;
	
		$returnString = "";
		
		if($appManager->isAdmin()){
			if($this->machine_type == "FUSION") $returnString = "<a href='edit_customer_fusion.php?customer_id=".$customer_id."&machine_id=".$machine_id."' >ARCHIVE</a>";
			if($this->machine_type == "HC") $returnString = "<a href='edit_customer_hc.php?customer_id=".$customer_id."&machine_id=".$machine_id."' >ARCHIVE</a>";
		}else{
			$returnString = $customer_name;
		}
		return $returnString;
	}

	// method declaration
	private function getCustomerDataLink($customer_name, $customer_id, $machine_id) {
		$returnString = "";
		
		if($this->machine_type == "FUSION") $returnString = "<a href='edit_customer_fusion.php?customer_id=".$customer_id."&machine_id=".$machine_id."' >ARCHIVE</a>";
		if($this->machine_type == "HC") $returnString = "<a href='edit_customer_hc.php?customer_id=".$customer_id."&machine_id=".$machine_id."' >ARCHIVE</a>";
		return $returnString;
	}


	// method declaration
	public function editCustomerMachineHMI() {
		//$this->insertArchiveFile(); 	
	
		$today = date('y-m-j');
		$this->last_hmi_update = $today;

		$query = sprintf("UPDATE  `hmi_plc_mgr`.`customer_machine` SET  
				`last_hmi_update` =  '%s',
				`current_hmi_file_id` =  '%s',
				`current_hmi` =  '%s',
				`current_hmi_version` =  '%s'
				WHERE  `customer_machine`.`id` = %s ;", 
				mysql_real_escape_string($this->last_hmi_update ), 
				mysql_real_escape_string($this->current_hmi_file_id),
				mysql_real_escape_string($this->current_hmi),
				mysql_real_escape_string($this->current_hmi_version),
				mysql_real_escape_string($this->id)
				); 
				
				//echo $query;
				mysql_query($query);
	}

	// method declaration
	public function editCustomerMachinePLC() {
		//$this->insertArchiveFile(); 	
		$today = date('y-m-j');
		$this->last_plc_update = $today;

		$query = sprintf("UPDATE  `hmi_plc_mgr`.`customer_machine` SET  
				`last_plc_update` =  '%s',
				`current_plc_file_id` =  '%s',
				`current_plc` =  '%s',
				`current_plc_version` =  '%s'
				WHERE  `customer_machine`.`id` = %s ;", 
				mysql_real_escape_string($this->last_plc_update ), 
				mysql_real_escape_string($this->current_plc_file_id),
				mysql_real_escape_string($this->current_plc),
				mysql_real_escape_string($this->current_plc_version),
				mysql_real_escape_string($this->id)
				); 
				
				//echo $query;
				mysql_query($query);
	}
	
	// method declaration
	public function loadErrors() {
		exec('mkdir ../../customers/error_logs');	
		exec('mkdir ../../customers/error_logs/'.$this->customer->code);	
		exec('mkdir ../../customers/error_logs/'.$this->customer->code.'/'.$this->machine_type);	
		$this->csv_dir = '../../customers/error_logs/'.$this->customer->code.'/'.$this->machine_type.'/';
		$csvFiles = scandir($this->csv_dir, 1);
		
		foreach($csvFiles as $csvFile) 
		{ 
			if($csvFile != "." && $csvFile != ".." ){
				if(!$this->hasFileBeenLogged($csvFile)){
					$csv_array = $this->readErrors($csvFile);
					$this->insertErrors($csv_array);
					$this->insertLoggedFile($csvFile);
				}
			}
		} 



	}	

	// method declaration
	public function hasFileBeenLogged($filename) {
		$returnValue = false;
		
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_error_file_log` WHERE `customer_machine_error_file_log`.`filename` = '%s' AND `customer_machine_error_file_log`.`customer_id` = '%s' AND `customer_machine_error_file_log`.`machine_type` = '%s' ",  mysql_real_escape_string($filename), mysql_real_escape_string($this->customer->id), mysql_real_escape_string($this->machine_type));
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




	// method declaration
	public function readErrors($csvFile) {
		$csv_array = $this->util->csv_to_array($this->csv_dir . $csvFile);
		return $csv_array;
	}	

	// method declaration
	public function insertErrors($csv_array) {
		foreach ($csv_array as &$value) {
			if($this->isErrorPresent($value['Date'], $value['Time']) == 0){
				$query = sprintf("INSERT IGNORE INTO `hmi_plc_mgr`.`customer_machine_error` (
					`id` ,
					`customer_id` ,
					`created_on_date` ,
					`created_on_time` ,
					`type` ,
					`description` 
					)
					VALUES (
					NULL , '%s', '%s', '%s', '%s', '%s'
					);", 
					mysql_real_escape_string($this->customer->id), 
					mysql_real_escape_string($value['Date']), 
					mysql_real_escape_string($value['Time']), 
					mysql_real_escape_string($value['Type']),
					mysql_real_escape_string($value['Description']));
					//echo $query . "\n\n";
				if(mysql_query($query)) echo "inserted!";
			}
		}	
	}	
	
	// method declaration
	public function isErrorPresent($createdDate, $createdTime) {
		$returnValue = 0;	
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_error` WHERE `customer_machine_error`.`customer_id` = '%s' AND `customer_machine_error`.`created_on_date` = '%s' AND `customer_machine_error`.`created_on_time` = '%s' ", mysql_real_escape_string($this->customer->id), mysql_real_escape_string($createdDate),  mysql_real_escape_string($createdTime));
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


	public function insertArchiveFile() {
	$lastUpdate = "";
	$fileId = -1;
	$fileName = "";
	$fileVersion = "";
	$fileIP = "";
	if($this->code_base == "HMI"){
		$lastUpdate = $this->last_hmi_update;
		$fileId = $this->current_hmi_file_id;
		$fileName = $this->current_hmi;
		$fileVersion = $this->current_hmi_version;
		$fileIP = $this->current_hmi_ip;
	}
	if($this->code_base == "PLC"){
		$lastUpdate = $this->last_plc_update;
		$fileId = $this->current_plc_file_id;
		$fileName = $this->current_plc;
		$fileVersion = $this->current_plc_version;
		$fileIP = $this->current_hmi_ip;
	}	
	
				$query = sprintf("INSERT IGNORE INTO `hmi_plc_mgr`.`customer_machine_archive` (
					`id`,
					`machine_type`,
					`code_base`,
					`customer_machine_id`,
					`customer_id`,
					`customer_name`,
					`file_update`,
					`file_id`,
					`file_name`,
					`file_version`,
					`file_ip`
					)
					VALUES (
					NULL , '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'
					);", 
					mysql_real_escape_string($this->machine_type), 
					mysql_real_escape_string($this->code_base), 
					mysql_real_escape_string($this->id), 
					mysql_real_escape_string($this->customer->id), 
					mysql_real_escape_string($this->customer->name), 
					mysql_real_escape_string($lastUpdate), 
					mysql_real_escape_string($fileId), 
					mysql_real_escape_string($fileName), 
					mysql_real_escape_string($fileVersion), 
					mysql_real_escape_string($fileIP));
					//echo $query . "\n\n";
				mysql_query($query);
	}


	public function showArchiveFiles() {
		$this->linkMaker->machine_type = $this->machine_type;
		$this->linkMaker->code_base = $this->code_base;
		
		$rowCounter = 0;
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_archive` WHERE `customer_machine_archive`.`customer_machine_id` = '%s' AND `customer_machine_archive`.`machine_type` = '%s' AND `customer_machine_archive`.`code_base` = '%s' ORDER BY `customer_machine_archive`.`id` %s", mysql_real_escape_string($this->id), mysql_real_escape_string($this->machine_type), mysql_real_escape_string($this->code_base), mysql_real_escape_string($this->sort));

		//echo $query;
		echo "<table border=1  style='background:#F3F7F7' >";
				echo "<tr>";
					echo "<td style='font-size:18'><b>Customer</b></td>";
					echo "<td style='font-size:18'><b>Date</b></td>";
					echo "<td style='font-size:18'><b>File</b></td>";
					echo "<td style='font-size:18'><b>Description</b></td>";
					echo "<td style='font-size:18'><b>Version</b></td>";
					echo "<td style='font-size:18'><b>IP</b></td>";
				echo "</tr>";
		$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				$this->listFiles->setFile($row['file_id']);		
			
				if($rowCounter % 2 == 0) echo "<tr style='background:#F5E0EB'>";
				else echo "<tr>";
				echo "<td valign=top align=left>".$row['customer_name']."</td>";
				echo "<td valign=top align=left>".$row['file_update']."</td>";
				echo "<td valign=top align=left>".$this->linkMaker->getFileLink($row['file_name'])."</td>";
				echo "<td valign=top align=left>".nl2br($this->listFiles->description_of_changes)."</td>";
				echo "<td valign=top align=left>".$row['file_version']."</td>";
				echo "<td valign=top align=left>".$row['file_ip']."</td>";
				echo "</tr>";
				$rowCounter++;
			}	
		echo "</table>";
	}

	public function setCustomerMachine($machineId){
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine` WHERE `customer_machine`.`id` = %s ", mysql_real_escape_string($machineId));
		
		//echo $query;
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
			$this->id = $row['id'];
			$this->customer_name = $row['customer_name'];
			$this->machine_type = $row['machine_type'];
			$this->created_on = $row['created_on'];
			$this->customer_id = $row['customer_id'];
			$this->last_hmi_update = $row['last_hmi_update'];
			$this->current_hmi_file_id = $row['current_hmi_file_id'];
			$this->current_hmi = $row['current_hmi'];
			$this->current_hmi_version = $row['current_hmi_version'];
			$this->current_hmi_ip = $row['current_hmi_ip'];
			$this->last_plc_update = $row['last_plc_update'];
			$this->current_plc_file_id = $row['current_plc_file_id'];
			$this->current_plc = $row['current_plc'];
			$this->current_plc_version = $row['current_plc_version'];
			$this->current_plc_ip = $row['current_plc_ip'];
		}				
	}
	
	public function showCurrentHMIDetails(){	
		$this->linkMaker->machine_type = $this->machine_type;
		$this->linkMaker->code_base = "HMI";	
		$this->listFiles->setFile($this->current_hmi_file_id);			
		//echo $this->current_hmi;		
		echo "<font class='formFieldLabel2'>Current HMI:</font>";
		echo "<table border=1  style='background:#F3F7F7' >";
			echo "<tr>";
				echo "<td style='font-size:18'><b>Date</b></td>";
				echo "<td style='font-size:18'><b>File</b></td>";
				echo "<td style='font-size:18' class='descriptionColumn' ><b>Description</b></td>";
				echo "<td style='font-size:18'><b>Version</b></td>";
				echo "<td style='font-size:18'><b>IP</b></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td valign=top align=left>".$this->last_hmi_update."</td>";
				echo "<td valign=top align=left>".$this->linkMaker->getFileLink($this->current_hmi)."</td>";
				echo "<td valign=top align=left class='descriptionColumn' >".nl2br($this->listFiles->description_of_changes)."</td>";
				echo "<td valign=top align=left>".$this->current_hmi_version."</td>";
				echo "<td valign=top align=left>".$this->current_hmi_ip."</td>";
			echo "</tr>";
		echo "</table>";		
	}

	public function showCurrentPLCDetails(){	
		$this->linkMaker->machine_type = $this->machine_type;
		$this->linkMaker->code_base = "PLC";	
		$this->listFiles->setFile($this->current_plc_file_id);			
		//echo $this->current_hmi;		
		echo "<font class='formFieldLabel2'>Current PLC:</font>";
		echo "<table border=1  style='background:#F3F7F7' >";
			echo "<tr>";
				echo "<td style='font-size:18'><b>Date</b></td>";
				echo "<td style='font-size:18'><b>File</b></td>";
				echo "<td style='font-size:18' class='descriptionColumn' ><b>Description</b></td>";
				echo "<td style='font-size:18'><b>Version</b></td>";
				echo "<td style='font-size:18'><b>IP</b></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td valign=top align=left>".$this->last_plc_update."</td>";
				echo "<td valign=top align=left>".$this->linkMaker->getFileLink($this->current_plc)."</td>";
				echo "<td valign=top align=left class='descriptionColumn' >".nl2br($this->listFiles->description_of_changes)."</td>";
				echo "<td valign=top align=left>".$this->current_plc_version."</td>";
				echo "<td valign=top align=left>".$this->current_plc_ip."</td>";
			echo "</tr>";
		echo "</table>";		
		
	}


}


?>