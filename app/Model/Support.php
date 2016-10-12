<?php
App::uses('AppModel', 'Model');
class Support extends AppModel {
	var $name = 'Support';

    public $belongsTo = array(
    'Receiver' => array(
        'className' => 'User',
        'foreignKey' => 'receiver_id'            
    ),
    'Sender' => array(
        'className' => 'User',
        'foreignKey' => 'sender_id'
    ));

    public $validate = array(
            
           'subject' => array(
                'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter your subject.'
            )),
           'message' => array(
                'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter your message.'
            )));
 

}
           