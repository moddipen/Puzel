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
 public $uses = array('Puzzle','User','Image','Visitor','Support','Order','Plan','Subscription');
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
	  	//parent::beforeFilter();
	  	$signup = 0;
		$this->set("Signup",$signup);
	  	$this->Auth->allow(array('index','contact','user_register','user_login','about','business','user_forgetpassword','admin_login','user_reset'));
	 // Count of total puzzle 
	 	// Count of total puzzle 
	 	
	  	if($this->Auth->login())
	  	{
		  		$data = $this->Puzzle->find('count',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id'))));
			if(empty($data))
			{
				$data = 0 ;
			}
			$this->set('CountPuzzle',$data);

			$active = $this->Puzzle->find('count',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id'),'Puzzle.status'=>0)));
			if(empty($active))
			{
				$active = 0 ;
			}
			$this->set('CountActivePuzzle',$active);

			// Count total pieces
			$list = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id'))));
			// foreach ($list as $key => $value)
			// {
			// 	$visitor  = $this->Visitor->find('count',array('conditions'=>array('Visitor.puzzle_id'=>$value['Puzzle']['id'])));	
			// 	if($visitor != NULL)
			// 	{
			// 		$list[$key]['Visitor'] = $visitor;
			// 	}
			// 	else
			// 	{
			// 		$list[$key]['Visitor'] = 0;	
			// 	}

			// 	$peices  = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$value['Puzzle']['id'])));	
			// 	if($peices != NULL)
			// 	{
			// 		$list[$key]['Peices'] = $peices;
				
			// 	}
			// 	else
			// 	{
			// 		$list[$key]['Peices'] = 0;	
			// 	}
			// }
			// First loop   for peices count
			// foreach($list as $value)
			// 	{
			// 		$visitcount+= $value['Visitor'];
			// 	}

				// if(empty($list))
	//			{	
					$visitcount = 0;
	//			}	

			// count balance pieces  
				$order = $this->Order->find('first',array('conditions'=>array('Order.user_id'=>$this->Auth->user('id'))));	
				if(!empty($order))
				{
					$clas = $this->Subscription->find('first',array('conditions'=>array('Subscription.id'=>$order['Order']['subscription_id'])));	
					$pic = $clas['Subscription']['pieces'] ;
				}
				else
				{
					$pic = 0;
				}	
				
				$this->set('Visitor',$visitcount);
				$this->set('Balancepeices',$pic);
		  	}
	 	
			
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
		  if ($this->request->is('post'))
		  {
          	  
            if ($this->Auth->login())
            {
              	// if user click on remember me checkbox
              	if ($this->request->data['User']['remember_me'] == 1)
              	{
	                // remove "remember me checkbox"
	                unset($this->request->data['User']['remember_me']);

	                // hash the user's password
	                $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);

	                // write the cookie
	                $this->Cookie->write('remember_me_cookie', $this->Auth->user(), true, '2 weeks');
            	}
				
				if($this->Auth->user('usertype') == 2)
              	{
              		$this->Session->setFlash(__('Login successfully!!....', true), 'default', array('class' => 'alert alert-success'));
              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','admin'=>true));
              	}	
              	elseif($this->Auth->user('usertype') == 1)
              	{
              		$this->Session->setFlash(__('Login successfully!!....', true), 'default', array('class' => 'alert alert-success'));
              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','business'=>true));
              	}
              	else
              	{
              		$this->Session->setFlash(__('Login successfully!!....', true), 'default', array('class' => 'alert alert-success'));
              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','user'=>true));	
              	}	
                
            }
            $this->Session->setFlash(__('Invalid username or password, try again', true), 'default', array('class' => 'alert alert-danger'));
        }
       
        // Auto login 
        if (empty($this->data))
        {
			$cookie = $this->Cookie->read('remember_me_cookie');
			if (!is_null($cookie))
			{
				//  Clear auth message, just in case we use it.
				$this->Session->delete('Message.auth');
				if ($this->Auth->login($cookie['usertype'] == 2))
				{
					return $this->redirect(array('controller'=>'puzzles','action'=>'index','admin'=>true));
				}
				else if($this->Auth->login($cookie['usertype'] == 1))
				{
					return $this->redirect(array('controller'=>'puzzles','action'=>'index','business'=>true));	
				}
				else if($this->Auth->login($cookie['usertype'] == 0))
				{
					return $this->redirect(array('controller'=>'puzzles','action'=>'index'));	
				}	
				else
				{ 
					// Delete invalid Cookie
					$this->Cookie->delete('remember_me_cookie');
				}
			}		
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
					$this->Auth->login();
					$email = array(
              			"templateid"=>1007701,
              			"name"=>$this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
              			"TemplateModel"=> array(
						    "user_name"=> $this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
						    "product_name"=>"You have signup Successfully",
							"action_url"=>"Congratulation you have successfully sign up "),
						"InlineCss"=> true, 
              			"from"=> "support@puzel.co",
              			'to'=>$this->Auth->user('email'),
              			'reply_to'=>"support@puzel.co"
              			);	

					if($this->Auth->user('usertype') == 2)
	              	{
	              		$this->Session->setFlash(__('Signup Successfully!!....', true), 'default', array('class' => 'alert alert-success'));
	              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','admin'=>true));
	              	}	
	              	elseif($this->Auth->user('usertype') == 1)
	              	{
	              		if($this->sendemail($email))
	              		{	
		              		$this->Session->setFlash(__('Signup Successfully!!....', true), 'default', array('class' => 'alert alert-success'));
		              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','business'=>true));
	              		}
	              		else
	              		{
	              			$this->Session->setFlash(__('Email not sent !!....', true), 'default', array('class' => 'alert alert-danger'));
		              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','business'=>true));	
	              		}	
	              	}
	              	else
	              	{
	     	         	if($this->sendemail($email))
						{
							$this->Session->setFlash(__('Signup Successfully!!....', true), 'default', array('class' => 'alert alert-success'));
	              			return $this->redirect(array('controller'=>'puzzles','action'=>'index','user'=>true));		
						}
						else
						{
							$this->Session->setFlash(__('Email not sent !!....', true), 'default', array('class' => 'alert alert-danger'));
	              			return $this->redirect(array('controller'=>'puzzles','action'=>'index','user'=>true));			
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
	User forget password  page 
*/	
	public function user_forgetpassword()
	{
		$this->layout = 'dashboard';
		$signup = 1 ;
    	$this->set('Signup',$signup);
		$this->set("title","Forgot Password ");
		$this->User->recursive=-1;
		if(!empty($this->data))
		{
			$email=$this->data['User']['email'];
			$fu=$this->User->find('first',array('conditions'=>array('User.email'=>$email)));
			if($fu)
			{
				if($fu['User']['email'])
				{
					$key = Security::hash(String::uuid(),'sha512',true);
					$hash=sha1($fu['User']['email'].rand(0,100));
					$url = Router::url( array('controller'=>'users','action'=>'reset','user'=>true), true ).'/'.$key.'#'.$hash;
					$ms=$url;
					$ms=wordwrap($ms,1000);
					$fu['User']['tokenhash']=$key;
					$this->User->id=$fu['User']['id'];
					if($this->User->saveField('tokenhash',$fu['User']['tokenhash']))
					{
						$email = array(
              			"templateid"=>1007061,
              			"name"=>$fu['User']['firstname'].' '.$fu['User']['lastname'],
              			"TemplateModel"=> array(
						    "user_name"=> $fu['User']['firstname'].' '.$fu['User']['lastname'],
						    "company"=> array(
						      	"name"=> $fu['User']['company_name']),
						    "action_url"=>$ms,
						    "product_name"=>''),
						
						"InlineCss"=> true, 
              			"from"=> "support@puzel.co",
              			'to'=>$fu['User']['email'],
              			'subject'=>"Reset Your Puzzle Password",
              			'text_body'=>"Please click on below link to reset your password".$ms,
              			'reply_to'=>"support@puzel.co",
              			'html_body'=>"dsadasd" );
						

						if($this->sendemail($email))
						{
							$this->Session->setFlash(__('Please check your email ', true), 'default', array('class' => 'alert alert-success'));
							$this->redirect(array('controller'=>'users','action'=>'login'));
						} 
						else
						{
							$this->Session->setFlash('Problem during sending email','default',array('class'=>'alert alert-warning'));
						}

						//============EndEmail=============//
					}
					else{
						
						$this->Session->setFlash(__(' Error Generating Reset link !!....', true), 'default', array('class' => 'alert alert-danger'));
					}
				}
				else
				{
					
					$this->Session->setFlash(__(' This Account is not Active yet.Check Your mail to activate it !!....', true), 'default', array('class' => 'alert alert-danger'));
				}
			}
			else
			{
				
				$this->Session->setFlash(__(' Email does Not Exist !!....', true), 'default', array('class' => 'alert alert-danger'));
			}
			
		}
	}

/**
	Password reset code 
*/
public function user_reset($token=null)
	{
		$this->layout = 'dashboard';
		$signup = 1 ;
    	$this->set('Signup',$signup);
		$this->set("title","Reset Password ");
		$this->User->recursive=-1;
		if(!empty($token))
		{
			$this->set("token",$token);
			$u=$this->User->findBytokenhash($token);
			if($u)
				{
					$this->User->id=$u['User']['id'];
					if(!empty($this->data))
						{
							if($this->User->validates())
								{
									if($this->data['User']['newpassword'] == $this->data['User']['cnfrmpassword'])
									{
										$new_hash=sha1($u['User']['email'].rand(0,100));//created token
										$this->request->data['User']['tokenhash']=$new_hash;
										$this->request->data['User']['id'] = $u['User']['id'];
										$this->request->data['User']['password'] = $this->data['User']['newpassword'];
										if($this->User->save($this->request->data))
											{
												$this->Session->setFlash(__(' Your New Password Has Been Reset !!....', true), 'default', array('class' => 'alert alert-success'));
												$this->redirect(array('controller'=>'users','action'=>'login','user'=>true));
											}
									}
									else
									{
										$this->Session->setFlash(__('Password does not match .', true), 'default', array('class' => 'alert alert-danger'));	
									}	
									
								}
						}
					}
			else
				{
					$this->Session->setFlash('Token Corrupted,,Please Retry.the reset link work only for once.',array('class'=>'alert alert-warning'));
				}
		}
		else
		{
			$this->redirect('/');
		}
	}	

/**
	User Register page 
*/	
	public function user_logout()
	{
		 // clear the cookie (if it exists) when logging out
    	$this->Cookie->delete('remember_me_cookie');
		
		$this->Auth->logout();
		$this->Session->setFlash(__('<div class="alert alert-success alert-dismissible"><p>Logout successfully.</p></div>'));
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
			unset($this->User->validate['email']);
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


/**
	Business Setting page 
*/	
	public function business_setting()
	{
		$this->layout = 'dashboard';
		$this->set("title","Profile Page");
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$this->Auth->user('id'))));
		$this->set("User",$user);

		if(!empty($this->request->data))
		{
			unset($this->User->validate['email']);
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
					$this->Session->setFlash(__('Profile update successfully !!....', true), 'default', array('class' => 'alert alert-success'));		
				}
			}
			else
			{
				$this->Session->setFlash(__('Password does not match !!....', true), 'default', array('class' => 'alert alert-danger'));
			}	
			
		}
	}	

/**
	Cancel User account
*/
	public function business_cancel()
	{
		$this->autoRender = false;
		$id = $this->Auth->user('id');
		$array = array(
			'id'=>$id,
			'status'=>'1');
		// Deactive User account
		if($this->User->save($array))
		{
			$this->Session->write('Auth.User.status', 1);

			//Deactive Puzzle of this user
			if($this->Puzzle->updateAll(array('Puzzle.status'=>1),array('Puzzle.user_id'=>$id)))
			{
				$puzzle = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$id)));
				if(!empty($puzzle))
				{	
					// Deactive  number of all image block
					foreach($puzzle as $image)
					{
						$update = $this->Image->updateAll(array('Image.puzzle_active'=>1),array('Image.puzzle_id'=>$image['Puzzle']['id']));	
						
						if($update)
						{
							
							// Send email to user that your has been deactivate 
							$email = array(
							"templateid"=>1025061,
							"name"=>$this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
							"TemplateModel"=> array(
								"user_name"=> $this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
								"product_name"=>"Account cancel",
								"action_url"=>"Your account has been cancel , if you want to activate your account please contact to admin"),
							"InlineCss"=> true, 
							"from"=> "support@puzel.co",
							'to'=>$this->Auth->user('email'),
							'reply_to'=>"support@puzel.co"
							);	

							if($this->sendemail($email))
							{
								$this->Session->setFlash(__('Your account has been cancel', true), 'default', array('class' => 'alert alert-success'));		
								$this->redirect(array('controller'=>'puzzles','action'=>'index'));
							}

						}

					}
				}
				else
				{
					$this->Session->setFlash(__('Your account has been cancel', true), 'default', array('class' => 'alert alert-success'));		
					$this->redirect(array('controller'=>'puzzles','action'=>'index'));
				}
			}
		}

	}



	






}
