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

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class  VisitorsController  extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Visitor','Puzzle','User','Order','Support','Image','Plan','Subscription');
	public $components = array('Session','RequestHandler');
	public $helpers = array('Html', 'Form','Session','Csv');
	var $name = 'Visitors';
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
		// /$this->layout = 'default';
	 	$this->Auth->allow('v_dynamic','process','fetchimage','generateRandomString');	 		
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
	Visitor Add form page 
*/	
	public function add($name = Null)
	{
		$this->layout = '';

	}



/**
	Visitor Add form page 
*/	
	public function process()
	{
		$this->autoRender = false;
		if(!empty($this->request->data))
		{
			$puzle = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.name'=>$this->request->data['puzzlename'])));
			$this->request->data['puzzle_id'] = $puzle['Puzzle']['id'];
			
			// Signup with puzzle account 
			if($this->request->data['signwithpuzzleaccount'] == 1)
			{
				$visitor = $this->User->find('first',array('conditions'=>array('User.email'=>$this->request->data['email'])));
				if(!empty($visitor))
				{
					$response = array("message"=>"That email address has already taken. Please use another email.");
                    echo json_encode($response);
				}
				else
				{
					$array = array(
					'firstname'=>$this->request->data['firstname'],
					'lastname'=>$this->request->data['lastname'],
					'email'=>$this->request->data['email']);
					$this->User->create();
					if($this->User->save($array))
					{	
						$user = $this->User->find('first',array('conditions'=>array('User.id'=>$this->User->getLastInsertId())));
						$this->request->data['user_id'] =  $user['User']['id'];
						$this->Visitor->create();
						if($this->Visitor->save($this->request->data))
						{
							$modified = date('Y-m-d H:i:s');
							$update = $this->Image->query("UPDATE images SET status = 1 ,modified = '".$modified."' WHERE status <> '1' AND user_id = '".$puzle['Puzzle']['user_id']."' AND puzzle_id = '".$puzle['Puzzle']['id']."' ORDER BY RAND() LIMIT 1 ");  
							$update_puzzle = $this->Image->find('first',array('conditions'=>array('Image.modified'=>$modified,'Image.puzzle_id'=>$puzle['Puzzle']['id'],'Image.user_id'=>$puzle['Puzzle']['user_id'])));
							if($update_puzzle)
							{
								$password_random =$this->generateRandomString();
							    
							    $message = "You have signup successfully \n\n\n  your password is :" .$password_random;
								$useremail = array(
					              			"templateid"=>1007661,
					              			"name"=>$user['User']['firstname'].' '.$user['User']['lastname'],
					              			"TemplateModel"=> array(
											    "user_name"=> $user['User']['firstname'].' '.$user['User']['lastname'],
											    "product_name"=>"Signup Successfully",
											    "company"=>array("name"=>""),
												"action_url"=>$message),
											"InlineCss"=> true, 
					              			"from"=> "support@puzel.co",
					              			'to'=>$user['User']['email'],
					              			'reply_to'=>"support@puzel.co"
					              			);	

								$update = array(
										'id'=>$user['User']['id'],
										'password'=>$password_random);
								if($this->User->save($update))
								{
									$this->hostedemail($useremail,$update_puzzle['Image']['puzzle_id'],"Front")	;
								}	
							}
						}		
					}	
				}	
				
			}
			
			// Normal sign up process 
			else
			{
				$visitor = $this->Visitor->find('first',array('conditions'=>array('Visitor.email'=>$this->request->data['email'],'Visitor.puzzle_id'=>$puzle['Puzzle']['id'])));
				$user = $this->User->find('first',array('conditions'=>array('User.email'=>$this->request->data['email'])));
				if(!empty($user))
				{
					$this->request->data['user_id'] = $user['User']['id'];
				}
				else
				{
					$this->request->data['id'] = 0;	
				}	

				if(!empty($visitor))
				{
					$response = array("message"=>"That email address has already taken. Please use another email.");
                    echo json_encode($response);
				}
				else
				{
					$this->Visitor->create();
					if($this->Visitor->save($this->request->data))
					{
						$modified = date('Y-m-d H:i:s');
						$update = $this->Image->query("UPDATE images SET status = 1 ,modified = '".$modified."' WHERE status <> '1' AND user_id = '".$puzle['Puzzle']['user_id']."' AND puzzle_id = '".$puzle['Puzzle']['id']."' ORDER BY RAND() LIMIT 1 ");  
						$update_puzzle = $this->Image->find('first',array('conditions'=>array('Image.modified'=>$modified,'Image.puzzle_id'=>$puzle['Puzzle']['id'],'Image.user_id'=>$puzle['Puzzle']['user_id'])));
						if($update_puzzle)
						{
							$response = array("message"=>"success","Id"=>$update_puzzle['Image']['puzzle_id']);
		                    echo json_encode($response);
						}
					}	
				}	
			}	
		}
	}

/**
	Visitor Add form page 
*/	
	public function fetchimage($id = Null)
	{
		$this->layout = '';
		$image = $this->Image->find('all',array('conditions'=>array('Image.puzzle_id'=>$id)));
		$this->set('image',$image);
		$this->set('drawimage_s',count($image));
		$puzzle = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$id)));
		$this->set('PuzzleData',$puzzle);
	}

/**
	Visitor dynamic form page 
*/			

	public function v_dynamic($name = null)
	{
		$this->layout = "visitor";
		$this->set('title',$name);
		$name = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.name'=>$name)));
		// $this->set('comname',$companyname);
		$this->set('PuzzleData',$name);
		$image = $this->Image->find('all',array('conditions'=>array('Image.puzzle_id'=>$name['Puzzle']['id'])))	;
		$this->set('image',$image);
		$this->set('drawimage_s',count($image));
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
			
/**
	Business Data Captured
*/			
	public function business_data($id = null)
	{
		$this->set('title',"Data Captured");
		$this->layout = 'dashboard';
		// Get Puzzle list 
		if($id)
		{
			$list = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$id)));				
			$this->set('List',$list);
		}	
		else
		{
			$puzzle_list = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id'))));		
			$this->set('Data',$puzzle_list);
			
			$email_list = $this->Puzzle->Visitor->find('all', array(
                'conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id')),
                'fields' => array('Visitor.email'),
                'group' => array('Visitor.email HAVING  1')));

			$this->set('ResultEmail',$email_list);

		}	

		
		
	}

	
/**
	Business header content and count 
*/	
	public function business_export($email = Null,$from = Null , $to = Null)
	{
	  
		$this->Puzzle->unbindModel(array("belongsTo"=>array("Business")));
		
		if($email)
		{
			$data =  $this->Puzzle->Visitor->find('all',array('conditions'=>array('Visitor.email'=>$email)));
		}
		else
		{
			$data =  $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id')),"fields"=>array("Puzzle.name")));	
		}	
		$index = 0;
		
		if($email)
		{
			$i = 0;
			foreach ($data as  $user)
            {

				$date =  date('m/d/Y',strtotime($user['Visitor']['created']));
				$data[$i]['Visitor']['Visitor Firstname'] = $user['Visitor']['firstname'];
				$data[$i]['Visitor']['Visitor Lastname'] =  $user['Visitor']["lastname"];
				$data[$i]['Visitor']['Company Name'] =  $user['Visitor']['company_name'];
				$data[$i]['Visitor']['Visitor email'] =  $user['Visitor']["email"];
				$data[$i]['Visitor']['Date'] = $date;
				$data[$i]['Visitor']['Puzzle Name'] = $user['Puzzle']['name'];
				$i++;
			}
			$var = "True";
		}
		else
		{
			foreach($data as $visitor)
			{
				$i = 0;
				foreach ($visitor['Visitor'] as  $user)
	            {
					$date =  date('m/d/Y',strtotime($user['created']));
					$data[$index]['Visitor'][$i]['Visitor Firstname'] = $user['firstname'];
					$data[$index]['Visitor'][$i]['Visitor Lastname'] =  $user["lastname"];
					$data[$index]['Visitor'][$i]['Company Name'] =  $user['company_name'];
					$data[$index]['Visitor'][$i]['Visitor email'] =  $user["email"];
					$data[$index]['Visitor'][$i]['Date'] = $date;
					$data[$index]['Visitor'][$i]['Puzzle Name'] = $visitor['Puzzle']['name'];
					$i++;
				}	
				$index++;
			}
			$var = "False";		
		}	
		
		$this->set("Flag",$var);
	 	$this->set('Visitor',$data);
		$this->layout = null;
	}


/**
	Business email filter
*/	

	public function business_emailFilter()
	{	
		$this->layout = null;
		if(!empty($this->request->data))
		{
			if($this->request->data['email'])
			{
				$email = $this->Visitor->find('all',array('conditions'=>array('Visitor.email'=>$this->request->data['email'])));	
			}
			else
			{
				$email = $this->Visitor->find('all',array('conditions'=>array('Visitor.email'=>$this->request->data['email'])));		
			}	
			$this->set('Emaildata',$email);	
		}
		
	}

/**
	Ajax calender filter in business panel
*/
	public function business_datefilter()
	{
		if(!empty($this->request->data))
		{
			$email = $this->Visitor->find('all',array('conditions'=>array('AND'=>array(array('DATE(Visitor.created) >='=>$this->request->data['startdate'],'DATE(Visitor.created) <='=>$this->request->data['enddate']))))) ; 	
			$this->set('Emaildata',$email);	
		}
	}	











}
