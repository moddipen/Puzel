<?php if(!empty($Supports))
                            {
                              foreach ($Supports as  $singlesupport)
                              {
                                $user = AuthComponent::user();
                                ?>
                          <tr>
                            <td><?php 
                                  // check in list that list in name is not a login user name
                                  if($singlesupport['Sender']['id'] != $user['id'])
                                  {
                                    $name = $singlesupport['Sender']['firstname'];
                                  }
                                  else
                                  {
                                    $name = $singlesupport['Receiver']['firstname']; 
                                  }  
                                  echo $name;?></td>
                            <td><?php echo $singlesupport['Support']['subject'];?></td>
                            <td><?php echo date('g:i A dS M Y',strtotime($singlesupport['Support']['created']));?></td>
                            <td>
                              <?php 
                              echo $this->html->link( '',array('action' => 'conversation',$singlesupport['Support']['id']),array('class'=>'fa fa-comments','style'=>"color:white;"));
                              echo "&nbsp; &nbsp;";
                              echo $this->html->link( '',array('action' => 'delete',$singlesupport['Support']['id']),array('class'=>'fa fa-trash-o','style'=>"color:white;"),' Do you want to delete this record?');
                              ?>
                            </td>
                          </tr>
                          <?php  } }?>