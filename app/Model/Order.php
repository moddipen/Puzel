<?php
App::uses('AppModel', 'Model');
class Order extends AppModel {
	
	var $name = 'Order';
	public $belongsTo = array(
    'User' => array(
        'className' => 'User',
        'foreignKey' => 'user_id'            
    ),
    'Subscription' => array(
        'className' =>'Subscription',
        'foreignKey'=>'subscription_id'));


}
           