<?php 
include_once "../model/Customer.php"; 

class CustomerMachineNote extends QtmiBaseClass {
    // declare properties
    public $id = -1;    
    public $machine_type = "";
    public $customer_id = -1;
    public $customer_machine_id = -1;
    
    public $created_by = "";
    public $division = "";
    public $note_subject = "";
    public $note = "";
    public $sort = "DESC";    
    private $base_dir = "C:/wamp/www/HMI_PLC_MANAGER/uploads/";    
    private $customer = ""; 

    private $searchManager = ""; 


   function __construct($link) {
       parent::__construct($link);
       $this->customer = new Customer($link); 
       $this->searchManager = new SearchManager(); 
      // print "In SubClass constructor\n";
   }

   function __destruct() {
      // parent::__destruct();
      // print "In SubClass deconstructor\n";
   }

	// method declaration
	public function addCustomerMachineNote() {
		$today = date('y-m-j');
		$this->division = "Tech";
		$query = sprintf("INSERT INTO `hmi_plc_mgr`.`customer_machine_note` (
		`id` ,
		`created_on` ,
		`machine_type` ,
		`customer_id` ,
		`created_by` ,
		`division` ,
		`note_subject`,
		`note`,
		`timeAdded`
		)
		VALUES (
		NULL , '%s', '%s', '%s', '%s', '%s', '%s', '%s', %s
		);", 
		mysql_real_escape_string($today), 
		mysql_real_escape_string($this->machine_type), 
		mysql_real_escape_string($this->customer_id), 
		mysql_real_escape_string($this->created_by), 
		mysql_real_escape_string($this->division), 
		mysql_real_escape_string($this->note_subject), 
		mysql_real_escape_string($this->note),
		mysql_real_escape_string("CURRENT_TIME()"));
		//echo $query;
		mysql_query($query);
	}
	
	public function listCustomerMachineNotes() {
		$this->customer->setCustomerName($this->customer_id); 
		$this->division = "Tech"; 

	
		$rowCounter = 0;
		

		//echo $this->searchManager->getWhereClause();

		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_note` WHERE `customer_machine_note`.`customer_id` = '%s' AND `customer_machine_note`.`machine_type` = '%s' AND `customer_machine_note`.`division` = '%s' %s ORDER BY `customer_machine_note`.`id` %s",  mysql_real_escape_string($this->customer_id), mysql_real_escape_string($this->machine_type), mysql_real_escape_string($this->division), $this->searchManager->getSearchClause(), mysql_real_escape_string($this->sort));

		//echo $query;
		echo "<table border=1  style='background:#F3F7F7' >";
				echo "<tr>";
					echo "<td style='font-size:18'><b>Created On</b></td>";
					echo "<td style='font-size:18'><b>Created By</b></td>";
					echo "<td style='font-size:18'><b>Customer</b></td>";
					echo "<td style='font-size:18'><b>Note</b></td>";
					echo "<td style='font-size:18'><b>Pictures</b></td>";
					echo "<td style='font-size:18'><b>Add Picture</b></td>";
				echo "</tr>";
		$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				$noteId = $row['id'];
				
				if($rowCounter % 2 == 0) echo "<tr style='background:#F5E0EB'>";
				else echo "<tr>";
				echo "<td valign=top align=left><b>".$row['created_on']."</b></br>".$row['timeAdded']."</td>";
				echo "<td valign=top align=left><b>".$row['created_by']."</b></td>";
				echo "<td valign=top align=left><b>".$this->customer->name."</b></td>";
				echo "<td valign=top align=left class=descriptionColumn><font class=notesSubject>".$row['note_subject']."</font></br><b>".nl2br($row['note'])."</b></td>";
				echo "<td valign=top align=left>".$this->getPicturesList($noteId)."</td>";
				echo "<td valign=top align=left><span><form enctype='multipart/form-data' method='POST' action='upload_file.php' name='uploadCustomerMachinePic".$noteId."' id='uploadCustomerMachinePic".$noteId."' ><input name='qtmiFile' type='file' /> <input type='hidden' name='MAX_FILE_SIZE' value='30000000' /><input type='hidden' name='customerNoteId' value='".$noteId."' /><input type='hidden' name='machineType' value='".$this->machine_type."' /><input type='submit' value='Add Picture' /></form></span></td>";
				echo "</tr>";
				$rowCounter++;
			}	
		echo "</table>";
	}	

	public function getPicturesList($noteId) {
	
		$picLinkBase = "../../uploads/" . $this->machine_type . "/Customer/notes/img/";
	
		$returnString = "";
	
		$rowCounter = 1;
		
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`customer_machine_note_pic` WHERE `customer_machine_note_pic`.`customer_note_id` = '%s' ORDER BY `customer_machine_note_pic`.`id` %s",  mysql_real_escape_string($noteId), mysql_real_escape_string($this->sort));

		//echo $query;
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
			$substringStart = ($this->machine_type == "FUSION") ? 40 : 36; 
			$returnString .= "<a href='".$picLinkBase.$row['filename']."' >".substr($picLinkBase.$row['filename'], $substringStart, 10)." (".$row['created_by'].")</a></br>";
			$rowCounter++;
		}	
		return $returnString;
		
	}	

	// method declaration
	public function saveMyLastNote() {
		$today = date('y-m-j');
		$this->division = "Tech";
		$query = sprintf("INSERT INTO `hmi_plc_mgr`.`my_last_machine_note` (
		`id` ,
		`created_on` ,
		`machine_type` ,
		`customer_id` ,
		`created_by` ,
		`division` ,
		`note_subject`,
		`note`,
		`timeAdded`
		)
		VALUES (
		NULL , '%s', '%s', '%s', '%s', '%s', '%s', '%s', %s
		);", 
		mysql_real_escape_string($today), 
		mysql_real_escape_string($this->machine_type), 
		mysql_real_escape_string($this->customer_id), 
		mysql_real_escape_string($this->created_by), 
		mysql_real_escape_string($this->division), 
		mysql_real_escape_string($this->note_subject), 
		mysql_real_escape_string($this->note),
		mysql_real_escape_string("CURRENT_TIME()"));
		//echo $query;
		mysql_query($query);
	}
	
	public function retrieveMyLastNote() {
		$this->customer->setCustomerName($this->customer_id); 

	
		$rowCounter = 0;
		

		//echo $this->searchManager->getWhereClause();

		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`my_last_machine_note` WHERE `my_last_machine_note`.`created_by` = '%s' ORDER BY `my_last_machine_note`.`id` ASC",  mysql_real_escape_string($_SESSION['username']));

		//echo $query;
		$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				$this->note_subject = $row['note_subject'];
				$this->note = $row['note'];
			}	
	}		

}


?>