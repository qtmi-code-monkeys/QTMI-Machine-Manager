<?php 
class UploadController extends QtmiBaseClass {
    // declare properties
    public $file_name = "";
    public $file_tmp_name = "";
    public $file_ext = "";
    public $version_number = "";
    public $descriptionOfChanges = "";
    public $machine_type = "";
    public $code_base = "";
    public $release_type = "";    
    public $error_message = "";    
    public $created_by = "";    
    public $system_time = "";    
    private $base_dir = "";
    private $upload_file = "";
    private $app_manager = "";
	
// For Note pictures ONLY
    public $note_id = -1;    
// For Customer Note pictures ONLY
    public $customer_note_id = -1;    


   function __construct($link) {
       parent::__construct($link);
       $this->app_manager = new AppManager();
       $this->base_dir =  $this->app_manager->getBaseDir();
       //print "In SubClass constructor\n";
   }

   function __destruct() {
      // parent::__destruct();
       //print "In SubClass deconstructor\n";
   }


	public function uploadFile() {	
		$this->upload_file = $this->base_dir . "" . $this->machine_type . "/" . $this->code_base . "/" . $this->file_name;
		if($this->note_id > -1) $this->upload_file = $this->base_dir . "" . $this->machine_type . "/notes/img/" . $this->file_name;
		if($this->customer_note_id > -1) $this->upload_file = $this->base_dir . "" . $this->machine_type . "/Customer/notes/img/" . $this->file_name;

		
		$uploadFileName = $this->upload_file;
		echo $this->upload_file;
		
		if($this->note_id > -1 || $this->customer_note_id > -1 || $this->checkFileType()){
			if (move_uploaded_file($this->file_tmp_name, $uploadFileName)) {
			    echo "File is valid, and was successfully uploaded.\n";
			} else {
			    echo "Possible file upload attack!\n";
			}
		}else {
			$this->setErrorMessage();
		}
	}

	public function saveFile() {
		if($this->note_id == -1)  $this->saveSoftwareFile(); 
		if($this->note_id > -1) $this->saveNotePicture(); 
		if($this->customer_note_id > -1) $this->saveCustomerNotePicture(); 
	}


	public function saveSoftwareFile() {
		$today = date('y-m-j');
		$query = sprintf("INSERT INTO `hmi_plc_mgr`.`saved_file` (
		`id` ,
		`upload_date` ,
		`machine_type` ,
		`code_base` ,
		`fileName` ,
		`description_of_changes` ,
		`release_type` ,
		`version` 
		)
		VALUES (
		NULL , '%s', '%s', '%s', '%s', '%s', '%s', '%s'
		);", 
		mysql_real_escape_string(mysql_real_escape_string($today)), 
		mysql_real_escape_string($this->machine_type), 
		mysql_real_escape_string($this->code_base), 
		mysql_real_escape_string($this->file_name), 
		mysql_real_escape_string($this->descriptionOfChanges), 
		mysql_real_escape_string($this->release_type), 
		mysql_real_escape_string($this->version_number));
	//	echo $query;
		mysql_query($query);
	}

	public function updateRevision() {
		if($this->release_type == "FULL")
			$query = sprintf("UPDATE `hmi_plc_mgr`.`system_rev` SET `full_rev`=`full_rev` + 1 WHERE `machine_type` = '%s' AND `code_base` = '%s';", 
			mysql_real_escape_string($this->machine_type), 
			mysql_real_escape_string($this->code_base));
		if($this->release_type == "INC")
			$query = sprintf("UPDATE `hmi_plc_mgr`.`system_rev` SET `inc_rev`=`inc_rev` + 1 WHERE `machine_type` = '%s' AND `code_base` = '%s';", 
			mysql_real_escape_string($this->machine_type), 
			mysql_real_escape_string($this->code_base));
	//	echo $query;
		mysql_query($query);
	}

	private function checkFileType() {
		if($this->code_base == "PLC") $fileExtension = "cxp";
		if($this->code_base == "HMI") $fileExtension = "cd3";		
		if($this->file_ext == $fileExtension)
			return true;
		else
			return false;
	}

	private function setErrorMessage() {
		if($this->code_base == "PLC") 
			$this->error_message = "Please make sure the file you are uploading is a cxp file";
		if($this->code_base == "HMI") 
			$this->error_message = "Please make sure the file you are uploading is a cd3 file";
	}

	public function saveNotePicture() {
		$today = date('y-m-j');
		$query = sprintf("INSERT INTO `hmi_plc_mgr`.`machine_note_pic` (
		`id` ,
		`upload_date` ,
		`note_id` ,
		`machine_type` ,
		`fileName` ,
		`created_by`
		)
		VALUES (
		NULL , '%s', '%s', '%s', '%s', '%s'
		);", 
		mysql_real_escape_string(mysql_real_escape_string($today)), 
		mysql_real_escape_string($this->note_id), 
		mysql_real_escape_string($this->machine_type), 
		mysql_real_escape_string($this->file_name), 
		mysql_real_escape_string($this->created_by));
	//	echo $query;
		mysql_query($query);
	}

	public function saveCustomerNotePicture() {
		$today = date('y-m-j');
		$query = sprintf("INSERT INTO `hmi_plc_mgr`.`customer_machine_note_pic` (
		`id` ,
		`upload_date` ,
		`customer_note_id` ,
		`machine_type` ,
		`fileName` ,
		`created_by`
		)
		VALUES (
		NULL , '%s', '%s', '%s', '%s', '%s'
		);", 
		mysql_real_escape_string(mysql_real_escape_string($today)), 
		mysql_real_escape_string($this->customer_note_id), 
		mysql_real_escape_string($this->machine_type), 
		mysql_real_escape_string($this->file_name), 
		mysql_real_escape_string($this->created_by));
	//	echo $query;
		mysql_query($query);
	}



}


?>