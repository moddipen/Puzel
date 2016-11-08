<?php if(!empty($Puzzel))
                            {
                              foreach ($Puzzel as $list) { ?>
                          <tr>
                            <td><?php echo date('m/d/Y',strtotime($list['Puzzle']['created']));?></td>
                            <td><?php echo $list['Business']['company_name'];?></td>
                            <td><?php echo $list['Puzzle']['name'];?></td>
                            <td><?php echo $list['Puzzle']['pieces'];?></td>
                            <td><?php echo $list['Show'];?></td>
                            <td><?php echo $list['Hide'];?></td>
                            <td class="minipadding controls">
                              <div class="col-xs-5 text-right"><i class="fa fa-pencil"></i></div><div class="col-xs-7">
                            <div class="onoffswitch green small">
                                  <?php 
                                  // check puzzle s activate or not
                                  if($list['Puzzle']['status'] == 0)
                                  {
                                    $status = "checked='checked'";
                                  }
                                  else
                                   {
                                     $status = '';
                                   } 

                                ?> 
                                  <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch_<?php echo $list['Puzzle']['id']?>" <?php echo $status;?> value = "<?php echo $list['Puzzle']['id']?>" >
                                  <label class="onoffswitch-label" for="onoffswitch_<?php echo $list['Puzzle']['id']?>">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div></div>
                            </td>
                          </tr>
                          <?php  } }?>