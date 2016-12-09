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

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class  SupportsController  extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Puzzle','User','Order','Support','Image','Visitor','Plan','Subscription');
	 var $name = 'Supports';
/**
 * Displays a view
 *
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	function beforeFilter()
	{
	 	parent::beforeFilter();
		$signup = 0;
		$this->set("Signup",$signup);
		$this->layout = 'dashboard';
		$this->set('main_action','Support');
	}


	
/**
	Business Support index page 
*/	
	public function business_index()
	{
		$this->set('sub_action','index');
		$this->set("title","Support");
		$support = $this->Support->find('all',array('conditions'=>array('OR'=>array('Support.receiver_id' =>$this->Auth->user('id'),'Support.sender_id' =>$this->Auth->user('id'))),'order'=>'Support.created desc','group' => array('Support.subject HAVING  1')));

		$this->set('Supports',$support);
	}

/**
	Business Add Support  page 
*/	
	public function business_add()
	{
		$this->set('sub_action','add');
		$this->set("title","Add Support");
		$admin = $this->User->find('first',array('conditions'=>array('User.usertype'=>2)));
		$this->Session->write("ADMINDETAIL",$admin);
		if(!empty($this->request->data))
		{
			$user = $this->Auth->user();
			$this->request->data['Support']['sender_id'] = $this->Auth->user('id');
			$this->Support->create();
			if($this->Support->save($this->request->data))
			{
				// Create a message and send it to admin 
				$adminemail = array(
              			"templateid"=>1007242,
              			"name"=>$this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
              			"TemplateModel"=> array(
						    "user_name"=> $this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
						    "company"=> array(
						      	"name"=> $this->Auth->user('company_name')),
							"product_name"=>$this->request->data['Support']['subject'],
							"action_url"=>$this->request->data['Support']['message']),
						"InlineCss"=> true, 
              			"from"=> "support@puzel.co",
              			'to'=>$admin['User']['email'],
              			'reply_to'=>"support@puzel.co"
              			);

				// Create email to user self
				if($this->sendemail($adminemail))
				{	
					$useremail = array(
              			"templateid"=>1007245,
              			"name"=>$this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
              			"TemplateModel"=> array(
						    "user_name"=> $this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
						    "company"=> array(
						      	"name"=> $this->Auth->user('company_name')),
							"product_name"=>$this->request->data['Support']['subject'],
							"action_url"=>$this->request->data['Support']['message']),
						"InlineCss"=> true, 
              			"from"=> "support@puzel.co",
              			'to'=>$this->Auth->user('email'),
              			'reply_to'=>"support@puzel.co"
              			);	
				

					if($this->sendemail($useremail))
				    {
						$this->Session->setFlash(__('Support Send to admin!!....', true), 'default');
						$this->redirect(array('action'=>'index','business'=>true));
					}
					else
					{
						$this->Session->setFlash(__('Error in Send email to admin!!....', true), 'default');
					}
				}			
			}
			else
			{
				$this->Session->setFlash(__('Unable to add support!!....', true), 'default');
			}	
			
		}
	}	
			
/**
	Admin Support index page 
*/	
	public function admin_index()
	{
		$this->set('sub_action','index');
		$this->set("title","Support");
		$support = $this->Support->find('all',array('conditions'=>array('OR'=>array('Support.receiver_id' =>$this->Auth->user('id'),'Support.sender_id' =>$this->Auth->user('id'))),'order'=>'Support.created desc','fields' => array('Support.subject','Sender.firstname','Receiver.firstname','Sender.lastname','Receiver.lastname','Sender.company_name','Receiver.company_name','Support.created','Sender.id','Receiver.id','Support.message','Support.id'),'group' => array('Support.subject HAVING  1')));
		$this->set('Supports',$support);
		$this->User->recursive = -2;
		$email_list = $this->User->find('all',array('conditions'=>array('User.usertype'=>1),'fields'=>array('User.id','User.email')));
		$this->set('Emailist',$email_list);
	}

/**
	Admin Support add page for business 
*/	
	public function admin_add()
	{
		$this->set('sub_action','add');
		$this->set("title","Add Support");
		
		$this->set('CompanyName',$this->User->find('all',array('conditions'=>array('User.usertype'=>1),'order'=>'User.company_name asc')));
		if(!empty($this->request->data))
		{
			$user = $this->Auth->user();
			$this->request->data['Support']['sender_id'] = $user['id'];
			$this->Support->create();
			if($this->Support->save($this->request->data))
			{
				// send email to particular business account 

				$receiver  = $this->User->find('first',array('conditions'=>array('User.id'=>$this->request->data['Support']['receiver_id'])));

				$useremail = array(
          			"templateid"=>1064102,
          			"name"=>$receiver['User']['firstname'].' '.$receiver['User']['lastname'],
          			"TemplateModel"=> array(
					    "user_name"=> $receiver['User']['firstname'].' '.$receiver['User']['lastname'],
					    "company"=> array(
					      	"name"=> $receiver['User']['company_name']),
						"product_name"=>$this->request->data['Support']['subject'],
						"action_url"=>$this->request->data['Support']['message']),
					"InlineCss"=> true, 
          			"from"=> "support@puzel.co",
          			'to'=>$receiver['User']['email'],
          			'reply_to'=>"support@puzel.co"
          			);	
				
				if($this->sendemail($useremail))
				{
					$this->Session->setFlash(__('Support Added!!....', true), 'default');
					$this->redirect(array('action'=>'index','admin'=>true));	
				}	
			}
			else
			{
				$this->Session->setFlash(__('Unable to add support!!....', true), 'default');
			}	
			
		}
	}	

/**
	Delete Support from admin page 
*/	
	public function admin_delete($id= Null)
	{
		if($id)
		{
			if($this->Support->delete($id))
			{	
				$this->Session->setFlash(__('Delete successfully!!....', true), 'default');
				$this->redirect(array('action'=>'index','admin'=>true));
			}
			else
			{
				$this->Session->setFlash(__('Unable to Delete!!....', true), 'default');
			}	
		}
		else
		{
			$this->Session->setFlash(__('No data found....', true), 'default');
		}	
	}		

/**
	User Support index page 
*/	
	public function user_index()
	{
		$this->set('sub_action','index');
		$this->set("title","Support");
		$this->set('Supports',$this->Support->find('all',array('conditions'=>array('OR'=>array('Support.receiver_id'=>$this->Auth->user('id'),'Support.sender_id'=>$this->Auth->user('id'))),'order'=>'Support.created desc','group' => array('Support.subject HAVING  1'))));
	}

/**
	User Add Support  page 
*/	
	public function user_add()
	{
		$this->set('sub_action','add');
		$this->set("title","Add Support");
		$admin = $this->User->find('first',array('conditions'=>array('User.usertype'=>2)));
		$this->Session->write("ADMINDETAIL",$admin);
		if(!empty($this->request->data))
		{
			$user = $this->Auth->user();
			$this->request->data['Support']['sender_id'] = $this->Auth->user('id');
			$this->Support->create();
			if($this->Support->save($this->request->data))
			{
				// Create a message and send it to admin 
				$adminemail = array(
              			"templateid"=>1007242,
              			"name"=>$this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
              			"TemplateModel"=> array(
						    "user_name"=> $this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
						    "company"=> array(
						      	"name"=> $this->Auth->user('comapny_name')),
							"product_name"=>$this->request->data['Support']['subject'],
							"action_url"=>$this->request->data['Support']['message']),
						"InlineCss"=> true, 
              			"from"=> "support@puzel.co",
              			'to'=>$admin['User']['email'],
              			'reply_to'=>"support@puzel.co"
              			);

				// Create email to user self
				if($this->sendemail($adminemail))
				{	
					$useremail = array(
              			"templateid"=>1007245,
              			"name"=>$this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
              			"TemplateModel"=> array(
						    "user_name"=> $this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
						    "company"=> array(
						      	"name"=> $this->Auth->user('comapny_name')),
							"product_name"=>$this->request->data['Support']['subject'],
							"action_url"=>$this->request->data['Support']['message']),
						"InlineCss"=> true, 
              			"from"=> "support@puzel.co",
              			'to'=>$this->Auth->user('email'),
              			'reply_to'=>"support@puzel.co"
              			);	
				

					if($this->sendemail($useremail))
				    {
						$this->Session->setFlash(__('Support Send to admin!!....', true), 'default');
						$this->redirect(array('action'=>'index','user'=>true));
					}
					else
					{
						$this->Session->setFlash(__('Error in Send email to admin!!....', true), 'default');
					}
				}			
			}
			else
			{
				$this->Session->setFlash(__('Unable to add support!!....', true), 'default');
			}	
			
		}
	}		

/**
	Delete Support from user page 
*/	
	public function user_delete($id= Null)
	{
		if($id)
		{
			if($this->Support->delete($id))
			{	
				$this->Session->setFlash(__('Delete successfully!!....', true), 'default');
				$this->redirect(array('action'=>'index','user'=>true));
			}
			else
			{
				$this->Session->setFlash(__('Unable to Delete!!....', true), 'default');
			}	
		}
		else
		{
			$this->Session->setFlash(__('No data found....', true), 'default');
		}	
	}		

/**
	Vise versa Support message in user page 
*/	
	public function user_conversation($id= Null)
	{
		$this->set('sub_action','conversation');
		$this->set('title',"Conversation");
		if($id)
		{
			$viseversa  = $this->Support->find('all',array('conditions'=>array(array('OR'=>array('Support.receiver_id'=>$this->Auth->user('id'),'Support.sender_id'=>$this->Auth->user('id'),'Support.id'=>$id,'Support.reply_id'=>$id))),'order'=>'Support.created asc'));
			$this->set("Conversation",$viseversa);
		}
	}

/**
	Admin reply to Support ssssssticket 
*/	
	public function admin_reply($reply_id = null)
	{
		$this->set("title","Reply Support");
		
		$support =$this->Support->find('first',array('conditions'=>array('Support.id'=>$reply_id)));
		$this->Set("Support",$support);	
		if(!empty($this->request->data))
		{
			$user = $this->Auth->user();
			$this->request->data['Support']['sender_id'] = $this->Auth->user('id');

			// check if admin send reply multiple time without any reply by business 
			if($support['Support']['sender_id'] != $this->Auth->user('id'))
			{
				$this->request->data['Support']['receiver_id'] = $support['Support']['sender_id'];	
			}
			else
			{
				$this->request->data['Support']['receiver_id'] = $support['Support']['receiver_id'];		
			}	
			
			$this->request->data['Support']['subject'] = $support['Support']['subject'];
			$this->Support->create();
			if($this->Support->save($this->request->data))
			{
				// get last insert support data

				$last_inserted_supported = $this->Support->find('first',array('conditions'=>array('Support.id'=>$this->Support->getLastInsertId())));


				// // Create a message and send it to admin 
				$mail = array(
              			"templateid"=>1064341,
              			"name"=>$last_inserted_supported['Receiver']['firstname'].' '.$last_inserted_supported['Receiver']['lastname'],
              			"TemplateModel"=> array(
						    "user_name"=> $last_inserted_supported['Receiver']['firstname'].' '.$last_inserted_supported['Receiver']['lastname'],
						    "company"=> array(
						      	"name"=> $last_inserted_supported['Receiver']['company_name']),
							"product_name"=>$this->request->data['Support']['subject'],
							"action_url"=>$this->request->data['Support']['message']),
						"InlineCss"=> true, 
              			"from"=> "support@puzel.co",
              			'to'=>$last_inserted_supported['Receiver']['email'],
              			'reply_to'=>"support@puzel.co"
              			);	
				if($this->sendemail($mail))
				{
					$this->Session->setFlash(__('Support Send !!....', true), 'default');
					$this->redirect(array('action'=>'index','admin'=>true));
				}	
			}
			else
			{
				$this->Session->setFlash(__('Unable to add support!!....', true), 'default');
			}	
			
		}
	}		

/**
	User reply to Admin Support ticket 
*/	
	public function user_reply($reply_id = null)
	{
		$this->set("title","Reply Support");
		
		$support =$this->Support->find('first',array('conditions'=>array('Support.id'=>$reply_id)));
		$this->Set("Support",$support);	
		if(!empty($this->request->data))
		{
			$user = $this->Auth->user();
			$this->request->data['Support']['sender_id'] = $this->Auth->user('id');
			$this->request->data['Support']['receiver_id'] = $support['Support']['receiver_id'];
			$this->request->data['Support']['subject'] = $support['Support']['subject'];
			$this->Support->create();
			if($this->Support->save($this->request->data))
			{
				// Create a message and send it to admin 
				$email = array(
              			"templateid"=>1007227,
              			"name"=>$this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
              			"TemplateModel"=> array(
						    "user_name"=> $this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
						    "company"=> array(
						      	"name"=> $this->Auth->user('company_name')),
							"product_name"=>$support['Support']['subject'],
							"action_url"=>$this->request->data['Support']['message']),
						"InlineCss"=> true, 
              			"from"=> "support@puzel.co",
              			'to'=>$support['Receiver']['email'],
              			'reply_to'=>"support@puzel.co"
              			);	

				if($this->sendemail($email))
				{
					$this->Session->setFlash(__('Support Send !!....', true), 'default');
					$this->redirect(array('action'=>'index','user'=>true));
				}	
			}
			else
			{
				$this->Session->setFlash(__('Unable to add support!!....', true), 'default');
			}	
			
		}
	}			

/**
	Vise versa Support message in user page 
*/	
	public function business_conversation($id= Null)
	{
		$this->set('sub_action','conversation');
		$this->set('title',"Conversation");
		if($id)
		{
			$viseversa  = $this->Support->find('all',array('conditions'=>array(array('OR'=>array('Support.receiver_id'=>$this->Auth->user('id'),'Support.sender_id'=>$this->Auth->user('id'),'Support.id'=>$id,'Support.reply_id'=>$id))),'order'=>'Support.created asc'));
			$this->set("Conversation",$viseversa);
		}
	}

/**
	Business reply to Admin Support ticket 
*/	
	public function business_reply($reply_id = null)
	{
		$this->set("title","Reply Support");
		
		$support =$this->Support->find('first',array('conditions'=>array('Support.id'=>$reply_id)));
		$this->Set("Support",$support);	
		if(!empty($this->request->data))
		{
			$user = $this->Auth->user();
			$this->request->data['Support']['sender_id'] = $this->Auth->user('id');
			
			if($support['Support']['sender_id'] != $this->Auth->user('id'))
			{
				$this->request->data['Support']['receiver_id'] = $support['Support']['sender_id'];
			}
			else
			{
				$this->request->data['Support']['receiver_id'] = $support['Support']['receiver_id'];	
			}	
			$this->request->data['Support']['subject'] = $support['Support']['subject'];
			$this->Support->create();
			if($this->Support->save($this->request->data))
			{
				// Create a message and send it to admin 
				$email = array(
              			"templateid"=>1007227,
              			"name"=>$this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
              			"TemplateModel"=> array(
						    "user_name"=> $this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
						    "company"=> array(
						      	"name"=> $this->Auth->user('company_name')),
							"product_name"=>$support['Support']['subject'],
							"action_url"=>$this->request->data['Support']['message']),
						"InlineCss"=> true, 
              			"from"=> "support@puzel.co",
              			'to'=>$support['Receiver']['email'],
              			'reply_to'=>"support@puzel.co"
              			);	

				if($this->sendemail($email))
				{
					$this->Session->setFlash(__('Support Send !!....', true), 'default');
					$this->redirect(array('action'=>'index','business'=>true));
				}	
			}
			else
			{
				$this->Session->setFlash(__('Unable to add support!!....', true), 'default');
			}	
			
		}
	}			

/**
	Delete Support from business page 
*/	
	public function business_delete($id= Null)
	{
		if($id)
		{
			if($this->Support->delete($id))
			{	
				$this->Session->setFlash(__('Delete successfully!!....', true), 'default');
				$this->redirect(array('action'=>'index','business'=>true));
			}
			else
			{
				$this->Session->setFlash(__('Unable to Delete!!....', true), 'default');
			}	
		}
		else
		{
			$this->Session->setFlash(__('No data found....', true), 'default');
		}	
	}	

/**
	Ajax calender filter in business panel
*/
	public function business_datefilter()
	{
		if(!empty($this->request->data))
		{
			if($this->request->data['startdate'] != "" && $this->request->data['enddate'] != "")
			{
				$support = $this->Support->find('all',array('conditions'=>array('AND'=>array(array('DATE(Support.created) >='=>$this->request->data['startdate'],'DATE(Support.created) <='=>$this->request->data['enddate'])),'OR'=>array('Support.receiver_id'=>$this->Auth->user('id'),'Support.sender_id'=>$this->Auth->user('id'))),'group' => array('Support.subject HAVING  1'))) ; 					
			}
			else
			{
				$support = $this->Support->find('all',array('conditions'=>array('OR'=>array('Support.receiver_id'=>$this->Auth->user('id'),'Support.sender_id'=>$this->Auth->user('id'))))) ; 	
			}	




			
			
			$this->set('Supports',$support);
		}
	}	

/**
	Vise versa Support message in admin page 
*/	
	public function admin_conversation($id= Null)
	{
		$this->set('sub_action','conversation');
		$this->set('title',"Conversation");
		if($id)
		{
			$get_data = $this->Support->find('first',array('conditions'=>array('Support.id'=>$id)));
			 $viseversa  = $this->Support->find('all',array('conditions'=>array('Support.subject'=>$get_data['Support']['subject']),'order'=>'Support.created asc'));
			// $viseversa = $this->Support->find('all',array('conditions'=>array('OR'=>array('Support.receiver_id' =>$this->Auth->user('id'),'Support.sender_id' =>$this->Auth->user('id'))),'order'=>'Support.created desc','fields' => array('Support.subject','Sender.firstname','Receiver.firstname','Sender.lastname','Receiver.lastname','Sender.company_name','Receiver.company_name','Support.created','Sender.id','Receiver.id','Support.message','Support.id'),'group' => array('Support.subject HAVING  1')));
			
			$this->set("Conversation",$viseversa);
		}
	}


/**
	Admin Support email filter on index page 
*/	
	public function admin_emailfilter()
	{
		
		if($this->request->data['search'])
		{
			// $list = $this->Support->find('all',array('conditions'=>array('OR'=>array('Support.receiver_id' =>$this->request->data['id'],'Support.sender_id' =>$this->request->data['id'])),'order'=>'Support.created desc'));
			$list = $this->Support->find('all',array('conditions'=>array('OR'=>array('Sender.firstname LIKE' =>'%'.$this->request->data['search'].'%','Receiver.firstname LIKE' =>'%'.$this->request->data['search'].'%','Sender.lastname LIKE'=>'%'.$this->request->data['search'].'%','Sender.company_name LIKE'=>'%'.$this->request->data['search'].'%','Receiver.company_name LIKE'=>'%'.$this->request->data['search'].'%','Support.subject LIKE'=>'%'.$this->request->data['search'].'%')),'order'=>'Support.created desc','group' => array('Support.subject HAVING  1')));
		}	
		
		$this->set('Supports',$list);
	}



/**
	Admin Support calender filter on index page 
*/	
	public function admin_datefilter()
	{
		if($this->request->data)
		{
			if($this->request->data['startdate'] != '' && $this->request->data['enddate'] != '')
			{
				$list = $this->Support->find('all',array('conditions'=>array('AND'=>array(array('DATE(Support.created) >='=>$this->request->data['startdate'],'DATE(Support.created) <='=>$this->request->data['enddate']))),'order'=>'Support.created desc'));				
			}
			else
			{
				$list = $this->Support->find('all',array('order'=>'Support.created desc'));
			}	
			$this->set('Supports',$list);
		}	
		
	}	

/**
	User Support calender and monthwise filter  
*/	
	public function user_datefilter()
	{
		if(!empty($this->request->data))
		{
			if($this->request->data['startdate'] != "" && $this->request->data['enddate'] != "")
			{
				$this->set('Supports',$this->Support->find('all',array('conditions'=>array('AND'=>array(array('DATE(Support.created) >='=>$this->request->data['startdate'],'DATE(Support.created) <='=>$this->request->data['enddate'])),'OR'=>array('Support.receiver_id'=>$this->Auth->user('id'),'Support.sender_id'=>$this->Auth->user('id'))),'order'=>'Support.created desc','group' => array('Support.subject HAVING  1'))));	
			}
			else
			{
				$this->set('Supports',$this->Support->find('all',array('conditions'=>array('OR'=>array('Support.receiver_id'=>$this->Auth->user('id'),'Support.sender_id'=>$this->Auth->user('id'))),'order'=>'Support.created desc','group' => array('Support.subject HAVING  1'))));		
			}	
			
		}	
	}








}
