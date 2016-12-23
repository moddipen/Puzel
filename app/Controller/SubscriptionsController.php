
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
App::uses('CakeLog', 'Log');
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
	 	$this->Auth->allow(array('package','user_plan','thankyou','failure'));
	 	$this->set('main_action','Subscription');
	 	
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
			$this->set('Upgrade','upgrade');
		}
		else{
			$plan = $this->Subscription->find('all');
			$this->set('Upgrade','all');
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
			$this->set("get_current_plan",$get_current_plan);
			
			if(!empty($get_current_plan) && $get_current_plan['Order']['customer_id'] != 0)
			{
				if($get_current_plan['Order']['token'] != "")
				{
					$paymentMethod_s = Braintree_PaymentMethod::find($get_current_plan['Order']['token']);				
					$paymentMethod->creditCard['last4'] = $paymentMethod_s->last4;
					$paymentMethod->creditCard['cardholderName'] = $paymentMethod_s->cardholderName;
					$paymentMethod->creditCard['expirationMonth'] = $paymentMethod_s->expirationMonth;
					$paymentMethod->creditCard['expirationYear'] = $paymentMethod_s->expirationYear;
					$this->set('cardDetail',$paymentMethod);
				}
				else{
					$paymentMethod = Braintree_Transaction::find($get_current_plan['Order']['transiction_id']);
					$this->set('cardDetail',$paymentMethod);
				}
			}			
		}
		
		$plan = $this->Subscription->find('first',array('conditions'=>array('Subscription.name'=>$id))); 
		$this->set('Rate',$plan);
		$id =$plan['Subscription']['id'];
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
					
					if($order['Order']['price'] == "Free")
					{
						
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
									$tomorrow = new DateTime("now + 1 day");
									$tomorrow->setTime(0,0,0);
									// 	$tomorrow->setTime(0,0,0);
									// if($plan['Subscription']['id'] != 2)
									// {
										$result = Braintree_Subscription::create([
									  'paymentMethodToken' => $customer->customer->paymentMethods[0]->token,
									  'planId' => $plan['Subscription']['id']
									  // 'firstBillingDate' => $tomorrow
										]);	
									// } 
									// else
									// {
									// 	$tomorrow = new DateTime("now + 1 day");
									// 	$tomorrow->setTime(0,0,0);

									// 	$result = Braintree_Subscription::create([
									//   'paymentMethodToken' => $customer->customer->paymentMethods[0]->token,
									//   'planId' => $plan['Subscription']['id'],
									//   'firstBillingDate' => $tomorrow,
									//   'price'=>"2500"
									// 	]);
									// }	
									
																
									if ($result->success == 1) 
									{
										
										//Expire current subscription
											$this->request->data['UserSubscription']['id'] = $order['UserSubscription']['id'];
											$this->request->data['UserSubscription']['status'] = 1;
											$this->UserSubscription->save($this->request->data);
											$data['Order']['transiction_id'] = $result->subscription->transactions[0]->id;
											$data['Order']['subscriptions_id']=$result->subscription->id;
											$data['Order']['token']=$result->subscription->paymentMethodToken;
											$data['Order']['customer_id']=$customer->customer->id;
											$data['Order']['price']=$plan['Subscription']['price'];
											$data['Order']['created']=date('Y-m-d H:i:s',time());
											$data['Order']['modified']=date('Y-m-d H:i:s',time());
											$data['Order']['subscription_id'] = $id;

											// check user is already exists or not 

											$user = $this->User->find('first',array('conditions'=>array('User.email'=>$this->Auth->user('email'))));
											
											if(!empty($user))
											{
												
												$data['Order']['user_id'] = $user['User']['id'];
												$array = array(
													'id'=>$this->Auth->user('id'),
													'status'=>0 );
												if($this->User->save($array))
													{
														if($this->Puzzle->updateAll(array('Puzzle.status'=>0),array('Puzzle.user_id'=>$user['User']['id'])))
															{
																$this->Image->updateAll(array('Image.puzzle_active'=>0),array('Image.user_id'=>$user['User']['id']));
																$this->Session->write('Auth', $this->User->read(null, $this->Auth->user('id')));
															}	
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

												$merge_pieces = $order['UserSubscription']['used_pieces'] + $plan['Subscription']['pieces'];	

												$insert = array(
													'user_id'=>$data['Order']['user_id'],
													'order_id'=>$this->Order->getLastInsertId(),
													'subscription_id'=>$id,
													'used_pieces'=>$merge_pieces);    //$plan['Subscription']['pieces']);

												$this->UserSubscription->create();
												if($this->UserSubscription->save($insert))
												{
													$this->sendinvoice($email);
													//$this->Session->setFlash(__('Signup Successfully!!....', true), 'default', array('class' => 'alert alert-success'));
													//$this->redirect(array('controller'=>'orders','action'=>'index','business'=>true));	
													$this->redirect(array('controller'=>'subscriptions','action'=>'thankyou'));			
												}
											}
										
									}
									else
									{
										if($this->request->data['Subscription']['check'] == '')
										{
											$this->Session->setFlash(__('Invalid card detail.', true), 'default');						
										}
										else
										{
											$this->Session->setFlash(__('Failed : Error processing transaction'),'default');	
										}	
									}	
								}
					}
					else
					{
						
						//Assign new subscription
						$result = Braintree_Subscription::update($order['Order']['subscriptions_id'], array(												
							'paymentMethodToken' => $order['Order']['token'],
							'planId' => $plan['Subscription']['id']												
						));
						
						if($result->success)
						{
							$user = $this->User->find('first',array('conditions'=>array('User.id'=>$this->Auth->user('id'))));
							if(!empty($user))
							{
								$array = array(
									'id'=>$this->Auth->user('id'),
									'status'=>0 );
								if($this->User->save($array))
								{
									if($this->Puzzle->updateAll(array('Puzzle.status'=>0),array('Puzzle.user_id'=>$user['User']['id'])))
										{
											$this->Image->updateAll(array('Image.puzzle_active'=>0),array('Image.user_id'=>$user['User']['id']));
											$this->Session->write('Auth', $this->User->read(null, $this->Auth->user('id')));
										}	
								}	

								//echo "<pre>";print_r($array);exit;
							}

							$this->request->data['Order']['user_id'] = $this->Auth->user('id');
							$this->request->data['Order']['transiction_id'] = $result->subscription->transactions[0]->id;
							$this->request->data['Order']['subscriptions_id']=$result->subscription->id;
							$this->request->data['Order']['price'] = $plan['Subscription']['price'];
							$this->request->data['Order']['subscription_id'] = $plan['Subscription']['id'];
							$this->request->data['Order']['token']=$result->subscription->paymentMethodToken;
							$this->request->data['Order']['customer_id']=$result->subscription->transactions[0]->customer['id'];
							if($this->Order->save($this->request->data))
							{
								$merge_pieces = $order['UserSubscription']['used_pieces'] + $plan['Subscription']['pieces'];
								$this->request->data['UserSubscription']['user_id'] = $this->Auth->user('id');
								$this->request->data['UserSubscription']['order_id'] = $this->Order->getLastInsertId();
								$this->request->data['UserSubscription']['subscription_id'] = $plan['Subscription']['id'];
								$this->request->data['UserSubscription']['used_pieces'] = $merge_pieces;//$plan['Subscription']['pieces'];
								$this->UserSubscription->create();
								if($this->UserSubscription->save($this->request->data))
								{
									//Expire current subscription
									$this->request->data = array();
									$this->request->data['UserSubscription']['id'] = $order['UserSubscription']['id'];
									$this->request->data['UserSubscription']['status'] = 1;
									$this->UserSubscription->save($this->request->data);
						
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
									'to'=>$this->Auth->user('email'),
									'reply_to'=>"support@puzel.co"
									);	
									$this->sendinvoice($email);
									$this->Session->setFlash(__('Your subscription upgraded'),'default');
									$this->redirect(array('controller'=>'orders','action'=>'index','business'=>true));		
								}
								else{
									$this->Session->setFlash(__("Error while subscription"), 'default');						
								}												
							}
							else
							{
								$this->Session->setFlash(__("Error while making order"), 'default');						
							}
						}
						else
						{
							foreach($result->errors->deepAll() AS $error) {
										$this->Session->setFlash(__($error->code . ": " . $error->message . "\n", true), 'default');						
									}
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
									$tomorrow = new DateTime("now + 1 day");
									$tomorrow->setTime(0,0,0);	
									$result = Braintree_Subscription::create([
									  'paymentMethodToken' => $customer->customer->paymentMethods[0]->token,
									  'planId' => $plan['Subscription']['id']
									   // 'firstBillingDate' => $tomorrow
									]);
									// if($plan['Subscription']['id'] != 2)
									// {
									// 	$result = Braintree_Subscription::create([
									//   'paymentMethodToken' => $customer->customer->paymentMethods[0]->token,
									//   'planId' => $plan['Subscription']['id']
									// 	]);	
									// }
									// else
									// {
									// 	$tomorrow = new DateTime("now + 1 day");
									// 	$tomorrow->setTime(0,0,0);

									// 	$result = Braintree_Subscription::create([
									//   'paymentMethodToken' => $customer->customer->paymentMethods[0]->token,
									//   'planId' => $plan['Subscription']['id'],
									//   'firstBillingDate' => $tomorrow,
									//   'price'=>"2500"
									// 	]);
									// }	 									
									
									if ($result->success) 
									{
															
											$data['Order']['transiction_id']=$result->subscription->transactions[0]->id;
											$data['Order']['subscriptions_id']=$result->subscription->id;
											$data['Order']['customer_id']=$result->subscription->transactions[0]->customer['id'];
											$data['Order']['price']=$plan['Subscription']['price'];
											$data['Order']['created']=date('Y-m-d H:i:s',time());
											$data['Order']['modified']=date('Y-m-d H:i:s',time());
											$data['Order']['token']=$result->subscription->paymentMethodToken;
											$data['Order']['subscription_id'] = $id;
											
											// check user is already exists or not 

											$user = $this->User->find('first',array('conditions'=>array('User.email'=>$this->request->data['Subscription']['email'])));
											if(!empty($user))
											{
												$data['Order']['user_id'] = $user['User']['id'];
												$array = array(
													'id'=>$this->Auth->user('id'),
													'status'=>0 );
												if($this->User->save($array))
													{
														if($this->Puzzle->updateAll(array('Puzzle.status'=>0),array('Puzzle.user_id'=>$user['User']['id'])))
															{
																$this->Image->updateAll(array('Image.puzzle_active'=>0),array('Image.user_id'=>$user['User']['id']));
																$this->Session->write('Auth', $this->User->read(null, $this->Auth->user('id')));
															}	
													}	
											}
											else
											{
												// Create new Business account 
												
												// check confirm password and password match or not 

												if($this->request->data['Subscription']['password'] == $this->request->data['Subscription']['confirm_password'])
												{
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
												else
												{
													$this->Session->setFlash(__('Password doesnot match' , true), 'default');	
													$this->redirect($this->here);
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
													$this->redirect(array('controller'=>'subscriptions','action'=>'thankyou','user'=>false));		
												}
											}
									}
									else
									{
										if($this->request->data['Subscription']['check'] == '')
										{
											$this->Session->setFlash(__('Invalid card detail.', true), 'default');						
										}
										else
										{
											$this->Session->setFlash('<div><button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">×</span></button><p class="text-small"><b>Failed </b>: Error processing transaction:</p><br>
											</div>');	
										}	
									}	
								}else{
									foreach($customer->errors->deepAll() AS $error) {
										$this->Session->setFlash(__($error->code . ": " . $error->message . "\n", true), 'default');						
									}
								}
						}


						// When user select free plan 
						else
						{
							//$data['Order']['transiction_id']=time();
							$data['Order']['price']=$plan['Subscription']['price'];
							$data['Order']['created']=date('Y-m-d H:i:s',time());
							$data['Order']['modified']=date('Y-m-d H:i:s',time());
							$data['Order']['subscription_id'] = $id;
							$data['Order']['transiction_id'] = $this->generateRandomString();
							// check user is already exists or not 

							$user = $this->User->find('first',array('conditions'=>array('User.email'=>$this->request->data['Subscription']['email'])));
							if(!empty($user))
							{
								$data['Order']['user_id'] = $user['User']['id'];
								$array = array(
									'id'=>$this->Auth->user('id'),
									'password'=>$this->request->data['Subscription']['password'],
									'status'=>0 );
								if($this->User->save($array))
								{
									if($this->Puzzle->updateAll(array('Puzzle.status'=>0),array('Puzzle.user_id'=>$user['User']['id'])))
										{
											$this->Image->updateAll(array('Image.puzzle_active'=>0),array('Image.user_id'=>$user['User']['id']));
											$this->Session->write('Auth', $this->User->read(null, $this->Auth->User('id')));
										}	
								}	
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


/**
	Failure detail of braintree
*/

	public function failure()
	{
		//$this->layout = '';
		$this->autoRender = false;
		Braintree_Configuration::environment('sandbox');
		Braintree_Configuration::merchantId('dvgmgzszxf2qgmfh');
		Braintree_Configuration::publicKey('2yhywhtr9583jhmh');
		Braintree_Configuration::privateKey('2bcc2668e0766ce64a3d9f975d953f78');

		// $check  = Braintree_WebhookNotification::CHECK;	

		// $this->log($check);
		if(isset($_POST["bt_signature"]) && isset($_POST["bt_payload"])) 
		{
			    $webhookNotification = Braintree_WebhookNotification::parse(
			        $_POST["bt_signature"], $_POST["bt_payload"]
			    );
			     
        		$message =
        		 	        "[Webhook Received " . $webhookNotification->timestamp->format('Y-m-d H:i:s') . "] "
        						. "Kind: " . $webhookNotification->kind . " | "
        						. "Subscription: " . $webhookNotification->subscription->id . "\n";
        		

        		if($webhookNotification->kind == "subscription_charged_successfully")
        		{
        			$get_order = $this->Order->find('first',array('conditions'=>array('Order.subscriptions_id'=> $webhookNotification->subscription->id),'order'=>'Order.id Desc'));
        			$plan = $this->Subscription->find('first',array('conditions'=>array('Subscription.id'=>$get_order['Order']['subscription_id']))); 
        			
					$user = $this->User->find('first',array('conditions'=>array('User.id'=>$get_order['Order']['user_id'])));
					if(!empty($user))
					{
						$array = array(
							'id'=>$get_order['Order']['user_id'],
							'status'=>0 );
						if($this->User->save($array))
						{
							if($this->Puzzle->updateAll(array('Puzzle.status'=>0),array('Puzzle.user_id'=>$user['User']['id'])))
								{
									$this->Image->updateAll(array('Image.puzzle_active'=>0),array('Image.user_id'=>$user['User']['id']));
								}	
						}	

						//echo "<pre>";print_r($array);exit;
					}

					$this->request->data['Order']['user_id'] = $get_order['Order']['user_id'];
					$this->request->data['Order']['transiction_id'] = $result->subscription->transactions[0]->id;
					$this->request->data['Order']['subscriptions_id']=$result->subscription->id;
					$this->request->data['Order']['price'] = $plan['Subscription']['price'];
					$this->request->data['Order']['subscription_id'] = $plan['Subscription']['id'];
					$this->request->data['Order']['token']=$result->subscription->paymentMethodToken;
					$this->request->data['Order']['customer_id']=$result->subscription->transactions[0]->customer['id'];
					if($this->Order->save($this->request->data))
					{
						$merge_pieces = $plan['Subscription']['pieces'];
						$this->request->data['UserSubscription']['user_id'] = $user['User']['id'];
						$this->request->data['UserSubscription']['order_id'] = $this->Order->getLastInsertId();
						$this->request->data['UserSubscription']['subscription_id'] = $plan['Subscription']['id'];
						$this->request->data['UserSubscription']['used_pieces'] = $merge_pieces;
						$this->UserSubscription->create();
						if($this->UserSubscription->save($this->request->data))
						{
							//Expire current subscription
							$this->request->data = array();
							$this->request->data['UserSubscription']['id'] = $order['UserSubscription']['id'];
							$this->request->data['UserSubscription']['status'] = 1;
							$this->UserSubscription->save($this->request->data);
				
							$email = array(
							"templateid"=>1035483,
							"name"=>$user['User']['firstname'].' '.$user['User']['lastname'],
							"TemplateModel"=> array(
								"name"=> $user['User']['firstname'].' '.$user['User']['lastname'],
								"product_name"=>$plan['Subscription']['name'],
								"action_url"=> $this->Order->getLastInsertId(),
								"date"=>date('m-d-Y'),
								"amount"=>$plan['Subscription']['price']."$",
								"description"=>"Upgrade to One month purchase plan",
								'total'=>$plan['Subscription']['price']."$"),
							"InlineCss"=> true, 
							"from"=> "support@puzel.co",
							'to'=>$user['User']['email'],
							'reply_to'=>"support@puzel.co"
							);	
							$this->sendinvoice($email);
						}
					}
				}
				// Subscription not successfull
        		else
        		{
        			Braintree_Subscription::cancel($webhookNotification->subscription->id);        						
					$get_order = $this->Order->find('first',array('conditions'=>array('Order.subscriptions_id'=> $webhookNotification->subscription->id),'order'=>'Order.id Desc'));


	        		$array = array(
						'id'=>$get_order['Order']['id'],
						'reason'=> $webhookNotification->kind);
	        		
	        		if($this->Order->save($array))
	        		{	
	        			$user = array(
	        				'id'=>$get_order['Order']['user_id'],
	        				'status'=>1);
	        			if($this->User->save($user))
	        			{
	        				if($this->Puzzle->updateAll(array('Puzzle.status'=>1),array('Puzzle.user_id'=>$get_order['Order']['user_id'])))
							{
								$puzzle = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$get_order['Order']['user_id'])));
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
											"name"=>$get_order['User']['firstname'].' '.$get_order['User']['lastname'],
											"TemplateModel"=> array(
												"user_name"=> $get_order['User']['firstname'].' '.$get_order['User']['firstname'],
												"product_name"=>"Account Cancelled",
												'company'=>array(
				                					'name'=>''),
												"action_url"=>"Your account has been cancelled. Please get in touch with our support team for further instructions."),
											"InlineCss"=> true, 
											"from"=> "support@puzel.co",
											'to'=>"moddipen@gmail.com",
											'reply_to'=>"support@puzel.co"
											);	

											$this->sendemail($email);
											
										}

									}
								}
	        				}
	        				else
	        				{
	        					$email = array(
									"templateid"=>1025061,
									"name"=>$get_order['User']['firstname'].' '.$get_order['User']['firstname'],
									"TemplateModel"=> array(
										"user_name"=> $get_order['User']['firstname'].' '.$get_order['User']['firstname'],
										"product_name"=>"Account Cancelled",
										'company'=>array(
		                					'name'=>''),
										"action_url"=>"Your account has been cancelled. Please get in touch with our support team for further instructions."),
									"InlineCss"=> true, 
									"from"=> "support@puzel.co",
									'to'=>"moddipen@gmail.com",
									'reply_to'=>"support@puzel.co"
									);	

									$this->sendemail($email);
							}	
					}
        		}				

			}
		}
}	

/**
	Generate rndom string
*/			
	public function generateRandomString($length = 10)
	{
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}










}
