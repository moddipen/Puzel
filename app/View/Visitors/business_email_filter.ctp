
<?php 
  if(!empty($Emaildata))
  {
     foreach($Emaildata as $email)
      { 
    ?>
  <tr>
    <td><?php echo $email['Visitor']['firstname'];?></td>
    <td><?php echo $email['Visitor']['lastname'];?></td>
    <td><?php echo $email['Puzzle']['name'];?></td>
    <td><?php echo $email['Visitor']['email'];?></td>
  </tr>
    <?php }}?>                     