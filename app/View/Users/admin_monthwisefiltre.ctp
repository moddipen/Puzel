<?php 
    if($Flag == 'Business')
    {
      if(!empty($Business))
      {
        foreach ($Business as $user)
         {?>
          <tr>
            <td><?php echo $user['User']['firstname'] ;?></td> 
            <td><?php echo $user['User']['lastname'] ;?></td>
            <td><?php echo $user['User']['company_name'] ;?></td>
            <td><?php echo count($user['Puzzle']); ?></td>
            <td><?php
                  $index = 1;
                  $count = 0;
                  foreach($user['Puzzle'] as $puz)
                  {
                    if($puz['status'] == 0)
                    {
                      $count = $index;
                      $index ++;
                    }
                  }
                  echo $count;
                ?></td>
            <td><?php if($user['UserSubscription']['id'] != ""){echo $user['UserSubscription']['used_pieces'];}else{echo "0";}?></td>
            <td><?php if($user['UserSubscription']['id'] != ""){echo $user['UserSubscription']['Subscription']['name'];}else{echo "Inactive";}?></td>
            <td class="minipadding controls"><div class="col-xs-5 text-right"><i class="fa fa-eye"></i></div><div class="col-xs-7">
              <div class="onoffswitch green small">
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
                 
                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch_<?php echo $user['User']['id'];?>" <?php echo $status;?> value ="<?php echo $user['User']['id'];?>">
                    <label class="onoffswitch-label" for="onoffswitch_<?php echo $user['User']['id'];?>">
                      <span class="onoffswitch-inner"></span>
                      <span class="onoffswitch-switch"></span>
                    </label>
                  </div></div>
            </td>
          </tr>    
          <?php
        }
      }
      else
      {?>
          <tr>
            <td>No record found</td> 
          </tr>  
          
      <?php }  
    }
    else
    {
      if(!empty($Business))
      {
       foreach ($Business as $user)
        { ?>
          <tr>
            <td><?php echo $user['User']['firstname'];?></td>
            <td><?php echo $user['User']['lastname'];?></td>
            <td><?php echo $user['User']['email'];?></td>
            <td><?php echo $user['Visitor'];?></td>
            <td><?php echo $user['Refrel'];?></td>
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
            } 
          }
          else
          {?>
            <tr>
              <td>No record found</td>
             </tr> 
          
         <?php } 
        }?>