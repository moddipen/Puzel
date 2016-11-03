<style>
  body {overflow-y:scroll;}  
</style>



<div id="container" class="container inner-popup-page">
<div class="row">
  
        <div class="twelve columns text-center fix-max-width">
      <a href="<?php echo Configure::read("SITE_URL");?>subscriptions/package"><img src="<?php echo $this->webroot;?>img/logo.png"></a>
        <h3 class="purple">Grow your customer base with Puzel.<br>
        Sign up to be first in line to take it for a test drive once it launches.</h3>
    </div>
    
</div>
<div class="row">
  <div class="three columns">
    </div>
    <div class="six columns">
    <!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
<style type="text/css">
  #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif;  max-width:600px; width: 100%; margin: 0px auto;}
  /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
     We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
     #mc_embed_signup #mc-embedded-subscribe-form div.mce_inline_error{position:absolute; right:-10px; top:0px; background:none;}
</style>
<div id="mc_embed_signup">
<?php   
  echo $this->Session->flash();
 $id = $Rate['Subscription']['id']; 
echo $this->Form->create('Subscription', array('action' => 'plan/'.$id));?>
<!-- <form action="<?php echo $Type;?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" novalidate> -->
    <div id="mc_embed_signup_scroll">
  <h2>Sign up for Puzel</h2>
<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
<?php

	if(!$cardDetail && $this->Session->read("Auth.User.id") == "")
	{
?>
<div class="mc-field-group">
  <label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
</label>
  <input type="email" value="" name="data[Subscription][email]" class="required email" id="email" required>
</div>
<div id="erroremail"></div>
<div class="mc-field-group">
  <label for="mce-FNAME">First Name </label>
  <input type="text" value="" name="data[Subscription][firstname]" class="" id="FNAME" required>
</div>
<div id="errorfname"></div>
<div class="mc-field-group">
  <label for="mce-LNAME">Last Name </label>
  <input type="text" value="" name="data[Subscription][lastname]" class="" id="LNAME" required>
</div>
<div id="errorlname"></div>

<div class="mc-field-group">
  <label for="mce-LNAME">Company Name </label>
  <input type="text" value="" name="data[Subscription][company_name]" class="" id="company_name" required>
</div>
<div id="errorcname"></div>


<div class="mc-field-group">
  <label for="mce-LNAME">Password</label>
  <input type="password" value="" name="data[Subscription][password]" class="" id="password" required>
</div>
<div id="errorpassword"></div>
	<?php }else{
		
		echo "<input type='hidden' name='data[Subscription][action]' value='upgrade'>";
		
	} ?>
<div class="mc-field-group">
  <label for="mce-LNAME">Amount </label>
  <input type="text" value="<?php echo $Rate['Subscription']['price'];?>" name="data[Subscription][price]" readonly="readonly"  id="amount">
</div>
<?php if($Rate['Subscription']['price'] != "Free" ) {?>
<div class="mc-field-group">
  <label for="mce-LNAME">Card </label>
  <?php
	$number = "************".$cardDetail->creditCard['last4'];
	if(!$cardDetail){
		echo '<input type="text" value="'.$number.'"  name="data[Subscription][card_number]" class="" id="card_number" placeholder="1234 5678 9012 3456" required>';
		
	}else{
		echo '<input type="text" value="'.$number.'" readonly name="data[Subscription][card_number]" class="" id="card_number" placeholder="1234 5678 9012 3456" required>';
	}
  ?>
  
</div>

<div class="mc-field-group">
 <label for="mce-LNAME">Card Holder Name </label>
 <?php
	$name = $cardDetail->creditCard['cardholderName'];
	if(!$cardDetail){
		echo '<input type="text" value="'.$name.'"  name="data[Subscription][holder_name]" class="" id="card_number" placeholder="John Duo" required>';
		
	}else{
		echo '<input type="text" value="'.$name.'" readonly name="data[Subscription][holder_name]" class="" id="card_number" placeholder="John Duo" required>';
	}
	?>
 
  
</div>

<div id="errorccard"></div>
<input type ="hidden" value ="" name="data[Subscription][check]" id="validcard">
<div class="mc-field-group">
  <label for="mce-LNAME">Month </label>
  <?php
	
	if(!$cardDetail){
		echo '<select required  name="data[Subscription][ex_date_month][month]" id="month" >';
		
	}else{
		echo '<select required disabled name="data[Subscription][ex_date_month][month]" id="month" >';
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
<div class="mc-field-group">
  <label for="mce-LNAME">Year </label>
  <?php
	
	if(!$cardDetail){
		echo '<select required  name="data[Subscription][ex_date_year][year]" id="year" >';
		
	}else{
		echo '<select required disabled name="data[Subscription][ex_date_year][year]" id="year" >';
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

<div class="mc-field-group">
  <label for="mce-LNAME">CVV </label>
  <input type="text" value="" name="data[Subscription][cvv]" class="" id="cvv" maxlength="4" required>
</div>
<div id="errorcvv"></div>
<?php } ?>
  <div id="mce-responses" class="clear">
    <div class="response" id="mce-error-response" style="display:none"></div>
    <div class="response" id="mce-success-response" style="display:none"></div>
  </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_07f1846d778e631822b8f85cf_e5b207e707" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </div>
</form>

</div>

<?php echo $this->Html->script('jquery.creditCardValidator');?>

<script>
  $(document ).ready(function()
  {
      $('#card_number').validateCreditCard(function(result) {
            if(result.card_type == null)
            {
                $('#card_number').removeClass();
            }
            else
            {
                $('#card_number').addClass(result.card_type.name);
                $('#validcard').val(result.card_type.name);
            }
            
            if(!result.valid)
            {
                $('#card_number').removeClass("valid");
            }
            else
            {
                $('#card_number').addClass("valid");
              }
        }); 




     $("form").submit(function()
     {
       
      if($("#email").val() == "")
        {
          $("#erroremail").html('<p style = "color:red">Please Enter email id</p>')
          return false;
        }
        if($("#FNAME").val() == "")
        {
          $("#errorfname").html('<p style = "color:red">Please Enter first name.</p>')
          return false; 
        }
		 if($("#company_name").val() == "")
        {
          $("#errorcname").html('<p style = "color:red">Please Enter company name.</p>')
          return false; 
        }
        if($("#LNAME").val() == "")
        {
          $("#errorlname").html('<p style = "color:red">Please Enter last name.</p>')
          return false; 
        }
        if($("#password").val() == "")
        {
           $("#errorpassword").html('<p style = "color:red">Please Enter last name.</p>')
          return false; 
        }
        if($("#card_number").val() == "")
        {
           $("#errorccard").html('<p style = "color:red">Please Enter card number.</p>')
          return false; 
        }
        if($("#cvv").val() == "")
        {
           $("#errorcvv").html('<p style = "color:red">Please Enter cvv number.</p>')
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
        



     }) 


    
  })
</script>