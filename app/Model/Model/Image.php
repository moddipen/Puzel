<?php
App::uses('AppModel', 'Model');
class Image extends AppModel {
	var $name = 'Image';
    
    public $belongsTo = array(
    'Puzzle' => array(
        'className' => 'Puzzle',
        'foreignKey' => 'puzzle_id'            
    ));


 

}
           