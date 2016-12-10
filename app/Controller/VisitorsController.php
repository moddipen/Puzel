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
	 	parent::beforeFilter();
	 	$signup = 0;
		$this->set("Signup",$signup);
		// /$this->layout = 'default';
	 	$this->Auth->allow('v_dynamic','process','fetchimage','generateRandomString','snipestimage');	 		
	 	$this->set('main_action','Visitor');
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
		header('Access-Control-Allow-Origin: *');
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
					$response = array("message"=>"You have already enrolled");
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
						if(isset($this->request->data['refrel']))
						{
							$this->request->data['is_refrel'] = 1;
						}		


						$this->Visitor->create();
						if($this->Visitor->save($this->request->data))
						{
							$modified = date('Y-m-d H:i:s');
							$update = $this->Image->query("UPDATE images SET status = 1 ,modified = '".$modified."' WHERE status <> '1' AND user_id = '".$puzle['Puzzle']['user_id']."' AND puzzle_id = '".$puzle['Puzzle']['id']."' ORDER BY RAND() LIMIT 1 ");  
							$update_puzzle = $this->Image->find('first',array('conditions'=>array('Image.modified'=>$modified,'Image.puzzle_id'=>$puzle['Puzzle']['id'],'Image.user_id'=>$puzle['Puzzle']['user_id'])));
							if($update_puzzle)
							{
								$password_random = $this->generateRandomString();
							    
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
									$this->hostedemail($useremail,$update_puzzle['Image']['puzzle_id'],$update_puzzle['Image']['id'],"Front")	;
								}	
							}
						}		
					}	
				}	
				
			}
			
			// Normal sign up process 
			else
			{
				$user = $this->User->find('first',array('conditions'=>array('User.email'=>$this->request->data['email1'],'User.password'=>AuthComponent::password($this->request->data['password']))));	
				
				if(!empty($user))
				{
					$this->request->data['user_id'] = $user['User']['id'];
					$this->request->data['firstname'] = $user['User']['firstname'];
					$this->request->data['lastname'] = $user['User']['lastname'];
					$this->request->data['email'] = $user['User']['email'];
					$this->request->data['company_name'] = $user['User']['company_name'];
					$visitor = $this->Visitor->find('first',array('conditions'=>array('Visitor.email'=>$user['User']['email'],'Visitor.puzzle_id'=>$puzle['Puzzle']['id'])));	


					if(!empty($visitor))
					{
						$response = array("message"=>"You have already enrolled");
	                    echo json_encode($response);
					}
					else
					{
						$this->Visitor->create();
						if(isset($this->request->data['refrel']))
							{
								$this->request->data['is_refrel'] = 1;
							}		

						if($this->Visitor->save($this->request->data))
						{
							$modified = date('Y-m-d H:i:s');
							$update = $this->Image->query("UPDATE images SET status = 1 ,modified = '".$modified."' WHERE status <> '1' AND user_id = '".$puzle['Puzzle']['user_id']."' AND puzzle_id = '".$puzle['Puzzle']['id']."' ORDER BY RAND() LIMIT 1 ");  
							$update_puzzle = $this->Image->find('first',array('conditions'=>array('Image.modified'=>$modified,'Image.puzzle_id'=>$puzle['Puzzle']['id'],'Image.user_id'=>$puzle['Puzzle']['user_id'])));
							
							if($update_puzzle)
							{
								$response = array("message"=>"success","Id"=>$update_puzzle['Image']['puzzle_id'],"ImageId"=>$update_puzzle['Image']['id']);
			                    echo json_encode($response);
							}
						}
				
					}
				}
				else
				{
					$response = array("message"=>"Invalid email or password.");
	                echo json_encode($response);
				}		
			}	
		}
	}

/**
	Visitor Add form page 
*/	
	public function fetchimage($id = Null)
	{
		header('Access-Control-Allow-Origin: *');
		$this->layout = '';
		$this->autoRendar = false;
		$image = $this->Image->find('first',array('conditions'=>array('Image.id'=>$id),'fields'=>array("Image.name"),'order' => 'rand()'));
		echo json_encode($image['Image']);exit;
		// $this->set('image',$image);
		// $this->set('drawimage_s',count($image));
		// $puzzle = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$id)));
		// $this->set('PuzzleData',$puzzle);
	}
	
	
	public function snipestimage($id = Null)
	{
		header('Access-Control-Allow-Origin: *');
		$this->layout = '';
		$image = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$id)));	
		$this->set('image',$image['Image']);
		$this->set('drawimage_s',count($image['Image']));
		$this->set('PuzzleData',$image);
		$puzel['Show'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$id,'Image.status'=>0))); 
		$puzel['Hide'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$id,'Image.status'=>1))); 
		$this->set("ShowPuzzel",$puzel);
		
		$this->render('/Visitors/fetchimage');
	}

/**
	Visitor dynamic form page 
*/			

	public function v_dynamic($company_name = null,$name = null,$refrel = null)
	{
		$this->layout = "visitor";
		$this->set('title',$name);
		$name = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.name'=>$name,'Puzzle.status'=>0)));
		$this->set('PuzzleData',$name);
		$image = $this->Image->find('all',array('conditions'=>array('Image.puzzle_id'=>$name['Puzzle']['id'])));
		$this->set('image',$image);

		$puzel['Show'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$name['Puzzle']['id'],'Image.status'=>0))); 
		$this->set("ShowPuzzel",$puzel);
		if($refrel)
		{
			$this->set('Refrel',$refrel);
		}	


		$this->set('drawimage_s',count($image));
		$this->set("Company",$company_name);
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
		$this->set('sub_action','data');
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
	public function business_export($search = Null,$from = Null , $to = Null)
	{
	  
		$this->Puzzle->unbindModel(array("belongsTo"=>array("Business")));
		
		if($search)
		{
			$data =  $this->Puzzle->Visitor->find('all',array('conditions'=>array(array('OR'=>array('Visitor.email LIKE'=>'%'.$search.'%','Visitor.firstname LIKE'=>'%'.$search.'%','Visitor.lastname LIKE'=>'%'.$search.'%','Puzzle.name LIKE'=>'%'.$search.'%')),'Puzzle.user_id'=>$this->Auth->user('id'))));
		}
		elseif($search == 0 && $from && $to)
		{
			$data =  $this->Puzzle->Visitor->find('all',array('conditions'=>array('AND'=>array(array('DATE(Visitor.created) >='=>$from,'DATE(Visitor.created) <='=>$to)),'Puzzle.user_id'=>$this->Auth->user('id')))) ; 		
		}	
		else
		{
			$data =  $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id')),"fields"=>array("Puzzle.name")));	
		}	
		$index = 0;
		
		if($search)
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
		elseif($search == 0 && $from && $to)
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
	Admin export data 
*/	
	public function admin_export($search = Null,$from = Null , $to = Null)
	{
		if($search)
		{
			$data = $this->Visitor->find('all',array("conditions"=>array("OR"=>array("Visitor.firstname LIKE"=>'%'.$search.'%',"Visitor.lastname LIKE"=>'%'.$search.'%',"Visitor.email LIKE"=>'%'.$search.'%',"Puzzle.name LIKE"=>'%'.$search.'%',"Puzzle.name LIKE"=>'%'.$search.'%'))));
		}
		else if($email == 0 && $from  && $to)
		{
			$data = $this->Visitor->find('all',array('conditions'=>array('AND'=>array(array('DATE(Visitor.created) >='=>$from,'DATE(Visitor.created) <='=>$to))),'order'=>'Visitor.created Desc')) ; 
		}
		else
		{
			$data =  $this->Visitor->find('all');	
		}	
		$i = 0;
		foreach ($data as  $user)
        {
			$data[$i]['Visitor']['Visitor Firstname'] = $user['Visitor']['firstname'];
			$data[$i]['Visitor']['Visitor Lastname'] =  $user['Visitor']["lastname"];
			$data[$i]['Visitor']['Visitor email'] =  $user['Visitor']["email"];
			$data[$i]['Visitor']['Puzzle Name'] = $user['Puzzle']['name'];
			$i++;
		}
		$var = "True";
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
			$email = $this->Visitor->find('all',array('conditions'=>array(array('OR'=>array('Visitor.firstname LIKE'=>'%'.$this->request->data['search'].'%','Visitor.lastname LIKE'=>'%'.$this->request->data['search'].'%','Visitor.email LIKE'=>'%'.$this->request->data['search'].'%','Puzzle.name LIKE'=>'%'.$this->request->data['search'].'%')),'Puzzle.user_id'=>$this->Auth->user('id'))));	
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
			if($this->request->data['startdate'] && $this->request->data['enddate'])
			{
				$email = $this->Puzzle->Visitor->find('all',array('conditions'=>array('AND'=>array(array('DATE(Visitor.created) >='=>$this->request->data['startdate'],'DATE(Visitor.created) <='=>$this->request->data['enddate'])),'Puzzle.user_id'=>$this->Auth->user('id')))) ; 	
			}
			else
			{
				$email = $this->Puzzle->Visitor->find('all',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id')))) ; 
			}	


			
			$this->set('Emaildata',$email);	
		}
	}	

/**
	Admin email filter for data capture
*/	

	public function admin_emailFilter()
	{	
		$this->layout = null;
		if(!empty($this->request->data))
		{
			if($this->request->data['search'])
			{
				$email = $this->Visitor->find('all',array("conditions"=>array("OR"=>array("Visitor.firstname LIKE"=>'%'.$this->request->data['search'].'%',"Visitor.lastname LIKE"=>'%'.$this->request->data['search'].'%',"Visitor.email LIKE"=>'%'.$this->request->data['search'].'%',"Puzzle.name LIKE"=>'%'.$this->request->data['search'].'%'))));
			}
			else
			{
				$email = $this->Visitor->find('all',array('conditions'=>array('Visitor.email'=>$this->request->data['email'])));		
			}	

			$this->set('Data',$email);	
		}
		
	}



/**
	Admin visitor data cAlender filter  and monthwise filter 
*/	
	public function admin_datefilter()
	{
		if(!empty($this->request->data))
		{
			if($this->request->data['startdate'] != '' && $this->request->data['startdate'] != 'enddate')
			{
				$puzel = $this->Puzzle->Visitor->find('all',array('conditions'=>array('AND'=>array(array('DATE(Visitor.created) >='=>$this->request->data['startdate'],'DATE(Visitor.created) <='=>$this->request->data['enddate']))),'order'=>'Visitor.created Desc')) ; 
			}			
			else
			{
				$puzel = $this->Puzzle->Visitor->find('all',array('order'=>'Visitor.created Desc')) ; 
			}	
		}	
		
		$this->set('Data',$puzel);
	}				










}
