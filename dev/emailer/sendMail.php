<?php


require_once "Mail.php";
//echo "hi";


$from = "Warren Davidson <warrenkdavidson@gmail.com>";
$to = "Warren Davidson <warren_k_davidson@yahoo.com>";
$subject = "Hi!";
$body = "Hi,\n\nHow are you?";

$host = "smtp.gmail.com";
$port = "587";
$username = "qtmimm@gmail.com";
$password = "December44";

$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'port' => $port,
    'auth' => true,
    'username' => $username,
    'password' => $password));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
 } else {
  echo("<p>Message successfully sent!</p>");
 }

public function sendUsageEmail($usage_level, $part){
	
	
	
} 
 
public function threeQuarterUsageEmail($part){
	//create email from machine manager 
	//send email to Freshdesk/TST
	//message should be that the passed part is at 75% of its prescribed life
}

public function ninteyPercentUsageEmail($part){
	//create email from machine manager 
	//send email to Freshdesk/TST
	//message should be that the passed part is at 90% of its prescribed life
}

public function ninteyFivePercentPlusEmail($part){
	//create email from machine manager 
	//send email to Freshdesk/TST
	//message should be that the passed part is at 95+% of its prescribed life
}
 
?>