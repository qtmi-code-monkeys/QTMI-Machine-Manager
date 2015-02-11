<?php 
class Util extends QtmiBaseClass {

   function __construct() {
      // print "In SubClass constructor\n";
   }

   function __destruct() {
      // parent::__destruct();
      // print "In SubClass deconstructor\n";
   }

function csv_to_array($filename='', $delimiter=',')
{
	if(!file_exists($filename)) echo "filename - ".$filename;

	if(!file_exists($filename) || !is_readable($filename))
	return FALSE;

	$header = NULL;
	$data = array();
	if (($handle = fopen($filename, 'r')) !== FALSE)
	{
	while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
	{
	    if(!$header)
		$header = $row;
	    else
		$data[] = array_combine($header, $row);
	}
	fclose($handle);
	}
	return $data;
}


}


?>