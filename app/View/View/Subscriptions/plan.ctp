
<div id="container" class="container inner-popup-page">
<div class="row">
  
        <div class="twelve columns text-center fix-max-width">
      <a href="index.php"><img src="<?php echo $this->webroot;?>img/logo.png"></a>
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
<?php   echo $this->Form->create('Subscription', array('action' => 'plan'));?>
<!-- <form action="<?php echo $Type;?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" novalidate> -->
    <div id="mc_embed_signup_scroll">
  <h2>Sign up for Puzel</h2>
<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
<div class="mc-field-group">
  <label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
</label>
  <input type="email" value="" name="data[Subscription][email]" class="required email" id="mce-EMAIL">
</div>
<div class="mc-field-group">
  <label for="mce-FNAME">First Name </label>
  <input type="text" value="" name="data[Subscription][firstname]" class="" id="mce-FNAME">
</div>
<div class="mc-field-group">
  <label for="mce-LNAME">Last Name </label>
  <input type="text" value="" name="data[Subscription][lastname]" class="" id="mce-LNAME">
</div>
  <div id="mce-responses" class="clear">
    <div class="response" id="mce-error-response" style="display:none"></div>
    <div class="response" id="mce-success-response" style="display:none"></div>
  </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_07f1846d778e631822b8f85cf_e5b207e707" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </div>
</form>

</div>
<!-- <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script> -->