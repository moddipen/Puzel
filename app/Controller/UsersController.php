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
App::import('Vendor', 'Csv', array('file' => 'Csv.php'));
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
 public $helpers = array('Html', 'Form','Session','Csv');
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
	  	$statistics = $this->get_statistics();
		
		$this->set("statistics",$statistics);
	  	$signup = 0;
		$this->set("Signup",$signup);
	  	$this->Auth->allow(array('index','contact','user_register','user_login','about','business','user_forgetpassword','admin_login','user_reset','clearcache','user_confirm'));
	  	$this->set('main_action','User');
	 	// Count of total puzzle 
	 	// Count of total puzzle 
	 	
	  	if($this->params['prefix'] == 'business')
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
			
			$this->set('Balancepeices',$pic);
		}	
		// Admin header data
		if ($this->params['prefix'] == 'admin')
		{
			// Business count 
			$list_ofbusiness = $this->User->find('count',array('conditions'=>array('User.usertype'=>1)));
			$this->set('Businesscount', $list_ofbusiness);

			// user count 
			$user_ofcount = $this->User->find('count',array('conditions'=>array('User.usertype'=>0)));
			$this->set('Usercount', $user_ofcount); 

			// Puzzle count 
			$puzle = $this->Puzzle->find('count');
			$this->set('Puzzle', $puzle); 	        			       			

			// Active puzzle count 

			$active_puzle = $this->Puzzle->find('count',array('conditions'=>array('Puzzle.status'=>0)));
			$this->set('ActivePuzzle', $active_puzle); 	        			       				

		}

		if($this->params['prefix'] == 'user')
		{
		    // Support count 
            $support = $this->Support->find('count',array('conditions'=>array(array('OR'=>array('Support.sender_id'=>$this->Auth->user('id'),'Support.receiver_id'=>$this->Auth->user('id')))),'group' => array('Support.subject HAVING  1')));
            if(!empty($support))
            {
                $support = $support;
            }
            else
            {
                $support = 0 ;
            }    
            $this->set('Support',$support);

            // Participate in puzzle 

            $visitor = $this->Visitor->find('count',array('conditions'=>array('Visitor.user_id'=>$this->Auth->user('id'))));
            if(!empty($visitor))
            {
                $visitor = $visitor ;
            }
            else
            {
                $visitor = 0;
            }       

            $this->set('Visitor',$visitor);    

            // Check participate puzzle is active 
            $active_puzzle = $this->Visitor->find('count',array('conditions'=>array('Visitor.user_id'=>$this->Auth->user('id'),'Puzzle.status'=>0)));
            if(!empty($active_puzzle))
            {
                $active_puzzle = $active_puzzle ;
            }
            else
            {
                $active_puzzle = 0;
            }       

            $this->set('Activepuzzle',$active_puzzle);    
		}	
	}


public function get_statistics()
	  {
		 
		  	$data = $this->Puzzle->find('count',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id'))));
			if(empty($data))
			{
				$data = 0 ;
			}
			$statistics['CountPuzzle'] = $data; 
			

			$active = $this->Puzzle->find('count',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id'),'Puzzle.status'=>0)));
			if(empty($active))
			{
				$active = 0 ;
			}
		
			$statistics['CountActivePuzzle'] = $active; 
			// Count total pieces
			$list = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id'))));
			
			$visitcount = 0;
	
			// count balance pieces  
				$pic = $this->UserSubscription->find("first",array("conditions"=>array("UserSubscription.user_id"=>$this->Auth->user('id'),"UserSubscription.status"=>0)));
				if(empty($pic)){$pic['UserSubscription']['used_pieces'] = 0;}
				$statistics['Visitor'] = $visitcount; 
				$statistics['Balancepeices'] = $pic['UserSubscription']['used_pieces']; 
				if($statistics['Balancepeices'] < 0){$statistics['Balancepeices'] = 0;}
				
				return $statistics;
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
		$this->set('sub_action','index');
		$this->layout = 'dashboard';
		$this->set("title","Index");
		$add = $this->User->find('all',array('conditions'=>array('User.usertype' =>0),'order'=>'User.id Desc')) ;

		foreach($add as $key => $value)
		{
			$add[$key]['Visitor'] = $this->Visitor->find('count',array('conditions'=>array('Visitor.user_id'=>$value['User']['id'])));	
			$add[$key]['Refrel'] = $this->Visitor->find('count',array('conditions'=>array('Visitor.refrel_id'=>$value['User']['id'],'Visitor.is_refrel'=>1)));	
		}
		$this->set("User",$add);
	}			

/**
	Admin Business page 
*/	
	public function admin_business()
	{
		$this->set('sub_action','business');
		$this->layout = 'dashboard';
		$this->set("title","Business");
		$this->User->recursive = 2;
		$business = $this->User->find('all',array('conditions'=>array('User.usertype' =>1),'order'=>'User.id Desc'));
		$this->set("Business", $business);				
	}				

/**
	Admin data page 
*/	
	public function admin_data()
	{
		$this->set('sub_action','data');
		$this->layout = 'dashboard';
		$this->set("title","Data Captured");
		// Get Puzzle list 
		if(isset($id))
		{
			$list = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$id)));				
			$this->set('List',$list);
		}	
		else
		{
			$puzzle_list = $this->Puzzle->find('all');//,array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id'))));		
			$this->set('Data',$puzzle_list);
			
			//debug($puzzle_list);exit;
			$email_list = $this->Puzzle->Visitor->find('all', array(
                
                'fields' => array('Visitor.email'),
                'group' => array('Visitor.email HAVING  1')));
			$this->set('ResultEmail',$email_list);
		}
	}				

/**
	User login  page 
*/	
	public function user_login()
	{
		$this->layout = 'insidebox';
		$signup = 1 ;
    	$this->set('Signup',$signup);
		$this->set("title","Login");
		  if ($this->request->is('post'))
		  {
          	  
            if ($this->Auth->login())
            {
              	// if user click on remember me checkbox
             //  	if ($this->request->data['User']['remember_me'] == 1)
             //  	{
	            //     // remove "remember me checkbox"
	            //     unset($this->request->data['User']['remember_me']);

	            //     // hash the user's password
	            //     $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);

	            //     // write the cookie
	            //     $this->Cookie->write('remember_me_cookie', $this->Auth->user(), true, '2 weeks');
            	// }

				if($this->Auth->user('usertype') == 2)
              	{
					$this->Session->setFlash(__('Login successfully!!....', true), 'default');
              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','admin'=>true));
              		
              	}	
              	elseif($this->Auth->user('usertype') == 1)
              	{
              		
              		$this->Session->setFlash(__('Login successfully!!....', true), 'default');
              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','business'=>true));
              		
              	}
              	else
              	{
              		$this->Session->setFlash(__('Login successfully!!....', true), 'default');
              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','user'=>true));	
              		
              	}	
                
            }
            $this->Session->setFlash(__('Looks like you entered an incorrect username or password', true), 'default');
        }
       
        // Auto login 
  //       if (empty($this->data))
  //       {
		// 	$cookie = $this->Cookie->read('remember_me_cookie');
		// 	if (!is_null($cookie))
		// 	{
		// 		//  Clear auth message, just in case we use it.
		// 		$this->Session->delete('Message.auth');
		// 		if ($this->Auth->login($cookie['usertype'] == 2))
		// 		{
		// 			return $this->redirect(array('controller'=>'puzzles','action'=>'index','admin'=>true));
		// 		}
		// 		else if($this->Auth->login($cookie['usertype'] == 1))
		// 		{
		// 			return $this->redirect(array('controller'=>'puzzles','action'=>'index','business'=>true));	
		// 		}
		// 		else if($this->Auth->login($cookie['usertype'] == 0))
		// 		{
		// 			return $this->redirect(array('controller'=>'puzzles','action'=>'index'));	
		// 		}	
		// 		else
		// 		{ 
		// 			// Delete invalid Cookie
		// 			$this->Cookie->delete('remember_me_cookie');
		// 		}
		// 	}		
		// } 


	}					

/**
	User Register  page 
*/	
	public function user_register($type = Null)
	{
		$this->layout = 'insidebox';
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
	              		$this->Session->setFlash(__('Signup Successfully!!....', true), 'default');
	              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','admin'=>true));
	              	}	
	              	elseif($this->Auth->user('usertype') == 1)
	              	{
	              		if($this->sendemail($email))
	              		{	
		              		$this->Session->setFlash(__('Signup Successfully!!....', true), 'default');
		              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','business'=>true));
	              		}
	              		else
	              		{
	              			$this->Session->setFlash(__('Email not sent !!....', true), 'default');
		              		return $this->redirect(array('controller'=>'puzzles','action'=>'index','business'=>true));	
	              		}	
	              	}
	              	else
	              	{
	     	         	if($this->sendemail($email))
						{
							$this->Session->setFlash(__('Signup Successfully!!....', true), 'default');
	              			return $this->redirect(array('controller'=>'puzzles','action'=>'index','user'=>true));		
						}
						else
						{
							$this->Session->setFlash(__('Email not sent !!....', true), 'default');
	              			return $this->redirect(array('controller'=>'puzzles','action'=>'index','user'=>true));			
						}		    
						
	              	}	

				}
			}	
			else
			{	
				$this->Session->setFlash(__('<div><p>Password does not match</p></div>'));	
			}	
		}

		
	}					

/**
	User forget password  page 
*/	
	public function user_forgetpassword()
	{
		$this->layout = 'insidebox';
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
							$this->Session->setFlash(__('Please check your email ', true), 'default');
							$this->redirect(array('controller'=>'users','action'=>'login'));
						} 
						else
						{
							$this->Session->setFlash('Problem during sending email','default');
						}

						//============EndEmail=============//
					}
					else{
						
						$this->Session->setFlash(__(' Error Generating Reset link !!....', true), 'default');
					}
				}
				else
				{
					
					$this->Session->setFlash(__(' This Account is not Active yet.Check Your mail to activate it !!....', true), 'default');
				}
			}
			else
			{
				
				$this->Session->setFlash(__(' We do not have an account with this email address, you can sign up now.', true), 'default');
			}
			
		}
	}

/**
	Password reset code 
*/
public function user_reset($token=null)
	{
		$this->layout = 'insidebox';
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
												$this->Session->setFlash(__(' Your New Password Has Been Reset !!....', true), 'default');
												$this->redirect(array('controller'=>'users','action'=>'login','user'=>true));
											}
									}
									else
									{
										$this->Session->setFlash(__('Password does not match .', true), 'default');	
									}	
									
								}
						}
					}
			else
				{
					$this->Session->setFlash('Token Corrupted,,Please Retry.the reset link work only for once.');
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
    	//$this->Cookie->delete('remember_me_cookie');
		
		$this->Auth->logout();
		$this->Session->setFlash(__('<div><p>Logout successfully.</p></div>'));
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
		$this->set('sub_action','setting');
		$this->layout = 'dashboard';
		$this->set("title","Profile Page");
		
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
					$this->Session->setFlash(__('profile update successfully !!....', true), 'default');		
				}
			}
			else
			{
				$this->Session->setFlash(__('Password does not match !!....', true), 'default');
			}	
			
		}
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$this->Auth->user('id'))));
		$this->set("User",$user);
	}			


/**
	Business Setting page 
*/	
	public function business_setting()
	{
		$this->set('sub_action','setting');
		$this->layout = 'dashboard';
		$this->set("title","Profile Page");
		
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
					$this->Session->setFlash(__('Profile update successfully !!....', true), 'default');		
				}
			}
			else
			{
				$this->Session->setFlash(__('Password does not match !!....', true), 'default');
			}	
			
		}
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$this->Auth->user('id'))));
		$this->set("User",$user);

	}	

/**
	Cancel User account
*/
	public function business_cancel()
	{
		$this->autoRender = false;
		$id = $this->Auth->user('id');
		$get_last_order = $this->Order->find('first',array('conditions'=>array('Order.user_id'=>$id),'order'=>'Order.id Desc','limit'=>1));	

		$array = array(
			'id'=>$id,
			'status'=>'1');
		// Deactive User account
		if($this->User->save($array))
		{
			$this->Session->write('Auth.User.status', 1);

			// Cancel subscription package from brain tree 
			// if($get_last_order['Order']['subscriptions_id'] != "")
			// {
			// 	Braintree_Configuration::environment('sandbox');
			// 	Braintree_Configuration::merchantId('dvgmgzszxf2qgmfh');
			// 	Braintree_Configuration::publicKey('2yhywhtr9583jhmh');
			// 	Braintree_Configuration::privateKey('2bcc2668e0766ce64a3d9f975d953f78');	
			// 	Braintree_Subscription::cancel($get_last_order['Order']['subscriptions_id']);
			// }

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
								"product_name"=>"Account Cancelled",
								'company'=>array(
                					'name'=>''),
								"action_url"=>"Your account has been cancelled. Please get in touch with our support team for further instructions."),
							"InlineCss"=> true, 
							"from"=> "support@puzel.co",
							'to'=>$this->Auth->user('email'),
							'reply_to'=>"support@puzel.co"
							);	

							if($this->sendemail($email))
							{
								$this->Session->setFlash(__('Your account has been cancelled', true), 'default');		
								$this->redirect(array('controller'=>'puzzles','action'=>'index'));
							}

						}

					}
				}
				else
				{
					
					$email = array(
						"templateid"=>1025061,
						"name"=>$this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
						"TemplateModel"=> array(
							"user_name"=> $this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
							"product_name"=>"Account Cancelled",
							'company'=>array(
            					'name'=>''),
							"action_url"=>"Your account has been cancelled. Please get in touch with our support team for further instructions."),
						"InlineCss"=> true, 
						"from"=> "support@puzel.co",
						'to'=>$this->Auth->user('email'),
						'reply_to'=>"support@puzel.co"
						);	

						if($this->sendemail($email))
						{
							$this->Session->setFlash(__('Your account has been cancelled', true), 'default');		
							$this->redirect(array('controller'=>'puzzles','action'=>'index'));
						}
				}
			}
		}

	}

/**
	Cancel Business account admin
*/
	public function admin_deactive($id= null)
	{
		$this->autoRender = false;
		
		$array = array(
			'id'=>$id,
			'status'=>'1');
		// Deactive Business account
		if($this->User->save($array))
		{
			$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
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
							"name"=>$user['User']['firstname'].' '.$user['User']['lastname'],
							"TemplateModel"=> array(
								"user_name"=> $user['User']['firstname'].' '.$user['User']['lastname'],
								"product_name"=>"Account cancel by admin",
								'company'=>array(
                				'name'=>''),	
								"action_url"=>"Your account has been cancel by administrative department, if you want to activate your account please contact to admin"),
							"InlineCss"=> true, 
							"from"=> "support@puzel.co",
							'to'=>$user['User']['email'],
							'reply_to'=>"support@puzel.co"
							);	

							if($this->sendemail($email))
							{
								$this->Session->setFlash(__('User account has been deactivated ', true), 'default');		
								$this->redirect(array('controller'=>'users','action'=>'business','admin' => true));
							}

						}

					}
				}
				// if user can't create any puzzle then also send email  
				else
				{
					$email = array(
						"templateid"=>1025061,
						"name"=>$user['User']['firstname'].' '.$user['User']['lastname'],
						"TemplateModel"=> array(
							"user_name"=> $user['User']['firstname'].' '.$user['User']['lastname'],
							"product_name"=>"Account cancel by admin",
							'company'=>array(
                			'name'=>''),
							"action_url"=>"Your account has been cancel by administrative department, if you want to activate your account please contact to admin"),
						"InlineCss"=> true, 
						"from"=> "support@puzel.co",
						'to'=>$user['User']['email'],
						'reply_to'=>"support@puzel.co"
						);	

						if($this->sendemail($email))
						{
							$this->Session->setFlash(__('User account has been deactivated ', true), 'default');		
							$this->redirect(array('controller'=>'users','action'=>'business','admin' => true));
						}

				}
			}
		}

	}	

/**
	Active Business account admin
*/
	public function admin_active($id= null)
	{
		$this->autoRender = false;
		
		$array = array(
			'id'=>$id,
			'status'=>'0');
		// Deactive Business account
		if($this->User->save($array))
		{
			$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
			//Deactive Puzzle of this user
			if($this->Puzzle->updateAll(array('Puzzle.status'=>0),array('Puzzle.user_id'=>$id)))
			{
				$puzzle = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$id)));
				if(!empty($puzzle))
				{	
					// Deactive  number of all image block
					foreach($puzzle as $image)
					{
						$update = $this->Image->updateAll(array('Image.puzzle_active'=>0),array('Image.puzzle_id'=>$image['Puzzle']['id']));	
						
						if($update)
						{
							
							// Send email to user that your has been deactivate 
							$email = array(
							"templateid"=>1059661,
							"name"=>$user['User']['firstname'].' '.$user['User']['lastname'],
							"TemplateModel"=> array(
								"user_name"=> $user['User']['firstname'].' '.$user['User']['lastname'],
								"product_name"=>"Account reactivate by administrative department",
								'company'=>array(
                				'name'=>''),
								"action_url"=>"Your account has been reactivate by administrative department, please access your acount with previous functionality"),
							"InlineCss"=> true, 
							"from"=> "support@puzel.co",
							'to'=>$user['User']['email'],
							'reply_to'=>"support@puzel.co"
							);	

							$this->sendemail($email);
						}

					}
				}
				// if user can't create any puzzle then also send email  
				else
				{
					$email = array(
						"templateid"=>1059661,
						"name"=>$user['User']['firstname'].' '.$user['User']['lastname'],
						"TemplateModel"=> array(
							"user_name"=> $user['User']['firstname'].' '.$user['User']['lastname'],
							"product_name"=>"Account reactivate by administrative department",
							'company'=>array(
                			'name'=>''),
							"action_url"=>"Your account has been reactivate by administrative department, please access your acount with previous functionality"),
						"InlineCss"=> true, 
						"from"=> "support@puzel.co",
						'to'=>$user['User']['email'],
						'reply_to'=>"support@puzel.co"
						);	

						$this->sendemail($email);
				}
			}
		}

	}	

/**
	Suspend User account admin
*/
	public function admin_userdeactive($id= null)
	{
		$this->autoRender = false;
		
		$array = array(
			'id'=>$id,
			'status'=>'1');
		// Deactive User account
		if($this->User->save($array))
		{
			$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
			// Send email to user that your has been deactivate 
			$email = array(
			"templateid"=>1025061,
			"name"=>$user['User']['firstname'].' '.$user['User']['lastname'],
			"TemplateModel"=> array(
				"user_name"=> $user['User']['firstname'].' '.$user['User']['lastname'],
				"product_name"=>"Account suspended by admin",
				'company'=>array(
                'name'=>''),
				"action_url"=>"Your account has been suspended by administrative department, if you want to activate your account please contact to admin"),
			"InlineCss"=> true, 
			"from"=> "support@puzel.co",
			'to'=>$user['User']['email'],
			'reply_to'=>"support@puzel.co"
			);	
			$this->sendemail($email);
		}

	}
	
/**
	Active User account admin
*/
	public function admin_useractive($id= null)
	{
		$this->autoRender = false;
		
		$array = array(
			'id'=>$id,
			'status'=>'0');
		// Deactive User account
		if($this->User->save($array))
		{
			$user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		
			// Send email to user that your has been deactivate 
			$email = array(
			"templateid"=>1059661,
			"name"=>$user['User']['firstname'].' '.$user['User']['lastname'],
			"TemplateModel"=> array(
				"user_name"=> $user['User']['firstname'].' '.$user['User']['lastname'],
				"product_name"=>"Account reactivate by administrative department",
				'company'=>array(
                'name'=>''),
				"action_url"=>"Your account has been reactivate by administrative department, please access your acount with previous functionality"),
			"InlineCss"=> true, 
			"from"=> "support@puzel.co",
			'to'=>$user['User']['email'],
			'reply_to'=>"support@puzel.co"
			);	

			$this->sendemail($email);
		}

	}
	
/**
 	Ajax active - inactive filter in admin panel
 */
	public function admin_status()
	{
		if(!empty($this->request->data))
		{
			$add = $this->User->find('all',array('conditions'=>array('User.usertype' =>0 ,'User.status'=>$this->request->data['status']),'order'=>'User.id Desc')) ;
			foreach($add as $key => $value)
			{
				$add[$key]['Visitor'] = $this->Visitor->find('count',array('conditions'=>array('Visitor.email'=>$value['User']['email'])));	
				$add[$key]['Refrel'] = $this->Visitor->find('count',array('conditions'=>array('Visitor.refrel_id'=>$value['User']['id'],'Visitor.is_refrel'=>1)));	
			}
			$this->set("User",$add);			
		}
	}

/**
	Admin Business calender ajax filter 
*/	
	public function admin_datefilter()
	{
		if($this->request->data)
		{
			$this->User->recursive = 2;
			if($this->request->data['flag'] == "User")
			{
				$list = $this->User->find('all',array('conditions'=>array('AND'=>array(array('DATE(User.created) >='=>$this->request->data['startdate'],'DATE(User.created) <='=>$this->request->data['enddate'])), 'User.usertype' =>$this->request->data['usertype']),'order'=>'User.id Desc'));
				foreach($list as $key => $value)
				{
					$list[$key]['Visitor'] = $this->Visitor->find('count',array('conditions'=>array('Visitor.email'=>$value['User']['email'])));
					$list[$key]['Refrel'] = $this->Visitor->find('count',array('conditions'=>array('Visitor.refrel_id'=>$value['User']['id'],'Visitor.is_refrel'=>1)));		
				}
			}
			else
			{
				$list = $this->User->find('all',array('conditions'=>array('AND'=>array(array('DATE(User.created) >='=>$this->request->data['startdate'],'DATE(User.created) <='=>$this->request->data['enddate'])), 'User.usertype' =>$this->request->data['usertype']),'order'=>'User.id Desc'));
			}	
			$this->set("Flag",$this->request->data['flag']);
			$this->set("Business", $list);					
		}	
	}

/**
	Business CSV download from admin side 
*/	
	public function admin_export($startdate = null , $enddate = null)
	{
	  

	if($startdate && $enddate)
	{
		$data =  $this->User->find('all',array('conditions'=>array('AND'=>array(array('DATE(User.created) >='=>$startdate,'DATE(User.created) <='=>$enddate)),'User.usertype'=>1),'order'=>'User.firstname Asc','fields'=>array('User.firstname','User.lastname','User.email','User.website','User.usertype','User.company_name','User.tokenhash','UserSubscription.used_pieces','UserSubscription.subscription_id','UserSubscription.id')));		
	}	
	else
	{
		$data =  $this->User->find('all',array('conditions'=>array('User.usertype'=>1),'order'=>'User.firstname Asc','fields'=>array('User.firstname','User.lastname','User.email','User.website','User.usertype','User.company_name','User.tokenhash','UserSubscription.used_pieces','UserSubscription.subscription_id','UserSubscription.id')));	
	}	

	$index = 0;
		foreach($data as $business)
		{
			$data[$index]['User']['firstname'] = $business['User']['firstname'];
			$data[$index]['User']['lastname'] = $business['User']['lastname'];
			$data[$index]['User']['company_name'] = $business['User']['company_name'];
			$data[$index]['User']['email'] = count($business['Puzzle']);
			
			// Active puzzle 
			$i = 1;
			$count = 0;
			foreach($business['Puzzle'] as $puz)
			{
				if($puz['status'] == 0)
				{
					$count = $i;
					$i ++;
				}
			}
	  		
	  		$data[$index]['User']['website'] = $count;
	  		
	  		// Number of peices 
	  		if($business['UserSubscription']['id'] != "")
  			{
  				$data[$index]['User']['usertype'] =  $business['UserSubscription']['used_pieces'];
  			}
	  		else
  			{
  				$data[$index]['User']['usertype']  =  "0";
  			}					

  			// Member ship plan name 
  			if($business['UserSubscription']['id'] != "")
  			{
  				$name_of_plan = $this->Subscription->find('first',array('conditions'=>array('Subscription.id'=>$business['UserSubscription']['subscription_id']))) ;
  				$data[$index]['User']['tokenhash'] =  $name_of_plan['Subscription']['name'];
  			}
  			else
  			{
  				$data[$index]['User']['tokenhash'] = "Inactive";
  			}
			$index ++;
		}
		$this->set('Business',$data);
		$this->layout = null;
	}


/**
	User CSV download from admin side 
*/	
	public function admin_userexport($status =Null ,$startdate = null , $enddate = null)
	{
	  

	if($status == 2 && $startdate && $enddate)
	{
	 	$data =  $this->User->find('all',array('conditions'=>array('AND'=>array(array('DATE(User.created) >='=>$startdate,'DATE(User.created) <='=>$enddate)),'User.usertype'=>0),'order'=>'User.firstname Asc','fields'=>array('User.firstname','User.lastname','User.email','User.usertype','User.website')));		
	}
	else if($status !=2 && $startdate == 0  && $enddate == 0 && $enddate != '')
	{
		$data =  $this->User->find('all',array('conditions'=>array('User.usertype'=>0,'User.status'=>$status),'order'=>'User.firstname Asc','fields'=>array('User.firstname','User.lastname','User.email','User.usertype','User.website')));		
	}	
	else
	{
		$data =  $this->User->find('all',array('conditions'=>array('User.usertype'=>0),'order'=>'User.firstname Asc','fields'=>array('User.firstname','User.lastname','User.email','User.usertype','User.website')));
	}	
		foreach($data as $key => $value)
		{
			$data[$key]['User']['usertype'] = $this->Visitor->find('count',array('conditions'=>array('Visitor.email'=>$value['User']['email'])));	
			$data[$key]['User']['website'] = $this->Visitor->find('count',array('conditions'=>array('Visitor.refrel_id'=>$value['User']['id'],'Visitor.is_refrel'=>1)));	
			
		}

		$index = 0;
		foreach($data as $user)
		{
			$data[$index]['User']['firstname'] = $user['User']['firstname'];
			$data[$index]['User']['lastname'] = $user['User']['lastname'];
			$data[$index]['User']['email'] = $user['User']['email'];
			$data[$index]['User']['usertype'] = $user['User']['usertype'];
			$data[$index]['User']['website'] = $user['User']['website'];
			
			$index ++;
		}
		$this->set('User',$data);
		$this->layout = null;
	}


/**
	Admin Setting page 
*/	
	public function admin_setting()
	{
		$this->set('sub_action','setting');
		$this->layout = 'dashboard';
		$this->set("title","Profile Page");
		
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
					$this->Session->setFlash(__('Profile update successfully !!....', true), 'default');		
				}
			}
			else
			{
				$this->Session->setFlash(__('Password does not match !!....', true), 'default');
			}	
			
		}
		$user = $this->User->find('first',array('conditions'=>array('User.id'=>$this->Auth->user('id'))));
		$this->set("User",$user);

	}	



/**
	Admin Business monthwise filter
*/	
	public function admin_monthwisefiltre()
	{
		if(!empty($this->request->data))
		{
			$this->User->recursive = 2;
			if($this->request->data["startDate"] != ""  && $this->request->data["endDate"] != "" )
			{
				if($this->request->data['flag'] == "Business")
				{
					$user = $this->User->find('all',array('conditions'=>array('AND'=>array(array('DATE(User.created) >='=>$this->request->data['startDate'],'DATE(User.created) <='=>$this->request->data['endDate'])),'User.usertype' =>1))) ; 		
				}
				else
				{
					$user = $this->User->find('all',array('conditions'=>array('AND'=>array(array('DATE(User.created) >='=>$this->request->data['startDate'],'DATE(User.created) <='=>$this->request->data['endDate'])), 'User.usertype' =>0)));
					foreach($user as $key => $value)
					{
						$user[$key]['Visitor'] = $this->Visitor->find('count',array('conditions'=>array('Visitor.email'=>$value['User']['email'])));
						$user[$key]['Refrel'] = $this->Visitor->find('count',array('conditions'=>array('Visitor.refrel_id'=>$value['User']['id'],'Visitor.is_refrel'=>1)));		
					}

				}	
				
			}
			else
			{
				if($this->request->data['flag'] == "Business")
				{
					$user = $this->User->find('all',array('conditions'=>array('User.usertype' =>1),'order'=>'User.id Desc')) ; 	
				}
				else
				{
					$user = $this->User->find('all',array('conditions'=>array('User.usertype' =>0),'order'=>'User.id Desc'));
					foreach($user as $key => $value)
					{
						$user[$key]['Visitor'] = $this->Visitor->find('count',array('conditions'=>array('Visitor.email'=>$value['User']['email'])));	
						$user[$key]['Refrel'] = $this->Visitor->find('count',array('conditions'=>array('Visitor.refrel_id'=>$value['User']['id'],'Visitor.is_refrel'=>1)));		
			
			}					
				}	
			}
		}	
		$this->set('Flag',$this->request->data['flag']);
		$this->set("Business", $user);				
	}



	public function clearcache()
	{
        Cache::clear();
        clearCache();
       // exit("hello");
        $files = array();
        $files = array_merge($files, glob(CACHE . '*')); // remove cached css
        $files = array_merge($files, glob(CACHE . 'css' . DS . '*')); // remove cached css
        $files = array_merge($files, glob(CACHE . 'js' . DS . '*'));  // remove cached js           
        $files = array_merge($files, glob(CACHE . 'models' . DS . '*'));  // remove cached models           
        $files = array_merge($files, glob(CACHE . 'persistent' . DS . '*'));  // remove cached persistent           

        foreach ($files as $f) {
            if (is_file($f)) {
                unlink($f);
            }
        }

        if(function_exists('apc_clear_cache')):      
        apc_clear_cache();
        apc_clear_cache('user');
        endif;

        $this->set(compact('files'));
        $this->autoRender = false;
    }			

public function user_confirm()
{
	$this->Session->setFlash(__('Account activate !!....', true), 'default');		
	$this->render('login');
}













}
