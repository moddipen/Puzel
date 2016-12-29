<style type="text/css">
    blockquote.reply {
min-height: 60px;
border-color: #717171;
border-right: 5px solid rgba(0, 0, 0, 0.3) !important;
border-left: none !important;
background: #f8f8f8;
padding: 10px;
color: #717171;
-webkit-border-radius: 0 0 4px 4px;
-moz-border-radius: 0 0 4px 4px;
-ms-border-radius: 0 0 4px 4px;
-o-border-radius: 0 0 4px 4px;
border-radius: 0 0 4px 4px;
-webkit-box-shadow: 0 1px 0 0 rgba(0, 0, 0, 0.1);
box-shadow: 0 1px 0 0 rgba(0, 0, 0, 0.1);
word-wrap: break-word;
}
blockquote.reply.withoutHeader{
margin-top: 0;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
-ms-border-radius: 4px;
-o-border-radius: 4px;
border-radius: 4px;
}
</style>


      
                
        <!-- Page content -->
        <div id="content" class="col-md-12">

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <?php echo $this->element('business/header');?>

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
                     
                        <button onclick="location.href='<?php echo Configure::read("SITE_URL")?>delete/<?php echo $Conversation[0]['Support']['random'];?>'" type="button" class="btn btn-default pull-right" style="margin-top: -53px;">
                        <i class="fa fa-trash-o"></i></button>

                      </div>
                    </div>

                    <div class="content">

                      <?php 

                      foreach($Conversation as $chat)
                      {

                        if($chat['Support']['sender_id'] == AuthComponent::user('id'))
                         {?>
                          <blockquote class="reply withoutHeader">
                              <p><?php echo $chat['Support']['message'];?></p>
                            </blockquote>
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

                          <button type="submit" class="btn btn-oranges">Send</button>
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

