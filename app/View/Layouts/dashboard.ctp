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
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo  $title; ?>
	</title>
	
    
    
    
    
    
	<?php
		//echo $this->Html->meta('icon');
		echo $this->Html->css('dashboard/vendor/bootstrap/bootstrap.min');?>
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<?php 
		echo $this->Html->css('dashboard/vendor/animate/animate.min');
		echo $this->Html->css('dashboard/vendor/mmenu/jquery.mmenu.all.css');
		echo $this->Html->css('dashboard/vendor/videobackground/jquery.videobackground');
		echo $this->Html->css('dashboard/vendor/bootstrap-checkbox.css');
		echo $this->Html->css('dashboard/vendor/datepicker/bootstrap-datepicker.css');
		echo $this->Html->css('dashboard/vendor/chosen/chosen-bootstrap.css');
		echo $this->Html->css('dashboard/vendor/bootstrap/bootstrap-dropdown-multilevel.css');	
		echo $this->Html->css('dashboard/minimal.css');	
		
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

	?>
</head>
<body class="bg-1">

    <!-- Preloader -->
    <div class="mask"><div id="loader"></div></div>
    <!--/Preloader -->

    <!-- Wrap all page content here -->
    <div id="wrap">

		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
	
	</div>
	
</body>
</html>
