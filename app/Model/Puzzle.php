<?php
App::uses('AppModel', 'Model');
class Puzzle extends AppModel {
	
	var $name = 'Puzzle';
	
    public $hasMany = array('Visitor');
	
    public $belongsTo = array(
    'Business' => array(
        'className' => 'User',
        'foreignKey' => 'user_id'            
    ));

    public $validate = array(
    	'name'=>array(	
				'rule'=>'check_name_exists',  
	            'message'=>'Puzzle name already exists, please choose another name'
			));


	/**

     * Check a puzzle name  exists in the database

     * @param array $check

     * @return bool

     */

    function check_name_exists($check) {
		// get User by username
		if(!empty($check['name'])) {
            $name = $this->find('first',array('conditions'=>array('Puzzle.name'=>$check['name'])));
        if(!empty($name)) {
			    return FALSE;
			}
        }
    	return TRUE;
    }	    


 

}
           