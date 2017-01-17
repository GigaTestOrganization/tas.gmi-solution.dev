<?php
	class Customer extends AppModel
	{		
		public $hasMany = array("Person", "UserProfile");
		public $belongsTo = array("User");
		public $virtualFields = array('encoder_name' => "(SELECT CONCAT(UserProfile.first_name, ' ', UserProfile.last_name) AS AUTHOR FROM user_profiles AS UserProfile WHERE UserProfile.user_id = Customer.user_id LIMIT 1)");
	}
?>