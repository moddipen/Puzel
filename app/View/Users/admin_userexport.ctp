<?php
 $header_row = array("Firstname"=>"firstname","Lastname"=>"lastname","Email Address"=>"email","Puzels Participated"=>"usertype","Referals"=>"");

 $this->CSV->addRow(array_keys($header_row));

foreach ($User as $value)
{
	$line=array(
	   $value['User']['firstname'],
	   $value['User']['lastname'],
	   $value['User']['email'],
	   $value['User']['usertype'],
	   "10"
	   );
	  $this->CSV->addRow($line);
}

 
 $filename='User';
 echo $this->CSV->render($filename);
?>