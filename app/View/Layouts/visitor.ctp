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

$cakeDescription = __d('cake_dev', 'Puzel');
//$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en" itemscope itemtype="http://schema.org/Product">
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
		echo $this->Html->css('dashboard/vendor/bootstrap/bootstrap.min');
		echo $this->Html->css('visitor/gumby.css');
		echo $this->Html->css('visitor/styles.css');
		echo $this->Html->css('visitor/add-oct-13-2016.css');
		echo $this->Html->css('visitor/addons.css');
		//echo $this->Html->css('dashboard/minimal.css');	
		echo $this->fetch('meta');
		echo $this->fetch('css');
		
		echo $this->Html->script('jquery.min.js');
		echo $this->Html->script('visitor/jquery-1.9.1.min.js');
		echo $this->Html->script('dashboard/vendor/bootstrap/bootstrap.min.js');	
		echo $this->Html->script('visitor/main.js');
		echo $this->Html->script('visitor/plugins.js');
		echo $this->Html->script('visitor/cbpScroller.js');
		echo $this->Html->script('visitor/classie.js');
		echo $this->Html->script('visitor/jquery.scrollto.js');
		echo $this->Html->script('jquery.validate.min.js');
		//echo $this->Html->script('dashboard/minimal.min.js');
		echo $this->fetch('script');
	?>
    

</head>
<body class="bg-1">
	<?php echo $this->fetch('content'); ?>
</body>
</html>
