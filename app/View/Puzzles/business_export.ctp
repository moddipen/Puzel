<?php
 $line= $Visitor[0]['Visitor'];
 $this->CSV->addRow(array_keys($line));
 foreach ($Visitor as $post)
 {
   $line= $post['Visitor']; 
   $this->CSV->addRow($line);
 }
  $filename='Export';

  echo  $this->CSV->render($filename);
?>