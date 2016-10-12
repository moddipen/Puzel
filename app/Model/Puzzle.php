<?php
App::uses('AppModel', 'Model');
class Puzzle extends AppModel {
	
	var $name = 'Puzzle';
	//public $hasMany = 'Image';
	public $belongsTo = array(
    'Business' => array(
        'className' => 'User',
        'foreignKey' => 'user_id'            
    ));


 

}
           