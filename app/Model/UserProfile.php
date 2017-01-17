<?php
	class UserProfile extends AppModel
	{		
		public $belongsTo = array("User", "Customer");		
		public $validate = array('first_name' => array('required' => array('rule' => array('notEmpty'), 'message' => 'First Name is required')),
								 'last_name' => array('required' => array('rule' => array('notEmpty'), 'message' => 'Last Name is required')));
	}
?>