<?php

exit("hello");

 $header_row = array("Firstname"=>"firstname","Lastname"=>"lastname","Company Name"=>"company_name","Puzels created"=>"email","Active Puzels"=>"website","Balance Credits"=>"usertype","Membership Plan"=>"tokenhash");

 $this->CSV->addRow(array_keys($header_row));

foreach ($Business as $value)
{
	$line=array(
	   $value['User']['firstname'],
	   $value['User']['lastname'],
	   $value['User']['company_name'],
	   $value['User']['email'],
	   $value['User']['website'],
	   $value['User']['usertype'],
	   $value['User']['tokenhash'],
	   );
	  $this->CSV->addRow($line);
}

 
 $filename='Business';
 echo $this->CSV->render($filename);
?>