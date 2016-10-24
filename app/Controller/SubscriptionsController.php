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
App::import('Vendor', 'braintree/lib/Braintree');


/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class  SubscriptionsController  extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
 public $uses = array('Subscriptions','User','Image','Visitor','Support','Template','Order','Plan');

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
	 	$this->Auth->allow(array('package','user_plan'));
	 	
	}





/**
	Business plan
*/	
	public function package()
	{	
		$signup = 0;
		$this->set("Signup",$signup);
		$this->set('title',"Packages");

		$plan = $this->Plan->find('all');
		$this->set('Plan',$plan);
	}	


/**
	Business plan suscribe
*/	
	public function user_plan($id=null)
	{	
		$this->layour = "dashboard";
		$signup = 1;
		$this->set("Signup",$signup);
		$this->set('title',"Packages");

		$plan = $this->Plan->find('first',array('conditions'=>array('Plan.id'=>$id))); 
		$this->set('Rate',$plan);

		if($this->request->data)
		{
			Braintree_Configuration::environment('sandbox');
			Braintree_Configuration::merchantId('dvgmgzszxf2qgmfh');
			Braintree_Configuration::publicKey('2yhywhtr9583jhmh');
			Braintree_Configuration::privateKey('2bcc2668e0766ce64a3d9f975d953f78');

			$result = Braintree_Transaction::sale(array(
						'customer' => array(
							'firstName' => $this->request->data['Subscription']['firstname'],
							 'lastName' => $this->request->data['Subscription']['lastname'],
							 'email' => $this->request->data['Subscription']['email'],
							),
							'amount' => $plan['Plan']['price'],
							'creditCard' => array(
								'number' => trim($this->request->data['Subscription']['card_number']),
								'expirationDate' => $this->request->data['Subscription']['ex_date_month']['month'].'/'.$this->request->data['Subscription']['ex_date_year']['year'],
								'cvv' => $this->request->data['Subscription']['cvv']
							)
						));

				if ($result->success) 
						{
							
							$result1 = Braintree_Transaction::submitForSettlement($result->transaction->id);
							
								$data['Order']['transiction_id']=$result->transaction->id;
								$data['Order']['price']=$plan['Plan']['price'];
								$data['Order']['created']=date('Y-m-d H:i:s',time());
								$data['Order']['modified']=date('Y-m-d H:i:s',time());
								$data['Order']['plan_id'] = $id;
								// check user is already exists or not 

								$user = $this->User->find('first',array('conditions'=>array('User.email'=>$this->request->data['Subscription']['email'])));
								if(!empty($user))
								{
									$data['Order']['user_id'] = $user['User']['id'];
									$array = array(
										'id'=>$user['User']['id'],
										'password'=>$this->request->data['Subscription']['password'] );
									$this->User->save($array);
								}
								else
								{
									// Create new Business account 

									$this->request->data['User']['firstname'] = $this->request->data['Subscription']['firstname'] ;
									$this->request->data['User']['lastname'] = $this->request->data['Subscription']['lastname'] ;
									$this->request->data['User']['email'] = $this->request->data['Subscription']['email'] ;
									$this->request->data['User']['password'] = $this->request->data['Subscription']['password'] ;
									$this->request->data['User']['usertype'] = 1;
									
									$this->User->create();
									if($this->User->save($this->request->data))
									{
										$data['Order']['user_id'] = $this->User->getLastInsertId();
									}
								}	
								if($this->Order->save($data))
								{
									$invoice = $this->Order->find('first',array('conditions'=>array('Order.id'=>$this->Order->getLastInsertId())));
									$email = array(
			              			"templateid"=>1024802,
			              			"name"=>$this->request->data['Subscription']['firstname'].' '.$this->request->data['Subscription']['lastname'],
			              			"TemplateModel"=> array(
									    "name"=> $this->request->data['Subscription']['firstname'].' '.$this->request->data['Subscription']['lastname'],
									    "product_name"=>$plan['Plan']['price']."$",
										"action_url"=>$invoice['Order']['id'],
										"date"=>$invoice['Order']['created'],
										"amount"=>$invoice['Order']['price']."$",
										"description"=>"One month purchase plan",
										'total'=>$invoice['Order']['price']."$"),
									"InlineCss"=> true, 
			              			"from"=> "support@puzel.co",
			              			'to'=>$this->request->data['Subscription']['email'],
			              			'reply_to'=>"support@puzel.co"
			              			);	

									$this->sendinvoice($email);
									$this->Session->setFlash('<div class="alert alert-success"><button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">×</span></button><p class="text-small"><b>Success </b>: Offer saved for Approval. </p></div>');
									$this->redirect(array('controller'=>'users','action'=>'index','user'=>false));	
									
								}
						}
						else
						{
							$this->Session->setFlash('<div class="alert alert-danger"><button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">×</span></button><p class="text-small"><b>Failed </b>: Error processing transaction:</p><br>
								<span>code: '.$result->transaction->processorResponseCode.'</span><br>

								<span>text: '.$result->transaction->processorResponseText.'</span><br></div>');
						}	
			}	 
	}	










}
