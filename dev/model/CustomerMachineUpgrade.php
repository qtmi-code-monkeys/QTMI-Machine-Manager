<?php 
include_once "../model/Customer.php"; 

class CustomerMachineUpgrade extends QtmiBaseClass {
    // declare properties
    public $id = -1;    
    public $machine_type = "";
    public $customer_id = -1;
    public $customer_machine_id = -1;
    
    public $created_by = "";
    public $upgrade_subject = "";
    public $upgrade = "";
    public $sort = "DESC";    
    private $customer = ""; 

    private $searchManager = ""; 

	// Upgrade Array vars
    private $my_upgrade_id = array(); 
    private $my_created_by = array(); 
    private $my_created_on = array(); 
    private $my_time_added = array(); 
    private $my_upgrade_subject = array();
    private $my_upgrade = array();

   function __construct($link) {
       parent::__construct($link);
       $this->customer = new Customer($link); 
      // print "In SubClass constructor\n";
   }

   function __destruct() {
      // parent::__destruct();
      // print "In SubClass deconstructor\n";
   }

	// method declaration
	public function addCustomerMachineUpgrade() {
		$today = date('y-m-j');
		$query = sprintf("INSERT INTO `hmi_plc_mgr`.`customer_machine_upgrade` (
		`id` ,
		`created_on` ,
		`machine_type` ,
		`created_by` ,
		`upgrade_subject`,
		`upgrade`,
		`timeAdded`
		)
		VALUES (
		NULL , '%s', '%s', '%s', '%s', '%s', %s
		);", 
		mysql_real_escape_string($today), 
		mysql_real_escape_string($this->machine_type), 
		mysql_real_escape_string($this->created_by), 
		mysql_real_escape_string($this->upgrade_subject), 
		mysql_real_escape_string($this->upgrade),
		mysql_real_escape_string("CURRENT_TIME()"));
		//echo $query;
		mysql_query($query);
		$ugrade_id = mysql_insert_id();
		$this->linkMachineUpgrade($ugrade_id);
	}

	// method declaration
	public function linkMachineUpgrade($ugrade_id) {
		$today = date('y-m-j');
		$query = sprintf("INSERT INTO `hmi_plc_mgr`.`machine_upgrade_linker` (
		`id` ,
		`created_on` ,
		`timeAdded`,
		`machine_type` ,
		`customer_id` ,
		`upgrade_id` 
		)
		VALUES (
		NULL , '%s', %s, '%s', %s, %s
		);", 
		mysql_real_escape_string($today),
		mysql_real_escape_string("CURRENT_TIME()"),
		mysql_real_escape_string($this->machine_type), 
		mysql_real_escape_string($this->customer_id), 
		mysql_real_escape_string($ugrade_id) 
		);
		//echo $query;
		mysql_query($query);
	}


	public function listCustomerMachineUpgrades() {
		$this->customer->setCustomerName($this->customer_id); 
	
		$rowCounter = 0;
		
		//echo $this->searchManager->getWhereClause();

		$query = sprintf("SELECT `customer_machine_upgrade`.`created_on`,`customer_machine_upgrade`.`timeAdded`,`customer_machine_upgrade`.`created_by`,`customer_machine_upgrade`.`upgrade_subject`,`customer_machine_upgrade`.`upgrade`  FROM `hmi_plc_mgr`.`customer_machine_upgrade`, `hmi_plc_mgr`.`machine_upgrade_linker` WHERE `customer_machine_upgrade`.`machine_type` = '%s' AND `machine_upgrade_linker`.`customer_id` = '%s' AND `customer_machine_upgrade`.`id` = `machine_upgrade_linker`.`upgrade_id` ORDER BY `customer_machine_upgrade`.`id` %s", mysql_real_escape_string($this->machine_type), mysql_real_escape_string($this->customer_id), mysql_real_escape_string($this->sort));

		//echo $query;
		echo "<table border=1  style='background:#F3F7F7' >";
				echo "<tr>";
					echo "<td style='font-size:18'><b>Created On</b></td>";
					echo "<td style='font-size:18'><b>Created By</b></td>";
					echo "<td style='font-size:18'><b>Customer</b></td>";
					echo "<td style='font-size:18'><b>Upgrade</b></td>";
				echo "</tr>";
		$result = mysql_query($query);
		
		//echo $query;
			while ($row = mysql_fetch_assoc($result)) {

				if($rowCounter % 2 == 0) echo "<tr style='background:#F5E0EB'>";
				else echo "<tr>";
				echo "<td valign=top align=left><b>".$row['created_on']."</b></br>".$row['timeAdded']."</td>";
				echo "<td valign=top align=left><b>".$row['created_by']."</b></td>";
				echo "<td valign=top align=left><b>".$this->customer->name."</b></td>";
				echo "<td valign=top align=left class=descriptionColumn><font class=notesSubject>".$row['upgrade_subject']."</font></br><b>".nl2br($row['upgrade'])."</b></td>";
				echo "</tr>";
				$rowCounter++;
			}	
		echo "</table>";
	}	


	// method declaration
	public function saveMyLastUpgrade() {
		$today = date('y-m-j');
		$query = sprintf("INSERT INTO `hmi_plc_mgr`.`my_last_machine_upgrade` (
		`id` ,
		`created_on` ,
		`machine_type` ,
		`customer_id` ,
		`created_by` ,
		`upgrade_subject`,
		`upgrade`,
		`timeAdded`
		)
		VALUES (
		NULL , '%s', '%s', '%s', '%s', '%s', '%s', %s
		);", 
		mysql_real_escape_string($today), 
		mysql_real_escape_string($this->machine_type), 
		mysql_real_escape_string($this->customer_id), 
		mysql_real_escape_string($this->created_by), 
		mysql_real_escape_string($this->upgrade_subject), 
		mysql_real_escape_string($this->upgrade),
		mysql_real_escape_string("CURRENT_TIME()"));
		//echo $query;
		mysql_query($query);
	}
	
	public function retrieveMyLastUpgrade() {
		$this->customer->setCustomerName($this->customer_id); 

	
		$rowCounter = 0;
		

		//echo $this->searchManager->getWhereClause();

		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`my_last_machine_upgrade` WHERE `my_last_machine_upgrade`.`created_by` = '%s' ORDER BY `my_last_machine_upgrade`.`id` ASC",  mysql_real_escape_string($_SESSION['username']));

		//echo $query;
		$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				$this->upgrade_subject = $row['upgrade_subject'];
				$this->upgrade = $row['upgrade'];
			}	
	}	

	public function prepareMyUpgrades() {
		//echo "My Upgrades Prepared";
		
		$query = sprintf("SELECT `machine_upgrade_linker`.`upgrade_id` FROM `hmi_plc_mgr`.`customer_machine_upgrade`, `hmi_plc_mgr`.`machine_upgrade_linker` WHERE  `customer_machine_upgrade`.`machine_type` = '%s' AND `machine_upgrade_linker`.`customer_id` = '%s' AND `customer_machine_upgrade`.`id` =`machine_upgrade_linker`.`upgrade_id` ORDER BY `customer_machine_upgrade`.`id` %s", mysql_real_escape_string($this->machine_type), mysql_real_escape_string($this->customer_id), mysql_real_escape_string($this->sort));

		//echo $query;
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
		    $this->my_upgrade_id[] = $row['upgrade_id']; 
		    //$this->my_created_by[] = $row['created_by']; 
		    //$this->my_created_on[] = $row['created_on']; 
		    //$this->my_time_added[] = $row['timeAdded']; 
		    //$this->my_upgrade_subject[] = $row['upgrade_subject'];
		    //$this->my_upgrade[] = $row['upgrade'];		
		}			
	}	


	public function listAvailableUpgrades() {
		//echo "List Availiable Upgrades";	
		$returnString = "";	
		
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_upgrade` WHERE `customer_machine_upgrade`.`machine_type` = '%s' ORDER BY `customer_machine_upgrade`.`id` %s", mysql_real_escape_string($this->machine_type), mysql_real_escape_string($this->sort));

		//echo $query;
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
			if($this->checkMyUpgrades($row['id'])){
				$baseUrl = "upgrades_customer_machine.php?machine_type=".$row['machine_type']."&username=".$_SESSION['username']."&linkUpgradeNow=1&upgradeId=".$row['id'];
				$returnString .= "<a style='background:#99FF99' href='".$baseUrl."'>".$row['upgrade_subject']."</a><br/>";
			}
				$returnString .= "<br/>";
		}
		echo $returnString;
	}

	public function checkMyUpgrades($check_id) {
		$returnVar = true;
		
		//print_r($this->my_upgrade_id);
		//echo $check_id;
		foreach ($this->my_upgrade_id as &$my_id) {
		    if($my_id == $check_id)
			$returnVar = false;
		}
		return $returnVar;
	}	


}


?>