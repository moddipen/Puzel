

      
                
        <!-- Page content -->
        <div id="content" class="col-md-12">

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <?php echo $this->element('business/header');?>
           <?php 
			 echo $this->Session->flash();
		   ?>
               <!-- /cards -->
            
             <div class="pagesubheader">
            

              <h2><i class="fa fa-billing-big"></i> Billing</h2>

            </div>


            <!-- row -->
            <div class="row">


              <!-- col 8 -->
              <div class="col-lg-12 col-md-12">




                <!-- tile -->
                <!-- /tile -->



                <!-- tile -->
                <section class="tile color transparent-black padding10px">




                  <!-- tile header -->
                  
                  <!-- /tile header -->


                  <!-- tile body -->
                  <div class="tile-body">
                  <div class="row paddingbottom30">
                    <div class="col-md-7">
                      <div class="row">
                          <div class="col-md-6">
                              <h4 class="title">Current Plan - <?php echo $get_current_plan['Subscription']['name'];?> &nbsp;&nbsp;&nbsp;&nbsp; 
							  <u><a href="<?php echo Configure::read("SITE_URL")."subscriptions/package/".$get_current_plan['Subscription']['id'];?>">Upgrade</a></u></h4>
                            </div>
                            <div class="col-md-6">
                              <h4 class="title">Renewal Date - <?php 
                              if(!empty($Payment))
                              {
                                $add_days = 30;
                                echo date('m/d/Y' ,strtotime($Payment[0]['Order']['created'])+(24*3600*$add_days));  
                              }
                              ?> &nbsp;&nbsp;&nbsp;&nbsp; 
                              <?php echo $this->html->link('Cancel',array('controller'=>'users','action' => 'cancel'),array('style'=>"color:white;"),' Are you sure that you want to cancel your account?');?>
                              </h4>
                            </div>
                        </div>
                      
                    </div>
                    <div class="col-md-5">
					<?php
						if($cardDetail && $cardDetail->creditCard['last4'] != "")
						{
					?>
                      <h4 class="title dropdown">Payment Type - <i class="fa fa-cc-visa"></i> &nbsp;&nbsp; <?php echo "XX-".$cardDetail->creditCard['last4'];?>&nbsp;&nbsp;&nbsp;&nbsp; <u style="cursor:pointer" onclick="showdiv('changecreditcard')">Change Credit Card</u></h4>
                    <?php
						}
					?>
					
					</div>
                  </div>
                  <div class="row">
                    <div class="col-md-7">
                    <div class="table-responsive">
                      <table class="table nomargin text-center">
                        <thead>
                          
                          <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Plan</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Receipt</th>
                          </tr>
                          
                        </thead>
                        <tbody>
                          <?php 
                            if(!empty($Payment)){
                               foreach ($Payment as $value) {?>
                          <tr>
                            <td><?php echo date('m/d/Y' , strtotime($value['Order']['created']))?></td>
                            <td><?php echo $value['Subscription']['name'];?></td>
                            <td>
									<?php
										if($value['Order']['price'] == "Free")
										{
											echo "Free";
										}
										else
										{
											echo "$".$value['Order']['price'];
										}
									?>
							</td>
                            <td>
								<a href="<?php echo Configure::read("SITE_URL");?>orders/receipt/<?php echo $value['Order']['id']?>" target="_blank" style="color:white;">
								  <i class="fa fa-file-pdf-o"></i>
                </a>
							</td>
                          </tr>
                            <?php } }?>
                          </tbody>
                      </table>
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div id="changecreditcard" class="dropdown-content">
                      <?php echo $this->Form->create("Order",array("class"=>"custom-form"));?>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
						  <?php
							$number = "************".$cardDetail->creditCard['last4'];
						  ?>
                                <input type="text" name="data[Order][number]" value="<?php if(isset($number)){ echo $number ;} ?>" class="form-control" placeholder="Card Number" id="cardnumber">
                              </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
						  <?php
							$name = $cardDetail->creditCard['cardholderName'];
						  ?>
                                <input type="text" name="data[Order][name]" value="<?php echo $name;?>" class="form-control" placeholder="Name" id="cardholdername">
                              </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
							<?php
							$date = $cardDetail->creditCard['expirationMonth']."/".$cardDetail->creditCard['expirationYear'];
						  ?>
                                <input type="text"  name="data[Order][date]" class="form-control" value="<?php echo $date;?>" placeholder="Expiry Date" id="cardexpiredate">
                              </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                                <input type="text" class="form-control"  name="data[Order][cvv]" placeholder="CVV Number" id="cardcvv">
                              </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                              <button type="submit" class="btn btn-oranges fullwidth">Change</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                              <button type="reset" class="btn btn-oranges fullwidth" id="reset" >Cancel</button>
                            </div>
                        </div>
                      
                      </div>
                      <?php echo $this->Form->end();?>
                        
                      </div>
                    </div>
                   </div>
                  </div>
                  <!-- /tile body -->


                  <!-- tile footer -->
                  
                  <!-- /tile footer -->



                </section>
                <!-- /tile -->


              </div>
              <!-- /col 8 -->



              <!-- col 4 -->
              
              <!-- /col 4 -->
              
              
            </div>
           

          </div>
          <!-- /content container -->






        </div>
        <!-- Page content end -->



 <script>
    $(function(){
    $(".chosen-select").chosen({disable_search_threshold: 10});
    $('.date').datepicker({ format: 'yyyy-mm-dd', autoclose: true});
    $('.input-group span.input-group-addon').click(function(){
      $(this).parent().children('input.date').focus();
    });
      // Initialize card flip
      $('.card.hover').hover(function(){
        $(this).addClass('flip');
      },function(){
        $(this).removeClass('flip');
      });  
      
    })
    function showdiv(id) {
      document.getElementById(id).classList.toggle("show");

      // Reset credit card value and close toggle
      if($("#reset").click('on',function()
      {
        $('#cardnumber').val("");
      }));


    }








    </script>
        






      