<?php
 $header_row = array("Visitor Firstname"=>"Visitor Firstname","Visitor Lastname"=>"Visitor Lastname","Visitor email"=>"Visitor email","Puzzle Name"=>"Puzzle Name");

 $this->CSV->addRow(array_keys($header_row));

if($Flag== "True")
{	
	foreach ($Visitor as $value)
	{
		$line=array(
		   $value['Visitor']['Visitor Firstname'],
		   $value['Visitor']['Visitor Lastname'],
		   $value['Visitor']['Visitor email'],
		   $value['Visitor']['Puzzle Name'],
		   );
		  $this->CSV->addRow($line);
	}
}
 
 $filename='Visitor';
 echo $this->CSV->render($filename);
?>