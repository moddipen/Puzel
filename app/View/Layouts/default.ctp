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
<html class="no-js" lang="en" itemscope itemtype="http://schema.org/Product">
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

		echo $this->Html->css('gumby');
		echo $this->Html->css('styles');
		echo $this->Html->css('component');
		
		echo $this->Html->script('modernizr-2.6.2.min.js');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

	?>
</head>
<body>

	<?php 
	if($Signup != 1)
	{
		echo $this->element("header");	
	}
	?>
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->fetch('content'); ?>
	<?php 
		if($Signup != 1)
		{
			echo $this->element('footer');
		}
	 ?>
</body>
</html>
