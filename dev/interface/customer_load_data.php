<?php
include_once 'global_includes.php';

$newCustomer = new Customer($dbLink);
if(isset($_REQUEST["customerId"])) $newCustomer->id =  $_REQUEST["customerId"];


$newCustomer->setCustomer_noParams();

$newCustomerMachine = new CustomerMachine($dbLink, "FUSION");

$newCustomerMachine->customer = $newCustomer;

//echo "hi";


$newCustomerMachine->loadErrors();


?>




<?php
// close DB connection
mysql_close($dbLink);
?>

