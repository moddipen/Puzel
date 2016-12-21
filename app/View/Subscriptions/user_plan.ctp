  
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
    <a href="<?php echo Configure::read("SITE_URL");?>subscriptions/package"><img src="<?php echo $this->webroot;?>img/logo.png" class="logo"></a>
    <h3 class="purple">Grow your customer base with Puzel.<br>
      Sign up to be first in line to take it for a test drive once it launches.</h3>
  
             
    <!-- Begin MailChimp Signup Form -->
    <!--link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
    <style type="text/css">
      #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif;  max-width:600px; width: 100%; margin: 0px auto;}
      /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
         We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
        #mc_embed_signup #mc-embedded-subscribe-form div.mce_inline_error{position:absolute; right:-10px; top:0px; background:none;}
    </style>
    <!-- <div id="mc_embed_signup"> -->
    <?php   
      echo $this->Session->flash();
      $id = $Rate['Subscription']['name']; 
      //echo $this->Form->create('Subscription', array('action' => 'plan/'.$id,'class'=>'Formsubmit'));?>
      <form id="SubscriptionPlan" class="Formsubmit" action="<?php echo Configure::read("SITE_URL");?>sign-up/<?php echo $id;?>" method="post" accept-charset="utf-8" novalidate="novalidate">
    <!-- <form action="<?php echo $Type;?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" novalidate> -->
      <section>
      <div id="mc_embed_signup_scroll">
      <h2 style="padding-bottom:20px;">Sign up for Puzel</h2>
      <!-- <div class="indicates-required"><span class="asterisk">*</span> indicates required</div> -->
    <?php

    	if(!$cardDetail && $this->Session->read("Auth.User.id") == "")
    	{
    ?>
    <div class="input-group">
      <!-- <label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
    </label> -->
      <input type="email" value="" name="data[Subscription][email]" class="form-control" id="email"  placeholder = "Please enter email" required>
        <div class="input-group-addon">
          <i class="fa fa-envelope"></i>
        </div>
    </div>
    <!--div id="erroremail"></div-->
    <div class="input-group">
      <!-- <label for="mce-FNAME">First Name </label> -->
      <input type="text" value="" name="data[Subscription][firstname]" class="form-control" id="FNAME" placeholder = "Please enter first name" required>
      <div class="input-group-addon">
          <i class="fa fa-user"></i>
        </div>
    </div>
    <!--div id="errorfname"></div-->
    <div class="input-group">
      <!-- <label for="mce-LNAME">Last Name </label> -->
      <input type="text" value="" name="data[Subscription][lastname]" class="form-control" id="LNAME" placeholder = "Please enter last name" required>
      <div class="input-group-addon">
          <i class="fa fa-user"></i>
        </div>
    </div>
    <!--div id="errorlname"></div-->

    <div class="input-group">
      <!-- <label for="mce-LNAME">Company Name </label> -->
      <input type="text" value="" name="data[Subscription][company_name]" class="form-control" id="company_name" placeholder = "Please enter company name" required>
      <div class="input-group-addon">
          <i class="fa fa-user"></i>
        </div>
    </div>
    <!--div id="errorcname"></div-->


    <div class="input-group">
      <!-- <label for="mce-LNAME">Password</label> -->
      <input type="password" value="" name="data[Subscription][password]" class="form-control" id="password" placeholder = "Please enter password" required>
      <div class="input-group-addon">
          <i class="fa fa-key"></i>
        </div>
    </div>

    <div id="errorpassword"></div>
    <div class="input-group">
      <!-- <label for="mce-LNAME">Password</label> -->
      <input type="password" value="" name="data[Subscription][confirm_password]" class="form-control" id="cnfrmpassword" placeholder = "Please enter confirm password" required>
      <div class="input-group-addon">
          <i class="fa fa-key"></i>
        </div>
    </div>
    <div id="errorcnfrmpassword"></div>

    <!--div id="errorpassword"></div-->

    	<?php }else{
    		
    		echo "<input type='hidden' name='data[Subscription][action]' value='upgrade'>";
    		
    	} ?>
    <div class="input-group">
      <!-- <label for="mce-LNAME">Amount </label> -->
      <input type="text" value="<?php echo $Rate['Subscription']['price'];?>" name="data[Subscription][price]" readonly="readonly" class="form-control" id="amount">
      <div class="input-group-addon">
          <i class="fa fa-dollar"></i>
        </div>
    </div>
    <?php if($Rate['Subscription']['price'] != "Free" ) {?>
    <div class="input-group">
     
      <?php
    	$number = "************".$cardDetail->creditCard['last4'];
    	if(!$cardDetail){
    		echo "<input type='text' class='form-control' value='".$number."'  name='data[Subscription][card_number]'  id='card_number1' maxlength='19' placeholder='1234 5678 9012 3456' required>";
        echo '<div class="input-group-addon"><i class="fa fa-credit-card"></i></div>';
    		
    	}else{
    		echo '<input type="text" value="'.$number.'" readonly name="data[Subscription][card_number]" id="card_number1" class="form-control"  placeholder="1234 5678 9012 56" required />';
        echo '<div class="input-group-addon"><i class="fa fa-credit-card"></i></div>';
    	}
      ?>
      
    </div>

    <div class="input-group">
     <?php
    	$name = $cardDetail->creditCard['cardholderName'];
    	if(!$cardDetail){
    	 	echo '<input type="text" value="'.$name.'"  name="data[Subscription][holder_name]" class="form-control" id="card_name" placeholder="Cardholder name" required>';
    	 echo '<div class="input-group-addon"><i class="fa fa-user"></i></div>';	
    	}else{
    		echo '<input type="text" value="'.$name.'" readonly name="data[Subscription][holder_name]" class="form-control"  id="card_name" placeholder="Cardholder name" required />';
        echo '<div class="input-group-addon"><i class="fa fa-user"></i></div>';
    	}
    	?>     
    </div>

    <div id="errorccard"></div>
    <input type ="hidden" value ="" name="data[Subscription][check]" id="validcard">
    <div class="form-group">
    <div class="row dropup">
     <div class="col-sm-4 col-xs-12">
     	<div class="form-group">
      <?php
    	
    	if(!$cardDetail){
    	?><select required  name="data[Subscription][ex_date_month][month]" id="month" data-chosen-options='{ "disable_search": true }' class="chosen-select chosen-transparent form-control " >
        <?php
    		
    	}else{
    		?><select required disabled name="data[Subscription][ex_date_month][month]" id="month" data-chosen-options='{ "disable_search": true }' class="chosen-select chosen-transparent form-control">
			<?php
    	}
    	?>
         
              <?php
    		  
    		 
      for ($i = 0; $i < 12; ++$i) {
    	 $selected = "";
        $time = strtotime(sprintf('+%d months', $i));
        $value = date('m', $time);
        $label = date('F', $time);
    	 if($value == $cardDetail->creditCard['expirationMonth']){printf('<option value="%s" selected>%s</option>', $value, $label);}
        else{
    		printf('<option value="%s">%s</option>', $value, $label);
    	}
      }
      ?>
    		  
            </select>
            </div>
            </div>
<div class="col-sm-4 col-xs-12">
<div class="form-group">
    
      <?php
    	$cardDetail->creditCard['last4'];
    	if(!$cardDetail){
    		?>
            <select required  name="data[Subscription][ex_date_year][year]" id="year" data-chosen-options='{ "disable_search": true }' class="chosen-select chosen-transparent form-control">
            <?php
    		
    	}else{
    		?>
            <select required disabled name="data[Subscription][ex_date_year][year]" id="year" data-chosen-options='{ "disable_search": true }' class="chosen-select chosen-transparent form-control">
            <?php
    	}
    	?>
         
       
          <?php
    	  
    		$year = date ('Y');
    		$years = range ($year, $year + 10);
    		foreach ($years as $value) {
    			if($value == $cardDetail->creditCard['expirationYear']){echo '<option value ="'.$value.'" selected>' . $value;}
    			else{echo '<option value ="'.$value.'">' . $value;}
    		}
    ?>
    	  
      </select>
</div>
</div>
    <!-- </div>

    <div class="mc-field-group"> -->
      <!-- <label for="mce-LNAME">CVV </label> -->
      <div class="col-sm-4 col-xs-12">
      <div class="input-group" style="width:100%;">
      <input type="text" value="" name="data[Subscription][cvv]"  id="cvv" maxlength="4"  placeholder ="CVV" class="form-control" required>
      </div>
      </div>
      </div>
    </div>
    <!--div id="errorcvv"></div-->
    <?php } ?>
      <div id="mce-responses" class="clear">
        <div class="response" id="mce-error-response" style="display:none"></div>
        <div class="response" id="mce-success-response" style="display:none"></div>
      </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->

        <input type="hidden" name="b_07f1846d778e631822b8f85cf_e5b207e707" tabindex="-1" value="">
        <?php if(!$cardDetail) {?>
            <div class="clear text-center" style="padding-bottom:30px;"><input type="submit" value="Sign up" name="subscribe" id="mc-embedded-subscribe" class="btn btn-oranges"></div><?php } else {?>
            <div class="clear text-center" style="padding-bottom:30px;"><input type="submit" value="Upgrade confirm" name="subscribe" id="mc-embedded-subscribe" class="btn btn-oranges"></div>
            <?php }?>
        </div>
      </section>
    </form>

    </div>
   </div>
<!-- </div> -->

<?php echo $this->Html->script('jquery.creditCardValidator');?>

 <script type="text/javascript">

$(document ).ready(function(){
	<?php if($Rate['Subscription']['price'] == "Free" ) {?>
	$("form").validate({
		rules: {
			'data[Subscription][email]': {required: true, email: true},
			'data[Subscription][firstname]':{required:true},
			'data[Subscription][lastname]':{required:true},
			'data[Subscription][company_name]':{required:true},
			'data[Subscription][password]': {required: true,password: true},
      'data[Subscription][confirm_password]': {required: true,password: true}           
		},
		messages: {
			'data[Subscription][email]': {required: 'Please enter a valid email address.'},
			'data[Subscription][firstname]':{required:'Please enter First name'},
			'data[Subscription][lastname]':{required:'Please enter Last name'},
			'data[Subscription][company_name]':{required:'Please enter Company name'},
			'data[Subscription][password]': {required: 'Please enter valid password.'},
      'data[Subscription][confirm_password]': {required: 'Please enter valid password.'}
		}
	});
	<?php }else {?> 
	$("form").validate({
		rules: {
			'data[Subscription][email]': {required: true, email: true},
			'data[Subscription][firstname]':{required:true},
			'data[Subscription][lastname]':{required:true},
			'data[Subscription][company_name]':{required:true},
			'data[Subscription][card_number]':{required:true},
			'data[Subscription][holder_name]':{required:true},
			'data[Subscription][ex_date_month][month]':{required:true},
			'data[Subscription][ex_date_year][year]':{required:true},
			'data[Subscription][cvv]':{required:true},
			'data[Subscription][password]': {required: true,password: true},
      		'data[Subscription][confirm_password]': {required: true,password: true}
      
		},
		messages: {
			'data[Subscription][email]': {required: 'Please enter a valid email address.'},
			'data[Subscription][firstname]':{required:'Please enter First name'},
			'data[Subscription][lastname]':{required:'Please enter Last name'},
			'data[Subscription][company_name]':{required:'Please enter Company name'},
			'data[Subscription][card_number]':{required:'Please enter Credit Card Number'},
			'data[Subscription][holder_name]':{required:'Please Enter Holder Name Card'},
			'data[Subscription][ex_date_month][month]':{required:'Please choose month'},
			'data[Subscription][ex_date_year][year]':{required:'Please choose year'},
			'data[Subscription][cvv]':{required:'Please enter CVV'},
			'data[Subscription][password]': {required: 'Please enter valid password.'},
      		'data[Subscription][confirm_password]': {required: 'Please enter valid password.'}
		}
	});
	$('#card_number1').validateCreditCard(function(result) {
            if(result.card_type == null)
            {
                $('#card_number1').removeClass();
                $('#card_number1').addClass("form-control");
            }
            else
            {
                $('#card_number1').addClass(result.card_type.name);
                $('#validcard').val(result.card_type.name);
            }
            
            if(!result.valid)
            {
                $('#card_number1').removeClass("valid");
            }
            else
            {
                $('#card_number1').addClass("valid");
            }
        }); 
	<?php }?> 
      
     $("form").submit(function()
     {
       
      if($("#email").val() == "")
        {
          $("#erroremail").html('<p style = "color:red">Please enter email id</p>')
          return false;
        }
        if($("#FNAME").val() == "")
        {
          $("#errorfname").html('<p style = "color:red">Please enter first name.</p>')
          return false; 
        }
		 if($("#company_name").val() == "")
        {
          $("#errorcname").html('<p style = "color:red">Please enter company name.</p>')
          return false; 
        }
        if($("#LNAME").val() == "")
        {
          $("#errorlname").html('<p style = "color:red">Please enter last name.</p>')
          return false; 
        }
        if($("#password").val() == "")
        {
           $("#errorpassword").html('<p style = "color:red">Please enter password.</p>')
          return false; 
        }
        if($("#cnfrmpassword").val() == "")
        {
           $("#errorcnfrmpassword").html('<p style = "color:red">Please enter confirm password.</p>')
          return false; 
        }

        if($("#password").val() != $("#cnfrmpassword").val())
         {
            $("#errorpassword").html('<p style = "color:red">Password doesnot match.</p>')
            $("#errorcnfrmpassword").html('<p style = "color:red">Password doesnot match.</p>')
            return false;   
         } 
        if($("#card_number").val() == "")
        {
           $("#errorccard").html('<p style = "color:red">Please enter card number.</p>')
          return false; 
        }
        if($("#cvv").val() == "")
        {
           $("#errorcvv").html('<p style = "color:red">Please enter cvv number.</p>')
          return false; 
        }

        if($("#month").val() == "")
        {
          alert("Please select month");
          return false; 
        }
        if($("#year").val() == "")
        {
          alert("Please select year");
          return false; 
        }
     }) ;


    
  });
</script>