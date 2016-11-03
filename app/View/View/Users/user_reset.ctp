
<script>
$("form").validate({
	rules: {
		'data[User][newpassword]': {required: true,password: true},
		'data[User][cnfrmpassword]': {required: true,password: true,equalTo: "#UserNewpassword" } 
	},
	messages: {
		'data[User][newpassword]': {required: 'Please enter an 8 to 16 characters alpha-numeric password.'},
		'data[User][cnfrmpassword]': {required: 'Please enter an 8 to 16 characters alpha-numeric password.',equalTo: 'Mismatch!'} 
	}
});
</script>
      
                
        <!-- Page content -->
        <div id="content" class="col-md-12 full-page login">

          <div class="row">
            <div class="col-md-3">
          </div>
        <div class=" col-md-6">
         <div class="inside-block">
              <img src="<?php echo $this->webroot;?>img/dashboard/logo.png" alt="" class="logo">
               <?php echo $this->Session->flash();
              echo $this->Form->create('User', array('action' => 'reset/'.$token,"class"=>"Formsubmit"));?>
                <section>
                  <div class="input-group" id="fname">
                    <?php echo $this->Form->input('User.newpassword',array('label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'Enter password','type'=>'password'));?>
                    <div class="input-group-addon"><i class="fa fa-key"></i></div>
                  </div>
                  <div class="input-group" id="lname">
                    <?php echo $this->Form->input('User.cnfrmpassword',array('label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'Enter confirm password ','type'=>'password'));?>
                    <div class="input-group-addon"><i class="fa fa-key"></i></div>
                  </div>
                </section>
                <section class="log-in">
                  <button class="btn btn-oranges" type="submit"><b>Reset Password</b></button>
                </section>
             <?php   echo $this->Form->end();?>
            </div>
            </div>
        </div>
     </div>
      <!-- Page content end -->

     <script type="text/javascript">
     
     $( document ).ready(function()
     {
      $("form").submit(function()
      {
          
          if($("#UserNewpassword").val() == '')
          {
            //$("#fname").after("<p class='error'> Please enter first name .</p>");
            return false;
          }
          else if($("#UserCnfrmpassword").val() == '')
          {
             //$("#lname").after("<p class='error'> Please enter last name .</p>");
              return false; 
          }
          else
          {
            $(".error").css({'display':'none'});
            return true;
          }

          if($("#UserNewpassword").val() !=  $("#UserCnfrmpassword").val())
          {
            $("#lname").after("<p class='error'> Password doesnot match .</p>");
            return false; 
          }
          else
          {
            $(".error").css({'display':'none'});
            return true;
          }  


      });



     });


     </script>



        






      