 <?php 
                          if(!empty($Supports)) 
                            {
                              foreach ($Supports as  $support)
                              {  
                                $user = AuthComponent::user();
                                ?>
                            <tr>
                              <td>
                                <?php 
                                    // check in list that list in first name is not a login user first name
                                    if($support['Sender']['id'] != $user['id'])
                                    {
                                      $name = $support['Sender']['firstname'];
                                    }
                                    else
                                    {
                                      $name = $support['Receiver']['firstname']; 
                                    }  
                                    echo $name;?>
                              </td>
                              <td>
                                  <?php 
                                    // check in list that list in last name is not a login user last name
                                    if($support['Receiver']['id'] != $user['id'])
                                    {
                                      $name = $support['Receiver']['lastname'];
                                    }
                                    else
                                    {
                                      $name = $support['Sender']['lastname']; 
                                    }  
                                    echo $name;?>
                              </td>
                              <td>
                                  <?php 
                                    // check in list that list in company name is not a login user company name
                                    if($support['Receiver']['id'] != $user['id'])
                                    {
                                      $name = $support['Receiver']['company_name'];
                                    }
                                    else
                                    {
                                      $name = $support['Sender']['company_name']; 
                                    }  
                                    echo $name;?>
                              </td>
                              <td><?php echo $support['Support']['subject'];?></td>
                              <td><?php 
                                echo date('g:i A dS M Y',strtotime($support['Support']['created']));?></td>
                              <td>
                                  <?php 
                                  echo $this->html->link( '',array('action' => 'conversation',$support['Support']['id']),array('class'=>'fa fa-comments','style'=>"color:white;"));
                                  echo "&nbsp; &nbsp;";
                                  echo $this->html->link( '',array('action' => 'delete',$support['Support']['id']),array('class'=>'fa fa-trash-o','style'=>"color:white;"),' Do you want to delete this record?');
                                  ?>
                              </td>
                          </tr>
                          <?php  } }
                          else
                          {

                            echo "No data found";

                          }



                          ?>