<?php
App::uses('AppModel', 'Model');
class Visitor extends AppModel {
	var $name = 'Visitor';

  public $belongsTo = array('Puzzle');

   public $validate = array(
            
           'firstname' => array(
                'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter your first name.'
            )),
           'lastname' => array(
                'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter your last name.'
            )),
           'email' => array(
                'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter your email.'
            )));
 

}
           