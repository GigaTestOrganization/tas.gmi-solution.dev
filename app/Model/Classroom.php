<?php
	class Classroom extends AppModel
	{
		public $hasMany = array("OfferClassroom");
		public $virtualFields = array('encoder_name' => "(SELECT CONCAT(UserProfile.first_name, ' ', UserProfile.last_name) AS AUTHOR FROM user_profiles AS UserProfile WHERE UserProfile.user_id = Classroom.user_id LIMIT 1)");
	}
?>