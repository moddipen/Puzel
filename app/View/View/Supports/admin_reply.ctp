

      
                
        <!-- Page content -->
        <div id="content" class="col-md-12">

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <?php echo $this->element('admin/header');?>

                  <!-- /cards -->
            
             <div class="pagesubheader">
            

              <h2><i class="fa fa-support-32"></i> Support</h2>

            </div>
                <div class="row">


              <!-- col 8 -->
              <div class="col-lg-12 col-md-12">




                <!-- tile -->
                <!-- /tile -->



                <!-- tile -->
                <section class="tile color transparent-black padding10px">


                  <!-- tile body -->
                  <div class="tile-body">
                    <!-- <form class="form-horizontal custom-form" role="form"> -->
                    <?php echo $this->Form->create('Support',array('action'=>'reply/'.$Support['Support']['id'],'class'=>"form-horizontal custom-form" ,'role'=>"form"));?>
                      <div class="form-group">
                        <label for="input01" class="col-sm-1 control-label">Name</label>
                        <div class="col-sm-6">
                          <input type = "text" class ='form-control' value ="<?php echo $Support['Sender']['firstname'].' '.$Support['Sender']['lastname']?>" disabled> 
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="input01" class="col-sm-1 control-label">Subject</label>
                        <div class="col-sm-6">
                          <input type = "text" class ='form-control'  value ="<?php echo "RE : ".$Support['Support']['subject']?>" disabled> 
                        </div>
                      </div>
                       <input type ="hidden" name="data[Support][reply_id]" value="<?php echo $Support['Support']['id'];?>"> 

                      <div class="form-group">
                        <label for="input05" class="col-sm-1 control-label">Message</label>
                        <div class="col-sm-6">
                          <!-- <textarea class="form-control" id="input05" rows="6"></textarea> -->
                          <?php echo $this->Form->input('Support.message',array('label'=>false,'div'=>false,'class'=>'form-control','rows'=>"6",'placeholder'=>'Enter Message'));?>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                          <button type="submit" class="btn btn-oranges">Submit</button>&nbsp;&nbsp;&nbsp;&nbsp;
                          <button type="reset" class="btn btn-black-transparent">Cancel</button>
                        </div>
                      </div>

                    <?php echo $this->Form->end();?>
                  </div>
                  <!-- /tile body -->


                </section>
                <!-- /tile -->


              </div>
              <!-- /col 8 -->



              <!-- col 4 -->
              
              <!-- /col 4 -->
              
              
            </div>
            <!-- /row -->


           

          </div>
          <!-- /content container -->


          </div>
          <!-- /content container -->

