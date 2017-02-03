  
<style>
  body {overflow-y:auto;}  
  #content.full-page .inside-block form .input-group input#cvv {
    border-bottom-right-radius: 4px !important;
    border-top-right-radius: 4px !important;
}
.chosen-container .chosen-drop {
    border-bottom: 0;
    border-top: 1px solid #aaa;
    top: auto;
    bottom: 40px;
}
</style>



<div id="content" class="col-md-12 full-page login">
  <div class="inside-block">


      <a href="<?php echo Configure::read("SITE_URL");?>"><img src="<?php echo $this->webroot;?>img/logo.png" class="logo"></a>
      
    <h3 class="purple">Sign up to receive rewards from your favorite companies.<br>
        Once Puzel launches you will be first in line for the abundance.</h3>
       
      <?php echo $this->Session->flash();?> 
      <form id="Usersignup" class="Formsubmit" action="<?php echo Configure::read("SITE_URL");?>user/sign-up" method="post" accept-charset="utf-8" novalidate="novalidate">
      <section>
            <div id="mc_embed_signup_scroll">
              <h2 style="padding-bottom:20px;">Sign up for Puzel</h2>
             
             <div class="input-group">
                <input type="email" value="" name="data[User][email]" class="form-control" id="email"  placeholder = "Please enter email" required>
                  <div class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                  </div>
              </div>
              <div class="input-group">
                <input type="text" value="" name="data[User][firstname]" class="form-control" id="FNAME" placeholder = "Please enter first name" required>
                <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
              </div>
              <div class="input-group">
                <input type="text" value="" name="data[User][lastname]" class="form-control" id="LNAME" placeholder = "Please enter last name" required>
                <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
              </div>
         
             <div class="input-group">
                <input type="password" value="" name="data[User][password]" class="form-control" id="password" placeholder = "Please enter password" required>
                <div class="input-group-addon">
                    <i class="fa fa-key"></i>
                  </div>
              </div>
            <div id="errorpassword"></div>
            <div class="input-group">
              <input type="password" value="" name="data[User][confirm_password]" class="form-control" id="confirm_password" placeholder = "Please enter confirm password" required>
              <div class="input-group-addon">
                  <i class="fa fa-key"></i>
                </div>
            </div>
            <div id="errorcnfrmpassword"></div>
            </div>
        
                <div class="clear text-center" style="padding-bottom:30px;"><input type="submit" value="Signup" id="mc-embedded-subscribe" class="btn btn-oranges"></div>
      </section>
    </form>

    </div>
   </div>


 <script type="text/javascript">

$(document ).ready(function(){
  $("form").validate({
    rules: {
      'data[User][email]': {required: true, email: true},
      'data[User][firstname]':{required:true},
      'data[User][lastname]':{required:true},
      'data[User][password]': {required: true,password: true},
      'data[User][confirm_password]': {required: true , equalTo : '#password'}           
    },
    messages: {
      'data[User][email]': 'Please enter a valid email address.',
      'data[User][firstname]':'Please enter First name.',
      'data[User][lastname]':'Please enter Last name',
      'data[User][password]': 'Please enter valid password.',
      'data[User][confirm_password]': 'Please enter valid password.'
    }
  }); 

 



});
</script>