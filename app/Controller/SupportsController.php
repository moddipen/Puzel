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
	public $uses = array('Puzzel','User','Order','Support');
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
	 	$signup = 0;
		$this->set("Signup",$signup);
		$this->layout = 'dashboard';
		
	 }


	
/**
	Business Support index page 
*/	
	public function business_index()
	{
		
		$this->set("title","Support");
	}

/**
	Business Add Support  page 
*/	
	public function business_add()
	{
		$this->set("title","Add Support");
		if(!empty($this->request->data))
		{
			$user = $this->Auth->user();
			$this->request->data['Support']['sender_id'] = $user['User']['id'];
			$this->Support->create();
			if($this->Support->save($this->request->data))
			{
				
				$this->Session->setFlash(__('Support Added!!....', true), 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action'=>'index'));
			}
			else
			{
				$this->Session->setFlash(__('Unable to add support!!....', true), 'default', array('class' => 'alert alert-danger'));
			}	
			
		}
		
		
	}	
			
/**
	Admin Support index page 
*/	
	public function admin_index()
	{
		$this->set("title","Support");
		$this->set('Supports',$this->Support->find('all',array('conditions'=>array('Support.receiver_id' =>$this->Auth->user('id')),'order'=>'Support.created desc')));
	}

/**
	Admin Support index page 
*/	
	public function admin_add()
	{
		$this->set("title","Add Support");
		$this->set('CompanyName',$this->User->find('all',array('conditions'=>array('User.usertype'=>1),'order'=>'User.company_name asc')));
		if(!empty($this->request->data))
		{
			$user = $this->Auth->user();
			$this->request->data['Support']['sender_id'] = $user['User']['id'];
			$this->Support->create();
			if($this->Support->save($this->request->data))
			{
				
				$this->Session->setFlash(__('Support Added!!....', true), 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action'=>'index'));
			}
			else
			{
				$this->Session->setFlash(__('Unable to add support!!....', true), 'default', array('class' => 'alert alert-danger'));
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
				$this->Session->setFlash(__('Delete successfully!!....', true), 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action'=>'index'));
			}
			else
			{
				$this->Session->setFlash(__('Unable to Delete!!....', true), 'default', array('class' => 'alert alert-danger'));
			}	
		}
		else
		{
			$this->Session->setFlash(__('No data found....', true), 'default', array('class' => 'alert alert-danger'));
		}	
	}		

/**
	User Support index page 
*/	
	public function user_index()
	{
		$this->set("title","Support");
		$this->set('Supports',$this->Support->find('all',array('conditions'=>array('Support.receiver_id'=>$this->Auth->user('id')),'order'=>'Support.created desc')));
	}

/**
	User Add Support  page 
*/	
	public function user_add()
	{
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
						$this->Session->setFlash(__('Support Send to admin!!....', true), 'default', array('class' => 'alert alert-success'));
						$this->redirect(array('action'=>'index'));
					}
					else
					{
						$this->Session->setFlash(__('Error in Send email to admin!!....', true), 'default', array('class' => 'alert alert-danger'));
					}
				}			
			}
			else
			{
				$this->Session->setFlash(__('Unable to add support!!....', true), 'default', array('class' => 'alert alert-danger'));
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
				$this->Session->setFlash(__('Delete successfully!!....', true), 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action'=>'index'));
			}
			else
			{
				$this->Session->setFlash(__('Unable to Delete!!....', true), 'default', array('class' => 'alert alert-danger'));
			}	
		}
		else
		{
			$this->Session->setFlash(__('No data found....', true), 'default', array('class' => 'alert alert-danger'));
		}	
	}		

/**
	Vise versa Support message in user page 
*/	
	public function user_conversation($id= Null)
	{
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
			$this->request->data['Support']['receiver_id'] = $support['Support']['sender_id'];
			$this->request->data['Support']['subject'] = $support['Support']['subject'];
			$this->Support->create();
			if($this->Support->save($this->request->data))
			{
				// // Create a message and send it to admin 
				$mail = array(
              			"templateid"=>1007226,
              			"name"=>$support['Sender']['firstname'].' '.$support['Sender']['lastname'],
              			"TemplateModel"=> array(
						    "user_name"=> $support['Sender']['firstname'].' '.$support['Sender']['lastname'],
						    "company"=> array(
						      	"name"=> $support['Sender']['company_name']),
							"product_name"=>$this->request->data['Support']['subject'],
							"action_url"=>$this->request->data['Support']['message']),
						"InlineCss"=> true, 
              			"from"=> "support@puzel.co",
              			'to'=>$support['Sender']['email'],
              			'reply_to'=>"support@puzel.co"
              			);	
				if($this->sendemail($mail))
				{
					$this->Session->setFlash(__('Support Send !!....', true), 'default', array('class' => 'alert alert-success'));
					$this->redirect(array('action'=>'index'));
				}	
			}
			else
			{
				$this->Session->setFlash(__('Unable to add support!!....', true), 'default', array('class' => 'alert alert-danger'));
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
			$this->request->data['Support']['subject'] = "RE :".$support['Support']['subject'];
			$this->Support->create();
			if($this->Support->save($this->request->data))
			{
				// Create a message and send it to admin 
				// $email = array(
	   //            			"from"=> "support@puzel.co",
	   //            			'to'=>$support['Receiver']['email'],
	   //            			'subject'=>$this->request->data['Support']['subject'],
	   //            			'text_body'=>"User ".$this->Auth->user('firstname').' '.$this->Auth->user('lastname'). "reply support request  \n\n\n".$this->request->data['Support']['message'],
	   //            			'reply_to'=>"support@puzel.co",
	   //            			'html_body'=>"<p>User ".$this->Auth->user('firstname').' '.$this->Auth->user('lastname'). "reply support request  \n\n\n".$this->request->data['Support']['message']."</p>" );	
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
					$this->Session->setFlash(__('Support Send !!....', true), 'default', array('class' => 'alert alert-success'));
					$this->redirect(array('action'=>'index'));
				}	
			}
			else
			{
				$this->Session->setFlash(__('Unable to add support!!....', true), 'default', array('class' => 'alert alert-danger'));
			}	
			
		}
	}			











}
