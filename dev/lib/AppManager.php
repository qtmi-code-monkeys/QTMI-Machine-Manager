<?php 
class AppManager extends QtmiBaseClass {
    public $location = "";

    // declare properties
    public $admin_group = array("warren", "briant", "cleidecker", "jglarum");

   function __construct() {
      // print "In SubClass constructor\n";
      if(PHP_OS == "Linux") 
	$this->location = "remote";
      else
	$this->location = "local";
   }

   function __destruct() {
      // parent::__destruct();
      // print "In SubClass deconstructor\n";
   }

   function isAdmin() {
	if (in_array($_SESSION['username'], $this->admin_group)) {
	    return true;
	}else{
	    return false;	
	}
   }

   function getBaseDir() {
	if ($this->location == "local") {
	    return "C:/wamp/www/HMI_PLC_MANAGER/uploads/";
	}else{
	    return "/var/www/HMI_PLC_MANAGER/uploads/";	
	}
   }


}


?>