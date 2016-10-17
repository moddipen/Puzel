<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller 
{
	public $helpers = array('Html', 'Form','Session');
	public $components = array('Session','RequestHandler','Cookie','Auth' => array(
        'authenticate' => array(
            'Form' => array(
                'fields' => array('username' => 'email')
            )
        )
    ));



	 function beforeFilter()
	 {
        $this->Auth->authenticate = array('Form');
        $this->Auth->autoRedirect = false;
        Security::setHash("md5");

    	    if ($this->params['prefix'] == 'admin')
        	{
        		$signup = 0 ;
        		$this->set('Signup',$signup);
        		$this->layout = "dashboard";
        	}
    	    elseif ($this->params['prefix'] == 'business')
    	     {
    	     	$signup = 0 ;
        		$this->set('Signup',$signup);
    	     	$this->layout = "dashboard";
    	     }
    	    elseif ($this->params['prefix'] == 'user')
    	     {
    	     	$signup = 0 ;
        		$this->set('Signup',$signup);
    	     	$this->layout = "dashboard";
    	     }
            elseif ($this->params['prefix'] == 'v')
             {
                $this->layout = "visitor";
             }  
    	    else
        	{
        		$signup = 0 ;
        		$this->set('Signup',$signup);
        		$this->layout = "default";
        	}

        // cookie code
        // set cookie options
        $this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
        $this->Cookie->httpOnly = true;

        if (!$this->Auth->loggedIn() && $this->Cookie->read('remember_me_cookie'))
        {
            $cookie = $this->Cookie->read('remember_me_cookie');

            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.username' => $cookie['username'],
                    'User.password' => $cookie['password']
                )
            ));

            if ($user && !$this->Auth->login($user['User'])) {
                $this->redirect('/users/logout'); // destroy session & cookie
            }
        }

        // // Manage session 

        // if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin')
        // {
        //     AuthComponent::$sessionKey = 'Auth.Admin';
        //     $this->Auth->loginAction = array('plugin' => false, 'controller' => 'users', 'action' => 'login','user'=>true);
        //     $this->Auth->logoutRedirect = array('plugin' => false, 'controller' => 'admin', 'action' => 'dashboard');
        // } 
        // else
        // {
        //     AuthComponent::$sessionKey = 'Auth.Front';
        //     $this->Auth->loginAction = array('plugin' => false, 'controller' => 'users', 'action' => 'login',$this->request->prefix=>false);
        //     $this->Auth->logoutRedirect = array('plugin' => false, 'controller' => 'users', 'action' => 'dashboard');
        // }
    }


    // send email 
    public function sendemail($mail)
    {
        $json = json_encode(array(
        'From' => $mail['from'],
        'To' => $mail['to'],
        'Subject' => $mail['subject'],
        'HtmlBody' => $mail['html_body'],
        'TextBody' =>$mail['text_body'],
        'ReplyTo' => $mail['reply_to'],
        ));
        $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, 'http://api.postmarkapp.com/email');
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Content-Type: application/json',
                'X-Postmark-Server-Token: ' .Configure::read("POSTMARKSERVERTOKEN")
                ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $response = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $http_code === 200;
    }




}
