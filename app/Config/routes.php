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
  Router::connect('/pricing/*', array('controller' => 'subscriptions', 'action' => 'package'));
  Router::connect('/subscriptions/failure', array('controller' => 'subscriptions', 'action' => 'failure'));
  Router::connect('/users/clearcache', array('controller' => 'users', 'action' => 'clearcache'));

  
  //---------------------User Account----------------------------//
  
  Router::connect('/login', array('controller' => 'users', 'action' => 'login','user'=>true));
  Router::connect('/forgot-password', array('controller' => 'users', 'action' => 'forgetpassword','user'=>true));
  Router::connect('/logout', array('controller' => 'users', 'action' => 'logout','user'=>true));
  Router::connect('/puzels', array('controller' => 'puzzles', 'action' => 'index','user'=>true));
 // Router::connect('/puzel', array('controller' => 'puzzles', 'action' => 'checkuser'));
  Router::connect('/supports', array('controller' => 'supports', 'action' => 'index','user'=>true));
  Router::connect('/create-tickets', array('controller' => 'supports', 'action' => 'add','user'=>true));
  Router::connect('/create-ticket', array('controller' => 'supports', 'action' => 'add','business'=>true));
  Router::connect('/settings', array('controller' => 'users', 'action' => 'setting','user'=>true));
  Router::connect('/sign-up/*', array('controller' => 'subscriptions', 'action' => 'plan','user'=>true));
  Router::connect('/date', array('controller' => 'puzzles', 'action' => 'datefilter','user'=>true));
  Router::connect('/datesupport', array('controller' => 'supports', 'action' => 'datefilter','user'=>true));
 




  //---------------------Business Account----------------------------//

  
  
  Router::connect('/puzel', array('controller' => 'puzzles', 'action' => 'index','business'=>true));  
  Router::connect('/data-captured', array('controller' => 'visitors', 'action' => 'data','business'=>true));
  Router::connect('/billing', array('controller' => 'orders', 'action' => 'index','business'=>true));
  Router::connect('/support', array('controller' => 'supports', 'action' => 'index','business'=>true));
  Router::connect('/setting', array('controller' => 'users', 'action' => 'setting','business'=>true));
  Router::connect('/create-puzel', array('controller' => 'puzzles', 'action' => 'create','business'=>true));
  Router::connect('/export', array('controller' => 'visitors', 'action' => 'export','business'=>true));
  Router::connect('/view/*', array('controller' => 'puzzles', 'action' => 'view','business'=>true));
  Router::connect('/preview/*', array('controller' => 'puzzles', 'action' => 'preview','business'=>true));
  Router::connect('/edit/*', array('controller' => 'puzzles', 'action' => 'edit','business'=>true));
  Router::connect('/receipt/*', array('controller' => 'orders', 'action' => 'receipt'));
  Router::connect('/ticket/*', array('controller' => 'supports', 'action' => 'conversation','business'=>true));
  Router::connect('/export/*', array('controller' => 'puzzles', 'action' => 'export','business'=>true));
  Router::connect('/cancel', array('controller' => 'users', 'action' => 'cancel','business'=>true));



  Router::connect('/business/puzzles/filter', array('controller' => 'puzzles', 'action' => 'filter','business'=>true));
  Router::connect('/business/puzzles/status', array('controller' => 'puzzles', 'action' => 'status','business'=>true));
  Router::connect('/business/visitors/datefilter', array('controller' => 'visitors', 'action' => 'datefilter','business'=>true));
  Router::connect('/business/visitors/emailFilter', array('controller' => 'visitors', 'action' => 'emailFilter','business'=>true));
  Router::connect('/business/supports/datefilter', array('controller' => 'supports', 'action' => 'datefilter','business'=>true));
  Router::connect('/business/puzzles/checkpieces', array('controller' => 'puzzles', 'action' => 'checkpieces'));
  Router::connect('/business/puzzles/template', array('controller' => 'puzzles', 'action' => 'template','business'=>true));
  Router::connect('/business/puzzles/terms', array('controller' => 'puzzles', 'action' => 'terms','business'=>true));
  Router::connect('/business/puzzles/price', array('controller' => 'puzzles', 'action' => 'price','business'=>true));
  Router::connect('/business/puzzles/send', array('controller' => 'puzzles', 'action' => 'send','business'=>true));
  Router::connect('/business/puzzles/pieces', array('controller' => 'puzzles', 'action' => 'pieces','business'=>true));
  Router::connect('/business/users/cancel', array('controller' => 'users', 'action' => 'cancel','business'=>true));
  Router::connect('/business/puzzles/template', array('controller' => 'puzzles', 'action' => 'template','business'=>true));

  //---------------------Admin Account----------------------------//
  
  Router::connect('/admin/puzel', array('controller' => 'puzzles', 'action' => 'index','admin'=>true)); 
  Router::connect('/admin/businesses', array('controller' => 'users', 'action' => 'business','admin'=>true)); 
  Router::connect('/admin/businesses/export', array('controller' => 'users', 'action' => 'export','admin'=>true)); 
  Router::connect('/admin/users', array('controller' => 'users', 'action' => 'index','admin'=>true)); 
  Router::connect('/admin/users/export', array('controller' => 'users', 'action' => 'userexport','admin'=>true)); 
  Router::connect('/admin/data-captured', array('controller' => 'users', 'action' => 'data','admin'=>true)); 
  //Router::connect('/admin/data-captured', array('controller' => 'users', 'action' => 'data','admin'=>true)); 
  Router::connect('/admin/support', array('controller' => 'supports', 'action' => 'index','admin'=>true)); 
  Router::connect('/admin/create-ticket', array('controller' => 'supports', 'action' => 'add','admin'=>true));
  Router::connect('/admin/settings', array('controller' => 'users', 'action' => 'setting','admin'=>true));
  Router::connect('/admin/preview/*', array('controller' => 'puzzles', 'action' => 'preview','admin'=>true));
  Router::connect('/admin/ticket/*', array('controller' => 'supports', 'action' => 'conversation','admin'=>true));
  Router::connect('/admin/data-captured/export', array('controller' => 'visitors', 'action' => 'export','admin'=>true));

  Router::connect('/process/*', array('controller' => 'visitors', 'action' => 'process'));
  Router::connect('/fetchimage/*', array('controller' => 'visitors', 'action' => 'fetchimage'));

  Router::connect('/admin/users/monthwisefiltre', array('controller' => 'users', 'action' => 'monthwisefiltre','admin'=>true));
  Router::connect('/admin/users/datefilter', array('controller' => 'users', 'action' => 'datefilter','admin'=>true));
  Router::connect('/admin/users/status', array('controller' => 'users', 'action' => 'status','admin'=>true));
  Router::connect('/admin/users/status', array('controller' => 'users', 'action' => 'status','admin'=>true)); 
  Router::connect('/admin/puzzles/monthwisefiltre', array('controller' => 'puzzles', 'action' => 'monthwisefiltre','admin'=>true));
  Router::connect('/admin/puzzles/status', array('controller' => 'puzzles', 'action' => 'status','admin'=>true));
  Router::connect('/admin/puzzles/datefilter', array('controller' => 'puzzles', 'action' => 'datefilter','admin'=>true));
  Router::connect('/admin/visitors/datefilter', array('controller' => 'visitors', 'action' => 'datefilter','admin'=>true));
  Router::connect('/admin/visitors/emailFilter', array('controller' => 'visitors', 'action' => 'emailFilter','admin'=>true));
  Router::connect('/admin/supports/datefilter', array('controller' => 'supports', 'action' => 'datefilter','admin'=>true));
  Router::connect('/admin/supports/emailfilter', array('controller' => 'supports', 'action' => 'emailfilter','admin'=>true));



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


  
  Router::connect('/process/*', array('controller' => 'visitors', 'action' => 'process'));
  Router::connect('/fetchimage/*', array('controller' => 'visitors', 'action' => 'fetchimage'));
  Router::connect('/snipestimage/*', array('controller' => 'visitors', 'action' => 'snipestimage'));


  Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
  Router::connect('/user', array('controller' => 'users', 'action' => 'login', 'user' => true));

  $path = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
  
  // Make parition or url and use conditions
  $explode = explode('/',$path);
  

  // refrel hosting page 
  // if(isset($explode[7]))
  // {
        Router::connect(
            '/:company_name/:name/:refrel', // E.g. /blog/3-CakePHP_Rocks
            array('controller' => 'visitors', 'action' => 'dynamic','v'=>true),
            array(
                // order matters since this will simply map ":id" to
                // $articleId in your action
                'pass' => array('company_name','name','refrel')
                
            )
        );
  // }
  // // normal hosting page 
  // else
  // {
     Router::connect(
            '/:company_name/:name', // E.g. /blog/3-CakePHP_Rocks
            array('controller' => 'visitors', 'action' => 'dynamic','v'=>true),
            array(
                // order matters since this will simply map ":id" to
                // $articleId in your action
                'pass' => array('company_name','name')
                
            )
        );   
 // }  



  

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
