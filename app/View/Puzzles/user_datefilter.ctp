                        <?php if(!empty($List)) {

                          $user = AuthComponent::user();
                          foreach ($List as $value) {  ?>
                         <tr>
                            <td><?php echo date('m/d/Y',strtotime($value['Visitor']['created']));?></td>
                            <td><?php echo $value['Puzzle']['Puzzle']['name'];?></td>
                            <td><?php echo $value['Open'];?>/<?php echo $value['All'];?></td>
                            <td>Grand</td>
                            <td class="minipadding controls">
                            <!-- <a href="https://www.facebook.com/" target="_blank" style="color:white;"><i class="fa fa-facebook"></i></a> -->
                            <!-- <a class="icon-facebook" rel="nofollow"
                                  href="http://www.facebook.com/"
                                  onclick="popUp=window.open(
                                      'http://www.facebook.com/sharer.php?u=https://postmarkapp.com',
                                      'popupwindow',
                                      'scrollbars=yes,width=800,height=400');
                                  popUp.focus();
                                  return false">
                                  <i class="fa fa-facebook"></i>
                              </a> -->
                              <a class="share-btn" href="http://www.facebook.com/share.php?u=http://puzel.stage.n-framescorp.com/<?php echo $value['Puzzle']['Business']['company_name'].'/'.$value['Puzzle']['Puzzle']['name'].'/'.$user['refrel_id'];?>&title=<?php echo $value['Puzzle']['Puzzle']['name'];?>&description=Price 33$" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')"><i class="fa fa-facebook"></i></a>
                                &nbsp;&nbsp;
                                <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text=http://puzel.stage.n-framescorp.com/<?php echo $value['Puzzle']['Business']['company_name'].'/'.$value['Puzzle']['Puzzle']['name'].'/'.$user['refrel_id'];?>" data-size="large" target = "_blank">
                                <i class="fa fa-twitter"></i></a>
                               &nbsp;&nbsp; 
                               <a class="icon-gplus" href ="https://mail.google.com/mail/?view=cm&fs=1&to=&su=Share new puzzle <?php echo $value['Puzzle']['Puzzle']['name'];?>&body=http://puzel.stage.n-framescorp.com/<?php echo $value['Puzzle']['Business']['company_name'].'/'.$value['Puzzle']['Puzzle']['name'].'/'.$user['refrel_id'];?>" onclick="return !window.open(this.href, 'Google', 'width=640,height=580')"><i class="fa fa-envelope"></i></a>
                               &nbsp;&nbsp;
                               <a href="http://mail.live.com/default.aspx?rru=compose&to=&subject=Share new puzzle <?php echo $value['Puzzle']['Puzzle']['name'];?>&body=http://puzel.stage.n-framescorp.com/<?php echo $value['Puzzle']['Business']['company_name'].'/'.$value['Puzzle']['Puzzle']['name'].'/'.$user['refrel_id'];?>" onclick="return !window.open(this.href, 'Outlook', 'width=640,height=580')" target="_blank" style="color:white;"><i class="fa fa-windows"></i></a>
                            
                          </td>
                          </tr>
                         <?php } }?>