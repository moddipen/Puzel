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
class  PuzzlesController  extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
 public $uses = array('Puzzle','User','Image');

/**
 * Displays a view
 *
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	
/**
	Business index page 
*/	
	public function business_index()
	{
		$this->set("title","Index");
		$puzel = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id')))) ; 
		foreach($puzel as $key => $psinglepuzle)
		{
			$puzel[$key]['Show'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>0))); 
			$puzel[$key]['Hide'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>1))); 
		}
		$this->set("Puzzel",$puzel);	
	}
/**
	Business create puzzel page 
*/	
	public function business_create()
	{
		$this->set("title","Create");

	}	

/**
	Admin index page 
*/	
	public function admin_index()
	{
		$this->set("title","Index");

	}	

/**
	User index page 
*/	
	public function user_index()
	{
		$this->set("title","Index");

	}		
			
/**
	Store image in session business view page 
*/	
	public function business_view()
	{
		$this->set("title","View");
		
		if(!empty($this->request->data))
		{
			$count = $this->Puzzle->find('first',array('order'=>'Puzzle.id Desc' , 'limit'=>1));
			$data = $count['Puzzle']['id'] + 1; 
			$this->set("IMAGEID",$data);
			$this->Session->write('IMAGECAPTURE',$this->request->data);
		}		
	}

/**
	Store image in session business view page 
*/	
	public function business_pieces()
	{
		$this->layout = '';
		if(!empty($this->request->data))
		{
			$URL = $_SERVER['DOCUMENT_ROOT'].'app/webroot/img/puzzel/';
			$image = time();
			$imageName = $this->request->data['Puzzle']['name'].".jpg";
			$path = $URL.$imageName;
			$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i','', $this->request->data['Puzzle']['image']));
			$success = file_put_contents($path,$data);
			
			$get_image = Configure::read('SITE_URL').'img/puzzel/'.$imageName;
			$read_image = exif_read_data($get_image) ;
			
			if(isset($read_image))
			{
			   $argv = $get_image;
			}

			  $info = $read_image['FileName'];

			  $size = $read_image['FileSize'];
			  $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
			  $power = $size > 0 ? floor(log($size, 1024)) : 0;
			  $imgsize =  number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];	
			  $this->request->data['Puzzle']['user_id'] = $this->Auth->user('id');
			  $this->Puzzle->create();
			  if($this->Puzzle->save($this->request->data))
			  {
				  $width=$read_image['COMPUTED']['Width'];
				  $height=$read_image['COMPUTED']['Height'];
				  $image_type =$read_image['MimeType'];
				  $peices = $this->request->data['Puzzle']['pieces'];

				  if($peices == 25)
				  {
				    $cut_width = 5;
				    $cut_height = 5;
				  }
				  elseif($peices == 50)
				  {
				    $cut_width = 10;
				    $cut_height = 5; 
				  }
				  elseif($peices == 75)
				  {
				    $cut_width = 15;
				    $cut_height = 5; 
				  }
				  else
				  {
				    $cut_width = 10;
				    $cut_height = 10; 
				  }



					$output = imagecreatetruecolor($width/$cut_width, $height/$cut_height);
				    $storewidth = $width/$cut_width;
				    $storeheight = $height/$cut_height;
			    


				    if($image_type == 'image/jpeg')
				    {
				      $orig = imagecreatefromjpeg($argv);
				    }
				    elseif($image_type == 'image/gif')
				    {
				       $orig = imagecreatefromgif($argv); 
				    }  
				    else
				    {
				      $orig = imagecreatefrompng($argv); 
				    }  

			  		// for height loop
				   for($i=0,$X=0 ; $i<$cut_height ; $i++)
				   {
				     // for width loop
					   for($j=0,$Y=0 ; $j<$cut_width ; $j++ )
					    {
					    	
				  		  imagecopy($output, $orig,0,0,$Y,$X, $width/$cut_width, $height/$cut_height);
				  		  $image_pieces = array(
				  		  'puzzle_id'=>$this->Puzzle->getLastInsertID(),
				  		  'user_id'=>$this->request->data['Puzzle']['user_id'],
				  		  'name'=>"result_".$j.'_'.$i."1.jpg",
				  		  'width'=>$storewidth,
				  		  'height'=>$storeheight,
				  		  'total_width'=>$width,
				  		  'puzzle_active'=>0
				  		  )	;		  
				  		  $this->Image->create();
				  		  $insert = $this->Image->save($image_pieces);
				       	  imagejpeg($output,WWW_ROOT.'img\puzzel\user\result_'.$j.'_'.$i.'1.jpg');
				  		  $Y = $Y + $width/$cut_width; 
				  	  	}
					   
					   $X=$X+$height/$cut_height;
					   
				 	}
				 	$this->redirect(array('action'=>'index'));
			    }
		}		
	}

/**
	Active image show in list with onoff switch
*/	
	public function business_active($id = Null)
	{
		$this->layout = '';
		$this->autoRender = false;
		$this->request->data['Puzzle']['id'] = $id;
		$this->request->data['Puzzle']['status'] = 1;
		if($this->Puzzle->save($this->request->data))
		{
			if($this->Image->updateAll(array('Image.status'=>0,'Image.puzzle_active'=>1),array('Image.puzzle_id'=>$id)))
			{
				$response = array("message" =>"Puzzle Active");	
			}
			
		}
		echo json_encode($response);
	}	










}
