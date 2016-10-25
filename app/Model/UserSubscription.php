<?php
App::uses('AppModel', 'Model');
class UserSubscription extends AppModel {
	var $name = 'UserSubscription';

  public $belongsTo = array('Plan');

}
           