<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	
	//--------------------Fronend--------------------------//
	
	Router::connect('/', array('controller' => 'users', 'action' => 'index'));
	Router::connect('/pricing', array('controller' => 'subscriptions', 'action' => 'package'));
	Router::connect('/how-it-works', array('controller' => 'users', 'action' => 'about'));
	Router::connect('/puzel-for-business', array('controller' => 'users', 'action' => 'business'));
	Router::connect('/contact', array('controller' => 'users', 'action' => 'contact'));
	Router::connect('/thank-you', array('controller' => 'subscriptions', 'action' => 'thankyou'));



	
	//---------------------User Account----------------------------//
	
	Router::connect('/login', array('controller' => 'users', 'action' => 'login','user'=>true));
	Router::connect('/forgot-password', array('controller' => 'users', 'action' => 'forgetpassword','user'=>true));
	Router::connect('/logout', array('controller' => 'users', 'action' => 'logout','user'=>true));
  Router::connect('/puzel', array('controller' => 'puzzles', 'action' => 'index','user'=>true));
  Router::connect('/support', array('controller' => 'supports', 'action' => 'index','user'=>true));
	Router::connect('/create-ticket', array('controller' => 'supports', 'action' => 'add','user'=>true));
	Router::connect('/settings', array('controller' => 'users', 'action' => 'setting','user'=>true));
  //---------------------Business Account----------------------------//
	
  Router::connect('/puzel', array('controller' => 'puzzles', 'action' => 'index','business'=>true));
	Router::connect('/data-captured', array('controller' => 'visitors', 'action' => 'data','business'=>true));
	Router::connect('/billing', array('controller' => 'orders', 'action' => 'index','business'=>true));
	Router::connect('/support', array('controller' => 'supports', 'action' => 'index','business'=>true));
	Router::connect('/settings', array('controller' => 'users', 'action' => 'setting','business'=>true));
	Router::connect('/create-puzel', array('controller' => 'puzzles', 'action' => 'create','business'=>true));
  Router::connect('/export', array('controller' => 'visitors', 'action' => 'export','business'=>true));
  Router::connect('/create-ticket', array('controller' => 'supports', 'action' => 'add','business'=>true));
	

	//---------------------Admin Account----------------------------//
	
  Router::connect('/admin/puzel', array('controller' => 'puzzles', 'action' => 'index','admin'=>true)); 
  Router::connect('/admin/businesses', array('controller' => 'users', 'action' => 'business','admin'=>true)); 
  Router::connect('/admin/businesses/export', array('controller' => 'users', 'action' => 'export','admin'=>true)); 
  Router::connect('/admin/users', array('controller' => 'users', 'action' => 'index','admin'=>true)); 
  Router::connect('/admin/users/export', array('controller' => 'users', 'action' => 'userexport','admin'=>true)); 
  Router::connect('/admin/data-captured', array('controller' => 'users', 'action' => 'data','admin'=>true)); 
  Router::connect('/admin/data-captured', array('controller' => 'users', 'action' => 'data','admin'=>true)); 
  Router::connect('/admin/support', array('controller' => 'supports', 'action' => 'index','admin'=>true)); 
  Router::connect('/admin/create-ticket', array('controller' => 'supports', 'action' => 'add','admin'=>true));
  Router::connect('/admin/settings', array('controller' => 'users', 'action' => 'setting','admin'=>true));
 



/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
    // Router::connect(
           // "/subscriptions/:action/*", array('plugin' => 'braintree', 'controller'=>'subscriptions')
        // );

        // Router::connect(
           // "/subscriptions/", array('plugin' => 'braintree', 'controller'=>'subscriptions', 'action'=>'orders')
        // );

        // Router::connect(
           // "/paymentmethods/:action/*", array('plugin' => 'braintree', 'controller'=>'paymentmethods')
        // );




	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	Router::connect('/user', array('controller' => 'users', 'action' => 'login', 'user' => true));

     // Get current URl 
  $path = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
  
  // Make parition or url and use conditions
  $explode = explode('/',$path);
  

  // refrel hosting page 
  if(isset($explode[6]))
  {
        Router::connect(
            '/puzzle/:company_name/:name/:refrel', // E.g. /blog/3-CakePHP_Rocks
            array('controller' => 'visitors', 'action' => 'dynamic','v'=>true),
            array(
                // order matters since this will simply map ":id" to
                // $articleId in your action
                'pass' => array('company_name','name','refrel')
                
            )
        );
  }
  // normal hosting page 
  else
  {
     Router::connect(
            '/puzzle/:company_name/:name', // E.g. /blog/3-CakePHP_Rocks
            array('controller' => 'visitors', 'action' => 'dynamic','v'=>true),
            array(
                // order matters since this will simply map ":id" to
                // $articleId in your action
                'pass' => array('company_name','name')
                
            )
        );   
  }  


	

    Router::parseExtensions('csv');

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
