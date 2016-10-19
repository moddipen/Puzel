<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
class User extends AppModel {
	var $name = 'User';

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
           'company_name' => array(
                'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter your company name.'
            )),
           'email'=>array(
                'Valid email'=>array(
                'rule'=>array('email'),
                'message'=>'Please enter a valid email address'
            ),
                'uniqueEmailRule' => array(
                'rule' => 'isUnique',
                'message' => 'Email already registered !........'
            )),
            'password'=>array(
                'length' => array(
                'rule'      => array('notEmpty'),
                'message'   => ' Please enter password',
                'allowEmpty' => false
                ),
            ),
            'confirm_password'=>array(
                'length' => array(
                'rule'      => array('notEmpty'),
                'message'   => ' Please enter confirm password',
                'allowEmpty' => false
                ),
            ));

//Saves the password in hashed format
  public function beforeSave($options = array()) 
    {
        if (!parent::beforeSave($options)) 
        {
            return false;
        }
        if (isset($this->data[$this->alias]['password'])) 
        {
            $hasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $hasher->hash($this->data[$this->alias]['password']);
        }
        return parent::beforeSave($options);    
    }


}
           