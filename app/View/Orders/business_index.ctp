

      
                
        <!-- Page content -->
        <div id="content" class="col-md-12">

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <?php echo $this->element('business/header');?>
           
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
                              <h4 class="title">Current Plan - Start Up &nbsp;&nbsp;&nbsp;&nbsp; <u>Upgrade</u></h4>
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
                      <h4 class="title dropdown">Payment Type - <i class="fa fa-cc-visa"></i> &nbsp;&nbsp;XX - 9872 &nbsp;&nbsp;&nbsp;&nbsp; <u style="cursor:pointer" onclick="showdiv('changecreditcard')">Change Credit Card</u></h4>
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
                            <td><?php echo $value['Plan']['name'];?></td>
                            <td>$<?php echo $value['Order']['price'];?></td>
                            <td>
								<a href="<?php echo Configure::read("SITE_URL");?>orders/receipt/<?php echo $value['Order']['id']?>">
								<i class="fa fa-file-pdf-o"></i>
							</td>
                          </tr>
                            <?php } }?>
                          </tbody>
                      </table>
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div id="changecreditcard" class="dropdown-content">
                      <form class="custom-form">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                                <input type="text" class="form-control" placeholder="Card Number">
                              </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                                <input type="text" class="form-control" placeholder="Name">
                              </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                                <input type="text" class="form-control" placeholder="Expiry Date">
                              </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                                <input type="text" class="form-control" placeholder="CVV Number">
                              </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                              <button type="button" class="btn btn-oranges fullwidth">Change</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                              <button type="button" class="btn btn-oranges fullwidth">Cancel</button>
                            </div>
                        </div>
                      
                      </div>
                      </form>
                        
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
  }
    </script>
        






      