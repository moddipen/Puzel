<script type="text/javascript">
$( document ).ready(function() { 
$("form").validate({
	rules: {
		'data[User][firstname]':{required:true},
		'data[User][lastname]':{required:true},
		'data[User][company_name]':{required:true},
		'data[User][email]': {required: true, email: true},
		'data[User][password]': {required: true, password: true},
		'data[User][confirm_password]': {required: true,password: true, equalTo: "#UserPassword"},
	},
	messages: {
		'data[User][firstname]':{required:'Please enter first name'},
		'data[User][lastname]':{required:'Please enter last name'},
		'data[User][company_name]':{required:'Please enter company name'},
		'data[User][email]': {required: 'Please enter a valid email address.'},
		'data[User][password]': {required: 'Please enter valid password.'},
		'data[User][confirm_password]': {required: 'Please enter valid password.', equalTo: "Mismatch!"},
	}
});
});
</script>    
    <!-- Page content -->
        <div id="content" class="col-md-12 full-page login">
       <div class="inside-block">
            <img src="<?php echo $this->webroot;?>img/logo.png" alt="" class="logo">
            
            <?php echo $this->Session->flash();
            echo $this->Form->create('User', array('action' => 'register/'.$Type,"class"=>"Formsubmit","novalidate"=>true));?>
              <section>
                <div class="input-group">
                  <!-- <input type="text" class="form-control" name="data[User][firstname]" id="firstname" placeholder="First Name"> -->
                  <?php echo $this->Form->input('User.firstname',array('label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'Enter first name'));?>
                  <div class="input-group-addon"><i class="fa fa-user"></i></div>
                </div>
                 <div style ="display:none" id="errorfname"> Please Enter First name </div>
                <div class="input-group">
                  <?php echo $this->Form->input('User.lastname',array('label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'Enter last name'));?>
                  <div class="input-group-addon"><i class="fa fa-user"></i></div>
                </div>
                <div style ="display:none" id="errorlname"> Please Enter Last name </div>  
                <div class="input-group">
                  <?php echo $this->Form->input('User.company_name',array('label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'Enter company name'));?>
                  <div class="input-group-addon"><i class="fa fa-user"></i></div>
                </div>
                <div class="input-group">
                  <?php echo $this->Form->input('User.email',array('label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'Enter email name'));?>
                  <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                </div>
                <div style ="display:none" id="erroremail"> Please Enter Email </div>
                <div class="input-group">
                  <?php echo $this->Form->input('User.password',array('label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'Enter Password'));?>
                  <div class="input-group-addon"><i class="fa fa-key"></i></div>
                </div>
                <div style ="display:none" id="errorpassword"> Please Enter Password </div>
                <div class="input-group">
                  <?php echo $this->Form->input('User.confirm_password',array('type'=>'password','label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'Enter confirm password'));?>
                  <div class="input-group-addon"><i class="fa fa-key"></i></div>
                </div>
                <div style ="display:none" id="errorrepass"> Please Enter Retype Password </div>
              </section>
              <section class="log-in">
                <button class="btn btn-oranges" type="submit"><b>Sign Up</b></button>
              </section>
            <?php   echo $this->Form->end();?>
          </div>
          
        </div>
        <!-- Page content end -->
<script type="text/javascript">
    
   $(function()
   {
      $("form").submit(function()
      {
        if($("#firstname").val() == '')
        {
          $("#errorfname").css("display", "block");
          return false;
        }
        else
        {
          $("#errorfname").css("display", "none"); 
        } 
        if($("#lastname").val() == '')
        {
          $("#errorlname").css("display", "block");
          return false;
        }
        else
        {
          $("#errorlname").css("display", "none");
        }  
        if($("#useremail").val() == '')
        {
          $("#erroremail").css("display", "block");
          return false;
        }
        else
        {
          $("#erroremail").css("display", "none");
        }  
        if($("#password").val() == '')
        {
          $("#errorpassword").css("display", "block");
          return false;
        }
        else
        {
          $("#errorpassword").css("display", "none"); 
        }  
        if($("#confirmpassword").val() == '')
        {
          $("#errorrepass").css("display", "block");
          return false;
        }
        else
        {
          $("#errorrepass").css("display", "none"); 
        }  
      });
   });



</script>

