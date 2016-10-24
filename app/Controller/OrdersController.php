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
	public $uses = array('Puzzle','User','Order','Support','Visitor','Image','Plan');

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
			$list = $this->Plan->find('first',array('conditions'=>array('Plan.id'=>$order['Order']['plan_id'])));
			$this->set('Visitor',$visitcount);
			$this->set('Balancepeices',$list['Plan']['pieces']);
			
	}	








/**
	Business Billing index page 
*/	
	public function business_index()
	{
		$this->layout = 'dashboard';
		$this->set("title","Billing");
		$order = $this->Order->find('all',array('conditions'=>array('Order.user_id'=>$this->Auth->user('id')),'order'=>'Order.id DESC'));
		$this->set("Payment",$order);
	}
			










}
