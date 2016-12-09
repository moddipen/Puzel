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
App::import('Vendor', 'Csv', array('file' => 'Csv.php'));


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
 public $uses = array('Puzzle','User','Image','Visitor','Support','Template','Order','Plan','Subscription','UserSubscription');
 public $helpers = array('Html', 'Form','Session','Csv');
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
	 	$this->Auth->allow('sub');
	}

/**
	Business index page 
*/	
	public function business_index()
	{
		$this->set("title","Index");
		$puzel = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id')),'order'=>'Puzzle.created Desc')) ; 
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
		$list = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id')),'fields'=>array('Puzzle.id','Puzzle.name')));
		$this->set('Name',$list);

		$status = $this->UserSubscription->find('first',array('conditions'=>array('UserSubscription.user_id'=>$this->Auth->user('id')),'Limit'=>1,'order'=>'UserSubscription.created Desc'));
		$this->set('Userpieces',$status);
	}	

/**
	Admin index page 
*/	
	public function admin_index()
	{
		$this->set("title","Index");
		$puzel = $this->Puzzle->find('all',array('order'=>'Puzzle.created Desc')) ; 
		foreach($puzel as $key => $psinglepuzle)
		{
			$puzel[$key]['Show'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>0))); 
			$puzel[$key]['Hide'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>1))); 
		}
		$this->set("Puzzel",$puzel);	

	}	

/**
	User index page 
*/	
	public function user_index()
	{
		$this->set("title","Index");
		$list = $this->Visitor->find('all',array('conditions'=>array('Visitor.user_id'=>$this->Auth->user('id'))));
		foreach ($list as $key =>  $puzzle)
		{
			$list[$key]['Puzzle'] = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$puzzle['Visitor']['puzzle_id'])));
			$list[$key]['All'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$puzzle['Visitor']['puzzle_id'] )));	
			$list[$key]['Open'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$puzzle['Visitor']['puzzle_id'] ,'Image.status'=>1)));
		}
		$this->set('List',$list);
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
			if(!empty($count))
			{
				$data = $count['Puzzle']['id'] + 1; 	
			}
			else
			{
				$data = 1;
			}	
			$this->set("IMAGEID",$data);
			
			$this->Session->write('IMAGECAPTURE',$this->request->data);
		}		
	}

	/* Get loggedin user total remaining pieces*/
	
	public function checkpieces()
	{
		$this->autoRender = false;
		$user_id = $this->Auth->user("id");
		$check = $this->UserSubscription->find("first",array("conditions"=>array("UserSubscription.user_id"=>$user_id,"UserSubscription.status"=>0)));
		
		if(!empty($check))
		{
			if($check['UserSubscription']['used_pieces'] < $this->data['pieces'])
			{
				$message = array(
					"success" => 0,
					"message" => "Remaining pieces are ".$check['UserSubscription']['used_pieces']."! Please upgrade."
				);
			}
			else
			{
				$message = array(
					"success" => 1,
					"message" => "Success"
				);
			}
		}
		else
		{
			$message = array(
					"success" => 0,
					"message" => "Please upgrade subscription."
				);
		}
		echo json_encode($message);
	}
	
/**
	Store image in session business view page 
*/	
	public function business_pieces()
	{
		$this->autoRender = false;
		
		if(!empty($this->request->data))
		{

			// check how many pieces remain of login user	
			$user_id = $this->Auth->user('id');
			$number_of_pieces = $this->UserSubscription->find('first',array('conditions'=>array('UserSubscription.user_id'=>$this->Auth->user('id'),"UserSubscription.status"=>0)));

	      
	       		// check if name already existes 
				$existname = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.name'=>$this->request->data['Puzzle']['name'])));
				if(!empty($existname))
				{
					$this->Session->setFlash(__('Puzzle name already exists, please choose another name', true), 'default', array('class' => 'alert alert-danger'));
					$this->redirect(array('action'=>'index'));
				}
				else
				{
					$this->request->data['Puzzle']['user_id'] = $user_id;
					// remove space from name 
					$this->request->data['Puzzle']['name'] = str_replace(' ','', $this->request->data['Puzzle']['name']);
					
					// create image directory 
					$multipleimagefolder = WWW_ROOT.'img/puzzel/'.$this->request->data['Puzzle']['name'];//WWW_ROOT."img\puzzel\";
					$folder = mkdir($multipleimagefolder);
					$URL = $_SERVER['DOCUMENT_ROOT'].'/app/webroot/img/puzzel/';
					$imageName = $this->request->data['Puzzle']['name'].".jpg";
					$path = $URL.$imageName;
					$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i','', $this->request->data['Puzzle']['image']));
					$success = file_put_contents($path,$data);
					
					$get_image = Configure::read('SITE_URL').'img/puzzel/'.$imageName;
					$read_image = getimagesize($get_image); 
					
					if(isset($read_image))
					{
					   $argv = $get_image;
					}
					
					//$info = $read_image['FileName'];

					  // $size = $read_image['FileSize'];
					  // $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
					  // $power = $size > 0 ? floor(log($size, 1024)) : 0;
					  // $imgsize =  number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];	
					
					
					  
					  // save single image in puzzle tabel
					  $term = $this->Session->read('IMAGETERMS') ; 
					  if(!empty($term))
					  {
					 	 $this->request->data['Puzzle']['terms'] =  $term['content']; 	
					  }

					  $grandprice = $this->Session->read('IMAGEPRICE');
					  if(!empty($grandprice))
					  {
					  	 $this->request->data['Puzzle']['price'] =  $grandprice['textarea']; 		
					  	 if(isset($grandprice['Puzzle']['price_image']))
					  	 {
					  	 	$this->request->data['Puzzle']['price_image'] =  $grandprice['Puzzle']['price_image']; 			
					  	 }	
					  }
					  $this->request->data['Puzzle']['status'] = 0;
					  $this->request->data['Puzzle']['image_ext'] = $imageName;
					  $this->Puzzle->create();
					  if($this->Puzzle->save($this->request->data))
					  {
						  $width=$read_image[0];
						  $height=$read_image[1];
						  $image_type =$read_image['mime'];
						  $peices = $this->request->data['Puzzle']['pieces'];

						  if($peices > 0)
					        {
					          $cut_width = $peices/5;
					          $cut_height = 5;
					       if($peices > 500)
					       {
					        $cut_width = $peices/25;
					        $cut_height = 25;
					       }
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
					  		  'name'=>$this->request->data['Puzzle']['name'].'_'.$j.'_'.$i.'1.jpg',
					  		  'width'=>$storewidth,
					  		  'height'=>$storeheight,
					  		  'total_width'=>$width,
					  		  'puzzle_active'=>0
					  		  )	;		  
					  		  $this->Image->create();
					  		  $insert = $this->Image->save($image_pieces);
					  		  imagejpeg($output,$multipleimagefolder.'/'.$this->request->data['Puzzle']['name'].'_'.$j.'_'.$i.'1.jpg');
					  		  $Y = $Y + $width/$cut_width; 							  
					  	  	}
						   
						   $X=$X+$height/$cut_height;
						   
					 	}
						
						$name = str_replace(' ','',$this->request->data['Puzzle']['name']);
						
						$company_name = str_replace(' ','', $this->Session->read('IMAGECAPTURE.Puzzel.compnay_name'));
						
						$html = '<script type="text/javascript" src="'.Configure::read("SITE_URL").'app/webroot/js/custom.js"></script><div class="snipest" id="puzzle_'.$this->Puzzle->getLastInsertID().'"></div>';
						$hosted = Configure::read("SITE_URL").'puzzle/'.$company_name.'/'.$name;

					 	$email = array(
	              			"templateid"=>1017941,
	              			"name"=>$this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
	              			"TemplateModel"=> array(
							    "user_name"=> $this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
							    "product_name"=>$this->request->data['Puzzle']['name'],
								"company"=> array(
									"name"=> $this->Auth->user('company_name')),
								"action_url"=>$html,
								"product_address_line1" => $hosted),
							"InlineCss"=> true, 
	              			"from"=> "support@puzel.co",
	              			'to'=>$this->Auth->user('email'),
	              			'reply_to'=>"support@puzel.co"
	              			);	
						if(!empty($number_of_pieces))
							  {
								  $remaining_pieces = $number_of_pieces['UserSubscription']['used_pieces'] - $peices;
								  $this->request->data['UserSubscription']['id'] = $number_of_pieces['UserSubscription']['id'];
								  $this->request->data['UserSubscription']['used_pieces'] = $remaining_pieces;
								  $this->UserSubscription->save($this->request->data);
							  }
						$this->sendsnipestemail($email);
						$this->redirect(array('action'=>'index'));
				    }	
				}	
		   // }
		  // else
	       // {
	       		// $this->Session->setFlash(__('Unable to create puzzle your puzzle remaing balance is lower then your required peices.', true), 'default', array('class' => 'alert alert-danger'));
	  			// $this->redirect(array('controller'=>'puzzles','action'=>'index','business'=>true));
	       // }	
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
		$this->request->data['Puzzle']['status'] = 0;
		if($this->Puzzle->save($this->request->data))
		{
			if($this->Image->updateAll(array('Image.puzzle_active'=>0),array('Image.puzzle_id'=>$id)))
			{
				$response = array("message" =>"Puzzle Active");	
			}
			
		}
		echo json_encode($response);
	}

/**
	Deactive image show in list with onoff switch
*/	
	public function business_deactive($id = Null)
	{
		$this->layout = '';
		$this->autoRender = false;
		$this->request->data['Puzzle']['id'] = $id;
		$this->request->data['Puzzle']['status'] = 1;
		if($this->Puzzle->save($this->request->data))
		{
			if($this->Image->updateAll(array('Image.puzzle_active'=>1),array('Image.puzzle_id'=>$id)))
			{
				$response = array("message" =>"Puzzle Deactive");	
			}
			
		}
		echo json_encode($response);
	}		

/**
	Business terms ajax 
*/	
	public function business_terms($id = Null)
	{
		$this->autoRender = false;

		if(!empty($this->request->data))
		{
			if($id)
			{
				$this->request->data['Puzzle']['id'] = $this->request->data['id'];	
				$this->request->data['Puzzle']['terms'] = $this->request->data['content'];
				$this->Puzzle->save($this->request->data);	
			}
			$this->request->data['Puzzle']['terms'] = $this->request->data['content'];
			$this->Session->write('IMAGETERMS',$this->request->data);
		}
	}

/**
	Business price ajax
*/	
	public function business_price()
	{
		$this->autoRender = false;
		if(!empty($this->request->data))
		{
				$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp');
				$path = $_SERVER['DOCUMENT_ROOT'].'/app/webroot/img/grand_price/';
				$filepath  = Configure::read("SITE_URL").'app/webroot/img/grand_price/';
				
				//echo "<pre>";print_r($this->request->data);exit;

				// when user add grand prize puzzle create time
				if(isset($this->request->data['Puzzle']['uploadfile']))
				{

					$img = trim($this->request->data['Puzzle']['uploadfile']['name']);
					$tmp = trim($this->request->data['Puzzle']['uploadfile']['tmp_name']); 
					 // get uploaded file's extension
					 $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
					 
					 // can upload same image using rand function
					 $final_image = rand(1000,1000000).$img;
					 
					 // check's valid format
					 if(in_array($ext, $valid_extensions)) 
					 {     
						$path = $path.strtolower($final_image); 
						  
						if(move_uploaded_file($tmp,$path)) 
						  {
							$filepath = $filepath.strtolower($final_image); 
							$this->request->data['Puzzle']['price_image'] = $final_image;
							echo "<img src='$filepath' style='width:540px;'/>";
						  }
					 }					
				}	

				

				
				if(isset($_FILES['uploadfile']))
				{

				$img = trim($_FILES['uploadfile']['name']);
				$tmp = trim($_FILES['uploadfile']['tmp_name']); 
				 // get uploaded file's extension
				 $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
				 
				 // can upload same image using rand function
				 $final_image = rand(1000,1000000).$img;
				 
				 // check's valid format
				 if(in_array($ext, $valid_extensions)) 
				 {     
				  $path = $path.strtolower($final_image); 
				   
				  if(move_uploaded_file($tmp,$path)) 
				  {
					$filepath = $filepath.strtolower($final_image); 
					$this->request->data['Puzzle']['price_image'] = $final_image;
					echo "<img src='$filepath' style='width:540px;'/>";
				  }
				 } 
				 
				}
				
				if(isset($this->request->data['Puzzle']['id']))
				{
				
					$this->request->data['Puzzle']['id'] = $this->request->data['Puzzle']['id'];	
					$this->request->data['Puzzle']['price'] = $this->request->data['textarea'];	
					
					$this->Puzzle->save($this->request->data);	
				}
			}
			//echo "<pre>";print_r($this->request->data);exit; 
			$this->Session->write('IMAGEPRICE',$this->request->data);
		
	}

/**
	Business get template ajax
*/	
	public function business_template()
	{
		$this->autoRender = false;
		if(!empty($this->request->data))
		{
			$this->Puzzle->recursive = -1;
			if($this->request->data['type'] == "terms"){$fields = array('Puzzle.terms');}else{$fields = array('Puzzle.price');}
			$data = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$this->request->data['id']),'fields'=>$fields));
			echo json_encode($data);
		}
	}

/**
	Business get price template ajax
*/	
	public function business_pricetemplate()
	{
		$this->autoRender = false;
		if(!empty($this->request->data))
		{
			$this->Puzzle->recursive = -1;
			$data = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$this->request->data['id']),'fields'=>array('Puzzle.price')));
			echo json_encode($data);
		}
	}


/**
	Business header content and count 
*/	
	public function business_export($id = null)
	{
	  $data =  $this->Visitor->find('all',
			array('conditions'=>array('Visitor.puzzle_id'=>$id),
			'fields'=>array(
			"Puzzle.name as PuzzleName,
			Visitor.firstname as `Visitor Firstname`,
			Visitor.lastname as `Visitor Lastname`,
			Visitor.company_name as `Company Name`,
			Visitor.email as `Visitor email`,
			Visitor.created as `Date`")));

	  	$index = 0;
		foreach($data as $visitor)
		{
			$date =  date('m/d/Y',strtotime($visitor['Visitor']['Date']));
			$data[$index]['Visitor']['Visitor Firstname'] = $visitor['Visitor']['Visitor Firstname'];
			$data[$index]['Visitor']['Visitor Lastname'] =  $visitor['Visitor']["Visitor Lastname"];
			$data[$index]['Visitor']['Company Name'] = $visitor['Visitor']['Company Name'];
			$data[$index]['Visitor']['Visitor email'] =  $visitor['Visitor']["Visitor email"];
			$data[$index]['Visitor']['Date'] = $date;
			$data[$index]['Visitor']['Puzzle Name'] = $visitor['Puzzle']['PuzzleName'];
			$index ++;
		}
		$this->set('Visitor',$data);
		$this->layout = null;
	}


/**
	Business header content and count 
*/	
	public function business_edit($id = null)
	{
	  
	  if($id)
	  {
	  		$list = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$id)));
  			$list['Template'] = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.terms'=>$list['Puzzle']['terms']),'fields'=>array('Puzzle.id','Puzzle.name')));
	 
	  		$this->set('title',$list['Puzzle']['name']);
	  		if(!empty($this->request->data))
	  		{

	  			$this->request->data['Puzzle']['id'] = $id;
	  			$this->request->data['Puzzle']['user_id'] = $this->Auth->user('id');
	  			
	  			// save data into table 
	  			if($this->Puzzle->save($this->request->data))
	  			{
	  				// $list = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$id)));
	  				$this->Session->setFlash(__('Puzzle updated.', true), 'default');
	  				$this->redirect(array('action'=>'index','business'=>true));
	  			}
	  		}
	  		else
	  		{
	  			$this->set("Capturedata",$list);
	  			$name = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id')),'fields'=>array('Puzzle.id','Puzzle.name')));
				$this->set('Name',$name);
	  		}	
	  }
	  else
	  {
	  	 exit("Something went wrong");
	  }	
	}

/**
	Ajax filter in business panel
*/
	public function business_status()
	{
		if(!empty($this->request->data))
		{
			$puzel = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.status'=>$this->request->data['status'],'Puzzle.user_id'=>$this->Auth->user('id')))) ; 
			foreach($puzel as $key => $psinglepuzle)
				{
					$puzel[$key]['Show'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>0))); 
					$puzel[$key]['Hide'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>1))); 
				}
			$this->set("Puzzel",$puzel);					
		}
	}
	
/**
	filter based on search
*/
	public function business_search()
	{
		if(!empty($this->request->data))
		{
			$puzel = $this->Puzzle->find('all',array("conditions"=>array("OR"=>array("Business.firstname LIKE"=>'%'.$this->data['search'].'%',"Business.lastname LIKE"=>'%'.$this->data['search'].'%',"Business.email LIKE"=>'%'.$this->data['search'].'%'))));//,array('conditions'=>array('Puzzle.status'=>$this->request->data['status']))) ; 
			
			foreach($puzel as $key => $psinglepuzle)
				{
					$puzel[$key]['Show'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>0))); 
					$puzel[$key]['Hide'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>1))); 
				}
			
			$this->set("Puzzel",$puzel);					
		}
	}
	
	/**
	filter based on search
*/
	public function business_filter()
	{
		if(!empty($this->request->data))
		{
			
			if($this->request->data("endDate") != "" && $this->request->data("startDate") != "")
			{
				$puzel = $this->Puzzle->find('all',array('conditions'=>array('AND'=>array(array('DATE(Puzzle.created) >='=>$this->request->data['starDate'],'DATE(Puzzle.created) <='=>$this->request->data['endDate']),'Puzzle.user_id'=>$this->Auth->user('id'))))) ; 	
			}
			else if($this->request->data("endDate") != "")
			{
				$puzel = $this->Puzzle->find('all',array('conditions'=>array('AND'=>array(array('DATE(Puzzle.created) >='=>$this->request->data['starDate'],'DATE(Puzzle.created) <='=>$this->request->data['endDate']),'Puzzle.user_id'=>$this->Auth->user('id'))))) ; 	
			}
			else
			{
				$puzel = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id')))) ; 	
			}
			
			foreach($puzel as $key => $psinglepuzle)
				{
					$puzel[$key]['Show'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>0))); 
					$puzel[$key]['Hide'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>1))); 
				}
			
			$this->set("Puzzel",$puzel);					
		}
	}

/**
	Ajax calender filter in business panel
*/
	public function business_datefilter()
	{
		if(!empty($this->request->data))
		{
			$puzel = $this->Puzzle->find('all',array('conditions'=>array('AND'=>array(array('DATE(Puzzle.created) >='=>$this->request->data['startdate'],'DATE(Puzzle.created) <='=>$this->request->data['enddate']),'Puzzle.user_id'=>$this->Auth->user('id'))))) ; 	

			foreach($puzel as $key => $psinglepuzle)
				{
					$puzel[$key]['Show'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>0))); 
					$puzel[$key]['Hide'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>1))); 
				}
			$this->set("Puzzel",$puzel);					
		}
	}


/**
	Puzzle preview in business panel
*/
	public function business_preview($id= Null)
	{
		$this->set('title',"Preview");
		if($id)
		{
			$puzel = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$id))) ; 	
			$this->set("Capturedata",$puzel);					
		}
	}
	
/*
	Send puzzle short code to developer(Given email ID)
*/

	public function business_send()
	{
		$this->layout = null;
		$this->autoRender = false;
		if(!empty($this->data))
		{
			
			$json = json_encode(array(
				"templateid"=>1050202,
				"TemplateModel"=> array(
					"from_name"=> $this->Auth->user('firstname').' '.$this->Auth->user('lastname'),
					"snipest_code"=>trim($this->request->data['snipest']),
					),
				"InlineCss"=> true, 
				"from"=> "support@puzel.co",
				'to'=>$this->request->data['email'],
				'reply_to'=>"support@puzel.co"
				));
				//echo $json;exit;
				 $ch = curl_init();
				  curl_setopt($ch, CURLOPT_URL, 'http://api.postmarkapp.com/email/withTemplate');
				  curl_setopt($ch, CURLOPT_POST, true);
				  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Accept: application/json',
						'Content-Type: application/json',
						'X-Postmark-Server-Token: ' .Configure::read("POSTMARKSERVERTOKEN")
						));
				curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($ch);
				$response = json_decode($response);
				if($puzzle_id != NULL && $layout != NULL){$response->Id = $puzzle_id;}
				$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				echo json_encode($response);
				
		}
	}

/**
	Active puzzle from admin side when click on  onoff switch
*/	
	public function admin_active($id = Null)
	{
		$this->layout = '';
		$this->autoRender = false;
		$this->request->data['Puzzle']['id'] = $id;
		$this->request->data['Puzzle']['status'] = 0;
		if($this->Puzzle->save($this->request->data))
		{
			if($this->Image->updateAll(array('Image.puzzle_active'=>0),array('Image.puzzle_id'=>$id)))
			{
				$user = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$id)));
				
				// Send email to business acount 
				$email = array(
	              			"templateid"=>1062363,
	              			"name"=>$user['Business']['firstname'].' '.$user['Business']['lastname'],
	              			"TemplateModel"=> array(
							    "user_name"=> $user['Business']['firstname'].' '.$user['Business']['lastname'],
							    "product_name"=>$user['Puzzle']['name'],
								"company"=> array(
									"name"=> $user['Business']['company_name']),
								"action_url"=>"Puzzle had been active by administrative department"),
							"InlineCss"=> true, 
	              			"from"=> "support@puzel.co",
	              			'to'=>$user['Business']['email'],
	              			'reply_to'=>"support@puzel.co"
	              			);	
				if($this->sendemail($email))
				{
					// Send email to visitor  acount 
					foreach($user['Visitor'] as $value)
					{
						$visitemail = array(
		              			"templateid"=>1062363,
		              			"name"=>$value['firstname'].' '.$value['lastname'],
		              			"TemplateModel"=> array(
								    "user_name"=> $value['firstname'].' '.$value['lastname'],
								    "product_name"=>$user['Puzzle']['name'],
									"company"=> array(
										"name"=> $value['company_name']),
									"action_url"=>"Puzzle had been active by administrative department"),
								"InlineCss"=> true, 
		              			"from"=> "support@puzel.co",
		              			'to'=>$value['email'],
		              			'reply_to'=>"support@puzel.co"
		              			);	
						$this->sendemail($visitemail);					
					}	
				}
			}
			
		}
		
	}

/**
	Deactive puzzle in puzzle list when click on  onoff switch
*/	
	public function admin_deactive($id = Null)
	{
		$this->layout = '';
		$this->autoRender = false;
		$this->request->data['Puzzle']['id'] = $id;
		$this->request->data['Puzzle']['status'] = 1;
		if($this->Puzzle->save($this->request->data))
		{
			if($this->Image->updateAll(array('Image.puzzle_active'=>1),array('Image.puzzle_id'=>$id)))
			{
				$user = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$id)));
				$email = array(
	              			"templateid"=>1062344,
	              			"name"=>$user['Business']['firstname'].' '.$user['Business']['lastname'],
	              			"TemplateModel"=> array(
							    "user_name"=> $user['Business']['firstname'].' '.$user['Business']['lastname'],
							    "product_name"=>$user['Puzzle']['name'],
								"company"=> array(
									"name"=> $user['Business']['company_name']),
								"action_url"=>"Puzzle had been deactive by administrative department"),
							"InlineCss"=> true, 
	              			"from"=> "support@puzel.co",
	              			'to'=>$user['Business']['email'],
	              			'reply_to'=>"support@puzel.co"
	              			);	
				if($this->sendemail($email))
				{
					foreach($user['Visitor'] as $value)
					{
						$visitoremail = array(
	              			"templateid"=>1062344,
	              			"name"=>$value['firstname'].' '.$value['lastname'],
	              			"TemplateModel"=> array(
							    "user_name"=> $value['firstname'].' '.$value['lastname'],
							    "product_name"=>$user['Puzzle']['name'],
								"company"=> array(
									"name"=> $value['company_name']),
								"action_url"=>"Puzzle had been deactive by administrative department"),
							"InlineCss"=> true, 
	              			"from"=> "support@puzel.co",
	              			'to'=>$value['email'],
	              			'reply_to'=>"support@puzel.co"
	              			);	
						$this->sendemail($visitoremail);
					}
				}	
			}
			
		}
		
	}

/**
	Admin side puzzle active or deactive filter get data with ajax
*/	
	public function admin_status()
	{
		
		$puzel = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.status'=>$this->request->data['status']),'order'=>'Puzzle.created Desc')) ; 
		foreach($puzel as $key => $psinglepuzle)
		{
			$puzel[$key]['Show'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>0))); 
			$puzel[$key]['Hide'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>1))); 
		}
		$this->set("Puzzel",$puzel);	
	}

/**
	Admin side puzzle date filter get data with ajax
*/	
	public function admin_datefilter()
	{
		if($this->request->data)
		{
			$puzel = $this->Puzzle->find('all',array('conditions'=>array('AND'=>array(array('DATE(Puzzle.created) >='=>$this->request->data['startdate'],'DATE(Puzzle.created) <='=>$this->request->data['enddate']))),'order'=>'Puzzle.created Desc')) ; 
			foreach($puzel as $key => $psinglepuzle)
			{
				$puzel[$key]['Show'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>0))); 
				$puzel[$key]['Hide'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>1))); 
			}
			$this->set("Puzzel",$puzel);		
		}	
		
	}		
	
/**
	Puzzle preview in admin panel
*/
	public function admin_preview($id= Null)
	{
		$this->set('title',"Preview");
		if($id)
		{
			$puzel = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$id))) ; 	
			$this->set("Capturedata",$puzel);					
		}
	}

/**
	Admin monthwise filter
*/	
	public function admin_monthwisefiltre()
	{
		if($this->request->data)
		{
			if($this->request->data['startDate'] != "" && $this->request->data['endDate'] != "")
			{
				$puzel = $this->Puzzle->find('all',array('conditions'=>array('AND'=>array(array('DATE(Puzzle.created) >='=>$this->request->data['startDate'],'DATE(Puzzle.created) <='=>$this->request->data['endDate']))),'order'=>'Puzzle.created Desc')) ; 
				foreach($puzel as $key => $psinglepuzle)
				{
					$puzel[$key]['Show'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>0))); 
					$puzel[$key]['Hide'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>1))); 
				}	
			}	
			else
			{
				$puzel = $this->Puzzle->find('all',array('order'=>'Puzzle.created Desc')) ; 
				foreach($puzel as $key => $psinglepuzle)
				{
					$puzel[$key]['Show'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>0))); 
					$puzel[$key]['Hide'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$psinglepuzle['Puzzle']['id'],'Image.status'=>1))); 
				}				
			}	
		}	
		$this->set("Puzzel",$puzel);	
	}	

/**
	User calender and monthwise filter with ajax 
*/	
	public function user_datefilter()
	{
		if(!empty($this->request->data))
		{
			$list = $this->Visitor->find('all',array('conditions'=>array(array('AND'=>array(array('DATE(Visitor.created) >='=>$this->request->data['startdate'],'DATE(Visitor.created) <='=>$this->request->data['enddate']))),'Visitor.user_id'=>$this->Auth->user('id'))));
			foreach ($list as $key =>  $puzzle)
			{
				$list[$key]['Puzzle'] = $this->Puzzle->find('first',array('conditions'=>array('Puzzle.id'=>$puzzle['Visitor']['puzzle_id'])));
				$list[$key]['All'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$puzzle['Visitor']['puzzle_id'] )));	
				$list[$key]['Open'] = $this->Image->find('count',array('conditions'=>array('Image.puzzle_id'=>$puzzle['Visitor']['puzzle_id'] ,'Image.status'=>1)));
			}
			$this->set('List',$list);
		}	
	}		













}
