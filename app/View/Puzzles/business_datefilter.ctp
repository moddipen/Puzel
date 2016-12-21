  
<?php if(!empty($Puzzel))
  {
   foreach ($Puzzel as $puzel)
     {?>
  <tr>
      <td><?php echo date('m/d/Y',strtotime($puzel['Puzzle']['created']))?></td>
      <td><?php echo $puzel['Puzzle']['name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-eye"></i></td>
      <td><?php echo $puzel['Puzzle']['pieces']?></td>
      <td><?php echo $puzel['Show']?></td>
      <td><?php echo $puzel['Hide']?>&nbsp;&nbsp;
      <?php 
      if($puzel['Hide'] != '')
      {
        echo $this->html->link('',array('action' => 'export',$puzel['Puzzle']['random']),array('class'=>'fa fa-download-16px','style'=>"color:white;"));
        echo "&nbsp;&nbsp;";
        echo $this->html->link('',array('controller'=>'visitors','action' => 'data',$puzel['Puzzle']['id']),array('class'=>'fa fa-eye','style'=>"color:white;"));
      
      }
      ?>
      </td>
      <td class="minipadding controls">
        <input type ="hidden" value = "<?php echo $puzel['Puzzle']['id'];?>" class ="puzelid" >
        <div class="col-xs-5 text-right"> <?php 
      echo $this->html->link('',array('action' => 'edit',$puzel['Puzzle']['random']),array('class'=>'fa fa-pencil','style'=>"color:white;"));?><!-- <i class="fa fa-pencil"></i> --></div>
        <div class="col-xs-7">
          <div class="onoffswitch green small">
            <?php 
              // check puzzle s activate or not
              if($puzel['Puzzle']['status'] == 0)
              {
                $puzzle = "checked='checked'";
              }
              else
               {
                 $puzzle = '';
               } 

            ?> 
            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch<?php echo $puzel['Puzzle']['id'];?>" <?php echo $puzzle;?> value = "<?php echo $puzel['Puzzle']['id'];?>">
            <label class="onoffswitch-label" for="onoffswitch<?php echo $puzel['Puzzle']['id'];?>">
              <span class="onoffswitch-inner"></span>
              <span class="onoffswitch-switch"></span>
            </label>
          </div>
        </div>
      </td>
    </tr>
   <?php }} ?> 