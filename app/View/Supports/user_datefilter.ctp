                          <?php if(!empty($Supports))
                            {
                              foreach($Supports as $support)
                              {?>
                                 <tr>
                                    <td><?php echo $support['Sender']['firstname'].' '.$support['Sender']['lastname'] ;?></td>
                                    <td><?php echo $support['Support']['subject'];?></td>
                                    

                                    <td><?php 
                                      echo date('g:i A dS M Y',strtotime($support['Support']['created']));?></td>
                                     <td>
                                      <?php 
                                      // echo $this->html->link( '',array('action' => 'reply',$support['Support']['reply_id']),array('class'=>'fa fa-reply','style'=>"color:white;"));
                                      // echo "&nbsp; &nbsp;";
                                      echo $this->html->link( '',array('action' => 'conversation',$support['Support']['random']),array('class'=>'fa fa-comments','style'=>"color:white;"));
                                      echo "&nbsp; &nbsp;";
                                      echo $this->html->link( '',array('action' => 'delete',$support['Support']['random']),array('class'=>'fa fa-trash-o','style'=>"color:white;"),' Do you want to delete this record?');
                                      ?>
                                    </td>
                                  </tr>
                              <?php }
                            }
                          ?>                 