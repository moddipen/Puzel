

      
                
        <!-- Page content -->
        <div id="content" class="col-md-12">

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <?php echo $this->element('admin/header');?>
               <!-- /cards -->
            <?php echo $this->Session->flash();?> 
             <div class="pagesubheader">
            

              <h2><i class="fa fa-puzel-icon-left-big"></i> Puzel</h2>

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
                                        <input name="startdate" id="startdate" class="form-control date">
                                        <span class="input-group-addon nobackground"><i class="fa fa-calendar fa-2x"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon nobackground" style="margin-left:-5px;">To</span>
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
                  </div>
                    <div class="table-responsive">
                      <table class="table nomargin text-center">
                        <thead>
                          <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Company Name</th>
                            <th class="text-center">Puzel Name</th>
                            <th class="text-center">Pieces Used</th>
                            <th class="text-center">Balance Pieces</th>
                            <th class="text-center">Data Captured</th>
                            <th class="text-center">Options</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>04/15/2016</td>
                            <td>New Company</td>
                            <td>Puzel 1</td>
                            <td>100</td>
                            <td>60</td>
                            <td>40</td>
                            <td class="minipadding controls">
                              <div class="col-xs-5 text-right"><i class="fa fa-pencil"></i></div><div class="col-xs-7">
                            <div class="onoffswitch green small">
                                  <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch" checked>
                                  <label class="onoffswitch-label" for="onoffswitch">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div></div>
              </td>
                          </tr>
                          <tr>
                            <td>04/15/2016</td>
                            <td>New Company</td>
                            <td>Puzel 1</td>
                            <td>100</td>
                            <td>60</td>
                            <td>40</td>
                            <td class="minipadding controls">
                              <div class="col-xs-5 text-right"><i class="fa fa-pencil"></i></div><div class="col-xs-7">
                            <div class="onoffswitch green small">
                                  <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch" checked>
                                  <label class="onoffswitch-label" for="onoffswitch">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div></div>
              </td>
                          </tr>
                          <tr>
                            <td>04/15/2016</td>
                            <td>New Company</td>
                            <td>Puzel 1</td>
                            <td>100</td>
                            <td>60</td>
                            <td>40</td>
                            <td class="minipadding controls">
                              <div class="col-xs-5 text-right"><i class="fa fa-pencil"></i></div><div class="col-xs-7">
                            <div class="onoffswitch green small">
                                  <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch" checked>
                                  <label class="onoffswitch-label" for="onoffswitch">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div></div>
              </td>
                          </tr>
                          <tr>
                            <td>04/15/2016</td>
                            <td>New Company</td>
                            <td>Puzel 1</td>
                            <td>100</td>
                            <td>60</td>
                            <td>40</td>
                            <td class="minipadding controls">
                              <div class="col-xs-5 text-right"><i class="fa fa-pencil"></i></div><div class="col-xs-7">
                            <div class="onoffswitch green small">
                                  <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch" checked>
                                  <label class="onoffswitch-label" for="onoffswitch">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div></div>
              </td>
                          </tr>
                          <tr>
                            <td>04/15/2016</td>
                            <td>New Company</td>
                            <td>Puzel 1</td>
                            <td>100</td>
                            <td>60</td>
                            <td>40</td>
                            <td class="minipadding controls">
                              <div class="col-xs-5 text-right"><i class="fa fa-pencil"></i></div><div class="col-xs-7">
                            <div class="onoffswitch green small">
                                  <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch" checked>
                                  <label class="onoffswitch-label" for="onoffswitch">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div></div>
              </td>
                          </tr>
                          <tr>
                            <td>04/15/2016</td>
                            <td>New Company</td>
                            <td>Puzel 1</td>
                            <td>100</td>
                            <td>60</td>
                            <td>40</td>
                            <td class="minipadding controls">
                              <div class="col-xs-5 text-right"><i class="fa fa-pencil"></i></div><div class="col-xs-7">
                            <div class="onoffswitch green small">
                                  <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch" checked>
                                  <label class="onoffswitch-label" for="onoffswitch">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div></div>
              </td>
                          </tr>
                          <tr>
                            <td>04/15/2016</td>
                            <td>New Company</td>
                            <td>Puzel 1</td>
                            <td>100</td>
                            <td>60</td>
                            <td>40</td>
                            <td class="minipadding controls">
                              <div class="col-xs-5 text-right"><i class="fa fa-pencil"></i></div><div class="col-xs-7">
                            <div class="onoffswitch green small">
                                  <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch" checked>
                                  <label class="onoffswitch-label" for="onoffswitch">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div></div>
              </td>
                          </tr>
                          <tr>
                            <td>04/15/2016</td>
                            <td>New Company</td>
                            <td>Puzel 1</td>
                            <td>100</td>
                            <td>60</td>
                            <td>40</td>
                            <td class="minipadding controls">
                              <div class="col-xs-5 text-right"><i class="fa fa-pencil"></i></div><div class="col-xs-7">
                            <div class="onoffswitch green small">
                                  <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch" checked>
                                  <label class="onoffswitch-label" for="onoffswitch">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div></div>
              </td>
                          </tr>
                          <tr>
                            <td>04/15/2016</td>
                            <td>New Company</td>
                            <td>Puzel 1</td>
                            <td>100</td>
                            <td>60</td>
                            <td>40</td>
                            <td class="minipadding controls">
                              <div class="col-xs-5 text-right"><i class="fa fa-pencil"></i></div><div class="col-xs-7">
                            <div class="onoffswitch green small">
                                  <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch" checked>
                                  <label class="onoffswitch-label" for="onoffswitch">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div></div>
              </td>
                          </tr>
                          <tr>
                            <td>04/15/2016</td>
                            <td>New Company</td>
                            <td>Puzel 1</td>
                            <td>100</td>
                            <td>60</td>
                            <td>40</td>
                            <td class="minipadding controls">
                              <div class="col-xs-5 text-right"><i class="fa fa-pencil"></i></div><div class="col-xs-7">
                            <div class="onoffswitch green small">
                                  <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch" checked>
                                  <label class="onoffswitch-label" for="onoffswitch">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div></div>
              </td>
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
        <!-- Page content end -->




        






      