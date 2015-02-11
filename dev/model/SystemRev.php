<?php 
class SystemRev extends QtmiBaseClass {
    // declare properties
    public $full_rev = -1;
    public $inc_rev = -1;
    public $machine = "none selected";
    public $code_base = "none selected";
    public $next_full_rev = "000.000";
    public $next_inc_rev = "000.000";

   function __construct($link) {
       parent::__construct($link);
       //print "In SubClass constructor\n";
   }

   function __destruct() {
      // parent::__destruct();
       //print "In SubClass deconstructor\n";
   }

	// method declaration
	public function populateObj() {
	//	$query = "SELECT * FROM `hmi_plc_mgr`.`system_rev`";
		$query = sprintf("SELECT * FROM `hmi_plc_mgr`.`system_rev` WHERE `system_rev`.`machine_type` = '%s' AND `system_rev`.`code_base` = '%s'", mysql_real_escape_string($this->machine), mysql_real_escape_string($this->code_base));

		//echo $query;
		$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				$this->full_rev = $row['full_rev'];
				$this->inc_rev = $row['inc_rev'];
				$this->machine = $row['machine_type'];
				$this->code_base = $row['code_base'];
			}
		$this->makeNextRevs();
	}


	private function makeNextRevs() {		//Creates the next revision number after changes have been made
		$inc_rev_val = $this->inc_rev + 1;
		$full_rev_val = $this->full_rev + 1;
		$next_inc = "";
		if($inc_rev_val < 10 && $inc_rev_val > -1) $next_inc = "00".$inc_rev_val;
		if($inc_rev_val < 100 && $inc_rev_val > 9) $next_inc = "0".$inc_rev_val;
		$this->next_full_rev = $full_rev_val.".000";
		$this->next_inc_rev = $this->full_rev.".".$next_inc;
		
	}

}


?>