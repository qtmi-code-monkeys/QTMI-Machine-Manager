<?php

class CustomerMachineContacts extends QtmiBaseClass {
    // declare properties
    public $id = -1;    
    public $customer_id = -1;
    public $customer_machine_id = -1;
    public $c1_name = "None Specified";
    public $c1_number = "None Specified";
    public $c1_email = "None Specified";
    public $c2_name = "None Specified";
    public $c2_number = "None Specified";
    public $c2_email = "None Specified";
    public $c3_name = "None Specified";
    public $c3_number = "None Specified";
    public $c3_email = "None Specified";

    public $sort = "DESC";    

   function __construct($link) {
       parent::__construct($link);
      // print "In SubClass constructor\n";
   }

   function __destruct() {
      // parent::__destruct();
      // print "In SubClass deconstructor\n";
   }

	// method declaration
	public function addCustomerMachineContacts() {
		
		$query = sprintf("INSERT INTO `hmi_plc_mgr`.`customer_machine_contacts` (
		`id` ,
		`customer_machine_id` ,
		`c1_name` ,
		`c1_number` ,
		`c1_email` ,
		`c2_name` ,
		`c2_number` ,
		`c2_email` ,
		`c3_name` ,
		`c3_number` ,
		`c3_email` 
		)
		VALUES (
		NULL , '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');", 
		mysql_real_escape_string($this->customer_machine_id), 
		mysql_real_escape_string($this->c1_name), 
		mysql_real_escape_string($this->c1_number), 
		mysql_real_escape_string($this->c1_email), 
		mysql_real_escape_string($this->c2_name), 
		mysql_real_escape_string($this->c2_number), 
		mysql_real_escape_string($this->c2_email), 
		mysql_real_escape_string($this->c3_name), 
		mysql_real_escape_string($this->c3_number), 
		mysql_real_escape_string($this->c3_email));
		//echo $query;
		mysql_query($query);
		$this->id = mysql_insert_id();
	}


	
	public function getCustomerContacts() {
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_contacts` WHERE `customer_machine_contacts`.`customer_machine_id` = '%s' LIMIT 0,1 ", mysql_real_escape_string($this->customer_machine_id));

		//echo $query;
		$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				$this->id = $row['id'];			
				$this->c1_name = $row['c1_name'];
				$this->c1_number = $row['c1_number'];
				$this->c1_email = $row['c1_email'];
				$this->c2_name = $row['c2_name'];
				$this->c2_number = $row['c2_number'];
				$this->c2_email = $row['c2_email'];
				$this->c3_name = $row['c3_name'];
				$this->c3_number = $row['c3_number'];
				$this->c3_email = $row['c3_email'];
			}	
	}
	



	// method declaration
	public function updateContactCustMachine() {
		$query = sprintf("UPDATE  `hmi_plc_mgr`.`customer_machine_contacts` SET  
				`c1_name` =  '%s',
				`c1_number` =  '%s',
				`c1_email` =  '%s',
				`c2_name` =  '%s',
				`c2_number` =  '%s',
				`c2_email` =  '%s',
				`c3_name` =  '%s',
				`c3_number` =  '%s',
				`c3_email` =  '%s'
				WHERE  `customer_machine_contacts`.`customer_machine_id` = %s ;", 
				mysql_real_escape_string($this->c1_name), 
				mysql_real_escape_string($this->c1_number), 
				mysql_real_escape_string($this->c1_email), 
				mysql_real_escape_string($this->c2_name), 
				mysql_real_escape_string($this->c2_number), 
				mysql_real_escape_string($this->c2_email), 
				mysql_real_escape_string($this->c3_name), 
				mysql_real_escape_string($this->c3_number), 
				mysql_real_escape_string($this->c3_email), 
				mysql_real_escape_string($this->customer_machine_id)
				); 
				
				//echo $query;
				mysql_query($query);
	}

}


?>