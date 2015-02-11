<?php 
include_once "../lib/LinkMaker.php"; 

class ListFiles extends QtmiBaseClass {
    // declare properties
    public $id = -1;
    public $filename = "";
    public $fileVersion = "";
    public $machine_type = "";
    public $code_base = "";
    public $description_of_changes = "";
    public $sort = "DESC";
    
    private $linkMaker = "";
    

   function __construct($link) {
       parent::__construct($link);
       //print "In SubClass constructor\n";
       $this->linkMaker = new LinkMaker($dbLink);       
   }

   function __destruct() {
      // parent::__destruct();
       //print "In SubClass deconstructor\n";
   }


	public function listAllFiles() {
		$rowCounter = 0;
		$this->linkMaker->machine_type = $this->machine_type;
		$this->linkMaker->code_base = $this->code_base;
		
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`saved_file` WHERE `saved_file`.`machine_type` = '%s' AND `saved_file`.`code_base` = '%s' ORDER BY `saved_file`.`id` %s", mysql_real_escape_string($this->machine_type), mysql_real_escape_string($this->code_base), mysql_real_escape_string($this->sort));

		//echo $query;
		echo "<table border=1  style='background:#F3F7F7' >";
				echo "<tr>";
					echo "<td id='columnTitle' ><b>Upload Date</b></td>";
					echo "<td id='columnTitle' ><b>File Name</b></td>";
					echo "<td id='columnTitle' ><b>Description Of Changes</b></td>";
					echo "<td id='columnTitle' ><b>Release Type</b></td>";
					echo "<td id='columnTitle' ><b>Version</b></td>";
				echo "</tr>";
		$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				if($rowCounter % 2 == 0) echo "<tr style='background:#F5E0EB'>";	//sets every other row to a have a background color
				else echo "<tr>";
				echo "<td valign=top align=left ><b>".$row['upload_date']."</b></td>";
				echo "<td valign=top align=left >".$this->linkMaker->getFileLink($row['filename'])."</td>";				
				echo "<td valign=top align=left class=descriptionColumn>".nl2br($row['description_of_changes'])."</td>";
				echo "<td valign=top align=left >".$row['release_type']."</td>";
				echo "<td valign=top align=left >".$row['version']."</td>";
				echo "</tr>";
				$rowCounter++;
			}	
		echo "</table>";
	}

	// method declaration
	public function getSelectFileOptions() {
		$rowCounter = 0;
		$resultingOptions = "";		
		
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`saved_file` WHERE `saved_file`.`machine_type` = '%s' AND `saved_file`.`code_base` = '%s' ORDER BY `saved_file`.`id` %s", mysql_real_escape_string($this->machine_type), mysql_real_escape_string($this->code_base), mysql_real_escape_string($this->sort));

		echo $query;

		$result = mysql_query($query);

		echo "<option value=''></option>";
		
		//echo $query;
		while ($row = mysql_fetch_assoc($result)) {
			if($rowCounter == 0) 
				$resultingOptions .= "<option value='".$row['id']."'>".$row['filename']." (latest)</option>";
			else
				$resultingOptions .= "<option value='".$row['id']."'>".$row['filename']."</option>";
			$rowCounter++;
		}	
		echo $resultingOptions;			
	}	

	public function setFile($fileId) {
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`saved_file` WHERE `saved_file`.`id` = '%s' ", mysql_real_escape_string($fileId));
		//echo $query;
		$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				$this->id = $row['id'];
				$this->filename = $row['filename'];
				$this->fileVersion = $row['version'];
				$this->description_of_changes = $row['description_of_changes'];
				//echo $row['description_of_changes'];
			}	
	}



}


?>