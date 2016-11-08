  <?php if(!empty($Data))
                           {

                            foreach($Data as  $value)
                              {
                                ?>
                                <tr>
                                  <td><?php echo $value['Visitor']['firstname'];?></td>
                                  <td><?php echo $value['Visitor']['lastname'];?></td>
                                  <td><?php echo $value['Puzzle']['name'];?></td>
                                  <td><?php echo $value['Visitor']['email'];?></td>
                                </tr>
                          <?php }} ?>