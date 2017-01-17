<?php
	App::uses('AppModel', 'Model');
	App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

	class User extends AppModel
	{		
		public $hasOne = array("UserProfile");
		public $hasMany = array("Customer", "Course");
		public $validate = array('username' => array('required' => array('rule' => array('notEmpty'), 
																		 'message' => 'A username is required')
													),
								 'password' => array('required' => array('rule' => array('notEmpty'), 
								 										 'message' => 'A password is required')
													),
								 'role' => array('valid' => array('rule' => array('inList', array('user', 'admin')), 
								 				 				  'message' => 'Please enter a valid role', 
																  'allowEmpty' => false)
								));
		
		public function beforeSave($options = array()) 
		{
		    if (isset($this->data[$this->alias]['password'])) {
		        $passwordHasher = new BlowfishPasswordHasher();
		        $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
		    }
		    return true;
		}
	}