<?php 
class MachineNote extends QtmiBaseClass {
    // declare properties
    public $id = -1;    
    public $machine_type = "";
    public $code_base = "";
    public $created_by = "";
    public $division = "";
    public $note = "";
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
	public function addMachineNote() {
		$today = date('y-m-j');
		$query = sprintf("INSERT INTO `hmi_plc_mgr`.`machine_note` (
		`id` ,
		`created_on` ,
		`machine_type` ,
		`code_base` ,
		`created_by` ,
		`division` ,
		`note`
		)
		VALUES (
		NULL , '%s', '%s', '%s', '%s', '%s', '%s'
		);", 
		mysql_real_escape_string($today), 
		mysql_real_escape_string($this->machine_type), 
		mysql_real_escape_string($this->code_base), 
		mysql_real_escape_string($this->created_by), 
		mysql_real_escape_string($this->division), 
		mysql_real_escape_string($this->note));
		//echo $query;
		mysql_query($query);
	}
	
	public function listMachineNotes() {
		$rowCounter = 0;
		
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`machine_note` WHERE `machine_note`.`machine_type` = '%s' AND `machine_note`.`code_base` = '%s' AND `machine_note`.`division` = '%s' ORDER BY `machine_note`.`id` %s",  mysql_real_escape_string($this->machine_type),  mysql_real_escape_string($this->code_base), mysql_real_escape_string($this->division), mysql_real_escape_string($this->sort));

		//echo $query;
		echo "<table border=1  style='background:#F3F7F7' >";
				echo "<tr>";
					echo "<td style='font-size:18'><b>Created On</b></td>";
					echo "<td style='font-size:18'><b>Created By</b></td>";
					echo "<td style='font-size:18'><b>Note</b></td>";
					echo "<td style='font-size:18'><b>Pictures</b></td>";
					echo "<td style='font-size:18'><b>Add Picture</b></td>";
				echo "</tr>";
		$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				$noteId = $row['id'];
				
				if($rowCounter % 2 == 0) echo "<tr style='background:#F5E0EB'>";
				else echo "<tr>";
				echo "<td valign=top align=left><b>".$row['created_on']."</b></td>";
				echo "<td valign=top align=left><b>".$row['created_by']."</b></td>";
				echo "<td valign=top align=left class=descriptionColumn><b>".$row['note']."</b></td>";
				echo "<td valign=top align=left>".$this->getPicturesList($noteId)."</td>";
				echo "<td valign=top align=left><span><form enctype='multipart/form-data' method='POST' action='upload_file.php' name='uploadMachinePic".$noteId."' id='uploadMachinePic".$noteId."' ><input name='qtmiFile' type='file' /> <input type='hidden' name='MAX_FILE_SIZE' value='30000000' /><input type='hidden' name='noteId' value='".$noteId."' /><input type='hidden' name='machineType' value='".$this->machine_type."' /><input type='hidden' name='codeBase' value='".$this->code_base."' /><input type='submit' value='Add Picture' /></form></span></td>";
				echo "</tr>";
				$rowCounter++;
			}	
		echo "</table>";
	}	

	public function getPicturesList($noteId) {
		$picLinkBase = "../../uploads/" . $this->machine_type . "/" . $this->code_base . "/notes/img/";
	
		$returnString = "";
	
		$rowCounter = 1;
		
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`machine_note_pic` WHERE `machine_note_pic`.`note_id` = '%s' ORDER BY `machine_note_pic`.`id` %s",  mysql_real_escape_string($noteId), mysql_real_escape_string($this->sort));

		//echo $query;
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
			$substringStart = ($this->machine_type == "FUSION") ? 32 : 28; 
			$returnString .= "<a href='".$picLinkBase.$row['filename']."' >".substr($picLinkBase.$row['filename'], $substringStart, 10)." (".$row['created_by'].")</a></br>";
			$rowCounter++;
		}	
		return $returnString;
	}	



}


?>