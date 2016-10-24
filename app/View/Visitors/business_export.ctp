<?php
 $header_row = array("Visitor Firstname"=>"Visitor Firstname","Visitor Lastname"=>"Visitor Lastname","Company Name"=>"Company Name","Visitor email"=>"Visitor email","Date"=>"Date","Puzzle Name"=>"Puzzle Name");

 $this->CSV->addRow(array_keys($header_row));

if($Flag== "True")
{	
	foreach ($Visitor as $value)
	{
		$line=array(
		   $value['Visitor']['Visitor Firstname'],
		   $value['Visitor']['Visitor Lastname'],
		   $value['Visitor']['Company Name'],
		   $value['Visitor']['Visitor email'],
		   $value['Visitor']['Date'],
		   $value['Visitor']['Puzzle Name'],
		   );
		  $this->CSV->addRow($line);
	}
}
else
{
	foreach ($Visitor as $order)
 {
  	foreach ($order['Visitor'] as$value)
  	{
  		$line=array(
		   $value['Visitor Firstname'],
		   $value['Visitor Lastname'],
		   $value['Company Name'],
		   $value['Visitor email'],
		   $value['Date'],
		   $value['Puzzle Name'],
		   
		   );
		  $this->CSV->addRow($line);
  	}
 }	
}

 
 $filename='Visitor';
 echo $this->CSV->render($filename);
?>