

      
                
        <!-- Page content -->
        <div id="content" class="col-md-12 full-page login">

          <div class="row">
            <div class="col-md-3">
          </div>
        <div class=" col-md-6">
         <div class="inside-block">
              <img src="<?php echo $this->webroot;?>img/dashboard/logo.png" alt="" class="logo">
               <?php echo $this->Session->flash();
              echo $this->Form->create('User', array('action' => 'login',"class"=>"Formsubmit","novalidate"=>true));?>
                <section>
                  <div class="input-group">
                    <?php echo $this->Form->input('User.email',array('label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'Enter email'));?>
                    <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                  </div>
                  <div class="input-group">
                    <?php echo $this->Form->input('User.password',array('label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'Enter Password'));?>
                    <div class="input-group-addon"><i class="fa fa-key"></i></div>
                  </div>
                </section>
                <section class="controls">
                  <div class="checkbox check-transparent">
                    <input type="checkbox" value="1"  name ="data[User][remember_me]" id="remember" checked="">
                    <label for="remember">Remember me</label>
                  </div>
                  <a href="<?php echo Configure::read('SITE_USER_URL');?>/users/forgetpassword">Forget password?</a>
                </section>
                <section class="log-in">
                  <button class="btn btn-oranges"><b>Log In</b></button>
                </section>
             <?php   echo $this->Form->end();?>
            </div>
            </div>
        </div>






        </div>
        <!-- Page content end -->




        






      