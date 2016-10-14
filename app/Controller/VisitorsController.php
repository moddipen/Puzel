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
								// Create a message and send it
								// $email = new CakeEmail();
								// $email->config('smtp');
								// $email->to($user['User']['email'],$user['User']['firstname'].' '.$user['User']['lastname']);
							 //    $email->subject('Signup Successfully');
							 //    $message = "You have signup Successfully \n\n\n  Your password is :" .$password_random;
							 //    if($email->send($message))
								// {
									$update = array(
										'id'=>$user['User']['id'],
										'password'=>$password_random);
									$this->User->save($update);
									$response = array("message"=>"success","Id"=>$update_puzzle['Image']['puzzle_id']);
			                    	echo json_encode($response);
								// }
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
	}


/**
	Generate rndom string
*/			
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
			




}
