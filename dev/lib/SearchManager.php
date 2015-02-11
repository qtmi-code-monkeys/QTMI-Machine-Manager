<?php 
class SearchManager extends QtmiBaseClass {
    public $search_term_1 = "";
    public $search_term_2 = "";
    public $operator_1 = "AND";
    public $operator_2 = "";

    public $row_limit = 20;

    // declare properties

   function __construct() {
      // print "In SubClass constructor\n";
	if(isset($_SESSION['searchTerm1'])) $this->search_term_1 =  $_SESSION['searchTerm1'];
	if(isset($_SESSION['logicalOperator1'])) $this->operator_1 =  $_SESSION['logicalOperator1'];
	if(isset($_SESSION['searchTerm2'])) $this->search_term_2 =  $_SESSION['searchTerm2'];	
	
	if($this->search_term_2 == "") {
		$this->operator_1 = "";
		$_SESSION['logicalOperator1'] = "";
	}	
	
	if($this->operator_1 == "") {
		$this->search_term_2 = "";
		$_SESSION['searchTerm2'] = "";
	}	
      
   }

   function __destruct() {
      // parent::__destruct();
      // print "In SubClass deconstructor\n";
   }

   public function showSearchForm() {
	echo "Search for: <input type='text' name='searchTerm1' value='".$this->search_term_1."' >";	
	echo "<select id='logicalOperator1' name='logicalOperator1'>";
	$this->showLogicalSearchOperator1();
	echo "</select>";
	echo "<input type='text' name='searchTerm2' value='".$this->search_term_2."' >";	
	echo "<input type='submit' value='Search' />";
   }


   private function showLogicalSearchOperator1() {
	echo "<option value='".$this->operator_1."'>".$this->operator_1."</option>";	
	echo "<option value=''></option>";	
	echo "<option value='AND'>AND</option>";	
	echo "<option value='OR'>OR</option>";	
	echo "<option value='NOT'>NOT</option>";	
   }

   public function getSearchClause() {
	$whereClause = "";
	if($this->search_term_1 != ""){
		if($this->operator_1 == ""){
			$whereClause = sprintf(" AND (`note_subject` LIKE  '%%%s%%' OR `note` LIKE '%%%s%%')", 
			mysql_real_escape_string($this->search_term_1), 
			mysql_real_escape_string($this->search_term_1));
		}else{
			if($this->operator_1 == "AND") 
				$whereClause = sprintf(" AND (`note_subject` LIKE  '%%%s%%' OR `note` LIKE '%%%s%%') AND (`note_subject` LIKE  '%%%s%%' OR `note` LIKE '%%%s%%') ", 
				mysql_real_escape_string($this->search_term_1), 
				mysql_real_escape_string($this->search_term_1),
				mysql_real_escape_string($this->search_term_2),
				mysql_real_escape_string($this->search_term_2));
			if($this->operator_1 == "OR") 
				$whereClause = sprintf(" AND (`note_subject` LIKE  '%%%s%%' OR `note` LIKE '%%%s%%') OR (`note_subject` LIKE  '%%%s%%' OR `note` LIKE '%%%s%%') ", 
				mysql_real_escape_string($this->search_term_1), 
				mysql_real_escape_string($this->search_term_1),
				mysql_real_escape_string($this->search_term_2),
				mysql_real_escape_string($this->search_term_2));
			if($this->operator_1 == "NOT") 
				$whereClause = sprintf(" AND (`note_subject` LIKE  '%%%s%%' OR `note` LIKE '%%%s%%') AND NOT (`note_subject` LIKE  '%%%s%%' OR `note` LIKE '%%%s%%') ", 
				mysql_real_escape_string($this->search_term_1), 
				mysql_real_escape_string($this->search_term_1),
				mysql_real_escape_string($this->search_term_2),
				mysql_real_escape_string($this->search_term_2));
		}
	}
	//echo $whereClause;
	return $whereClause;
	
   }


}


?>