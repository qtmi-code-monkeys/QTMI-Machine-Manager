<?php 
class ListFiles extends QtmiBaseClass {
    // declare properties
    public $lookup_Id = -1;

   function __construct($link) {
       parent::__construct($link);
       print "In SubClass constructor\n";
   }

   function __destruct() {
      // parent::__destruct();
       print "In SubClass deconstructor\n";
   }

// method declaration
public function populateObj() {
	$query = sprintf("SELECT * FROM `qtmi`.`parts` WHERE `parts`.`id` > '%s' ", 1);
	//echo $query;
	$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
			$this->lookup_Id = $row['id'];
		}
	}
}

?>