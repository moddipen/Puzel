  
<?php 
  if(!empty($User)) {
    foreach ($User as $user) { ?>
<tr>
  <td><?php echo $user['User']['firstname'];?></td>
  <td><?php echo $user['User']['lastname'];?></td>
  <td><?php echo $user['User']['email'];?></td>
  <td><?php echo $user['Visitor'];?></td>
  <td>10</td>
  <td class="minipadding controls">
  <div class="onoffswitch green small" style="margin:0px auto;">
  <?php 
    // check puzzle s activate or not
    if($user['User']['status'] == 0)
    {
      $status = "checked='checked'";
    }
    else
     {
       $status = '';
     } 

  ?> 
        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch_<?php echo $user['User']['id']?>" <?php echo $status;?> value ="<?php echo $user['User']['id']?>">
        <label class="onoffswitch-label" for="onoffswitch_<?php echo $user['User']['id']?>">
          <span class="onoffswitch-inner"></span>
          <span class="onoffswitch-switch"></span>
        </label>
      </div>
      </td>
</tr>
  <?php
    } }?>