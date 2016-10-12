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
	 }


	
/**
	Visitor Add form page 
*/	
	public function add()
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
			$puzle = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$this->request->id['Visitor']['puzzle_id'])));
			$this->request->data['user_id'] = $puzle['Puzzle']['user_id'];
			$this->request->data['puzzle_id'] = $puzle['Puzzle']['id'];
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


			




}
