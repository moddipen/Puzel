

      
                
        <!-- Page content -->
        <div id="content" class="col-md-12">

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <?php echo $this->element('admin/header');?>

                  <!-- /cards -->
            
                   <!-- /cards -->
            
             <div class="pagesubheader">
            

              <h2><i class="fa fa-envelope"></i> Mailbox</h2>

            </div>


            <!-- row -->
            <div class="main horizontal-mail">
            
            


            <!-- row -->
            <div class="row">
              <div class="col-md-12">
                <div class="mail-content" id="mail-content">
                 
                  <div class="message">
                  <?php //debug($Conversation);?>
                    <div class="header">
                      <h1>Mail Message : <?php echo $Conversation[0]['Support']['subject'];?> </h1>

                      

                      <div class="actions" style="padding: 0px 20px;">
                     
                        <?php  echo $this->html->link( '<button type="button" class="btn btn-default pull-right" style="margin-top: -53px;"></button>',array('action' => 'delete',$Conversation[0]['Support']['id']),array('class'=>'fa fa-trash-o','style'=>"color:white;","escape"=> false),' Do you want to delete this record?');?>

                      </div>
                    </div>

                    <div class="content">

                      <?php 

                      foreach($Conversation as $chat)
                      {

                        if($chat['Support']['sender_id'] == AuthComponent::user('id'))
                         {?>
                          <p>
                            <?php echo $chat['Support']['message'];?>
                          </p>
                         <?php }
                         else { if($chat['Support']['receiver_id'] == AuthComponent::user('id')) { ?> 
                            <blockquote class="filled withoutHeader">
                              <p><i class="fa fa-quote-left pull-left"></i><?php echo $chat['Support']['message'];?></p>
                            </blockquote>

                      <?php  } } }?>

                      <h4 class="filled"><i class="icon-mail-reply"></i> Reply</h4>
                      
                      <div>
                        <?php echo $this->form->create('Support',array('action'=>'reply/'.$Conversation[0]['Support']['id']))?>
                          <textarea name = "data[Support][message]" class="form-control" rows="5"></textarea>

                          <button type="submit" class="btn btn-greensea">Send</button>
                        <?php echo $this->form->end();?>
                      </div>
                      

                    </div>

                  </div>
                                  


                </div>

              </div>


              
            </div>
            <!-- /row -->



          </div>     

          </div>
          <!-- /content container -->


          </div>
          <!-- /content container -->

