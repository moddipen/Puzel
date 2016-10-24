<?php
App::uses('AppModel', 'Model');
class Order extends AppModel {
	
	var $name = 'Order';
	public $belongsTo = array(
    'User' => array(
        'className' => 'User',
        'foreignKey' => 'user_id'            
    ),
    'Plan' => array(
        'className' =>'Plan',
        'foreignKey'=>'plan_id'));


}
           