

      
                
        <!-- Page content -->
        <div id="content" class="col-md-12">

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <?php echo $this->element('business/header');?>
            
                <!-- /cards -->
            <?php echo $this->Session->flash(); ?>
             <div class="pagesubheader">
            

              <h2><i class="fa fa-support-32"></i> Support</h2>

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
                                    <select name="user" class="form-control chosen-select">
                                      <option value="">All Users</option>
                                    </select>
                                </div>
                            </div>
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
                            <div class="col-md-2">
                              <div class="form-group">
                                    <select name="by" class="form-control chosen-select">
                                      <option value="">Email Address</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                  <input type="text" value="" name="search" class="form-control">
                                </div>
                            </div>
                          </div>
                      </form>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <input type="button" value="Create Request" onClick="location.href='<?php echo Configure::read('SITE_BUSINESS_URL');?>/supports/add';" class="btn btn-oranges pull-right">
                        </div>
                    </div>
                  </div>
                    <div class="table-responsive">
                      <table class="table nomargin text-center">
                        <thead>
                          <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Subject</th>
                            <th class="text-center">Date / Time</th>
                            <th class="text-center">Options</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Tony</td>
                            <td>Subject 1</td>
                            <td>11:05 AM 25th May 2016</td>
                            <td><i class="fa fa-reply"></i>&nbsp; &nbsp;<i class="fa fa-trash-o"></i></td>
                          </tr>
                          <tr>
                            <td>Tony</td>
                            <td>Subject 1</td>
                            <td>11:05 AM 25th May 2016</td>
                            <td><i class="fa fa-reply"></i>&nbsp; &nbsp;<i class="fa fa-trash-o"></i></td>
                          </tr>
                          <tr>
                            <td>Tony</td>
                            <td>Subject 1</td>
                            <td>11:05 AM 25th May 2016</td>
                            <td><i class="fa fa-reply"></i>&nbsp; &nbsp;<i class="fa fa-trash-o"></i></td>
                          </tr>
                          <tr>
                            <td>Tony</td>
                            <td>Subject 1</td>
                            <td>11:05 AM 25th May 2016</td>
                            <td><i class="fa fa-reply"></i>&nbsp; &nbsp;<i class="fa fa-trash-o"></i></td>
                          </tr>
                          <tr>
                            <td>Tony</td>
                            <td>Subject 1</td>
                            <td>11:05 AM 25th May 2016</td>
                            <td><i class="fa fa-reply"></i>&nbsp; &nbsp;<i class="fa fa-trash-o"></i></td>
                          </tr>
                          <tr>
                            <td>Tony</td>
                            <td>Subject 1</td>
                            <td>11:05 AM 25th May 2016</td>
                            <td><i class="fa fa-reply"></i>&nbsp; &nbsp;<i class="fa fa-trash-o"></i></td>
                          </tr>
                          <tr>
                            <td>Tony</td>
                            <td>Subject 1</td>
                            <td>11:05 AM 25th May 2016</td>
                            <td><i class="fa fa-reply"></i>&nbsp; &nbsp;<i class="fa fa-trash-o"></i></td>
                          </tr>
                          <tr>
                            <td>Tony</td>
                            <td>Subject 1</td>
                            <td>11:05 AM 25th May 2016</td>
                            <td><i class="fa fa-reply"></i>&nbsp; &nbsp;<i class="fa fa-trash-o"></i></td>
                          </tr>
                          <tr>
                            <td>Tony</td>
                            <td>Subject 1</td>
                            <td>11:05 AM 25th May 2016</td>
                            <td><i class="fa fa-reply"></i>&nbsp; &nbsp;<i class="fa fa-trash-o"></i></td>
                          </tr>
                          <tr>
                            <td>Tony</td>
                            <td>Subject 1</td>
                            <td>11:05 AM 25th May 2016</td>
                            <td><i class="fa fa-reply"></i>&nbsp; &nbsp;<i class="fa fa-trash-o"></i></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- /tile body -->


                  <!-- tile footer -->
                  <div class="tile-footer text-center">
                    <ul class="pagination pagination-sm nomargin pagination-custom">
                      <li class="disabled"><a href="#"><i class="fa fa-angle-double-left"></i></a></li>
                      <li class="active"><a href="#">1</a></li>
                      <li><a href="#">2</a></li>
                      <li><a href="#">3</a></li>
                      <li><a href="#">4</a></li>
                      <li><a href="#">5</a></li>
                      <li><a href="#"><i class="fa fa-angle-double-right"></i></a></li>
                    </ul>
                  </div>
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
      
    </script>


      