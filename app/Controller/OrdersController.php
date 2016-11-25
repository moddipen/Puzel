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
App::import('Vendor', 'tcpdf', array('file' => 'tcpdf' . DS . 'mypdf.php'));
App::import('Vendor', 'Braintree', array('file' => 'Braintree' . DS . 'lib'. DS .'Braintree.php'));

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class  OrdersController  extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Puzzle','User','Order','Support','Visitor','Image','Plan','UserSubscription','Subscription');

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
	 		 // Count of total puzzle 
	 	// Count of total puzzle 
	 	
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


		  	}
	 	
			
	}	








/**
	Business Billing index page 
*/	
	public function business_index()
	{
		Braintree_Configuration::environment('sandbox');
		Braintree_Configuration::merchantId('dvgmgzszxf2qgmfh');
		Braintree_Configuration::publicKey('2yhywhtr9583jhmh');
		Braintree_Configuration::privateKey('2bcc2668e0766ce64a3d9f975d953f78');
			
		$this->layout = 'dashboard';
		$this->set("title","Billing");
		// $order = $this->Order->find('all',array('conditions'=>array('Order.user_id'=>$this->Auth->user('id')),'order'=>'Order.id DESC'));
		$order = $this->UserSubscription->find('all',array('conditions'=>array('UserSubscription.user_id'=>$this->Auth->user('id'),'UserSubscription.status'=>0),'order'=>'UserSubscription.id DESC'));
		$this->set("Payment",$order);
		$get_current_plan = $this->UserSubscription->find("first",array("conditions"=>array("UserSubscription.user_id"=>$this->Auth->user('id'),"UserSubscription.status"=>0),'order'=>array('UserSubscription.id DESC')));
	
		if(!empty($this->data))
		{
			
			$date = explode("/",$this->data['Order']['date']);
			$result = Braintree_Customer::update(
				  $get_current_plan['Order']['customer_id'],[
					'creditCard' => [
						"cardholderName" => $this->data['Order']['name'],
						"cvv" => $this->data['Order']['cvv'],
						"expirationMonth" => $date[0],//$this->data['Subscription']['ex_date_month']['month'],
						"expirationYear" => $date[1],//this->data['Subscription']['ex_date_year']['year'],
						"number" => $this->data['Order']['number']
					]
				  ]
				);
			
			if($result->success)
			{
				$this->request->data['Order']['id'] = $get_current_plan['Order']['id'];
				$this->request->data['Order']['token'] = $result->customer->creditCards[0]->token;
				$this->Order->save($this->request->data);
				$this->Session->setFlash('<div class="alert alert-success"><button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">×</span></button><p class="text-small"><b>Success </b>: Card details updated successfully. </p></div>');
			}else{
				foreach($result->errors->deepAll() AS $error) {
					$this->Session->setFlash(__($error->code . ": " . $error->message . "\n", true), 'default', array('class' => 'alert alert-danger'));						
				}
			}	
		}
		$get_current_plan = $this->UserSubscription->find("first",array("conditions"=>array("UserSubscription.user_id"=>$this->Auth->user('id')),'order'=>array('UserSubscription.id DESC')));
		$this->set("get_current_plan",$get_current_plan);//debug($get_current_plan);exit;
		if(!empty($get_current_plan) && $get_current_plan['Order']['customer_id'] != 0 && $get_current_plan['Order']['price'] != "Free")
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
		
	public function receipt($id = null)
	{
		$this->autoRender = false;
		$this->layout = null;
		$this->printpdf($id);
	}

	public function printpdf($id=NULL) {
    	$this->autoRender = false;
		$this->layout = null;
		
			
		$pdf = new MYPDF(PDF_PAGE_FORMAT, PDF_UNIT,array(150,150), true, 'UTF-8', false);
		//$this->Order->recursive = -1;
		$order = $this->Order->find("first",array("conditions"=>array("Order.id"=>$id)));
		//debug($order);exit;
		
		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH,PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
		$pdf->setFooterData(array(0,64,0), array(0,64,128));

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set default font subsetting mode
		$pdf->setFontSubsetting(true);

		
		$pdf->SetFont('dejavusans', '', 9, '', true);

		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();

		// set text shadow effect
		//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

		
		$html =
				 '
				 <section class="invoice">
					<div align="center">
						Payment Receipt
					</div>
					<div>
					</div>
					';
							if($order['Order']['price'] != "Free"){$order['Order']['price'] =  $order['Order']['price']."$";} 
						$html.= '
				 		<table cellspacing="10" class="table table-striped" style="font-size:10px;">					 	
							<tr>
								<th>
									Name : '.$order['User']['firstname'].' '.$order['User']['lastname'].'
								</th>
								<th>
									Transaction Status: Successful
								</th>								
							</tr>
							<tr>
								<th>
									Transaction Date : '.$order['Order']['created'].'
								</th>
								<th>
									Amount Paid: '.$order['Order']['price'].'
								</th>
							</tr>
							<tr>
								<th>
									Transaction ID : '.$order['Order']['transiction_id'].'
								</th>
								<th>
									Plan Name: '.$order['Subscription']['name'].'
								</th>
							</tr>
							<tr>
								<th>
									Pieces : '.$order['Subscription']['pieces'].'
								</th>
							</tr>
							
						</table> 
						</section>
					';

		$pdf->writeHTML($html, true, false, false, false, '');

		// ---------------------------------------------------------

		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$pdf->Output('receipt.pdf', 'I');
       	
    
    }










}
