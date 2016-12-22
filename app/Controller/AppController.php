<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller 
{
    public $uses = array('Puzzle','UserSubscription','User','Image','Visitor','Support','Template','Order','Plan','Subscription','UserSubscription');
	public $helpers = array('Html', 'Form','Session');
	public $components = array('Session','RequestHandler','Cookie','Auth' => array(
        'authenticate' => array(
            'Form' => array(
                'fields' => array('username' => 'email')
            )
        )
    ));



	function beforeFilter() 
	 {

	   $this->Auth->authenticate = array('Form');
        $this->Auth->autoRedirect = false;
		 $this->Auth->loginAction = array( 'controller' => 'users', 'action' => 'login' );
	   //Security::setHash("md5");
		$statistics = $this->get_statistics();
		
		$this->set("statistics",$statistics);
		
    	    // Manage session 
            if($this->params['prefix'] == 'admin' && $this->Auth->user('usertype') != 2  && $this->params['login'] && $this->params['register'])
            {
                $this->Cookie->delete('remember_me_cookie');
                $this->Auth->logout();
                $this->Session->setFlash(__('<div><p>Unable access this panel.</p></div>'));
                $this->redirect("/login");
            }
            elseif($this->params['prefix'] == 'business' && $this->Auth->user('usertype') != 1 &&  $this->params['login'] && $this->params['register'])
            {
                $this->Cookie->delete('remember_me_cookie');
                $this->Auth->logout();   
                $this->Session->setFlash(__('<div><p>Unable access this panel.</p></div>'));
                $this->redirect("/login");
            }
            elseif($this->params['prefix'] == 'user' && $this->Auth->user('usertype') != 0 && $this->params['login'] && $this->params['register'])
            {
                $this->Cookie->delete('remember_me_cookie');
                $this->Auth->logout();   
                $this->Session->setFlash(__('<div><p>Unable access this panel.</p></div>'));
                $this->redirect("/login");
            } 

            // prefix setting  and header count
            if ($this->params['prefix'] == 'admin' || $this->Session->read("Auth.User.usertype") == 2)
        	{
        		$signup = 0 ;
        		$this->set('Signup',$signup);
        		$this->layout = "dashboard";

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
            // Business prefix annd header count 
    	    elseif ($this->params['prefix'] == 'business' || $this->Session->read("Auth.User.usertype") == 1)
    	     {
    	     	$signup = 0 ;
        		$this->set('Signup',$signup);
    	     	 
               if (preg_match('/pricing/',$_SERVER[ 'REQUEST_URI' ]) || preg_match('/thank-you/',$_SERVER[ 'REQUEST_URI' ])){
                    $this->layout = "default";
                }
                else
                {
                    $this->layout = "dashboard";
                }
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
                
                $this->set('Balancepeices',$pic);

    	    }

            /// User header count and prefix 
    	    elseif ($this->params['prefix'] == 'user' || ($this->Session->read("Auth.User.usertype") && $this->Session->read("Auth.User.usertype") == 0))
    	     {
    	     	$signup = 0 ;
        		$this->set('Signup',$signup);
    	     	$this->layout = "dashboard";

                // Support count 
                $support = $this->Support->find('count',array('conditions'=>array(array('OR'=>array('Support.sender_id'=>$this->Auth->user('id'),'Support.receiver_id'=>$this->Auth->user('id')))),'group' => array('Support.subject HAVING  1')));
                if(!empty($support))
                {
                    $support = $support;
                }
                else
                {
                    $support = 0 ;
                }    
                $this->set('Support',$support);

                // Participate in puzzle 

                $visitor = $this->Visitor->find('count',array('conditions'=>array('Visitor.user_id'=>$this->Auth->user('id'))));
                if(!empty($visitor))
                {
                    $visitor = $visitor ;
                }
                else
                {
                    $visitor = 0;
                }       

                $this->set('Visitor',$visitor);    

                // Check participate puzzle is active 
                $active_puzzle = $this->Visitor->find('count',array('conditions'=>array('Visitor.user_id'=>$this->Auth->user('id'),'Puzzle.status'=>0)));
                if(!empty($active_puzzle))
                {
                    $active_puzzle = $active_puzzle ;
                }
                else
                {
                    $active_puzzle = 0;
                }       

                $this->set('Activepuzzle',$active_puzzle);    
    	     }
            elseif ($this->params['prefix'] == 'v')
             {
                // echo "<pre>";
                // print_R($this->params);exit;
                $this->layout = "visitor";
             }  
    	    else
        	{
        		$signup = 0 ;
        		$this->set('Signup',$signup);
        		$this->layout = "default";
        	}

        // cookie code
        // set cookie options
   //      $this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
   //      $this->Cookie->httpOnly = true;

   //      if (!$this->Auth->loggedIn() && $this->Cookie->read('remember_me_cookie'))
   //      {
			// $cookie = $this->Cookie->read('remember_me_cookie');

   //          $user = $this->User->find('first', array(
   //              'conditions' => array(
   //                  'User.username' => $cookie['username'],
   //                  'User.password' => $cookie['password']
   //              )
   //          ));

   //          if ($user && !$this->Auth->login($user['User'])) {
   //              $this->redirect('/users/logout'); // destroy session & cookie
   //          }
   //      }
		

       


      }
	  
	  public function get_statistics()
	  {
		 
		  	$data = $this->Puzzle->find('count',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id'))));
			if(empty($data))
			{
				$data = 0 ;
			}
			$statistics['CountPuzzle'] = $data; 
			

			$active = $this->Puzzle->find('count',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id'),'Puzzle.status'=>0)));
			if(empty($active))
			{
				$active = 0 ;
			}
		
			$statistics['CountActivePuzzle'] = $active; 
			// Count total pieces
			$list = $this->Puzzle->find('all',array('conditions'=>array('Puzzle.user_id'=>$this->Auth->user('id'))));
			
			$visitcount = 0;
	
			// count balance pieces  
				$pic = $this->UserSubscription->find("first",array("conditions"=>array("UserSubscription.user_id"=>$this->Auth->user('id'),"UserSubscription.status"=>0)));
				if(empty($pic)){$pic['UserSubscription']['used_pieces'] = 0;}
				$statistics['Visitor'] = $visitcount; 
				$statistics['Balancepeices'] = $pic['UserSubscription']['used_pieces']; 
				if($statistics['Balancepeices'] < 0){$statistics['Balancepeices'] = 0;}
				
				return $statistics;
	  }

/**
      // Send email with template
*/
  
    public function sendemail($mail)
    {
        $json = json_encode(array(
        'TemplateId'=>$mail['templateid'],
        'TemplateModel'=>array(
            'name'=>$mail['name'],
             'action_url' => $mail['TemplateModel']['action_url'],
            'company'=>array(
                'name'=>$mail['TemplateModel']['company']['name']),
            'product_name'=>$mail['TemplateModel']['product_name'],
            'sender_name'=>"Puzzle Team"),
        'From' => $mail['from'],
        'To' => $mail['to'],
        'InlineCss'=>true,
        'ReplyTo' => $mail['reply_to']
        ));
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
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return json_encode($response);
    }

/**
    Host page email code
*/
    public function hostedemail($mail,$puzzle_id = null,$image_id=null,$layout = null)
    {
        $json = json_encode(array(
        'TemplateId'=>$mail['templateid'],
        'TemplateModel'=>array(
            'name'=>$mail['name'],
             'action_url' => $mail['TemplateModel']['action_url'],
            'company'=>array(
                'name'=>$mail['TemplateModel']['company']['name']),
            'product_name'=>$mail['TemplateModel']['product_name'],
            'sender_name'=>"Puzzle Team"),
        'From' => $mail['from'],
        'To' => $mail['to'],
        'InlineCss'=>true,
        'ReplyTo' => $mail['reply_to']
        ));
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
        if($image_id != NULL && $layout != NULL){$response->ImageId = $image_id;}
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        echo json_encode($response);
    }

 
 /**
      // Send email invoice with template 
*/
  
    public function sendinvoice($mail)
    {
        $json = json_encode(array(
        'TemplateId'=>$mail['templateid'],
        'TemplateModel'=>array(
            'name'=>$mail['name'],
            'action_url' => $mail['TemplateModel']['action_url'],
            'company'=>array(
                'name'=>$mail['TemplateModel']['name']),
                'product_name'=>$mail['TemplateModel']['product_name'],
                'date'=>$mail['TemplateModel']['date'],
                'amount'=>$mail['TemplateModel']['amount'],
                'description'=>$mail['TemplateModel']['description'],
                'total'=>$mail['TemplateModel']['total'],
                'sender_name'=>"Puzzle Team"),
        'From' => $mail['from'],
        'To' => $mail['to'],
        'InlineCss'=>true,
        'ReplyTo' => $mail['reply_to']
        ));
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
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return json_encode($response);
    }
   
/**
        Check number of pieces remain of login user to create puzzle
*/    

    public function business_checkpieces()
    {




    }    

 /**
      // Send email with template
*/
  
    public function sendsnipestemail($mail)
    {
        $json = json_encode(array(
        'TemplateId'=>$mail['templateid'],
        'TemplateModel'=>array(
            'name'=>$mail['name'],
             'action_url' => $mail['TemplateModel']['action_url'],
             'product_address_line1' => $mail['TemplateModel']['product_address_line1'],
            'company'=>array(
                'name'=>$mail['TemplateModel']['company']['name']),
            'product_name'=>$mail['TemplateModel']['product_name'],
            'sender_name'=>"Puzzle Team"),
        'From' => $mail['from'],
        'To' => $mail['to'],
        'InlineCss'=>true,
        'ReplyTo' => $mail['reply_to']
        ));
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
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return json_encode($response);
    }     


    


}
