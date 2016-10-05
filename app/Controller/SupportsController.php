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
	}

/**
	Admin Support index page 
*/	
	public function admin_add()
	{
		$this->set("title","Add Support");
	}	











}
