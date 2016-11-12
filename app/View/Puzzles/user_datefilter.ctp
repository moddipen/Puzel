                        <?php if(!empty($List)) {

                          $user = AuthComponent::user();
                          foreach ($List as $value) {  ?>
                          <tr>
                            <td><?php echo date('m/d/Y',strtotime($value['Visitor']['created']));?></td>
                            <td><?php echo $value['Puzzle']['Puzzle']['name'];?></td>
                            <td><?php echo $value['Open'];?>/<?php echo $value['All'];?></td>
                            <td>Grand</td>
                            <td class="minipadding controls">
                              <a class="share-btn" href="http://www.facebook.com/share.php?u=http://puzel.stage.n-framescorp.com/puzzle/<?php echo $value['Puzzle']['Business']['company_name'].'/'.$value['Puzzle']['Puzzle']['name'].'/'.$value['Puzzle']['Business']['firstname'].'_'.$value['Puzzle']['Business']['id'];?>&title=<?php echo $value['Puzzle']['Puzzle']['name'];?>&description=Price 33$" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')"><i class="fa fa-facebook"></i></a>
                                &nbsp;&nbsp;
                                <a class="twitter-share-button"
                                    href="http://puzel.stage.n-framescorp.com/puzzle/<?php echo $value['Puzzle']['Business']['company_name'].'/'.$value['Puzzle']['Puzzle']['name'].'/'.$value['Puzzle']['Business']['firstname'].'_'.$value['Puzzle']['Business']['id'];?>"
                                     data-size="large"
                                    target = "_blank">
                                <i class="fa fa-twitter"></i></a>
                               &nbsp;&nbsp; 
                               <a class="icon-gplus" href ="http://puzel.stage.n-framescorp.com/puzzle/<?php echo $value['Puzzle']['Business']['company_name'].'/'.$value['Puzzle']['Puzzle']['name'].'/'.$value['Puzzle']['Business']['firstname'].'_'.$value['Puzzle']['Business']['id'];?>" onclick="return !window.open(this.href, 'Google', 'width=640,height=580')"><i class="fa fa-envelope"></i></a>
                               &nbsp;&nbsp;
                               <a href="http://mail.live.com/default.aspx?rru=compose&to=&subject=Share new puzzle <?php echo $value['Puzzle']['Puzzle']['name'];?>&body=http://puzel.stage.n-framescorp.com/puzzle/<?php echo $value['Puzzle']['Business']['company_name'].'/'.$value['Puzzle']['Puzzle']['name'].'/'.$value['Puzzle']['Business']['firstname'].'_'.$value['Puzzle']['Business']['id'];?>" onclick="return !window.open(this.href, 'Outlook', 'width=640,height=580')" target="_blank" style="color:white;"><i class="fa fa-windows"></i></a>
                            
                          </td>
                          </tr>
                         <?php } }?>