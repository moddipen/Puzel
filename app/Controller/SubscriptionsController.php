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
App::import('Vendor', 'Braintree', array('file' => 'Braintree' . DS . 'lib'. DS .'Braintree.php'));
//App::import('Vendor', 'braintree/lib/Braintree');


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
 public $uses = array('Subscriptions','User','Image','Visitor','Support','Template','Order','Plan','Subscription','UserSubscription');

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
	 	$this->Auth->allow(array('package','user_plan','thankyou'));
	 	
	}





/**
	Business plan
*/	
	public function package($id = null)
	{	
		$signup = 0;
		$this->set("Signup",$signup);
		$this->set('title',"Packages");
		if($id)
		{
			$plan = $this->Subscription->find('all',array("conditions"=>array("Subscription.id >"=>$id)));	
		}
		else{
			$plan = $this->Subscription->find('all');
		}
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
		if($this->Auth->user())
		{
			Braintree_Configuration::environment('sandbox');
			Braintree_Configuration::merchantId('dvgmgzszxf2qgmfh');
			Braintree_Configuration::publicKey('2yhywhtr9583jhmh');
			Braintree_Configuration::privateKey('2bcc2668e0766ce64a3d9f975d953f78');
			$get_current_plan = $this->UserSubscription->find("first",array("conditions"=>array("UserSubscription.user_id"=>$this->Auth->user('id')),'order'=>array('UserSubscription.id DESC')));
			$this->set("get_current_plan",$get_current_plan);//debug($get_current_plan);exit;
			if(!empty($get_current_plan) && $get_current_plan['Order']['transiction_id'] != "")
			{
				$paymentMethod = Braintree_Transaction::find($get_current_plan['Order']['transiction_id']);
				$this->set('cardDetail',$paymentMethod);
			}			
		}
		
		$plan = $this->Subscription->find('first',array('conditions'=>array('Subscription.id'=>$id))); 
		$this->set('Rate',$plan);

		if($this->request->data)
		{
			
			if($this->request->data['Subscription']['action'] && $this->request->data['Subscription']['action'] == "upgrade")
			{
				
				Braintree_Configuration::environment('sandbox');
				Braintree_Configuration::merchantId('dvgmgzszxf2qgmfh');
				Braintree_Configuration::publicKey('2yhywhtr9583jhmh');
				Braintree_Configuration::privateKey('2bcc2668e0766ce64a3d9f975d953f78');
				//Refund Transaction before upgrade
				
				//Get previous plan detial
				$order = $this->UserSubscription->find("first",array("conditions"=>array("UserSubscription.user_id"=>$this->Auth->user('id'),"UserSubscription.status"=>0)));
				if(!empty($order))
				{
					//Fetch total payment and deduct acording to month and refund
					
					$amount_to_refund = $order['Order']['price'] / 30;
					//Count total days users has used subscription
					$from=date_create(date('Y-m-d')); $to=date_create($order['Order']['created']); 
					$diff=date_diff($to,$from); 
					$days = $diff->format('%a');//Day plan used
					$amount_to_refund = $amount_to_refund * $days;
					$amount_to_refund = $order['Order']['price'] - $amount_to_refund; // Total refunded amount
					$amount_to_refund = $amount_to_refund/5;
					$refund = Braintree_Transaction::refund($order['Order']['transiction_id'],$amount_to_refund);
					if($refund->success)
					{
						$refund = Braintree_Transaction::refund($order['Order']['transiction_id'],$amount_to_refund);
						if($refund->success)
						{
							$refund = Braintree_Transaction::refund($order['Order']['transiction_id'],$amount_to_refund);
							if($refund->success)
							{
								$refund = Braintree_Transaction::refund($order['Order']['transiction_id'],$amount_to_refund);
								if($refund->success)
								{
									$refund = Braintree_Transaction::refund($order['Order']['transiction_id'],$amount_to_refund);
									if($refund->success)
									{
										//Expire current subscription
										$this->request->data['UserSubscription']['id'] = $order['UserSubscription']['id'];
										$this->request->data['UserSubscription']['status'] = 1;
										$this->UserSubscription->save($this->request->data);
										
										
										//Assign new subscription
										$result = Braintree_Transaction::sale([
											'customerId' => $order["Order"]['customer_id'],//->customer->id,
											'amount' => $plan['Subscription']['price']
										]);
										
										if($result->success)
										{
											$result1 = Braintree_Transaction::submitForSettlement($result->transaction->id);
											$this->request->data['Order']['user_id'] = $this->Auth->user('id');
											$this->request->data['Order']['transiction_id'] = $result->transaction->id;
											$this->request->data['Order']['price'] = $plan['Subscription']['price'];
											$this->request->data['Order']['subscription_id'] = $plan['Subscription']['id'];
											if($this->Order->save($this->request->data))
											{
												$this->request->data['UserSubscription']['user_id'] = $this->Auth->user('id');
												$this->request->data['UserSubscription']['order_id'] = $this->Order->getLastInsertId();
												$this->request->data['UserSubscription']['subscription_id'] = $plan['Subscription']['id'];
												$this->request->data['UserSubscription']['used_pieces'] = $plan['Subscription']['pieces'];
												$this->UserSubscription->create();
												if($this->UserSubscription->save($this->request->data))
												{
													$email = array(
													"templateid"=>1035483,
													"name"=>$this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
													"TemplateModel"=> array(
														"name"=> $this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
														"product_name"=>$plan['Subscription']['name'],
														"action_url"=> $this->Order->getLastInsertId(),
														"date"=>date('m-d-Y'),
														"amount"=>$plan['Subscription']['price']."$",
														"description"=>"Upgrade to One month purchase plan",
														'total'=>$plan['Subscription']['price']."$"),
													"InlineCss"=> true, 
													"from"=> "support@puzel.co",
													'to'=>$this->request->data['Subscription']['email'],
													'reply_to'=>"support@puzel.co"
													);	
													$this->sendinvoice($email);
													$this->Session->setFlash('<div class="alert alert-success"><button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">×</span></button><p class="text-small"><b>Success </b>: Your subscription upgraded </p></div>');
													$this->redirect(array('controller'=>'orders','action'=>'index','business'=>true));		
												}
												else{
													$this->Session->setFlash(__("Error while subscription"), 'default', array('class' => 'alert alert-danger'));						
												}												
											}
											else
											{
												$this->Session->setFlash(__("Error while making order"), 'default', array('class' => 'alert alert-danger'));						
											}
										}
									}
								}
							}
						}
						
					}else{
						foreach($refund->errors->deepAll() AS $error) {
							$this->Session->setFlash(__($error->code . ": " . $error->message . "\n", true), 'default', array('class' => 'alert alert-danger'));						
						}
					}		
				}								
			}
			else
			{
			
						// check if user select except free plan then in that case payment method call 
						if($plan['Subscription']['price'] != 'Free')
						{
								Braintree_Configuration::environment('sandbox');
								Braintree_Configuration::merchantId('dvgmgzszxf2qgmfh');
								Braintree_Configuration::publicKey('2yhywhtr9583jhmh');
								Braintree_Configuration::privateKey('2bcc2668e0766ce64a3d9f975d953f78');
								
								$customer = Braintree_Customer::create([
									'creditCard' => array(
										"cardholderName" => $this->data['Subscription']['holder_name'],
										"cvv" => $this->data['Subscription']['cvv'],
										"expirationMonth" => $this->data['Subscription']['ex_date_month']['month'],
										"expirationYear" => $this->data['Subscription']['ex_date_year']['year'],
										"number" => $this->data['Subscription']['card_number']
									)
								]);
								if($customer->success)
								{
									$result = Braintree_Transaction::sale([
										'customerId' => $customer->customer->id,
										'amount' => $plan['Subscription']['price']
									]);
											//'customerId' => 
									if ($result->success) 
									{
										$result1 = Braintree_Transaction::submitForSettlement($result->transaction->id);
										
											$data['Order']['transiction_id']=$result->transaction->id;
											$data['Order']['customer_id']=$customer->customer->id;
											$data['Order']['price']=$plan['Subscription']['price'];
											$data['Order']['created']=date('Y-m-d H:i:s',time());
											$data['Order']['modified']=date('Y-m-d H:i:s',time());
											$data['Order']['subscription_id'] = $id;
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
												$this->request->data['User']['company_name'] = $this->request->data['Subscription']['company_name'];
												$this->request->data['User']['usertype'] = 1;
												
												$this->User->create();
												if($this->User->save($this->request->data))
												{
													//$this->Auth->login();
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
													$this->sendemail($email);
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
													"product_name"=>$plan['Subscription']['price']."$",
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

												// Save data in user subscription table 

												$insert = array(
													'user_id'=>$data['Order']['user_id'],
													'order_id'=>$this->Order->getLastInsertId(),
													'subscription_id'=>$id,
													'used_pieces'=>$plan['Subscription']['pieces']);

												$this->UserSubscription->create();
												if($this->UserSubscription->save($insert))
												{
													$this->sendinvoice($email);
													$this->Session->setFlash(__('Signup Successfully!!....', true), 'default', array('class' => 'alert alert-success'));
													//$this->redirect(array('controller'=>'orders','action'=>'index','business'=>true));	
													$this->redirect(array('controller'=>'subscriptions','action'=>'thankyou','user'=>false));		
												}
											}
									}
									else
									{
										if($this->request->data['Subscription']['check'] == '')
										{
											$this->Session->setFlash(__('Invalid card detail.', true), 'default', array('class' => 'alert alert-danger'));						
										}
										else
										{
											$this->Session->setFlash('<div class="alert alert-danger"><button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">×</span></button><p class="text-small"><b>Failed </b>: Error processing transaction:</p><br>
											</div>');	
										}	
									}	
								}
						}


						// When user select free plan 
						else
						{
							$data['Order']['transiction_id']=time();
							$data['Order']['price']=$plan['Subscription']['price'];
							$data['Order']['created']=date('Y-m-d H:i:s',time());
							$data['Order']['modified']=date('Y-m-d H:i:s',time());
							$data['Order']['subscription_id'] = $id;
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
								$this->request->data['User']['company_name'] = $this->request->data['Subscription']['company_name'];
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
								if($invoice['Order']['price'] != "Free"){$invoice['Order']['price'] = $$invoice['Order']['price']."$"; }
								
								$email = array(
								"templateid"=>1024802,
								"name"=>$this->request->data['Subscription']['firstname'].' '.$this->request->data['Subscription']['lastname'],
								"TemplateModel"=> array(
									"name"=> $this->request->data['Subscription']['firstname'].' '.$this->request->data['Subscription']['lastname'],
									"product_name"=>$plan['Subscription']['name'],
									"action_url"=>$invoice['Order']['id'],
									"date"=>$invoice['Order']['created'],
									"amount"=>$invoice['Order']['price'],
									"description"=>"One month purchase plan",
									'total'=>$invoice['Order']['price']."$"),
								"InlineCss"=> true, 
								"from"=> "support@puzel.co",
								'to'=>$this->request->data['Subscription']['email'],
								'reply_to'=>"support@puzel.co"
								);	

								// Save data in user subscription table 

								$insert = array(
									'user_id'=>$data['Order']['user_id'],
									'order_id'=>$this->Order->getLastInsertId(),
									'subscription_id'=>$id,
									'used_pieces'=>$plan['Subscription']['pieces']);

								$this->UserSubscription->create();
								if($this->UserSubscription->save($insert))
								{
									$this->sendinvoice($email);
									//$this->Session->setFlash('<div class="alert alert-success"><button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">×</span></button><p class="text-small"><b>Success </b>: Offer saved for Approval. </p></div>');
									$this->redirect(array('controller'=>'subscriptions','action'=>'thankyou','user'=>false));		
								}
							}	
				
						}
					}		 
		}
		
	}	


/**
	Thank you page
*/	
	public function thankyou()
	{	
		$signup = 0;
		$this->set("Signup",$signup);
		$this->set('title',"Thank You");
	}	










}
