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
class  VisitorsController  extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Visitor','Puzzle','User','Order','Support','Image');
	 public $components = array('Session','RequestHandler');
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
	public function business_data()
	{
		$this->set('title',"Data Captured");
		$this->layout = 'dashboard';
		// Get Puzzle list 
		$this->Puzzle->recursive = -1;
		$puzzle_list = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id'))));	
   		
   		foreach ($puzzle_list as $key =>  $puzzle)
   		{
   			// Get Visitor list
   			$list = $this->Visitor->find('all',array('conditions'=>array('Visitor.puzzle_id'=>$puzzle['Puzzle']['id'])));
   			$name = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$puzzle['Puzzle']['id'])));
   			
   			foreach($list as $key => $data)
   			{
   				// Get puzzle name 
   				$list[$key]['Puzzle'] = $name['Puzzle']['name']; 	
   			}	
		}
   		$this->set('Data',$list);
	}

	// public function business_csv()
	// {
	// 	$this->autoRender = false;
	// 	header('Content-Type: text/csv; charset=utf-8');
	// 	header('Content-Disposition: attachment; filename=data.csv');

	// 	// create a file pointer connected to the output stream
	// 	$output = fopen('php://output', 'w');

	// 	// output the column headings
	// 	fputcsv($output, array('FirstName','LastName','PuzleName','Email'));

	// 	$this->Puzzle->recursive = -1;
	// 	$puzzle_list = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id'))));	
   		
 //   		foreach ($puzzle_list as $key =>  $puzzle)
 //   		{
 //   			// Get Visitor list
 //   			$list = $this->Visitor->find('all',array('conditions'=>array('Visitor.puzzle_id'=>$puzzle['Puzzle']['id'])));
 //   			$name = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$puzzle['Puzzle']['id'])));
   			
 //   			foreach($list as $key => $data)
 //   			{
 //   				// Get puzzle name 
 //   				$data['Visitor']['puzzle_id'] = $name['Puzzle']['name']; 
	// 			$data['Visitor']['firstname'];
	// 			$data['Visitor']['lastname'];
	// 			$data['Visitor']['email'];
	// 		}	
	// 	}
	// 	fputcsv($output,$data);			

	// 	// loop over the rows, outputting them
		

	// 	// Close the file
	// 	fclose($output);
	// }

	// public function business_export()
	// {

	// 	$this->response->download("export.csv");

	// 	$this->Puzzle->recursive = -1;
	// 	$puzzle_list = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id'))));	
	// 	foreach ($puzzle_list as $key =>  $puzzle)
 //   		{
 //   			// Get Visitor list
 //   			$list = $this->Visitor->find('all',array('conditions'=>array('Visitor.puzzle_id'=>$puzzle['Puzzle']['id'])));
 //   			$name = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$puzzle['Puzzle']['id'])));
   			
 //   			foreach($list as $key => $data)
 //   			{
 //   				// Get puzzle name 
 //   				$data['Visitor']['puzzle_id'] = $name['Puzzle']['name']; 
	// 			// $data['Visitor']['firstname'];
	// 			// $data['Visitor']['lastname'];
	// 			// $data['Visitor']['email'];
	// 		}	
	// 	}
	// 	$this->set(compact('data'));

	// 	$this->layout = 'ajax';

	// 	return;

	// }





}
