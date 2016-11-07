

      
                
        <!-- Page content -->
        <div id="content" class="col-md-12">

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <?php echo $this->element('admin/header');?>
            <!-- /cards -->
            
             <div class="pagesubheader">
            

              <h2><i class="fa fa-briefcase"></i> Business</h2>

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
                  <div class="row">
                    <div class="col-md-10">
                      <form role="form" class="custom-form">
                          <div class="row minipadding">
                            <div class="col-md-2">
                              <div class="form-group">
                                    <select name="datetime" class="form-control chosen-select">
                                      <option value="">Today</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                  <div class="input-group">
                                      <span class="input-group-addon nobackground">From</span>
                                        <input name="startdate" id="startdate" class="form-control date">
                                        <span class="input-group-addon nobackground"><i class="fa fa-calendar fa-2x"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon nobackground">To</span>
                                        <input name="enddate" id="enddate" class="form-control date">
                                        <span class="input-group-addon nobackground"><i class="fa fa-calendar fa-2x"></i></span>
                                     </div>
                                </div>
                            </div>                            
                          </div>
                      </form>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group iconwithtext">
                          <i class="fa fa-downloads"></i> <span class="text">Download as CSV</span>
                        </div>
                    </div>
                  </div>
                    <div class="table-responsive">
                      <table class="table nomargin text-center">
                        <thead>
                          <tr>
                            <th class="text-center">First Name</th>
                            <th class="text-center">Last Name</th>
                            <th class="text-center">Company Name</th>
                            <th class="text-center">Puzels Created</th>
                            <th class="text-center">Active Puzels</th>
                            <th class="text-center">Balance Credits</th>
                            <th class="text-center">Membership Plan</th>
                            <th class="text-center">Options</th>
                          </tr>
                        </thead>
                        <tbody>
						
                        <?php if(!empty($Business)) {
								
                              foreach ($Business as $user) {?>
                          <tr>
                            <td><?php echo $user['User']['firstname'] ;?></td> 
                            <td><?php echo $user['User']['lastname'] ;?></td>
                            <td><?php echo $user['User']['company_name'] ;?></td>
                            <td><?php echo count($user['Puzzle']); ;?></td>
                            <td><?php
								$index = 1;
								$count = 0;
								foreach($user['Puzzle'] as $puz)
								{
									if($puz['status'] == 0)
									{
										$count = $index;
										$index ++;
									}
								}
								echo $count;
							?></td>
                            <td><?php if($user['UserSubscription']['id'] != ""){echo $user['UserSubscription']['used_pieces'];}else{echo "0";}?></td>
                            <td><?php if($user['UserSubscription']['id'] != ""){echo $user['UserSubscription']['Subscription']['name'];}else{echo "Inactive";}?></td>
                            <td class="minipadding controls"><div class="col-xs-5 text-right"><i class="fa fa-eye"></i></div><div class="col-xs-7">
                              <div class="onoffswitch green small">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch" checked>
                                    <label class="onoffswitch-label" for="onoffswitch">
                                      <span class="onoffswitch-inner"></span>
                                      <span class="onoffswitch-switch"></span>
                                    </label>
                                  </div></div>
                            </td>
                          </tr>
                           <?php } }?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- /tile body -->


                  <!-- tile footer -->
                  <!--<div class="tile-footer text-center">
                    <ul class="pagination pagination-sm nomargin pagination-custom">
                      <li class="disabled"><a href="#"><i class="fa fa-angle-double-left"></i></a></li>
                      <li class="active"><a href="#">1</a></li>
                      <li><a href="#">2</a></li>
                      <li><a href="#">3</a></li>
                      <li><a href="#">4</a></li>
                      <li><a href="#">5</a></li>
                      <li><a href="#"><i class="fa fa-angle-double-right"></i></a></li>
                    </ul>
                  </div>-->
                  <!-- /tile footer -->



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
        <!-- Page content end -->




        






      