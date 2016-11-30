<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Puzzel');
//$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
  <head>
	<?php echo $this->Html->charset(); ?>
	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo  $title; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('dashboard/vendor/bootstrap/bootstrap.min');?>
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">	
	<?php //echo $this->Html->css('fonts/font-awesome.min.css');
		echo $this->Html->css('dashboard/vendor/animate/animate.min');
		echo $this->Html->css('dashboard/vendor/mmenu/jquery.mmenu.all.css');
		echo $this->Html->css('dashboard/vendor/videobackground/jquery.videobackground');
		echo $this->Html->css('dashboard/vendor/bootstrap-checkbox.css');
		echo $this->Html->css('dashboard/vendor/chosen/chosen.min.css');
		echo $this->Html->css('dashboard/vendor/datepicker/bootstrap-datepicker.css');
		echo $this->Html->css('dashboard/vendor/chosen/chosen-bootstrap.css');
		echo $this->Html->css('dashboard/vendor/bootstrap/bootstrap-dropdown-multilevel.css');	
		echo $this->Html->css('dashboard/minimal.css');	
		
		
		echo $this->Html->script('dashboard/jquery');	
		echo $this->Html->script('dashboard/vendor/bootstrap/bootstrap.min.js');	
		echo $this->Html->script('dashboard/vendor/bootstrap/bootstrap-dropdown-multilevel.js');	
		echo $this->Html->script('dashboard/vendor/mmenu/jquery.mmenu.min.js');	
		echo $this->Html->script('dashboard/vendor/sparkline/jquery.sparkline.min.js');	
		echo $this->Html->script('dashboard/vendor/nicescroll/jquery.nicescroll.min.js');	
		echo $this->Html->script('dashboard/vendor/animate-numbers/jquery.animateNumbers.js');	
		echo $this->Html->script('dashboard/vendor/chosen/chosen.jquery.min.js');	
		echo $this->Html->script('dashboard/vendor/datepicker/bootstrap-datepicker.js');	
		echo $this->Html->script('dashboard/minimal.min.js');	
		echo $this->Html->script('jquery.validate.min.js');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
        <!-- <meta property="og:url"           content="https://postmarkapp.com" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="Puzzle" />
        <meta property="og:description"   content="Detail" />
        <meta property="og:image"         content="https://postmarkapp.com" />
      -->
        <!-- Place this tag in your head or just before your close body tag. -->
		<script src="https://apis.google.com/js/platform.js" async defer></script>

</head>
<body class="bg-1">

    <!-- Preloader -->
    <?php if($Signup != 1) {?>
    	<div class="mask"><div id="loader"></div></div>
    	<?php } ?>
    <!--/Preloader -->

    <!-- Wrap all page content here -->
    <div id="wrap">
    	<div class="row">
    	<?php 
    	if ($this->params['prefix'] == 'admin')
    	{
    		if($Signup  == 0)
    		{
    			echo $this->element('admin/leftbar');	
    		}
    		
    	}
	    elseif($this->params['prefix'] == 'business')
	     {
	     	if($Signup  == 0)
    		{
	     		echo $this->element('business/leftbar');
	     	}	
	     }
	    else
    	{
    		if($Signup  == 0)
    		{
    			echo $this->element('user/leftbar');
    		}	
    	}
    	 ?>
		<?php echo $this->fetch('content'); ?>
		</div>
	</div>
	
</body>
</html>
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
      $('#flashMessage').delay(10000).fadeOut('slow');
      
    })
      

    ///////////////////////////////
   $(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
  </script>