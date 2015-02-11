<?php 
class LinkMaker {
    // declare properties  
    private $base_dir = "../../uploads/";
    public $machine_type = "";
    public $code_base = "";

	
	public function getFileLink($fileToLink) {
		$url = $this->base_dir . "" . $this->machine_type . "/" . $this->code_base . "/" . $fileToLink;
		return "<a href='" . $url . "'> " . $fileToLink . "</a>";
	}	

	public function getNotesForMachine($machine_type) {
		$url = "notes_machine.php";
		$url = $url . "?";
		$url = $url ."machine_type=" .  $machine_type;
		$returnString = "<div class='linksBar' ><b>Notes:</b> <a href='".$url . "&division=All" ."'>All Divisions</a>  
		| <a href='".$url . "&division=RandD" ."'>R and D</a> 
		| <a href='".$url . "&division=Manufacturing" ."'>Manufacturing</a> 
		| <a href='".$url . "&division=Tech" ."'>Tech</a> 
		| <a href='".$url . "&division=Process" ."'>Process</a></div>";
		return $returnString;
	}	

	public function getBackLink() {
		//echo $this->machine_type;
		//echo $this->code_base;
		$fileName = "";
		if($this->machine_type == "FUSION"){
			if($this->code_base == "PLC") $fileName = "add_fusion_plc.php";
			if($this->code_base == "HMI") $fileName = "add_fusion_hmi.php";
		}
		if($this->machine_type == "HC"){
			if($this->code_base == "PLC") $fileName = "add_hc_plc.php";
			if($this->code_base == "HMI") $fileName = "add_hc_hmi.php";
		}
		return $fileName;
	}

}


?>