<?php if(!empty($Data))
                           {

                            foreach($Data as  $list)
                              {
                              ?>
                                <tr>
                                  <td><?php echo $list['Visitor']['firstname'];?></td>
                                  <td><?php echo $list['Visitor']['lastname'];?></td>
                                  <td><?php echo $list['Puzzle']['name'];?></td>
                                  <td><?php echo $list['Visitor']['email'];?></td>
                                </tr>
                          <?php }} ?>                   