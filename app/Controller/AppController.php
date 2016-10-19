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
        //Security::setHash("md5");

    	    // Manage session 
            if($this->params['prefix'] == 'admin' && $this->Auth->user('usertype') != 2  && $this->params['login'] && $this->params['register'])
            {
                $this->Cookie->delete('remember_me_cookie');
                $this->Auth->logout();
                $this->Session->setFlash(__('<div class="alert alert-danger alert-dismissible"><p>Unable access this panel.</p></div>'));
                $this->redirect(array('controller'=>'users','action'=>'login','user'=>true));
            }
            elseif($this->params['prefix'] == 'business' && $this->Auth->user('usertype') != 1 &&  $this->params['login'] && $this->params['register'])
            {
                $this->Cookie->delete('remember_me_cookie');
                $this->Auth->logout();   
                $this->Session->setFlash(__('<div class="alert alert-danger alert-dismissible"><p>Unable access this panel.</p></div>'));
                $this->redirect(array('controller'=>'users','action'=>'login','user'=>true));
            }
            elseif($this->params['prefix'] == 'user' && $this->Auth->user('usertype') != 0 && $this->params['login'] && $this->params['register'])
            {
                $this->Cookie->delete('remember_me_cookie');
                $this->Auth->logout();   
                $this->Session->setFlash(__('<div class="alert alert-danger alert-dismissible"><p>Unable access this panel.</p></div>'));
                $this->redirect(array('controller'=>'users','action'=>'login','user'=>true));
            } 

            // prefix setting 
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
                // echo "<pre>";
                // print_R($this->params);exit;
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

      }

/**
      // Send email with template
*/
  
    public function sendemail($mail)
    {
        $json = json_encode(array(
        'TemplateId'=>$mail['templateid'],
        'TemplateModel'=>array(
            'name'=>$mail['name'],
             'action_url' => $mail['TemplateModel']['action_url'],
            'company'=>array(
                'name'=>$mail['TemplateModel']['company']['name']),
            'product_name'=>$mail['TemplateModel']['product_name'],
            'sender_name'=>"Puzzle Team"),
        'From' => $mail['from'],
        'To' => $mail['to'],
        'InlineCss'=>true,
        'ReplyTo' => $mail['reply_to']
        ));
         $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, 'http://api.postmarkapp.com/email/withTemplate');
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Content-Type: application/json',
                'X-Postmark-Server-Token: ' .Configure::read("POSTMARKSERVERTOKEN")
                ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = json_decode($response);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return json_encode($response);
    }

/**
    Host page email code
*/
    public function hostedemail($mail,$puzzle_id = null,$layout = null)
    {
        $json = json_encode(array(
        'TemplateId'=>$mail['templateid'],
        'TemplateModel'=>array(
            'name'=>$mail['name'],
             'action_url' => $mail['TemplateModel']['action_url'],
            'company'=>array(
                'name'=>$mail['TemplateModel']['company']['name']),
            'product_name'=>$mail['TemplateModel']['product_name'],
            'sender_name'=>"Puzzle Team"),
        'From' => $mail['from'],
        'To' => $mail['to'],
        'InlineCss'=>true,
        'ReplyTo' => $mail['reply_to']
        ));
         $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, 'http://api.postmarkapp.com/email/withTemplate');
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Content-Type: application/json',
                'X-Postmark-Server-Token: ' .Configure::read("POSTMARKSERVERTOKEN")
                ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = json_decode($response);
        if($puzzle_id != NULL && $layout != NULL){$response->Id = $puzzle_id;}
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        echo json_encode($response);
    }

    





}
