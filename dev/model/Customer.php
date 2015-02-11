<?php 
class Customer extends QtmiBaseClass {
    // declare properties
    public $id = -1;    
    public $name = "";
    public $code = "";
    public $has_hc = "";
    public $has_fusion = "";
    public $has_hc_html = "";
    public $has_fusion_html = "";
    public $sort = "DESC";    
    
    public $customers = array();    

   function __construct($link) {
       parent::__construct($link);
      // print "In SubClass constructor\n";
   }

   function __destruct() {
      // parent::__destruct();
      // print "In SubClass deconstructor\n";
   }
   
   	// method declaration
	public function getCustomers() {	
		$query = "SELECT * FROM `hmi_plc_mgr`.`customer`";
		//echo $query;
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
			$this->customers[] = $row['id'];
		}	

	}

	// method declaration
	public function addCustomer() {
		$today = date('y-m-j');
		$query = sprintf("INSERT INTO `hmi_plc_mgr`.`customer` (
		`id` ,
		`created_on` ,
		`name` ,
		`code` ,
		`has_hc` ,
		`has_fusion`
		)
		VALUES (
		NULL , '%s', '%s', '%s', '%s', '%s'
		);", 
		mysql_real_escape_string($today), 
		mysql_real_escape_string($this->name), 
		mysql_real_escape_string($this->code), 
		mysql_real_escape_string($this->has_hc), 
		mysql_real_escape_string($this->has_fusion));
	//	echo $query;
		mysql_query($query);
	}
	
	public function listCustomers() {
		global $appManager;
		
		$rowCounter = 0;
		$custUrl = "edit_customer.php?custId=";
		
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer` ORDER BY `customer`.`id` %s",  mysql_real_escape_string($this->sort));

		//echo $query;
		echo "<table border=1  style='background:#F3F7F7' >";
				echo "<tr>";
					echo "<td style='font-size:18'><b>Created On</b></td>";
					echo "<td style='font-size:18'><b>Customer Name</b></td>";
					echo "<td style='font-size:18'><b>Customer Code</b></td>";
					echo "<td style='font-size:18'><b>Has Hardcoater</b></td>";
					echo "<td style='font-size:18'><b>Has Fusion</b></td>";
				echo "</tr>";
		$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				if($rowCounter % 2 == 0) echo "<tr style='background:#F5E0EB'>";
				else echo "<tr>";
				echo "<td><b>".$row['created_on']."</b></td>";
				if($appManager->isAdmin())
					echo "<td><a href='". $custUrl . $row['id'] ."'>". $row['name'] ."</a></td>";
				else
					echo "<td>". $row['name'] ."</td>";
				echo "<td>".$row['code']."</td>";
				echo "<td>".$row['has_hc']."</td>";
				echo "<td>".$row['has_fusion']."</td>";
				echo "</tr>";
				$rowCounter++;
			}	
		echo "</table>";
	}	
	
	public function getCustData() {
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer` WHERE `customer`.`id` = %s",  mysql_real_escape_string($this->id));
		$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				$this->id = $row['id'];
				$this->name = $row['name'];
				$this->code = $row['code'];
				$this->has_hc = $row['has_hc'];
				$this->has_fusion = $row['has_fusion'];
			}
			if($this->has_hc == 1) $this->has_hc_html = "checked=1";
			if($this->has_fusion == 1) $this->has_fusion_html = "checked=1";
	}	

	public function updateCust() {
		$query = sprintf("UPDATE  `hmi_plc_mgr`.`customer` SET  `name` =  '%s', `code` =  '%s', `has_hc` =  '%s', `has_fusion` =  '%s' WHERE  `customer`.`id` =%s;",  mysql_real_escape_string($this->name), mysql_real_escape_string($this->code), mysql_real_escape_string($this->has_hc), mysql_real_escape_string($this->has_fusion), mysql_real_escape_string($this->id));
		//echo $query;
		$result = mysql_query($query);

	}
	
	// method declaration
	public function getSelectCustomerOptions($machine) {
		if($machine == "f") $machineSql = "has_fusion";
		if($machine == "h") $machineSql = "has_hc";
		$resultingOptions = "";
	
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer` WHERE `customer`.`%s` = 1",  mysql_real_escape_string($machineSql));
		//echo $query;
		$result = mysql_query($query);
		
		echo "<option value=''></option>";
		while ($row = mysql_fetch_assoc($result)) {
			$resultingOptions .= "<option value='".$row['id']."'>".$row['name']."</option>";
		}
		echo $resultingOptions;	
	}

	// method declaration
	public function setCustomer_noParams() {	
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer` WHERE `customer`.`id` = %s",  mysql_real_escape_string($this->id));
		//echo $query;
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
				$this->id = $row['id'];
				$this->name = $row['name'];
				$this->code = $row['code'];				
		}
	}	

	// method declaration
	public function setCustomer($custId, $machine) {	
		if($machine == "f") $machineSql = "has_fusion";
		if($machine == "h") $machineSql = "has_hc";
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer` WHERE `customer`.`id` = %s AND `customer`.`%s` = 1",  mysql_real_escape_string($custId),  mysql_real_escape_string($machineSql));
		//echo $query;
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
				$this->id = $row['id'];
				$this->name = $row['name'];
				$this->code = $row['code'];				
		}
	}
		
	// method declaration
	public function setCustomerName($custId) {	
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer` WHERE `customer`.`id` = %s ",  mysql_real_escape_string($custId));
		//echo $query;
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
				$this->name = $row['name'];
		}
	}	
}


?>