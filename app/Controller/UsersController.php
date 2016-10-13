<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
// App::import('Vendor', 'postmark', array('file' => 'postmark/Lib/Network/Email/PostmarkTransport.php'));
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
 public $helpers = array('Html', 'Form','Session');
 public $components = array('Session','RequestHandler');
 public $uses = array('User');
 var $name = 'Users';

/**
 * Displays a view
 *
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */

	 function beforeFilter()
	 {
	  	$signup = 0;
		$this->set("Signup",$signup);
	  	$this->Auth->allow(array('index','contact','user_register','user_login','about','business','user_forgetpassword','admin_login'));
	 }

	
	


/**
	Front index page 
*/	
	public function index()
	{
		$signup = 0;
		$this->set("Signup",$signup);
		$this->set("title","Home");

	}

/**
	Front about page 
*/	
	public function about()
	{
		$signup = 0;
		$this->set("Signup",$signup);
		$this->set("title","About");
	}

/**
	Front business page 
*/	
	public function business()
	{
		$signup = 0;
		$this->set("Signup",$signup);
		$this->set("title","Business");
	}

/**
	Front contact page 
*/	
	public function contact()
	{
		$signup = 0;
		$this->set("Signup",$signup);
		$this->set("title","Contact");
	}		


/**
	Front signup page 
*/	
	public function signup($type = Null)
	{
		$signup = 1;
		$this->set("Signup",$signup);
		$this->set("title","Register");
	}		

/**
	Business index page 
*/	
	public function business_index()
	{
		$this->layout = 'dashboard';
		$this->set("title","Index");
		
	}			

/**
	Business data page 
*/	
	public function business_data()
	{
		$this->layout = 'dashboard';
		$this->set("title","Data Captured");
	}				

/**
	Admin index page 
*/	
	public function admin_index()
	{
		$this->layout = 'dashboard';
		$this->set("title","Index");
		$this->set("Business",$this->User->find('all',array('conditions'=>array('User.usertype' =>1),'order'=>'User.id Desc')));
	}			

/**
	Admin Business page 
*/	
	public function admin_business()
	{
		$this->layout = 'dashboard';
		$this->set("title","Business");
		$this->set("Business",$this->User->find('all',array('conditions'=>array('User.usertype' =>1),'order'=>'User.id Desc')));
	}				

/**
	Admin data page 
*/	
	public function admin_data()
	{
		$this->layout = 'dashboard';
		$this->set("title","Data Captured");
	}				

/**
	User login  page 
*/	
	public function user_login()
	{
		$this->layout = 'dashboard';
		$signup = 1 ;
    	$this->set('Signup',$signup);
		$this->set("title","Login");
		  if ($this->request->is('post')) {
            
            if ($this->Auth->login())
            {
              	if($this->Auth->user('usertype') == 2)
              	{
              		$this->Session->setFlash(__('Login Successfully!!....', true), 'default', array('class' => 'alert alert-success'));
              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','admin'=>true));
              	}	
              	elseif($this->Auth->user('usertype') == 1)
              	{
              		$this->Session->setFlash(__('Login Successfully!!....', true), 'default', array('class' => 'alert alert-success'));
              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','business'=>true));
              	}
              	else
              	{
              		$this->Session->setFlash(__('Login Successfully!!....', true), 'default', array('class' => 'alert alert-success'));
              		return $this->redirect(array('controller'=>'puzzles','action'=>'index'));	
              	}	
                
            }
            $this->Session->setFlash(__('Invalid username or password, try again', true), 'default', array('class' => 'alert alert-danger'));
        }


	}					

/**
	User Register  page 
*/	
	public function user_register($type = Null)
	{
		$this->layout = 'dashboard';
		$signup = 2 ;
    	$this->set('Signup',$signup);
		$this->set("title","Register");
		$this->set('Type',$type);
		if(!empty($this->request->data))
		{
			if($this->request->data['User']['confirm_password'] == $this->request->data['User']['password'])
			{
				if($type == "business")
				{
					$Usertype = 1;
				}
				else
				{
					$Usertype = 0;
				}	
				$this->User->create();
				$this->request->data['User']['usertype'] = $Usertype ;
				if($this->User->save($this->request->data))
				{
					$this->Auth->login($this->request->data);
					if($this->Auth->user('User.usertype') == 2)
	              	{
	              		$this->Session->setFlash(__('Signup Successfully!!....', true), 'default', array('class' => 'alert alert-success'));
	              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','admin'=>true));
	              	}	
	              	elseif($this->Auth->user('User.usertype') == 1)
	              	{
	              		$this->Session->setFlash(__('Signup Successfully!!....', true), 'default', array('class' => 'alert alert-success'));
	              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','business'=>true));
	              	}
	              	else
	              	{
	              		// Create a message and send it
						$email = new CakeEmail();
						$email->config('smtp');
						$email->to($this->Auth->user('User.email'),$this->Auth->user('User.firstname').' '.$this->Auth->user('User.lastname'));
					    $email->subject('Subject');
					    $message = "You have signup Successfully";
					    
						if($email->send($message))
						{
							$this->Session->setFlash(__('Signup Successfully!!....', true), 'default', array('class' => 'alert alert-success'));
	              			return $this->redirect(array('controller'=>'puzzles','action'=>'index'));		
						}
						else
						{
							$this->Session->setFlash(__('Email not sent !!....', true), 'default', array('class' => 'alert alert-danger'));
	              			return $this->redirect(array('controller'=>'puzzles','action'=>'register'));			
						}		    
						
	              	}	

				}
			}	
			else
			{	
				$this->Session->setFlash(__('<div class="alert alert-danger alert-dismissible"><p>Password does not match</p></div>'));	
			}	
		}

		
	}					

/**
	User Register page 
*/	
	public function user_forgetpassword()
	{
		$this->layout = 'dashboard';
		$signup = 1 ;
    	$this->set('Signup',$signup);
		$this->set("title","Forgot Password ");
	}

/**
	User Register page 
*/	
	public function user_logout()
	{
		$this->Auth->logout();
		$this->Session->setFlash(__('<div class="alert alert-success alert-dismissible"><p>logout Successfully.</p></div>'));
		$this->redirect(array('action'=>'login','user'=>true));
	}	

/**
	Auth redirect admin login page 
*/	
	public function admin_login()
	{
		$this->redirect(array('controller'=>'users','action'=>'login','user'=>true));
	}	

/**
	Auth redirect business login page 
*/	
	public function business_login()
	{
		$this->redirect(array('controller'=>'users','action'=>'login','user'=>true));
	}		

/**
	User Setting page 
*/	
	public function user_setting()
	{
		$this->layout = 'dashboard';
		$this->set("title","Profile Page");
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$this->Auth->user('id'))));
		$this->set("User",$user);

		if(!empty($this->request->data))
		{
			if($this->request->data['User']['newpassword'] == $this->request->data['User']['newpasswordrepeat'])
			{
				if($this->request->data['User']['newpassword'] == '')
				{

				}
				else
				{
					$this->request->data['User']['password'] = $this->request->data['User']['newpassword'] ; 	
				}	

				
				$this->request->data['User']['id'] = $this->Auth->user('id');	 
				if($this->User->save($this->request->data))
				{
					$this->Session->setFlash(__('profile update successfully !!....', true), 'default', array('class' => 'alert alert-success'));		
				}
			}
			else
			{
				$this->Session->setFlash(__('Password does not match !!....', true), 'default', array('class' => 'alert alert-danger'));
			}	
			
		}



	}			








}
