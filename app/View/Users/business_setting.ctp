<style type="text/css">
    .pagesubheader .title, .pagesubheader .alert{float: left;}
    .alert{margin-left: 20px;margin-top: 25px;font-size: 16px;color: #FFF;}
    .title {margin-bottom: 15px;}
</style>


      
                
        <!-- Page content -->
        <div id="content" class="col-md-12">

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <?php echo $this->element('business/header');?>
            


          </div>
          <!-- /content container -->
                      <!-- /cards -->

             
             <div class="pagesubheader">
              <h2 class="title"><i class="fa fa-user"></i> Profile</h2><div id="alert" class="alert"><?php echo $this->Session->flash();?> </div>
             </div>


            <!-- row -->
            <div class="row">


              <!-- col 8 -->
              <div class="col-lg-12 col-md-12">




                <!-- tile -->
                <!-- /tile -->



                <!-- tile -->
                <section class="tile color transparent-black padding10px">


                  <!-- tile body -->
                  <div class="tile-body">
                    <?php echo $this->form->create('',array('action'=>'settings','class'=>"profile-settings custom-form"));?>

                      

                        <div class="row">

                          <div class="form-group col-md-12 legend">

                            <h4><strong>Personal</strong> Settings</h4>

                            <p>Your personal account settings</p>

                          </div>

                        </div>



                        <div class="row">



                          <div class="form-group col-sm-6">

                            <label for="first-name">First Name</label>

                            <input type="text" name ="data[User][firstname]" class="form-control" id="first-name" value="<?php echo $User['User']['firstname']?>">
                          </div>



                          <div class="form-group col-sm-6">

                            <label for="last-name">Last Name</label>

                            <input type="text" name = "data[User][lastname]" class="form-control"  id="last-name" value="<?php echo $User['User']['lastname']?>">

                          </div>



                        </div>


<!-- 
                        <div class="row">



                          <div class="form-group col-sm-6">

                            <label for="address1">Address Line 1</label>

                            <input type="text" class="form-control" id="address1" value="Vajnorska 215">

                          </div>



                          <div class="form-group col-sm-6">

                            <label for="address2">Address Line 2</label>

                            <input type="text" class="form-control" id="address2" value="IBM Tower, floor #32">

                          </div>



                        </div> 



                        <div class="row">



                          <div class="form-group col-sm-3">

                            <label for="city">City</label>

                            <input type="text" class="form-control" id="city" value="Bratislava">

                          </div>

                          <div class="form-group col-sm-3">

                            <label for="zip">Zip Code</label>

                            <input type="text" class="form-control" id="zip" value="215 62">

                          </div>

                          <div class="form-group col-sm-3">

                            <label for="state">State/Provice</label>

                            <input type="text" class="form-control" id="state" value="Bratislava">

                          </div>



                          
                            <div class="form-group col-sm-3">

                            <label for="country">Country</label>

                            <select class="chosen-select form-control" id="country">

                              <option>Slovakia</option>

                              <option>Czech Republic</option>

                              <option>Poland</option>

                              <option>Hungary</option>

                              <option>Austria</option>

                            </select>

                          </div>


                        </div>-->



                        <div class="row">



                          <div class="form-group col-sm-6">

                            <label for="phone">Phone</label>

                            <input type="text" class="form-control" name="data[User][phone]" id="phone" value="<?php echo $User['User']['phone']?>">
                            <span class="help-block">+(421) 999 999 999</span>
                            <span style="display:none" id="errorphone" style="color:#fff;">Please Enter Valid number</span>
                          </div>
                          <div class="form-group col-sm-6">

                            <label for="website">Website</label>

                            <input type="text" class="form-control" name="data[User][website]" id="website" value="<?php echo $User['User']['website']?>">

                          </div>
                        </div>


                        <div class="row">

                          <div class="form-group col-md-12 legend">

                            <h4><strong>Security</strong> Settings</h4>

                            <p>Secure your account</p>

                          </div>

                        </div>



                        <div class="row">



                          <div class="form-group col-sm-12">

                            <label for="emailaddress">Email Address</label>

                            <input type="text" class="form-control" id="emailaddress" name ="data[User][email]" value="<?php echo $User['User']['email']?>" >

                          </div>





<!--                           <div class="form-group col-sm-6">

                            <label for="password">Current Password</label>

                            <input type="password" class="form-control" id="password" value="<?php echo $User['User']['password']?>" readonly>

                          </div>
 -->


                        </div>



                        <div class="row">



                          <div class="form-group col-sm-6">

                            <label for="new-password">New Password</label>

                            <input type="password"  name ="data[User][newpassword]" class="form-control" id="new-password">

                          </div>



                          <div class="form-group col-sm-6">

                            <label for="new-password-repeat">New Password Repeat</label>

                            <input type="password" name ="data[User][newpasswordrepeat]" class="form-control" id="new-password-repeat">

                          </div>



                        </div>



                       <div class="row">
                       <div class="col-md-4">
                       </div>
                       <div class="col-sm-2 col-xs-6">
                          <button type="submit" class="btn btn-oranges fullwidth">Submit</button>
                       </div>
                       <div class="col-sm-2 col-xs-6">
                          <button type="reset" class="btn btn-black-transparent fullwidth">Cancel</button>
                        </div>
                       </div>



                        </div>



                      </form>

                  </div>
                  <!-- /tile body -->


                </section>
                <!-- /tile -->


              </div>
              <!-- /col 8 -->



              <!-- col 4 -->
              
              <!-- /col 4 -->
              
              
            </div>





        </div>
        <!-- Page content end -->




        

<script type="text/javascript">
  $("form").submit(function()
  {
    var mob = /([0-9]{10})|(\([0-9]{3}\)\s+[0-9]{3}\-[0-9]{4})/;
    if (mob.test($.trim($("#phone").val())) == false)
    {
        $("#phone").focus();
        $("#errorphone").css("display","block");   
        $("#errorphone").show().delay(3000).fadeOut(function(){ $(this).hide(); });   
        return false;
    }
    else
    {
      $("#errorphone").css("display","none");    
      return true;
    }  
  })
</script>




      