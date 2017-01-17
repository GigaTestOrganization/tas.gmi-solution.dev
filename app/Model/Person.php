<?php
	class Person extends AppModel
	{		
		public $belongsTo = array("Customer");
		public $hasMany = array("OfferingParticipant");
		public $virtualFields = array('encoder_name' => "(SELECT CONCAT(UserProfile.first_name, ' ', UserProfile.last_name) AS AUTHOR FROM user_profiles AS UserProfile WHERE UserProfile.user_id = Person.user_id LIMIT 1)", 'fullname'=>'CONCAT_WS(" ", Person.first_name, Person.last_name)', 'company_name'=>"(SELECT name FROM customers AS Customer WHERE Customer.id = Person.customer_id)");
	}
?>